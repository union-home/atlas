<?php

namespace App\Http\Controllers\Module\atlas\Admin;


use App\Http\Controllers\Module\atlas\Models\Menus;
use App\Http\Controllers\Module\atlas\Common\CommonController;
use App\Http\Controllers\Module\atlas\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends CommonController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    //上传图片
    public function upload() {
        $image = UploadFile($this->request, 'image', "project/" . date('Y-m-d') . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
        if (count(explode('.', $image)) > 0) {
            $path = url('uploads/' . $image);
            return ['img' => $path];
        } else {
            return [];
        }

    }

    //列表
    public function list() {
        $tig = [
            'title' => '项目列表',
            'controller' => 'Project',
            'action' => 'project/list',
        ];
        $data = Project::getProjectList();
        return $this->view('project.list', [
            'tig' => $tig,
            'data' => $data,
        ]);
    }

    //添加
    public function add() {
        if ($this->request->isMethod('POST')) {
            $post = $this->request->all();
            $if = $this->ifCondition([
                'name' => '项目名称不能为空',
                'tig' => '项目标识不能为空',
            ]);
            if ($if['status'] == 0) return $if;
            if (Project::where('tig', $post['tig'])->first()) return atlasReturn(0, '项目标识已存在');
            $res = Project::insert([
                'name' => $post['name'],
                'tig' => $post['tig'],
                'describe' => $post['describe'] ?: '',
                'create_at' => atlasGetDay(),
                'update_at' => time(),
            ]);
            if ($res) {
                return atlasReturn(200, '添加成功');
            } else {
                return atlasReturn(0, '添加失败');
            }

        } else {
            $tig = [
                'title' => '项目添加',
                'controller' => 'Project',
                'action' => 'project/list',
            ];
            return $this->view('project.add', [
                'tig' => $tig,
            ]);
        }
    }

    //编辑
    public function edit() {
        if ($this->request->isMethod('POST')) {
            $post = $this->request->all();
            $id = $post['id'];
            if ($id <= 0) return atlasReturn(0, 'id错误');

            $if = $this->ifCondition([
                'name' => '项目名称不能为空',
                'tig' => '项目标识不能为空',
            ]);
            if ($if['status'] == 0) return $if;

            if (Project::where('tig', $post['tig'])->where('id', '!=', $id)->first()) return atlasReturn(0, '项目标识已存在');


            $res = Project::where(['id' => $id])->limit(1)->update([
                'name' => $post['name'],
                'tig' => $post['tig'],
                'describe' => $post['describe'] ?: '',
                'update_at' => time(),
            ]);
            if ($res) {
                return atlasReturn(200, '编辑成功');
            } else {
                return atlasReturn(0, '编辑失败');
            }
        } else {
            $tig = [
                'title' => '项目编辑',
                'controller' => 'Project',
                'action' => 'project/list',
            ];
            $id = intval($this->request->id);
            if ($id <= 0) return atlasOneFlash([0, 'id错误']);
            $data = Project::find($id);
            if (!$data) return atlasOneFlash([0, 'id错误']);
            return $this->view('project.edit', [
                'tig' => $tig,
                'data' => $data,
            ]);
        }
    }

    //删除
    public function delete() {
        if (!$this->request->ajax()) return ['status' => 0, 'msg' => '请求方式错误'];
        $id = intval($this->request->id);
        if ($id <= 0) return ['status' => 0, 'msg' => 'id错误'];
        $menu = Project::find($id);
        if (count($menu) <= 0) return ['status' => 0, 'msg' => 'id错误'];
        $res = Project::destroy($id);
        if ($res) {
            return ['status' => 200, 'msg' => '删除成功'];
        }
        return ['status' => 0, 'msg' => '删除失败'];
    }

    public function updateInterfaceDraft() {
        $all = $this->request->all();
        if ($this->request->isMethod('post')) {
            $id = intval($this->request->id);
            if ($id <= 0) return atlasReturn(0, 'id错误');
            $find = Project::find($id);

            $tmp_url = 'uploads/pic_template/' . $find['tig'];
            $zip = new \ZipArchive();//新建一个ZipArchive的对象
            if ($zip->open($_FILES['file']['tmp_name']) === TRUE) {
                //假设解压缩到在当前路径下images文件夹的子文件夹php
                $zip->extractTo($tmp_url);
                $zip->close();//关闭处理的zip文件
            } else {
                return atlasReturn(0, 'zip解压错误');
            }

            return atlasReturn(200, '操作成功');

        }
        $tig = [
            'title' => '项目界面稿',
            'controller' => 'Project',
            'action' => 'project/list',
        ];
        $id = intval($this->request->id);
        if ($id <= 0) return atlasOneFlash([0, 'id错误']);
        $find = Project::find($id);
        $data = $this->scanFile($find['tig']);
        $data = atlasGetImageList($data,$find['tig']);
        return $this->view('project.updateInterfaceDraft', [
            'tig' => $tig,
            'data' => $data,
            'project_tig' => $find['tig'],
        ]);
    }

}
