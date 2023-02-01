<?php

return [
    // Profile settings menu
    'title' => 'Edit profile information',

    'menu' => [
        'my_account' => 'Account settings',
        'profile' => 'Profile',
        'edit_profile' => 'Edit Profile',
        'password' => 'Change Password',
    ],

    'form' => [
        'profile' => [
            'title' => 'Profile',
            'subtitle' => 'This information will be displayed publicly so be careful what you share.',
            'success' => 'Successfully update your profile.'
        ],
        'avatar' => [
            'success' => 'Successfully update your avatar'
        ],
        'password' => [
            'current_password' => 'Current Password',
            'new_password' => 'New Password',
            'new_password_confirmation' => 'New Password Confirmation',
            'success' => 'Successfully change your password.'
        ],
    ]
];
