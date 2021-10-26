<?php

namespace App\Http\Controllers\Module\atlas\Admin;

use Illuminate\Http\Request;

class IndexController extends CommonController {
    public function __construct(Request $request) {
        parent::__construct($request);
        view()->share('nav_active', 'index');
    }

    //首页
    function index() {
        if ($this->request->getPathInfo() == '/admin/module') {
            return redirect(atlasModuleAdminJump($this->module_name, 'index'));
        }
        $tig = [
            'title' => '后台—首页',
            'controller' => 'Index'
        ];
        return $this->view('index.index', [
            'tig' => $tig,
        ]);

    }


}
