<?php

namespace App\Http\Controllers\Module\atlas\Admin;


use App\Http\Controllers\Module\atlas\Models\Menus;
use App\Http\Controllers\Module\atlas\Common\CommonController;
use Illuminate\Http\Request;

class MenuController extends CommonController {


    public function __construct(Request $request) {
        parent::__construct($request);
    }


    //列表
    public function menuList() {
        $tig = [
            'title' => '菜单列表',
            'controller' => 'Setting',
            'action' => 'menu/menuList',
        ];
        $one = Menus::getList(['pid' => 0]);
        $two = Menus::getTwoList();
        return $this->view('menu.menuList', [
            'tig' => $tig,
            'one' => $one,
            'two' => $two,
        ]);
    }

    //添加
    public function menuAdd() {
        if ($this->request->isMethod('POST')) {
            $post = $this->request->all();
            $res = Menus::insert([
                'type' => $post['type'],
                'title' => $post['title'],
                'controller' => $post['controller'],
                'action' => $post['action'],
                'url' => $post['url'],
                'is_hide' => $post['is_hide'],
                'icon' => $post['icon'],
                'pid' => $post['pid'],
                'orders' => $post['orders'],
                'create_at' => time(),
                'update_at' => time(),
            ]);
            if ($res) {
                Menus::updateAdminMenu();
                return redirect(atlasModuleAdminJump($this->moduleName, 'menu/menuList'));
            } else {
                return newsOneFlash([0, '添加失败']);
            }

        } else {
            $tig = [
                'title' => '菜单添加',
                'controller' => 'Setting',
                'action' => 'menu/menuList',
            ];
            $menu_one = Menus::getMenu(['pid' => 0]);
            return $this->view('menu.menuAdd', [
                'tig' => $tig,
                'menu_one' => $menu_one,
            ]);
        }
    }

    //编辑
    public function menuEdit() {
        if ($this->request->isMethod('POST')) {
            $post = $this->request->all();
            $id = $post['id'];
            if ($id <= 0) return oneFlash([0, 'id错误']);
            $res = Menus::where(['id' => $id])->limit(1)->update([
                'type' => $post['type'],
                'title' => $post['title'],
                'controller' => $post['controller'],
                'action' => $post['action'],
                'url' => $post['url'],
                'is_hide' => $post['is_hide'],
                'icon' => $post['icon'],
                'pid' => $post['pid'],
                'orders' => $post['orders'],
                'update_at' => time(),
            ]);
            if ($res) {
                Menus::updateAdminMenu();
                return redirect(atlasModuleAdminJump($this->moduleName, 'menu/menuList'));
            } else {
                return newsOneFlash([0, '编辑失败']);
            }
        } else {
            $tig = [
                'title' => '菜单编辑',
                'controller' => 'Setting',
                'action' => 'menuList',
            ];
            $id = intval($this->request->id);
            if ($id <= 0) return oneFlash([0, 'id错误']);
            $data = Menus::find($id);
            if (!$data) return oneFlash([0, 'id错误']);
            $menu_one = Menus::getMenu(['pid' => 0]);
            return $this->view('menu.menuEdit', [
                'tig' => $tig,
                'data' => $data,
                'menu_one' => $menu_one,
            ]);
        }
    }

    //删除
    public function menuDelete() {
        if (!$this->request->ajax()) return ['status' => 0, 'msg' => '请求方式错误'];
        $id = intval($this->request->id);
        if ($id <= 0) return ['status' => 0, 'msg' => 'id错误'];
        $menu = Menus::find($id);
        if (count($menu) <= 0) return ['status' => 0, 'msg' => 'id错误'];
        if ($menu['pid'] == 0) {
            $menus = Menus::where(['pid' => $menu['id']])->count();
            if ($menus > 0) return ['status' => 0, 'msg' => '存在下级菜单'];
        }
        $res = Menus::where(['id' => $id])->limit(1)->delete();
        if ($res) {
            Menus::updateAdminMenu();
            return ['status' => 200, 'msg' => '删除成功'];
        }
        return ['status' => 0, 'msg' => '删除失败'];
    }


}
