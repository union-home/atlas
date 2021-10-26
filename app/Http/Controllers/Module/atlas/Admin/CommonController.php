<?php

namespace App\Http\Controllers\Module\atlas\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller {
    protected $module_name;
    protected $module_url;

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->module_name = get_module_name(dirname(__DIR__));
        $this->module_url = 'module/admin/' . $this->module_name;
        view()->share('module_url', $this->module_url);
        view()->share('module_name', $this->module_name);
        self::autoload();
    }

    private static function autoload() {
        if (is_dir($libs_path = dirname(__DIR__) . '/libs')) auto_incluede_directory_files($libs_path);
    }

    public function view($path, $data) {
        $data['moduleName'] = $this->module_name;
        return view(atlasModuleAdminTemplate($data['moduleName']) . $path, $data);
    }

    //判断参数
    function ifCondition($arr) {
        $all = $this->request->all();
        foreach ($arr as $key => $val) {
            $req = 'required';
            $field[$key] = $req;
            $msg[$key . '.' . $req] = $val;
        }
        $validator = Validator::make($all, $field, $msg);
        if ($validator->fails()) return ['status' => 0, 'msg' => $validator->errors()->first()];
        return ['status' => 200];
    }
}
