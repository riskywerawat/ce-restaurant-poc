<?php

namespace App\Console\Commands;

use App\Events\MarketDataUpdated;
use App\Models\AskRequest;
use App\Models\BidRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class DeleteOldPdfAttachmentsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pdf:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove old pdf attachments from disk';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = (Carbon::now('Asia/Bangkok'))->subDay()->format('Ymd');
        $path = storage_path('pdf/'.$date);
        if(File::isDirectory($path)){
            File::deleteDirectory($path);
            $this->info($path . ' directory deleted.');
        }
    }
}
