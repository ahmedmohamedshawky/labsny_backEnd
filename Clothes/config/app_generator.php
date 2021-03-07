<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */
    // $ php artisan infyom:app
    // $ php artisan infyom:app.rollback

    'schema' => [
        // Parents Tables
        /*[
            'model' => 'Shop',
            'fieldsFile' => 'schema/shops.json',
            'api' => true,
        ],
        [
            'model' => 'Category',
            'fieldsFile' => 'schema/categories.json',
            'api' => true,
        ],
        [
            'model' => 'FaqCategory',
            'fieldsFile' => 'schema/faq_categories.json',
            'api' => true,
        ],
        [
            'model' => 'OrderStatus',
            'fieldsFile' => 'schema/order_statuses.json',
            'api' => true,
        ],
        [
            'model' => 'Currency',
            'fieldsFile' => 'schema/currencies.json',
            'api' => true,
        ],
         [
            'model' => 'DeliveryAddress',
            'fieldsFile' => 'schema/delivery_addresses.json',
            'api' => true,
        ],

        // Child Tables
*/
        [
            'model' => 'Driver',
            'fieldsFile' => 'schema/drivers.json',
            'api' => true,
        ],
        [
            'model' => 'Earning',
            'fieldsFile' => 'schema/earnings.json',
            'api' => true,
        ],
        [
            'model' => 'DriversPayout',
            'fieldsFile' => 'schema/drivers_payouts.json',
            'api' => true,
        ],
        [
            'model' => 'ShopsPayout',
            'fieldsFile' => 'schema/shops_payouts.json',
            'api' => true,
        ],
        /*
        [
            'model' => 'Clothes',
            'fieldsFile' => 'schema/clothes.json',
            'api' => true,
        ],
        [
            'model' => 'Gallery',
            'fieldsFile' => 'schema/galleries.json',
            'api' => true,
        ],

        [
            'model' => 'ClothesReview',
            'fieldsFile' => 'schema/clothes_reviews.json',
            'api' => true,
        ],
        [
            'model' => 'ShopReview',
            'fieldsFile' => 'schema/shop_reviews.json',
            'api' => true,
        ],

        [
            'model' => 'Order',
            'fieldsFile' => 'schema/orders.json',
            'api' => true,
        ],
        [
            'model' => 'Cart',
            'fieldsFile' => 'schema/carts.json',
            'api' => true,
        ],
        [
            'model' => 'Nutrition',
            'fieldsFile' => 'schema/nutritions.json',
            'api' => true,
        ],
        [
            'model' => 'Extra',
            'fieldsFile' => 'schema/extras.json',
            'api' => true,
        ],
        [
            'model' => 'NotificationType',
            'fieldsFile' => 'schema/notification_types.json',
            'api' => true,
        ],
        [
            'model' => 'Notification',
            'fieldsFile' => 'schema/notifications.json',
            'api' => true,
        ],

        [
            'model' => 'Payment',
            'fieldsFile' => 'schema/payments.json',
            'api' => true,
        ],
        [
            'model' => 'Faq',
            'fieldsFile' => 'schema/faqs.json',
            'api' => true,
        ],

        // Pivot Table

        [
            'model' => 'Favorite',
            'fieldsFile' => 'schema/favorites.json',
            'api' => true,
        ],

        [
            'model' => 'ClothesOrder',
            'fieldsFile' => 'schema/clothes_orders.json',
            'api' => true,
        ],
        [
            'model' => 'CartExtra',
            'fieldsFile' => 'schema/cart_extras.json',
            'skip' => true,
        ],

        [
            'model' => 'UserShop',
            'fieldsFile' => 'schema/user_shops.json',
            'skip' => true,
        ],

         [
            'model' => 'DriverShop',
            'fieldsFile' => 'schema/driver_shops.json',
            'skip' => true,
        ],

        [
            'model' => 'ClothesOrderExtra',
            'fieldsFile' => 'schema/clothes_order_extras.json',
            'skip' => true,
        ],
        [
            'model' => 'FavoriteExtra',
            'fieldsFile' => 'schema/favorite_extras.json',
            'skip' => true,
        ],*/

    ],

//    'fields' => [
//        'boolean' => 'Boolean',
//        'checkbox' => 'Checkbox',
//        'date' => 'Date',
//        'email' => 'Email',
//        'number' => 'Number',
//        'password' => 'Password',
//        'radio' => 'Radio',
//        'select' => 'Select',
//        'selects' => 'Multi Selects',
//        'text' => 'Text',
//        'textarea' => 'Textarea'
//    ],

    'fields' => [
        'boolean',
        'checkbox',
        'date',
        'email',
        'number',
        'password',
        'radio',
        'select',
        'selects',
        'text',
        'textarea'
    ],
];
