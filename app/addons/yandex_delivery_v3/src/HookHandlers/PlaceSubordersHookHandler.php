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

namespace Tygh\Addons\YandexDelivery\HookHandlers;

use Tygh\Addons\YandexDelivery\Services\YandexDeliveryService;

class PlaceSubordersHookHandler
{
    /**
     * The "place_suborders_pre" hook handler.
     *
     * Actions performed:
     * - Generates the correct keys of "shippings_extra" in suborder cart.
     *
     * @param int                                                                                                                         $order_id      Order identifier
     * @param array<string|int>                                                                                                           $cart          Cart contents
     * @param array<string|int>                                                                                                           $auth          Authentication data
     * @param string                                                                                                                      $action        Current action. Can be empty or "save"
     * @param int                                                                                                                         $issuer_id     Issuer identifier
     * @param array{shippings_extra?: array{data?: array<string|int>}, chosen_shipping?: array<int>, shipping?: array<array<string|int>>} $suborder_cart Child cart contents
     * @param int                                                                                                                         $key_group     Child cart products group key
     * @param array<string|int>                                                                                                           $group         Child cart products
     *
     * @see \fn_place_suborders()
     *
     * @return void
     */
    public function onPlaceSubordersPre($order_id, $cart, $auth, $action, $issuer_id, &$suborder_cart, $key_group, $group)
    {
        if (
            !isset($suborder_cart['chosen_shipping'][$key_group])
            || !isset($suborder_cart['shipping'][$suborder_cart['chosen_shipping'][$key_group]])
        ) {
            return;
        }

        $shipping = $suborder_cart['shipping'][$suborder_cart['chosen_shipping'][$key_group]];

        if (
            empty($shipping['module'])
            || $shipping['module'] !== YandexDeliveryService::MODULE
        ) {
            return;
        }

        if (!isset($suborder_cart['shippings_extra']['data'][$key_group])) {
            return;
        }

        $suborder_cart['shippings_extra']['data'] = [$suborder_cart['shippings_extra']['data'][$key_group]];
    }
}
