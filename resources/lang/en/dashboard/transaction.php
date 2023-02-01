<?php

return [
    'model' => 'transaction',

    'page_title' => [
        'index'     => 'All Transactions',
//        'create'    => 'Create Transaction',
        'edit'      => 'Edit Transaction',
        'delete'    => 'Delete Transaction',
        'show'      => 'Transaction: ',
    ],

    'list' => [
        'not_found' => 'Transactions not found.',
        'empty'     => 'No Transactions orders yet.',
        'search_results' => 'Search Transactions Result:',
    ],

    'form' => [
        'delivery_date'         => 'Delivery Date',
        'price'                 => 'Price',
        'quantity'              => 'Quantity',
        'total'                 => 'Total',
        'buyer'                 => 'Buyer',
        'seller'                => 'Seller',
        'time'                  => 'Created at',
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
