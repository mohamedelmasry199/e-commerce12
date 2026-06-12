<?php


return [

    'page_title'  => 'Checkout',
    'optional'    => 'optional',
    'qty'         => 'Qty',
    'apply'       => 'Apply',
    'processing'  => 'Processing...',
    'status'      => 'Status',

    'proceed_to_payment' => 'Proceed to Payment',

    'sections' => [
        'contact'  => 'Contact Information',
        'shipping' => 'Shipping Address',
        'coupon'   => 'Coupon Code',
    ],

    'fields' => [
        'name'        => 'Full Name',
        'email'       => 'Email Address',
        'phone'       => 'Phone Number',
        'country'     => 'Country',
        'governorate' => 'Governorate',
        'city'        => 'City',
        'street'      => 'Street Address',
        'note'        => 'Order Notes',
    ],

    'order_summary'    => 'Order Summary',
    'subtotal'         => 'Subtotal',
    'discount'         => 'Discount',
    'shipping'         => 'Shipping',
    'total'            => 'Total',
    'payment_details'  => 'Payment Details',
    'payment_method'   => 'Payment Method',
    'shipping_address' => 'Shipping Address',

    'coupon_placeholder' => 'Enter coupon code',
    'secure_payment_note'=> 'Payments are secured and encrypted',

    // Validation / errors
    'empty_cart'                => 'Your cart is empty.',
    'out_of_stock'              => ':product is out of stock.',
    'payment_initiation_failed' => 'Could not connect to payment gateway. Please try again.',
    'unexpected_error'          => 'Something went wrong. Please try again.',
    'payment_success'           => 'Payment successful! Your order is confirmed.',
    'payment_failed'            => 'Payment was not completed.',
    'price_updated'             => 'Some item prices were updated to reflect the latest prices.',
    'invalid_coupon'            => 'This coupon is invalid or has expired.',
    'coupon_applied'            => ':pct% discount applied successfully!',

    'success' => [
        'title'              => 'Order Confirmed',
        'heading'            => 'Order Confirmed!',
        'subheading'         => 'Thank you for your purchase. We\'re preparing your order.',
        'order_number'       => 'Order',
        'continue_shopping'  => 'Continue Shopping',
        'view_order'         => 'View Order',
        'email_note'         => 'A confirmation email has been sent to :email',
    ],

    'failed' => [
        'title'              => 'Payment Failed',
        'heading'            => 'Payment Not Completed',
        'subheading'         => 'Your order was not placed.',
        'default_reason'     => 'The payment could not be processed.',
        'order_details'      => 'Order Details',
        'what_happened'      => 'What might have happened?',
        'reason_card'        => 'Insufficient card balance',
        'reason_cancel'      => 'Payment was cancelled',
        'reason_timeout'     => 'Session timed out',
        'reason_funds'       => 'Card declined by bank',
        'stock_note'         => 'Any reserved items have been released back to stock.',
        'retry'              => 'Return to Cart & Try Again',
        'continue_shopping'  => 'Continue Shopping',
    ],
'session_expired' => 'Your checkout session expired. Please try again.',

];
