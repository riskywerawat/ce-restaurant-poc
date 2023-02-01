<?php

return [
    'model' => 'User',

    'page_title' => [
        'index'     => 'All users',
        'create'    => 'Create user',
        'edit'      => 'Edit user',
        'delete'    => 'Delete user',
        'show'      => 'User: ',
    ],

    'list' => [
        'not_found' => 'Users not found',
        'empty'     => 'No users yet',
        'search_results' => 'Search users result:',
    ],

    'form' => [
        'profile_information_title' => 'Profile',
        'profile_information_description' => 'Profile information, contact detail',
        'name'                  => 'Name',
        'email'                 => 'Email',
        'role'                  => 'Role',
        'role_description'      => "Select user's role",
        'password'              => 'Password',
        'password_confirmation' => 'Password confirmation',

        'super_admin'           => 'Super Admin',
        'super_admin_description' => 'Can manage Admin',
        'admin'                 => 'Admin',
        'admin_description'     => 'View data, Manage users, Config system',
        'buyer'                 => 'Buyer',
        'buyer_description'     => 'User can buy order',
        'seller'                => 'Seller',
        'seller_description'    => 'User can sell order',
    ],

    'security' => [
        'title' => 'Security',
        'send_reset_password_email' => 'Send reset password email',
        'send_reset_pin_email' => 'Send reset pin email',
    ],

    'message' => [
        'store_success' => 'Successfully create user.',
        'update_success' => 'Successfully edit user.',
        'destroy_success' => 'Successfully delete user.',
    ]
];
