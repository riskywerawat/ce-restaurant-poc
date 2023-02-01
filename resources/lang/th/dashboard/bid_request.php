<?php

return [
    'model' => 'คำสั่งซื้อ',

    'page_title' => [
        'index'     => 'คำสั่งซื้อทั้งหมด',
//        'create'    => 'สร้างคำสั่งซื้อ',
        'edit'      => 'แก้ไขคำสั่งซื้อ',
        'delete'    => 'ลบคำสั่งซื้อ',
        'show'      => 'คำสั่งซื้อ: ',
    ],

    'list' => [
        'not_found' => 'ไม่พบคำสั่งซื้อ',
        'empty'     => 'ยังไม่มีคำสั่งซื้อ',
        'search_results' => 'ผลการค้นหาคำสั่งซื้อ:',
    ],

    'form' => [
        'status'                => 'สถานะ',
        'delivery_date'         => 'วันส่ง',
        'price'                 => 'ราคา',
        'quantity'              => 'จำนวน',
        'total'                 => 'รวม',
        'grand_total'           => 'รวมทั้งหมด',
        'buyer'                 => 'ผู้ซื้อ',
        'seller'                => 'ผู้ขาย',
        'fee'                   => 'ค่าธรรมเนียม',
    ],

    'spend'             => 'จ่าย',
    'received'          => 'ได้',
    'day_month_year'    => 'วัน-เดือน-ปี',

    'message' => [
//        'store_success' => 'สร้างคำสั่งซื้อเรียบร้อย',
        'update_success' => 'แก้ไขคำสั่งซื้อเรียบร้อย',
        'destroy_success' => 'ลบคำสั่งซื้อเรียบร้อย',
    ]
];
