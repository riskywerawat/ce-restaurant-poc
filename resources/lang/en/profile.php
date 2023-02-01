<?php

return [
    // Jetstream profile page
    'profile_information'   => [
        'title'     =>  'Profile Information',
        'subtitle'  =>  'Update your account\'s profile information and email address.',
        'form' => [
            'name'  => 'Name',
            'email'  => 'Email',
        ]
    ],

    'password'   => [
        'title'     =>  'Update Password',
        'subtitle'  =>  'Ensure your account is using a long, random password to stay secure.',
        'form' => [
            'current_password'      => 'Current Password',
            'password'              => 'New Password',
            'password_confirmation' => 'Confirm New Password',
        ]
    ],

    'sessions'   => [
        'title'     => 'Browser Sessions',
        'subtitle'  => 'Manage and logout your active sessions on other browsers and devices.',
        'text'      => 'If necessary, you may logout of all of your other browser sessions across all of your devices. If you feel your account has been compromised, you should also update your password.',
        'this_device' => 'This device',
        'button'    => 'Logout Other Browser Sessions',
        'confirm_text' => 'Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.',
        'password' => 'Password',
    ],
];
