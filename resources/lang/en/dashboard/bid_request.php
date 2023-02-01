<?php

return [
    'model' => 'bid request',

    'page_title' => [
        'index'     => 'All Bid Requests',
//        'create'    => 'Create Bid Request',
        'edit'      => 'Edit Bid Request',
        'delete'    => 'Delete Bid Request',
        'show'      => 'Bid Request: ',
    ],

    'list' => [
        'not_found' => 'Bid Requests not found.',
        'empty'     => 'No Bid Requests yet.',
        'search_results' => 'Search Bid Requests Result:',
    ],

    'form' => [
        'status'                => 'Status',
        'delivery_date'         => 'Delivery Date',
        'price'                 => 'Price',
        'quantity'              => 'Quantity',
        'total'                 => 'Total',
        'buyer'                 => 'Buyer',
        'seller'                => 'Seller',
        'fee'                   => 'Fee',
    ],

    'spend'             => 'Spend',
    'received'          => 'Received',
    'day_month_year'    => 'Day-Month-Year',

    'message' => [
//        'store_success' => 'Successfully create bid request.',
        'update_success' => 'Successfully edit bid request.',
        'destroy_success' => 'Successfully delete bid request.',
    ]
];
