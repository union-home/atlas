<?php

namespace App\Http\Controllers\Module\atlas\Api;

use App\Http\Controllers\Module\atlas\Common\CommonController;
use App\Http\Controllers\Module\atlas\Models\Project;
use Illuminate\Http\Request;


class IndexController extends CommonController {
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    //获取项目列表
    public function getProjectList() {
        if ($this->request->isMethod('OPTIONS')) return ['status' => 200];
        $data = Project::apiGetProjectList();
        return atlasReturn(200, '获取成功', $data);
    }
    //获取项目图片列表
    public function getProjectImageList() {
        if ($this->request->isMethod('OPTIONS')) return ['status' => 200];
        $id = intval($this->request->id);
        if ($id <= 0) return atlasReturn(0, 'id错误');
        $find = Project::find($id);
        if ($find['tig']) {
            $data = $this->scanFile($find['tig']);
            $list = atlasGetImageList($data,$find['tig']);
        } else {
            $list = [];
        }
        return atlasReturn(200, '获取成功', $list);
    }


}






















