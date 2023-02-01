<?php

return [
    'market'            => 'ตลาด',
    // Bid
    'bid_panel_title'   => 'ต้องการซื้อ',
    'bids'              => 'ซื้อ',

    // Ask
    'ask_panel_title'   => 'ต้องการขาย',
    'asks'              => 'ขาย',

    'my_bids'           => 'ประกาศซื้อของฉัน',
    'my_offers'         => 'ประกาศขายของฉัน',

    'graph'             => 'Graph',
    'asks_bids'         => 'ซื้อ / ขาย',

    // Trade form common
    'delivery_date'     => 'วันส่งสินค้า',
    'quantity'          => 'จำนวน',
    'minimum'           => 'ขั้นต่ำ',
    'price_per_mmbtu'   => 'ราคาต่อ MMBTU',
    'estimated_spend'   => 'ประมาณจำนวนที่ต้องจ่าย',
    'estimated_received'=> 'ประมาณจำนวนที่จะได้',
    'total'             => 'รวม',
    'grand_total'       => 'รวมทั้งสิ้น',
    'includes_fee'      => 'รวมค่าธรรมเนียม',
    'post'              => 'ประกาศ',
    'fee'               => 'ค่าธรรมเนียม',

    // Panels
    'qty'               => 'จำนวน',
    'price'             => 'ราคา',
    'day_month_year'    => '(วัน-เดือน-ปี)',
    'view_history'      => 'ดูประวัติ',
    'summary'           => 'โปรดตรวจสอบข้อมูล',
    'verification'      => 'ยืนยันทำรายการ',
    'please_enter_pin'  => 'กรุณากรอก <span class="font-bold">PIN 6 หลัก</span>',
//    'forgot_pin'        => 'ลืม PIN?',
//    'reset_pin'         => 'ตั้ง PIN ใหม่',
    'posted'            => 'ประกาศแล้ว',
    'posted_text'       => 'เราจะแจ้งท่านทันทีที่ประกาศถูกจับคู่',

    'view_detail'       => 'ดูรายละเอียด',
    'delete'            => 'ลบ',
    'delete_confirm'    => 'ประกาศนี้จะถูก<span class="font-bold">ลบถาวร</span> ไม่สามารถกู้คืนได้ ยืนยันที่จะลบ?',
    'delete_success'    => 'ลบประกาศเรียบร้อย',

    'bid_success'       => 'สร้างประกาศซื้อเรียบร้อยแล้ว',
    'ask_success'       => 'สร้างประกาศขายเรียบร้อยแล้ว',

    'validation' => [
        'bid_delivery_date' => [
            'required'  => 'กรุณาระบุวันส่งสินค้า'
        ],
        'bid_quantity' => [
            'required'  => 'กรุณาระบุจำนวน',
            'minValue'  => 'จำนวนต้องมีค่ามากกว่า 1,000 MMBTU',
        ],
        'bid_price' => [
            'required'  => 'กรุณาระบุราคา',
            'minValue'  => 'ราคาต้องมีค่ามากกว่า 1 THB/MMBTU',
            'maxValue'  => 'ราคาต้องมีค่าไม่เกิน :max THB/MMBTU',
        ],
        'ask_delivery_date' => [
            'required'  => 'กรุณาระบุวันส่งสินค้า'
        ],
        'ask_quantity' => [
            'required'  => 'กรุณาระบุจำนวน',
            'minValue'  => 'จำนวนต้องมีค่ามากกว่า 1,000 MMBTU',
        ],
        'ask_price' => [
            'required'  => 'กรุณาระบุราคา',
            'minValue'  => 'ราคาต้องมีค่ามากกว่า 1 THB/MMBTU',
            'maxValue'  => 'ราคาต้องมีค่าไม่เกิน :max THB/MMBTU',
        ],
        'pin' => [
            'required'  => 'กรุณากรอก PIN',
            'pinValidation'  => 'PIN ต้องเป็นเลข 6 หลัก',
        ]
    ],

    'graph_categories' => [
        'highest_bid' => 'ซื้อสูงสุด',
        'lowest_bid' => 'ซื้อต่ำสุด',
        'highest_ask' => 'ขายสูงสุด',
        'lowest_ask' => 'ขายต่ำสุด',
        'highest_matched' => 'จับคู่สำเร็จสูงสุด',
        'lowest_matched' => 'จับคู่สำเร็จต่ำสุด',
    ],
];
