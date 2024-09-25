<?php

use portalium\menu\models\Menu;
use portalium\menu\models\MenuItem;
use yii\db\Migration;

class m010101_010102_site_menu extends Migration
{

    public function up()
    {
        $id_menu = Menu::find()->where(['slug' => 'web-main-menu'])->one()->id_menu;
        $id_item = MenuItem::find()->where(['slug' => 'site'])->one();

        if(!$id_item){
            $this->insert('menu_item', [
                'id_item' => NULL,
                'label' => 'Site',
                'slug' => 'site',
                'type' => '3',
                'style' => '{"icon":"fa-cog","color":"","iconSize":"","display":"1","childDisplay":"3"}',
                'data' => '{"data":{"url":"#"}}',
                'sort' => '1',
                'id_menu' => $id_menu,
                'name_auth' => 'admin',
                'id_user' => '1',
                'date_create' => '2022-06-13 15:32:26',
                'date_update' => '2022-06-13 15:32:26',
            ]);
        }else {
            $id_item = MenuItem::find()->where(['slug' => 'site'])->one()->id_item;
        }

        $id_item = MenuItem::find()->where(['slug' => 'site'])->one()->id_item;
        $this->batchInsert('menu_item', ['id_item', 'label', 'slug', 'type', 'style', 'data', 'sort', 'id_menu', 'name_auth', 'id_user', 'date_create', 'date_update'], [
            [NULL, 'Settings', 'setting', '2', '{"icon":"","color":"","iconSize":"","display":"","childDisplay":false}', '{"data":{"module":"site","routeType":"action","route":"\\/site\\/setting\\/index","model":null,"menuRoute":null,"menuType":"web"}}', 2, $id_menu, 'siteWebSettingIndex', 1,'2022-06-14 13:34:04', '2022-06-14 13:34:04'],
          //  [NULL, 'Preference', 'preference', '2', '{"icon":"","color":"","iconSize":"","display":false,"childDisplay":false}', '{"data":{"module":"site","routeType":"action","route":"\\/site\\/preference\\/index","model":null,"menuRoute":null,"menuType":"web"}}', 3, $id_menu, 'siteWebPreferenceIndex', 1,'2022-06-14 13:34:12', '2022-06-14 13:34:12'],
            [NULL, 'Language', 'language', '2', '{"icon":"fa fa-language","color":"","iconSize":"","display":"1","childDisplay":"3"}', '{"data":{"module":"site","routeType":"widget","route":"portalium\\\\site\\\\widgets\\\\Language","model":"","menuRoute":null,"menuType":"web"}}', 11, $id_menu, '', 1,'2022-06-14 13:34:36', '2022-06-14 13:34:36'],
            [NULL, 'Login', 'login', '2', '{"icon":"","color":"","iconSize":"","display":"1","childDisplay":"3"}', '{"data":{"module":"site","routeType":"widget","route":"portalium\\\\site\\\\widgets\\\\LoginButton","model":"","menuRoute":null,"menuType":"web"}}', 12, $id_menu, '', 1,'2022-06-14 13:35:38', '2022-06-14 13:35:38'],
            [NULL,'Profile','profile-site','2','{"icon":"fa-user","color":"","iconSize":"","display":"3","childDisplay":false}','{"data":{"module":"site","routeType":"action","route":"/site/profile/edit","model":"","menuRoute":null,"menuType":"web"}}',3,2,'',1,'2022-06-14 13:35:40','2022-06-14 13:35:40'],
            [NULL,'Profile','profile-main','2','{"icon":"","color":"","iconSize":"","display":"1","childDisplay":false}','{"data":{"module":"site","routeType":"widget","route":"portalium\\\\site\\\\widgets\\\\Profile","model":"","menuRoute":null,"menuType":"web"}}',17,$id_menu,'',1,'2022-06-14 13:35:40','2022-06-14 13:35:40'],
        ]);

        $ids = $this->db->createCommand('SELECT id_item FROM menu_item WHERE slug in ("setting")')->queryColumn();


        foreach ($ids as $id) {
            $this->insert('menu_item_child', [
                'id_item' => $id_item,
                'id_child' => $id
            ]);
        }


    }

    public function down()
    {

    }
}
