<?php

return [

    'page_title'  => 'إتمام الطلب',
    'optional'    => 'اختياري',
    'qty'         => 'الكمية',
    'apply'       => 'تطبيق',
    'processing'  => 'جاري المعالجة...',
    'status'      => 'الحالة',

    'proceed_to_payment' => 'المتابعة للدفع',

    'sections' => [
        'contact'  => 'بيانات التواصل',
        'shipping' => 'عنوان الشحن',
        'coupon'   => 'كود الخصم',
    ],

    'fields' => [
        'name'        => 'الاسم الكامل',
        'email'       => 'البريد الإلكتروني',
        'phone'       => 'رقم الهاتف',
        'country'     => 'الدولة',
        'governorate' => 'المحافظة',
        'city'        => 'المدينة',
        'street'      => 'العنوان',
        'note'        => 'ملاحظات الطلب',
    ],

    'order_summary'    => 'ملخص الطلب',
    'subtotal'         => 'المجموع الجزئي',
    'discount'         => 'الخصم',
    'shipping'         => 'الشحن',
    'total'            => 'الإجمالي',
    'payment_details'  => 'تفاصيل الدفع',
    'payment_method'   => 'طريقة الدفع',
    'shipping_address' => 'عنوان التوصيل',

    'coupon_placeholder' => 'أدخل كود الخصم',
    'secure_payment_note'=> 'المدفوعات آمنة ومشفرة',

    // Validation / errors
    'empty_cart'                => 'سلة التسوق فارغة.',
    'out_of_stock'              => ':product غير متوفر في المخزون.',
    'payment_initiation_failed' => 'تعذر الاتصال ببوابة الدفع. يرجى المحاولة مرة أخرى.',
    'unexpected_error'          => 'حدث خطأ ما. يرجى المحاولة مرة أخرى.',
    'payment_success'           => 'تم الدفع بنجاح! تم تأكيد طلبك.',
    'payment_failed'            => 'لم تكتمل عملية الدفع.',
    'price_updated'             => 'تم تحديث أسعار بعض المنتجات.',
    'invalid_coupon'            => 'هذا الكود غير صالح أو منتهي الصلاحية.',
    'coupon_applied'            => 'تم تطبيق خصم :pct% بنجاح!',

    'success' => [
        'title'             => 'تم تأكيد الطلب',
        'heading'           => 'تم تأكيد طلبك!',
        'subheading'        => 'شكراً لك، نحن نجهز طلبك الآن.',
        'order_number'      => 'رقم الطلب',
        'continue_shopping' => 'مواصلة التسوق',
        'view_order'        => 'عرض الطلب',
        'email_note'        => 'تم إرسال تأكيد الطلب إلى :email',
    ],

    'failed' => [
        'title'             => 'فشل الدفع',
        'heading'           => 'لم تكتمل عملية الدفع',
        'subheading'        => 'لم يتم تسجيل طلبك.',
        'default_reason'    => 'تعذر إتمام عملية الدفع.',
        'order_details'     => 'تفاصيل الطلب',
        'what_happened'     => 'ما الذي ربما حدث؟',
        'reason_card'       => 'رصيد البطاقة غير كافٍ',
        'reason_cancel'     => 'تم إلغاء عملية الدفع',
        'reason_timeout'    => 'انتهت مهلة الجلسة',
        'reason_funds'      => 'تم رفض البطاقة من قِبل البنك',
        'stock_note'        => 'تم إعادة المنتجات المحجوزة إلى المخزون.',
        'retry'             => 'العودة للسلة والمحاولة مجدداً',
        'continue_shopping' => 'مواصلة التسوق',
    ],

];
