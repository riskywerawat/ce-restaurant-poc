<?php

return [
    'model' => 'order_requests',

    'page_title' => [
        'index'     => 'All Orders',
        'create'    => 'Create Orders',
        'edit'      => 'Edit Orders',
        'delete'    => 'Delete Orders',
        'show'      => 'Orders: ',
    ],

    'list' => [
        'not_found' => 'Transactions not found.',
        'empty'     => 'No Transactions orders yet.',
        'search_results' => 'Search Transactions Result:',
    ],
    'form' => [
        'profile_information_title' => 'Profile',
        'profile_information_description' => 'Kitchen information, menu detail',
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
        'id'         => 'Order ID',
        'kitchen'                 => 'Kitchen',
        'menu'                 => 'Menu',
        'quantity'                 => 'Quantity',
        'status'              => 'Status',
        'order_at' => 'Order Time',
    ],


    'spend'             => 'Spend',
    'received'          => 'Received',
    'day_month_year'    => 'Day-Month-Year',

    'message' => [
//        'store_success' => 'Successfully create transaction.',
        'update_success' => 'Successfully edit transaction.',
        'destroy_success' => 'Successfully delete transaction.',
    ]
];
