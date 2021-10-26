<?php

namespace App\Http\Controllers\Module\atlas\Admin;


use App\Http\Controllers\Module\atlas\Common\CommonController;
use Illuminate\Http\Request;

class BaseController extends CommonController {


    public function __construct(Request $request) {
        parent::__construct($request);
    }


    public function baseConfig() {
        $tig = [
            'title' => '基本配置',
            'controller' => 'Setting',
            'action' => 'base/baseConfig',
        ];
        $path = atlasGetModulesConfig($this->moduleName, 'baseConfig');
        $signIn = atlasGetModulesConfig($this->moduleName, 'signInConfig');
        $data['base'] = include($path);
        $data['signIn'] = include($signIn);
        return $this->view('base.baseConfig', [
            'tig' => $tig,
            'data' => $data,
        ]);
    }

    public function baseConfigSubmit() {
        $all = $this->request->all();
        unset($all['_token']);
        switch ($all['type']) {
            case 'base':
                unset($all['type']);
                return $this->baseCommonConfig($all, 'baseConfig');
                break;
            case 'signIn':
                unset($all['type']);
                return $this->signInCommonConfig($all, 'signInConfig');
                break;
        }

    }

    //配置
    public function baseCommonConfig($data, $filename) {
        $path = atlasGetModulesConfig($this->moduleName, $filename);
        $new_data = var_export($data, true);
        $fp = fopen($path, "w+");
        if (fwrite($fp, "<?php return " . $new_data . ";")) {
            fclose($fp);
            return ['status' => 200, 'msg' => '更新成功'];
        } else {
            return ['status' => 0, 'msg' => '更新失败'];
        }
    }

    //签到
    public function signInCommonConfig($data, $filename) {
        $data['day_int'] = $this->realKeyValue($data['day_int']);
        $path = atlasGetModulesConfig($this->moduleName, $filename);
        $new_data = var_export($data, true);
        $fp = fopen($path, "w+");
        if (fwrite($fp, "<?php return " . $new_data . ";")) {
            fclose($fp);
            return ['status' => 200, 'msg' => '更新成功'];
        } else {
            return ['status' => 0, 'msg' => '更新失败'];
        }
    }

    //处理key value，过滤空的
    public function realKeyValue($data) {
        foreach ($data as $key => $value) {
            if (!$value['key'] || !$value['value']) {
                unset($data[$key]);
            }
        }
        array_multisort(array_column($data, 'key'), SORT_ASC, $data);
        array_values($data);
        return $data;
    }
}
