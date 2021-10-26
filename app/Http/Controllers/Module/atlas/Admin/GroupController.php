<?php

namespace App\Http\Controllers\Module\atlas\Admin;

use App\Http\Controllers\Module\atlas\Common\CommonController;
use App\Http\Controllers\Module\atlas\Models\Group;
use App\Http\Controllers\Module\atlas\Models\Member;
use App\Http\Controllers\Module\atlas\Models\Menus;
use App\Http\Controllers\Module\atlas\Models\Role;
use Illuminate\Http\Request;

class GroupController extends CommonController {

    //列表
    public function groupList(Request $request) {
        $tig = [
            'title' => '权限组',
            'controller' => 'Group',
            'action' => 'group/groupList',
        ];
        $data = Group::getGroupList([]);
        return $this->view('group.groupList', [
            'tig' => $tig,
            'data' => $data,
        ]);
    }

    //添加
    public function groupAdd(Request $request) {

        $post = $this->request->all();
        $find = Group::where('group_name', $post['group_name'])->first();
        if (count($find)) return ['status' => 0, 'msg' => '权限组已存在'];
        $add = [
            'type' => $post['type'],
            'group_name' => trim($post['group_name']),
            'role_id' => '',
            'create_at' => time(),
            'update_at' => time(),
        ];
        $res = Group::insert($add);
        if ($res) {
            return ['status' => 200, 'msg' => '添加成功'];
        } else {
            return ['status' => 0, 'msg' => '添加失败'];
        }
    }

    //编辑
    public function groupEdit(Request $request) {
        $post = $this->request->all();
        $id = intval($post['id']);
        if ($id <= 0) return ['status' => 0, 'msg' => 'id错误'];
        $up['group_name'] = trim($post['group_name']);
        $up['update_at'] = time();
        $res = Group::where(['id' => $id])->limit(1)->update($up);
        if ($res) {
            return ['status' => 200, 'msg' => '更新成功'];
        }
        return ['status' => 0, 'msg' => '更新失败'];

    }

    //删除
    public function groupDelete(Request $request) {
        if (!$request->ajax()) return ['status' => 0, 'msg' => '请求方法错误'];
        $id = intval($request->id);
        if ($id <= 0) return ['status' => 0, 'msg' => 'id错误'];
        $res = Group::where(['id' => $id])->limit(1)->delete();
        if ($res) {
            return ['status' => 200, 'msg' => '删除成功'];
        }
        return ['status' => 0, 'msg' => '删除失败'];
    }

    //分配权限
    public function assignPermissions(Request $request) {
        if ($request->method() == 'POST') {
            $post = $this->request->all();
            $gid = intval($post['gid']);
            if ($gid <= 0) return newsOneFlash([0, 'id错误']);

            $up['role_id'] = implode(',', $post['role']);
            $up['update_at'] = time();
            $res = Group::where(['id' => $gid])->limit(1)->update($up);
            if ($res) {
                Menus::updateGroupMenu($gid, $post['role']);
                return newsOneFlash([200, '更新成功']);
            } else {
                return newsOneFlash([0, '更新失败']);
            }

        } else {
            $tig = [
                'title' => '权限组分配权限',
                'controller' => 'Group',
                'action' => 'group/groupList',
            ];
            $id = intval($request->id);
            if ($id <= 0) return newsOneFlash([0, 'id错误']);
            $data = Group::find($id);
            if (count($data) <= 0) return newsOneFlash([0, 'id错误']);

            $data['role_arr'] = $data['role_id'] ? explode(',', $data['role_id']) : [];
            $data['menu_one'] = Menus::getList(['pid' => 0]);
            $data['menu_two'] = Menus::getTwoList();
            return $this->view('group.assignPermissions', [
                'tig' => $tig,
                'data' => $data,
            ]);
        }
    }

    //组成员
    public function groupUsers(Request $request) {
        $tig = [
            'title' => '权限组成员',
            'controller' => 'Group',
            'action' => 'group/groupList',
        ];
        $id = intval($request->id);
        if ($id <= 0) return newsOneFlash([0, 'id错误']);

        $data = Role::groupUsers($id);

        return $this->view('group.groupUsers', [
            'tig' => $tig,
            'data' => $data,
        ]);
    }

    //给组分配人员
    public function groupAddUser(Request $request) {
        if ($request->method() == 'POST') {
            $post = $this->request->all();
            $gid = intval($request->gid);
            $uid = intval($request->uid);
            if ($gid <= 0 || $uid <= 0) return newsOneFlash([0, 'id错误']);

            $up = [
                'group_id' => $gid,
                'time' => time(),
            ];
            $res = Role::where(['uid' => $uid])->first();
            if ($res) {
                $row = Role::where(['uid' => $uid])->limit(1)->update($up);
            } else {
                $up['uid'] = $uid;
                $row = Role::insert($up);
            }
            if ($row) {
                return redirect(atlasModuleAdminJump($this->moduleName, 'group/groupUsers?id=' . $gid));
            } else {
                return newsOneFlash([0, '更新失败']);
            }
        } else {
            $tig = [
                'title' => '权限组添加成员',
                'controller' => 'Group',
                'action' => 'group/groupList',
            ];
            $data['user'] = Member::whereNotIn('type', ['admin'])->get()->toArray();

            $data['uid'] = $request->uid;
            $group_id = Role::where(['uid' => $request->uid])->value('group_id');
            $data['gid'] = $group_id ?: $request->id;
            $data['group'] = Group::get()->toArray();
            return $this->view('group.groupAddUser', [
                'tig' => $tig,
                'data' => $data,
            ]);
        }
    }

    //删除成员权限
    public function groupDeleteUser(Request $request) {
        if (!$request->ajax()) return ['status' => 0, 'msg' => '请求方式错误'];
        $id = intval($request->id);
        if ($id <= 0) return ['status' => 0, 'msg' => 'id错误'];
        $res = Role::where('id', $id)->limit(1)->delete();
        if ($res) {
            return ['status' => 200, 'msg' => '删除成功'];
        }
        return ['status' => 0, 'msg' => '删除失败'];
    }
}

