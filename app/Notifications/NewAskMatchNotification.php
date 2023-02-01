<?php

namespace App\Notifications;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class NewAskMatchNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $transaction;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // $url = route('users.setup', ['token' => $this->token, 'key' => $this->user->id], true);
        $transaction = $this->transaction;
        $contents = view('emails.pdf.matched_ask', compact('transaction'))->render();
        $date = (Carbon::now('Asia/Bangkok'))->format('Ymd');
//        Storage::makeDirectory('pdf/'.$date);
        if(!File::isDirectory(storage_path('pdf/'.$date))){
            File::makeDirectory(storage_path('pdf/'.$date), 0777, true, true);
        }
        $pathToPdf = storage_path('pdf/'.$date.'/bid_'.$transaction->id.'.pdf');
        $pdf = \Spatie\Browsershot\Browsershot::html($contents)
            ->emulateMedia('screen')
            ->format('A4')
            ->margins(10, 5, 5, 5)
            ->showBackground()
            ->timeout(30) // 30 seconds
            ->waitUntilNetworkIdle()
            ->noSandbox()
            ->savePdf($pathToPdf);

        $quantity = $this->transaction->quantity;
        $deliveryDate = $this->transaction->delivery_date->format('d/m/Y');
        return (new MailMessage)
            ->subject("New match $quantity MMBTU @ $deliveryDate")
            ->line('You offer request has been matched.')
            ->line('Quantity: ' . numberComma($quantity) . ' MMBTU')
            ->line('Price: ' . money($this->transaction->present()->price) . ' THB/MMBTU')
            ->line('Delivery Date: ' . $deliveryDate)
//            ->action('Set password', $url)
            ->line('Thank you for using our application!')
            ->attach($pathToPdf, [
                'as' => 'transaction.pdf',
                'mime' => 'text/pdf',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
