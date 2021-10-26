<?php

namespace App\Http\Controllers\Module\atlas\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    /*
    CREATE TABLE `union_module_atlas_project` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
      `tig` varchar(30) NOT NULL DEFAULT '' COMMENT '项目标识',
      `name` varchar(30) NOT NULL DEFAULT '' COMMENT '项目名称',
      `describe` text NOT NULL COMMENT '项目描述',
      `create_at` datetime DEFAULT NULL COMMENT '创建时间',
      `update_at` int(11) DEFAULT '0' COMMENT '更新时间',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='项目表';
    */
    const TABLE_NAME = "module_atlas_project";
    public $table = self::TABLE_NAME;
    public $primaryKey = "id";
    public $timestamps = false;

    //
    public static function apiGetProjectList() {
        return self::orderByDesc('create_at')
            ->get([
                'id','name','tig'
            ])
            ->toArray();

    }

    //列表
    public static function getProjectList() {
        return self::orderByDesc('create_at')->paginate(env('LENGTH'));
    }
}