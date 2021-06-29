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

namespace Tygh\Addons\CommerceML\HookHandlers;

class ProductHookHandler
{
    /**
     * The "update_product_features_value_pre" hook handler
     *
     * @param int                    $product_id               Product ID
     * @param array<int, int|string> $product_features         List of feature values
     * @param array                  $add_new_variant          List of new variants that will be added when the features of a product are saved
     * @param string                 $lang_code                Two-letter language code (e.g. 'en', 'ru', etc.)
     * @param array<string, bool>    $params                   List of additional parameters
     * @param array<int>             $product_category_ids     List of the category identifiers
     * @param array<string>          $product_categories_paths Categories paths (e.g. ['1/2/3', '1/2/4'])
     *
     * @return void
     *
     * @see fn_update_product_features_value
     *
     * @psalm-param array<int, array{variant: string|int}> $add_new_variant
     */
    public static function onUpdateProductFeaturesValuePre(
        $product_id,
        array $product_features,
        array $add_new_variant,
        $lang_code,
        array $params,
        array $product_category_ids,
        array $product_categories_paths
    ) {
        if (empty($params['commerceml_update_product_feature_categories'])) {
            return;
        }

        $category_ids = array_map(static function ($path) {
            $ids = explode('/', $path);
            return array_pop($ids);
        }, $product_categories_paths);

        $features = db_get_array(
            'SELECT feature_id, categories_path, feature_code FROM ?:product_features WHERE feature_id IN (?a)',
            array_keys($product_features)
        );

        foreach ($features as $feature) {
            $feature_categories_ids = $feature['categories_path'] ? fn_explode(',', $feature['categories_path']) : [];
            $is_imported = strpos($feature['feature_code'], 'commerceml_') === 0;

            if (
                (empty($feature_categories_ids) && $is_imported)
                || (!empty($feature_categories_ids) && empty(array_intersect($feature_categories_ids, $product_category_ids)))
            ) {
                $new_categories_ids = $category_ids;
            }

            if (empty($new_categories_ids)) {
                continue;
            }

            fn_update_product_feature([
                'feature_code' => $is_imported ? '' : $feature['feature_code'],
                'categories_path' => implode(',', array_merge($feature_categories_ids, $new_categories_ids))
            ], $feature['feature_id']);
        }
    }
}
