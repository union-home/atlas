<?php

namespace App\Http\Controllers\Module\atlas\Admin;


use App\Http\Controllers\Module\atlas\Common\CommonController;
use App\Http\Controllers\Module\atlas\Models\Progress;
use Illuminate\Http\Request;

class GanTeChartController extends CommonController {

    public function __construct(Request $request) {
        parent::__construct($request);
    }

    //列表
    public function progressList(Request $request) {
        $all = $this->request->all();
        if ($all['project_id'] <= 0) return atlasOneFlash([0, '项目id不能为空']);
        $tig = [
            'title' => '项目列表',
            'controller' => 'Project',
            'action' => 'project/list',
        ];
        $data = Progress::getProgressList($all);
        return $this->view('project.progressList', [
            'tig' => $tig,
            'data' => $data,
        ]);
    }

    //添加
    public function progressAdd(Request $request) {
        $post = $this->request->all();
        if ($this->request->isMethod('POST')) {
            $if = $this->ifCondition([
                'project_id' => '项目id不能为空',
                'name' => '名称不能为空',
                //'rang' => '时间范围不能为空',
                //'content' => '进度描述不能为空',
            ]);
            if ($if['status'] == 0) return $if;
            $tmp_str = '<p><br></p>';
            $post['content'] = rtrim($post['content'], $tmp_str);
            $pid = intval($post['pid']);
            if ($pid > 0) {
                if (!$post['content'] || $post['content'] == $tmp_str) return atlasReturn(0, '进度描述不能为空');
                $rang = explode(' - ', $post['rang']);
                if (count($rang) != 2) return atlasReturn(0, '时间范围错误');
            }
            $res = Progress::query()->create([
                'project_id' => $post['project_id'],
                'name' => $post['name'],
                'pid' => $pid,
                'start' => $rang[0],
                'end' => $rang[1],
                'content' => $post['content'] ?: '',
                'status' => $post['status'],
            ]);
            if ($res) {
                return atlasReturn(200, '添加成功');
            } else {
                return atlasReturn(0, '添加失败');
            }

        } else {
            $tig = [
                'title' => '添加进度',
                'controller' => 'Project',
                'action' => 'project/list',
                'sub_url' => url($request->getPathInfo()),
                'return_url' => atlasModuleAdminJump($this->moduleName, 'project/progressList?project_id=' . $post['project_id']),
            ];
            $cate = Progress::apiGetProgressList([
                'project_id' => $post['project_id'],
            ]);
            return $this->view('project.progressAdd', [
                'tig' => $tig,
                'cate' => $cate,
            ]);
        }
    }

    //编辑
    public function progressEdit(Request $request) {
        $post = $this->request->all();
        if ($this->request->isMethod('POST')) {
            $if = $this->ifCondition([
                'id' => 'id不能为空',
                'name' => '名称不能为空',
                //'rang' => '时间范围不能为空',
                //'content' => '进度描述不能为空',
            ]);
            if ($if['status'] == 0) return $if;
            $tmp_str = '<p><br></p>';
            $post['content'] = rtrim($post['content'], $tmp_str);
            $pid = intval($post['pid']);
            if ($pid > 0) {
                if (!$post['content'] || $post['content'] == $tmp_str) return atlasReturn(0, '进度描述不能为空');
                $rang = explode(' - ', $post['rang']);
                if (count($rang) != 2) return atlasReturn(0, '时间范围错误');
            }


            $res = Progress::query()
                ->where(['id' => $post['id']])
                ->limit(1)
                ->update([
                    'name' => $post['name'],
                    'pid' => $pid,
                    'start' => $rang[0],
                    'end' => $rang[1],
                    'content' => $post['content'] ?: '',
                    'status' => $post['status'],
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
                'sub_url' => url($request->getPathInfo()),
                'return_url' => atlasModuleAdminJump($this->moduleName, 'project/progressList?project_id=' . $post['project_id']),
            ];
            $id = intval($this->request->id);
            if ($id <= 0) return atlasOneFlash([0, 'id错误']);
            $data = Progress::find($id);
            if (!$data) return atlasOneFlash([0, 'id错误']);
            $cate = Progress::apiGetProgressList([
                'project_id' => $post['project_id'],
            ]);
            return $this->view('project.progressEdit', [
                'tig' => $tig,
                'data' => $data,
                'cate' => $cate,
            ]);
        }
    }

    //删除
    public function progressDelete() {
        if (!$this->request->ajax()) return ['status' => 0, 'msg' => '请求方式错误'];
        $id = intval($this->request->id);
        if ($id <= 0) return ['status' => 0, 'msg' => 'id错误'];
        $menu = Progress::find($id);
        if (count($menu) <= 0) return ['status' => 0, 'msg' => 'id错误'];
        if (Progress::where('pid', $id)->count() > 0) return ['status' => 0, 'msg' => '有子任务暂时不能删除'];
        $res = Progress::destroy($id);
        if ($res) {
            return ['status' => 200, 'msg' => '删除成功'];
        }
        return ['status' => 0, 'msg' => '删除失败'];
    }


}
