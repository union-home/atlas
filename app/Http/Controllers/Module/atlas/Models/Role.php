<?php

namespace App\Http\Controllers\Module\atlas\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    /*
    CREATE TABLE `union_module_atlas_role` (
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
    `uid` int(11) NOT NULL COMMENT '用户uid',
    `group_id` int(11) NOT NULL COMMENT '权限组id',
    `time` varchar(12) DEFAULT '' COMMENT '时间戳',
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='用户权限表';
    */
    //设置表名
    const TABLE_NAME = "module_atlas_role";
    public $table = self::TABLE_NAME;
    public $primaryKey = "id";
    public $timestamps = false;

    public static function groupUsers($gid) {
        $members = new Member();
        $Group = new Group();
        return self::from(self::TABLE_NAME)
            ->where(self::TABLE_NAME . '.group_id', $gid)
            ->leftJoin($members->table, $members->table . '.uid', '=', self::TABLE_NAME . '.uid')
            ->leftJoin($Group->table, $Group->table . '.id', '=', self::TABLE_NAME . '.group_id')
            ->select([
                $members->table . '.type',
                $members->table . '.username',
                $members->table . '.phone',
                $Group->table . '.group_name',
                self::TABLE_NAME . '.*',
            ])
            ->paginate(__E('admin_page_count'));

    }

    //通过uid获取组id
    public static function getGroupByUid($uid) {
        $Group = new Group();
        $find = self::from(self::TABLE_NAME)
            ->where(self::TABLE_NAME . '.uid', $uid)
            ->leftJoin($Group->table, $Group->table . '.id', '=', self::TABLE_NAME . '.group_id')
            ->select([
                $Group->table. '.id',
                $Group->table . '.role_id',
            ])
            ->first();
        return $find ? $find->toArray() : [];
    }
}
