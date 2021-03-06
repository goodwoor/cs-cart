<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

if (!defined('BOOTSTRAP')) { die('Access denied'); }

fn_register_hooks(
    'get_shipping_info_post',
    'update_shipping_post',
    'prepare_checkout_payment_methods',
    'shippings_get_shippings_list_post',
    'checkout_select_default_payment_method',
    'update_payment_post',
    'delete_payment_post',
    'delete_shipping',
    'prepare_checkout_payment_methods_before_get_payments',
    'calculate_cart_content_before_shipping_calculation',
    'get_access_to_checkout',
    'allow_place_order_post'
);
