<?php

return [
    'market'            => 'Market',
    // Bid
    'bid_panel_title'   => 'Want to bid',
    'bids'              => 'Bids',

    // Ask
    'ask_panel_title'   => 'Want to offer',
    'asks'              => 'Offers',

    'my_bids'           => 'My Bids',
    'my_offers'         => 'My Offers',

    'graph'             => 'Graph',
    'asks_bids'         => 'BIDS / OFFERS',

    // Trade form common
    'delivery_date'     => 'Delivery Date',
    'quantity'          => 'Quantity',
    'minimum'           => 'Minimum',
    'price_per_mmbtu'   => 'Price Per MMBTU',
    'estimated_spend'   => 'Estimated Spend',
    'estimated_received'=> 'Estimated Received',
    'total'             => 'Total',
    'grand_total'       => 'Grand Total',
    'includes_fee'      => 'includes fee',
    'post'              => 'Post',
    'fee'               => 'Fee',

    // Panels
    'qty'               => 'Qty.',
    'price'             => 'Price',
    'day_month_year'    => '(Day-Month-Year)',
    'view_history'      => 'View History',
    'summary'           => 'Summary',
    'verification'      => 'Verification',
    'please_enter_pin'  => 'Please enter your <span class="font-bold">6-digit PIN</span>',
//    'forgot_pin'        => 'Forgot your PIN?',
//    'reset_pin'         => 'Reset PIN',
    'posted'            => 'Posted',
    'posted_text'       => 'We will notify you as soon as your offer has been matched.',

    'view_detail'       => 'View Detail',
    'delete'            => 'Delete',
    'delete_confirm'    => 'This offer will be <span class="font-bold">deleted permanently</span> and connot be restored. Are you sure?',
    'delete_success'    => 'Successfully delete offer.',

    'bid_success'       => 'Successfully created bid.',
    'ask_success'       => 'Successfully created offer.',

    'validation' => [
        'bid_delivery_date' => [
            'required'  => 'Delivery Date is required'
        ],
        'bid_quantity' => [
            'required'  => 'Quantity is required',
            'minValue'  => 'Quantity must be at least 1,000 MMBTU',
        ],
        'bid_price' => [
            'required'  => 'Price is required',
            'minValue'  => 'Price must be at least 1 THB/MMBTU',
            'maxValue'  => 'Price must not exceed :max THB/MMBTU',
        ],
        'ask_delivery_date' => [
            'required'  => 'Delivery Date is required'
        ],
        'ask_quantity' => [
            'required'  => 'Quantity is required',
            'minValue'  => 'Quantity must be at least 1,000 MMBTU',
        ],
        'ask_price' => [
            'required'  => 'Price is required',
            'minValue'  => 'Price must be at least 1 THB/MMBTU',
            'maxValue'  => 'Price must not exceed :max THB/MMBTU',
        ],
        'pin' => [
            'required'  => 'PIN is required',
            'pinValidation'  => 'PIN must be 6 digits number',
        ]
    ],

    'graph_categories' => [
        'highest_bid' => 'Highest Bid',
        'lowest_bid' => 'Lowest Bid',
        'highest_ask' => 'Lowest Offer',
        'lowest_ask' => 'Lowest Offer',
        'highest_matched' => 'Highest Matched',
        'lowest_matched' => 'Lowest Matched',
    ],
];
