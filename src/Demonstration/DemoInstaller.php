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
namespace PrestaShop\Demonstration;

use PrestaShop\Demonstration\Config\ConfigurationProvider;
use PrestaShop\Demonstration\Entity\EntityFactory;

final class DemoInstaller
{
    public static function install()
    {
        foreach(ConfigurationProvider::processFromPath() as $section => $entities) {
            foreach($entities as $properties) {
                $entity = EntityFactory::createFromValues($section, $properties);
                $entity->save();
            }
        }
    }

    public static function uninstall()
    {
        $trashEntities = \Db::getInstance()->executeS('SELECT * FROM `'._DB_PREFIX_.'demonstration`');

        foreach ($trashEntities as $entity) {
            \Db::getInstance()->delete($entity['table_name'], $entity['id_name'].' IN ('.$entity['ids'].')');
        }
    }
}
