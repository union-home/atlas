<?php

namespace App\Http\Controllers\Module\atlas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Menus extends Model {
    /*
    CREATE TABLE `union_module_atlas_menus` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
    `type` tinyint(1) DEFAULT '1' COMMENT '权限 1=需要权限  2=不用权限  ',
    `title` varchar(255) CHARACTER SET utf8 DEFAULT '' COMMENT '题目',
    `controller` varchar(25) CHARACTER SET utf8 DEFAULT '' COMMENT '控制器',
    `action` varchar(25) CHARACTER SET utf8 DEFAULT '' COMMENT '方法',
    `url` varchar(120) CHARACTER SET utf8 DEFAULT '' COMMENT 'url 连接',
    `is_hide` tinyint(4) DEFAULT '0' COMMENT '是否隐藏(2=不隐藏，1=隐藏)',
    `icon` varchar(25) CHARACTER SET utf8 DEFAULT '' COMMENT '顶级菜单图标',
    `pid` int(11) DEFAULT '0' COMMENT '上级菜单id',
    `orders` tinyint(4) DEFAULT '1' COMMENT '排序顺序',
    `create_at` varchar(12) DEFAULT '' COMMENT '创建时间',
    `update_at` varchar(12) DEFAULT '' COMMENT '更新时间',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';
    */
    //设置表名
    const TABLE_NAME = "module_atlas_menus";
    const GROUP = ['atlas_admin_menu', 'atlas_group_menu'];
    protected $table = self::TABLE_NAME;
    protected $primaryKey = "id";
    public $timestamps = false;

    //菜单列表
    public static function getList($w) {
        return self::where($w)->orderByDesc('orders')->get()->toArray();
    }

    //后台菜单管理的列表
    public static function getTwoList() {
        return self::where('pid', '>', 0)->orderByDesc('orders')->get()->toArray();
    }

    //后台菜单管理的列表
    public static function getMenu($w) {
        return self::where($w)
            ->orderBy('orders', 'Desc')
            ->get()->toArray();
    }

    //左侧列表
    public static function getMenuList($w) {
        $res = self::from(self::TABLE_NAME);
        if ($w['is_hide'] > 0) {
            $res = $res->where('is_hide', $w['is_hide']);
        }
        if (count($w['in']) > 0) {
            $res = $res->whereIn('id', $w['in']);
        }
        $res = $res->orderByDesc('orders')
            ->get()
            ->toArray();
        return $res;
    }

    public static function setMenus($user) {
        $data_menu = self::GROUP;
        if ($user['type'] == 'admin') {
            session(['user_group_id' => 0]);
            session()->save();
            $data['key'] = $data_menu[0];
            $menu_data_str = Cache::get($data_menu[0]);
            if ($menu_data_str) return json_decode($menu_data_str, true);
            $menu = self::getMenuList([]);
        } else {
            $group = Role::getGroupByUid($user['uid']);
            if (!$group) {
                $findGroup = Group::getGroupByType($user['type']);
                if (!$findGroup) return [];
                $group = [
                    'id' => $findGroup->id,
                    'role_id' => $findGroup->role_id,
                ];
            }
            session(['user_group_id' => $group['id']]);
            session()->save();
            $data['key'] = $data_menu[1] . '_' . $group['id'];
            $menu_data_str = Cache::get($data['key']);
            if ($menu_data_str) return json_decode($menu_data_str, true);
            $role_arr = explode(',', $group['role_id']);
            $menu = self::getMenuList(['in' => $role_arr]);
        }
        $all = self::forMenu($menu);
        Cache::forever($data['key'], json_encode($all));
        return $all;
    }

    public static function updateAdminMenu() {
        $menu = self::getMenuList([]);
        $all = self::forMenu($menu);
        Cache::forever(self::GROUP[0], json_encode($all));
    }

    public static function updateGroupMenu($gid, $role_arr) {
        $menu = self::getMenuList(['in' => $role_arr]);
        $all = self::forMenu($menu);
        Cache::forever(self::GROUP[1] . '_' . $gid, json_encode($all));
    }

    public static function forMenu($menu) {
        foreach ($menu as $m) {
            //权限
            if ($m['url'] != '#') {
                $role[] = $m['url'];
            }
            if ($m['pid'] == 0) {//一级菜单
                $menu_one[] = $m;
            } else if ($m['pid'] > 0) {//二级菜单
                $menu_two[] = $m;
            }
        }
        return [
            'menu_one' => $menu_one,
            'menu_two' => $menu_two,
            'permissions' => $role,
        ];
    }
}
