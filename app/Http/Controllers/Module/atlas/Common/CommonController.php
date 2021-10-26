<?php

namespace App\Http\Controllers\Module\atlas\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommonController extends Controller {

    public $moduleName;

    public function __construct(Request $request) {
        $this->moduleName = 'atlas';
        $this->request = $request;
    }

    public function view($path, $data) {
        $data['moduleName'] = $this->moduleName;
        return view(atlasModuleAdminTemplate($data['moduleName']) . $path, $data);
    }

    public function homeView($path, $data) {
        $data['moduleName'] = $this->moduleName;
        return view(atlasModuleHomeTemplate($data['moduleName']) . $path, $data);
    }

    //获取key
    function getCodeKey($phone) {
        return md5('atlas' . date('Ymd') . $phone);
    }

    //检测手机号
    function checkPhone($phone) {
        $check = '/^(1([3456789][0-9]))\d{8}$/';
        if (preg_match($check, $phone)) {
            return true;
        } else {
            return false;
        }
    }

    //检测邮箱
    function checkEmail($email) {
        return @checkdnsrr(array_pop(explode("@", $email)), "MX");
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

    //读取目录
    public function scanFile($tig) {
        $path = public_path('uploads');
        $path = $path . '/pic_template/' . $tig;
        $files = scandir($path);//读取

        $files = array_diff($files, [".", ".."]);//删除
        $files = array_merge($files);//重新排key

        foreach ($files as $file) {
            if (is_dir($path . '/' . $file)) {
                $result1[] = $file;
            } else {
                $result2[] = basename($file);
            }
        }
        $result1 = $result1 ?: [];
        $result2 = $result2 ?: [];
        $result = array_merge($result1, $result2);
        return $result;
    }
}
