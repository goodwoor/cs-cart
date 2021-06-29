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

use Tygh\Registry;
use Tygh\Settings;

if (!defined('BOOTSTRAP')) { die('Access denied'); }


if ($mode == 'update') {

    if ($_REQUEST['addon'] == 'yml_export') {

        $version = fn_get_addon_version('yandex_market');
        if (!empty($version)) {
            Tygh::$app['view']->assign('yandex_market_on', true);
        } else {
            Tygh::$app['view']->assign('yandex_market_on', false);
        }
    }

}
