<?php

return [
    'model' => 'บัญชีผู้ใช้',

    'page_title' => [
        'index'     => 'บัญชีผู้ใช้ทั้งหมด',
        'create'    => 'สร้างบัญชีผู้ใช้',
        'edit'      => 'แก้ไขบัญชีผู้ใช้',
        'delete'    => 'ลบบัญชีผู้ใช้',
        'show'      => 'บัญชีผู้ใช้: ',
    ],

    'list' => [
        'not_found' => 'ไม่พบบัญชีผู้ใช้',
        'empty'     => 'ยังไม่มีบัญชีผู้ใช้',
        'search_results' => 'ผลการค้นหาบัญชีผู้ใช้:',
    ],

    'form' => [
        'profile_information_title' => 'ข้อมูลส่วนตัว',
        'profile_information_description' => 'ข้อมูลส่วนตัว, ข้อมูลการติดต่อผู้ใช้',
        'name'                  => 'ชื่อ',
        'email'                 => 'อีเมล',
        'role'                  => 'Role',
        'role_description'      => 'จัดการตำแหน่งและระดับการเข้าถึงข้อมูลของบัญชีผู้ไช้',
        'password'              => 'รหัสผ่าน',
        'password_confirmation' => 'ยืนยันรหัสผ่าน',

        'super_admin'           => 'Super Admin',
        'super_admin_description' => 'ผู้ดูแลระบบสูงสุด สามารถจัดการ Admin',
        'admin'                 => 'Admin',
        'admin_description'     => 'ผู้ดูแลระบบ บริหารข้อมูล ตั้งค่าระบบ',
        'buyer'                 => 'ผู้ซื้อ',
        'buyer_description'     => 'สามารถซื้อ order',
        'seller'                => 'ผู้ขาย',
        'seller_description'    => 'สามารถขาย sell order',
    ],

    'security' => [
        'title' => 'ความปลอดภัย',
        'send_reset_password_email' => 'ส่งอีเมลเปลี่ยนรหัสผ่าน',
        'send_reset_pin_email' => 'ส่งอีเมลเปลี่ยน PIN',
    ],

    'message' => [
        'store_success' => 'สร้างบัญชีผู้ใช้เรียบร้อย',
        'update_success' => 'แก้ไขบัญชีผู้ใช้เรียบร้อย',
        'destroy_success' => 'ลบบัญชีผู้ใช้เรียบร้อย',
    ]
];
