<?php
/**
 * 2007-2015 PrestaShop.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 *
 *  @author    PrestaShop SA <contact@prestashop.com>
 *  @copyright 2007-2015 PrestaShop SA
 *  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 *  International Registered Trademark & Property of PrestaShop SA
 */
namespace PrestaShop\Demonstration\Entity;

use PrestaShop\Demonstration\Contract\EntityInterface;
use Context;
use Product;

class ProductEntity implements EntityInterface
{
    public static function create(array $values)
    {
        $language = Context::getContext()->language;
        $shop = Context::getContext()->shop;
        $defaultCategoryId = $shop->getCategory();

        $product = new Product(null, false, $language->id);

        foreach ($values as $property => $value) {
            $product->{$property} = $value;
        }

        $product->link_rewrite = 'demonstration_product';
        $product->id_shop_default = $shop->id;
        $product->id_category_default = $defaultCategoryId;
        $product->active = 1;
        $product->save();

        return  [
            'id' => $product->id,
            'table_name' => 'product',
            'id_name' => 'id_product',
        ];
    }
}