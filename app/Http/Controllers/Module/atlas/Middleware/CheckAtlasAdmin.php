<?php

namespace App\Http\Controllers\Module\atlas\Middleware;

use App\Http\Controllers\Module\atlas\Models\Member;
use App\Http\Controllers\Module\atlas\Models\Menus;
use Closure;

class CheckAtlasAdmin {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        //检查是否登录，权限检查
        if (!session(Member::ADMIN_LOGIN_UNIQUE) && !session(Member::LOGIN_UNIQUE)) {
            /**
             * 不同的模块，返回自己的登陆界面
             */
            //获取当前路径，登录后依然回到该路径
            session()->put("previous", url()->current());
            return redirect('/');
        }

        if (session(Member::ADMIN_LOGIN_UNIQUE)) {
            //超级管理员和模块不共存
            session([Member::LOGIN_UNIQUE => NULL]);
            $userInfo = session(Member::ADMIN_LOGIN_UNIQUE);
            session(['login_type' => 'admin']);
        } elseif (session(Member::LOGIN_UNIQUE)) {
            $userInfo = session(Member::LOGIN_UNIQUE);
            session(['login_type' => 'user']);
        }
        $com = new \App\Http\Controllers\Module\atlas\Common\CommonController($request);
        session(['now_module' => $com->moduleName]);
        //获取菜单
        $menu_data = Menus::setMenus($userInfo);

        $permissions = $request->route()->getAction()['permissions'];
        //权限名
        if ($permissions && $userInfo['type'] != 'admin' && !in_array($permissions, $menu_data['permissions'])) {
            if ($request->ajax()) {
                exit(json_encode(['status' => 0, 'msg' => '没权限']));
            } else {
                return back()->with('errormsg', '没权限');
            }
        }

        session(['activeUserInfo' => $userInfo]);
        view()->share(array(
            'menu_one' => $menu_data['menu_one'],
            'menu_two' => $menu_data['menu_two'],
            'userInfo' => $userInfo,
        ));

//        dd($menu_data);
        return $next($request);
    }
}
