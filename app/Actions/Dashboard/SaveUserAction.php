<?php

namespace App\Actions\Dashboard;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SaveUserAction
{
    /** @var User */
    protected $user;

    public function execute(User $user, array $data)
    {
        $this->user = $user;

        $this->user->name = $data['name'];
        $this->user->email = $data['email'];

        if ($user->id === auth()->user()->id) {
            if (array_key_exists('password', $data) && ! empty($data['password'])) {
                $this->user->password = Hash::make($data['password']);
            }
        }

        $this->user->save();

//        $this->savePhoto();

        if (auth()->user()->can('updateRole', $this->user)) {
            if ($data['role'] == 'buyer') {
                $this->user->syncRoles([]);
                $this->user->type = User::TYPE_BUYER;
            } elseif ($data['role'] == 'seller') {
                $this->user->syncRoles([]);
                $this->user->type = User::TYPE_SELLER;
            } else { // admin or super admin
                $this->user->syncRoles($data['role'] ?? []);
                $this->user->type = null;
            }
            $this->user->save();
        }

        return $this->user;
    }

    /**
     * Save user photo
     */
//    protected function savePhoto()
//    {
//        if (request()->hasFile('photo')) {
//            $media = $this->user->addMediaFromRequest('photo')
//                ->toMediaCollection(User::MEDIA_COLLECTION_PHOTO);
//        }
//    }
}
