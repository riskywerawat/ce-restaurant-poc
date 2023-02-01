<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Dashboard\SaveUserAction;
//use App\Actions\Dashboard\UserFilterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateOrUpdateUserRequest;
use App\Models\AskRequest;
use App\Models\BidRequest;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response | \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);

//        $users = User::latest()->paginate(50);
        $roles = \Spatie\Permission\Models\Role::all();

//        $users = $userFilterAction->execute();
        $users = User::paginate(30);

        return view('dashboard.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response | \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $user = new User;

        $roles = \App\Models\Role::all();

        return view('dashboard.users.create', compact('user', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateOrUpdateUserRequest $request
     * @param SaveUserAction $saveUser
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(CreateOrUpdateUserRequest $request, SaveUserAction $saveUser)
    {
        $this->authorize('create', User::class);

        $user = new User();

        $user = $saveUser->execute($user, $request->validated());

        $this->sendWelcomeEmail($user);

        return redirect()->route('dashboard.users.show', $user)->with('success', 'สร้างบัญชีผู้ใช้เรียบร้อย');
    }

    protected function sendWelcomeEmail(User $user)
    {
        $token = $this->createSetupToken($user);

        // send email;
        $user->notify(new WelcomeEmailNotification($user, $token));
    }

    protected function createSetupToken(User $user)
    {
        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        $token = hash_hmac('sha256', Str::random(40), $key);

        DB::table('user_setups')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'created_at' => new Carbon()
        ]);

        return $token;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response | \Illuminate\View\View
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $transactions = Transaction::with(['askRequest.user', 'bidRequest.user'])
            ->whereHas('bidRequest', function ($q) use($user) {
                $q->where('user_id', $user->id);
            })
            ->orWhereHas('askRequest', function ($q) use($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByDesc('delivery_date')
            ->paginate(50, ['*'], 'transactions_page');

        $bidRequests = BidRequest::where('user_id', $user->id)
            ->orderByDesc('delivery_date')
            ->paginate(50, ['*'], 'bid_requests_page');

        $askRequests = AskRequest::where('user_id', $user->id)
            ->orderByDesc('delivery_date')
            ->paginate(50, ['*'], 'ask_requests_page');

        return view('dashboard.users.show', compact('user', 'transactions', 'bidRequests', 'askRequests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response | \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $roles = \App\Models\Role::all();

        return view('dashboard.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CreateOrUpdateUserRequest $request
     * @param  \App\Models\User $user
     * @param SaveUserAction $saveUser
     * @return \Illuminate\Http\Response | \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(CreateOrUpdateUserRequest $request, User $user, SaveUserAction $saveUser)
    {
        $this->authorize('update', $user);

        $user = $saveUser->execute($user, $request->validated());

        return redirect()->route('dashboard.users.show', $user)->with('success', 'แก้ไขบัญชีผู้ใช้เรียบร้อยแล้ว');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('dashboard.users.index')->with('success', 'ลบบัญชีผู้ใช้เรียบร้อย');
    }
}
