<?php

namespace App\Http\Controllers\Module\atlas\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {
    /*
    CREATE TABLE `union_module_atlas_group` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键id',
    `type` varchar(30) DEFAULT '' COMMENT '用户类型， general_admin 普通管理员，city_admin = 城市管理员,merchant=商家, general_admin_default 默认普通管理员，city_admin_default = 默认城市管理员,merchant_default=默认商家',
    `group_name` varchar(20) NOT NULL DEFAULT '' COMMENT '权限组名称',
    `role_id` text COMMENT '权限id',
    `create_at` varchar(12) DEFAULT '' COMMENT '创建时间',
    `update_at` varchar(12) DEFAULT '' COMMENT '更新时间',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='权限组';
    */
    const TABLE_NAME = "module_atlas_group";
    public $table = self::TABLE_NAME;
    public $primaryKey = "id";
    public $timestamps = false;

    //列表
    public static function getGroupList($w) {
        return self::where($w)->orderByDesc('create_at')->paginate(env('LENGTH'));
    }

    //用户类型存在权限组
    public static function getGroupByType($type) {
        return self::where('type', $type . '_default')->first();
    }
}