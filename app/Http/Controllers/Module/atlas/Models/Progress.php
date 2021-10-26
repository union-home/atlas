<?php

namespace App\Http\Controllers\Module\atlas\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model {
    /*
    CREATE TABLE `union_module_atlas_progress` (
      `id` int(11) DEFAULT NULL COMMENT '进度id',
      `pid` int(11) DEFAULT NULL COMMENT '进度pid',
      `start` date DEFAULT NULL COMMENT '开始时间',
      `end` date DEFAULT NULL COMMENT '结束时间',
      `content` text COMMENT '进度内容',
      `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
      `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间'
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='进度表';
    */
    const TABLE_NAME = "module_atlas_progress";
    const PK = "id";
    public $table = self::TABLE_NAME;
    public $primaryKey = self::PK;
    public $timestamps = true;
    protected $fillable = [
        'project_id',
        'name',
        'pid',
        'start',
        'end',
        'content',
        'status',
        'created_at',
        'updated_at',
    ];

    const status_0 = 0;
    const status_1 = 1;
    const status_2 = 2;
    const status = [
        self::status_0 => '待开发',
        self::status_1 => '开发中',
        self::status_2 => '已完成',
    ];

    //列表
    public static function apiGetProgressList($all) {
        return self::query()
            ->where('pid', 0)
            ->where('project_id', $all['project_id'])
            ->orderByDesc('created_at')
            ->get()
            ->toArray();

    }

    public function cate_list() {
        return $this->hasMany(self::class, 'pid', 'id');
    }

    //列表
    public static function getProgressList($all) {
        return self::query()
            ->where('project_id', $all['project_id'])
            ->where('pid', 0)
            ->with(['cate_list'])
            ->orderBy('created_at')
            ->paginate(env('LENGTH'));
    }

    public function task() {
        return $this->hasMany(self::class, 'pid', 'id');
    }

    //列表
    public static function homeGetProgressList($all) {
        return self::query()
            ->where('project_id', $all['project_id'])
            ->where('pid', 0)
            ->with(['task' => function ($q) {
                $q->select(['pid','name', 'content', 'start', 'end', 'status']);
            }])
            ->orderBy('created_at')
            ->get([
                'id', 'name as item'
            ])
            ->toArray();
    }

    public static function homeGetProgressInfo($all) {
        return self::query()
            ->where('project_id', $all['project_id'])
            ->where('pid', '>', 0)
            ->orderBy($all['sort_key'], $all['sort_val'])
            ->first();
    }
}