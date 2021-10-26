<?php

namespace App\Http\Controllers\Module\atlas\Admin;

use App\Http\Controllers\Module\atlas\Common\CommonController;
use App\Http\Controllers\Module\atlas\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends CommonController {

    //列表
    public function info(Request $request) {
        $all = $this->request->all();
        if ($request->isMethod('POST')) {
            if (session('login_type') == 'admin') {
                $userInfo = session(Member::ADMIN_LOGIN_UNIQUE);
            } else {
                $userInfo = session(Member::LOGIN_UNIQUE);
            }
            if ($all['username']) {
                $find = Member::where('uid', '!=', $userInfo['uid'])->where('username', $all['username'])->count();
                if ($find) return atlasOneFlash([0, '用户名已存在']);
                $userInfo['username'] = $up['username'] = $all['username'];
            }
            if ($all['nickname']) {
                $userInfo['nickname'] = $up['nickname'] = $all['nickname'];
            }
            if ($all['password']) {
                $userInfo['password'] = $up['password'] = Member::getPassword($all['password']);
            }


            if ($all['male']) {
                $userInfo['male'] = $up['male'] = $all['male'];
            }


            if ($all['birthday']) {
                $userInfo['birthday'] = $up['birthday'] = $all['birthday'];
            }


            //上传文件
            if (isset($_FILES['images']) && $_FILES['images']["size"] > 0) {
                $images = UploadFile($this->request, "images", "avatar/" . date("Y-m-d") . "/" . uniqid(), ALLOWEXT, __E("upload_driver"));
                if (count(explode('.', $images)) == 2) {
                    $userInfo['avatar'] = $up['avatar'] = $images;
                } else {
                    return atlasOneFlash([0, "上传失败"]);
                }
            }

            $up['update_at'] = atlasGetDay();
            if (Member::where('uid', $userInfo['uid'])->limit(1)->update($up)) {
                if (session('login_type') == 'admin') {
                    session([Member::ADMIN_LOGIN_UNIQUE => $userInfo]);
                } else {
                    session([Member::LOGIN_UNIQUE => $userInfo]);
                }
                return atlasOneFlash([200, '更新成功']);
            } else {
                return atlasOneFlash([0, '更新失败']);
            }

        } else {
            $tig = [
                'title' => '我的信息',
                'controller' => 'Info',
                'action' => 'user/info',
            ];
            return $this->view('user.info', [
                'tig' => $tig,
            ]);
        }
    }
}

