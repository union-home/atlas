<?php

use Illuminate\Support\Facades\Cache;

function atlasDealWithPhone($phone) {
    return substr($phone, 0, 3) . '****' . substr($phone, -4, 4);
}

//后台模块的模板地址简化函数
//参数$mo 是模块名
function atlasModuleAdminTemplate($mo) {
    $str = "admin." . ADMIN_SKIN . ".module." . $mo . ".admin.";
    return $str;
}

//后前模块的模板地址简化函数
//参数$mo 是模块名
function atlasModuleHomeTemplate($mo) {
    $str = "module." . $mo . ".";
    return $str;
}

//模块后台的静态资源文件路径
function atlasModuleAdminResource($mo = '') {
    $str = ADMIN_ASSET . "module/$mo/assets";
    return $str;
}

//模块前台的静态资源文件路径
function atlasModuleHomeResource($mo = '') {
    $str = MODULE_ASSET . "/$mo/assets";
    return $str;
}


//模块后台跳转链接简化
function atlasModuleAdminJump($mo, $path) {
    $str = url('module/admin/' . $mo) . '/' . $path;
    return $str;
}

//模块前台跳转链接简化
function atlasModuleHomeJump($mo, $path) {
    $str = url('module/' . $mo) . '/' . $path;
    return $str;
}

// 针对前台 ajax 返回 json 数据
// by andy update
// $status 为状态 成功 为200 其他都是失败
// $msg 返回提示信息
// $data 返回数据
function atlasReturnJson($status, $msg, $data = array()) {
    $arr = [
        'status' => $status,
        'msg' => $msg
    ];

    if (!empty($data)) {
        $arr['data'] = $data;
    }

    return json_encode($arr);
}

//获取时间格式
function atlasGetDay($type = 1) {
    if ($type == 2) {
        return date('Y-m-d');
    } else {
        return date('Y-m-d H:i:s');
    }
}

//返回数组json
function atlasReturn($status, $msg, $data = array()) {
    return ['status' => $status, 'msg' => $msg, 'data' => $data];
}

//数字保留几位
function atlasNumberFormat($price, $decimal = 2) {
    return number_format($price, intval($decimal), '.', '');
}

//条数
function atlasLimit() {
    $len = intval($_REQUEST['pagesize']);
    $page = intval($_REQUEST['page']);
    if ($len <= 0) $len = 10;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $len;
    //偏移量，条数
    return [
        0 => $offset,
        1 => $len,
        'skip' => $offset,
        'take' => $len,
    ];
}

//获取文件大小
function atlasGetSize($path, $type = 1) {
    if ($type == 2) {
        $info = filesize($path);
    } else {
        $info = filesize(public_path("uploads/$path"));
    }
    $size = $info / 1024;
    return number_format($size, 1, '.', '');
}

// $table=哪个表 / $filed=订单号的字段
function atlasGetOrderNum($table, $filed) {
    $order_num = date('ymdHis') . rand(1000, 9999) . rand(1000, 9999);
    for ($i = 1; $i <= 3; $i++) {
        $find = \Illuminate\Support\Facades\DB::table($table)->where($filed, $order_num)->first();
        if (!$find) {
            return $order_num;
            break;
        }
    }
    return false;
}

//处理多参数问题
function atlasDealStr($ids) {
    //有没有中文逗号
    $ids = str_replace('，', ',', $ids);
    $ids = str_replace(' ', '', $ids);
    $ids_arr = explode(',', $ids);
    $ids_arr = array_filter($ids_arr);
    $ids_arr = array_filter($ids_arr);
    $ids_arr = array_unique($ids_arr);
    $ids_arr = array_values($ids_arr);
    return $ids_arr;
}

//获取模块配置
function atlasGetModuleConfig($module, $filename) {
    return base_path("app/Http/Controllers/Module/$module/Config/$filename.php");
}

//循环加前缀
function atlasForPrefix($list, $field) {
    foreach ($list as &$val) {
        foreach ($field as $f) {
            $val[$f] = GetUrlByPath($val[$f]);
        }
    }
    return $list;
}


//返回信息
function atlasOneFlash($arr) {
    session(['tigStatus' => $arr[0]]);
    session(['tigMsg' => $arr[1]]);
    return back();
}

function atlasPermissions($path) {
    $group_id = session('user_group_id');
    $now_module = session('now_module');
    if ($now_module == 'atlas') {
        if (session(\App\Http\Controllers\Module\atlas\Models\Member::ADMIN_LOGIN_UNIQUE) && $group_id == 0) return '';
        $arr = \App\Http\Controllers\Module\atlas\Models\Menus::GROUP;
    }

    $permissions_str = Cache::get($arr[1] . '_' . $group_id);
    $data = json_decode($permissions_str, true);
    if (in_array($path, $data['permissions'])) {
        return '';
    } else {
        return 'hide';
    }
}

//用户类型
function atlasUserType() {
    return [
        ['name' => '默认普通管理员', 'tig' => 'general_admin_default'],
        ['name' => '普通管理员', 'tig' => 'general_admin'],
        ['name' => '默认商户', 'tig' => 'merchant_default'],
        ['name' => '商户', 'tig' => 'merchant'],
        ['name' => '默认用户', 'tig' => 'member_default'],
        ['name' => '用户', 'tig' => 'member'],
    ];
}

//获取模块配置
function atlasGetModulesConfig($modules, $filename) {
    return base_path('app/Http/Controllers/Module/' . $modules . '/Config/' . $filename . '.php');
}


//获取一年前
function atlasGetTimeRang() {
    return [date('Y-m-d', strtotime('-1 years', time())), date('Y-m-d')];
}

//获取第三方登录标识
function atlasGetThreeTigMsg($tig) {
    $msg = [
        'wx_app' => '微信APP账号',
        'wx_public' => '微信公众号账号',
        'wx_small' => '微信小程序账号',
        'bd_small' => '百度小程序账号',
        'apple' => '苹果账号',
        'qq' => 'QQ账号',
        'wb' => '微博账号',
    ];
    return $msg[$tig];
}

//判断第三方登录标识
function atlasCheckThreeTig($tig) {
    if (!atlasGetThreeTigMsg($tig)) {
        return false;
    } else {
        return true;
    }
}

/*
 * 获取纯文本
 * sub_len > 0 截取文本字段
 * sub_len = 0 计算文本字数
 * */
function atlasGetWordNum($string, $sub_len = 0) {

    $string = strip_tags($string);

    $string = preg_replace('/\n/is', '', $string);

    $string = preg_replace('/ |　/is', '', $string);

    $string = preg_replace('/&nbsp;/is', '', $string);

    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);


    if ($sub_len > 0) {
        if (count($t_string[0]) - 0 > $sub_len) $string = join('', array_slice($t_string[0], 0, $sub_len)) . "…";

        else $string = join('', array_slice($t_string[0], 0, $sub_len));

        return $string;
    } else {
        return mb_strlen($string);
    }
}

//获取中文字数
function atlasGetCNWordNum($str) {
    $newStr = preg_replace('/[^\x{4e00}-\x{9fa5}]/u', '', $str);
    return mb_strlen($newStr, "utf-8");
}

//获取调用Api的过滤key
function atlasGetAdminReqApiKey($str = '') {
    return md5(date('Y-m-d') . $str);
}

//获取支付方式
function atlasGetPayMethod() {
    return [
        'WeChat' => '微信',
        'Alipay' => '支付宝'
    ];
}

//认证状态
function atlasGetAgreementType() {
    return [
        1 => '注册协议',
        2 => '隐私协议',
        3 => '申请条款',
    ];
}

//递归   分类管理
function atlasGetTree($data, $pId, $arr) {
    $tree = [];
    foreach ($data as $k => $v) {
        if ($v[$arr['pid']] == $pId) {        //父亲找到儿子
            $v[$arr['pid']] = atlasGetTree($data, $v[$arr['table_id']], $arr);
            $tree[] = $v;
        }
    }

    return $tree;
}

// 添加 页显示 层级分类
function atlasGetAllOption($data, $i = 0, $check = false, $str = '') {
    for ($j = 0; $j < $i; $j++) {
        $str .= '─ ';
    }
    foreach ($data as $val) {
        if ($check && intval($val['cate_id']) === intval($check)) {
            echo "<option selected value='" . $val['cate_id'] . "' >" . $str . $val['name'] . "</option>";
        } else {
            echo "<option value='" . $val['cate_id'] . "'>" . $str . $val['name'] . "</option>";
        }
        if (count($val['pid']) > 0) {
            $i = 0;
            atlasGetAllOption($val['pid'], ++$i, $check, $str);
        }
    }
}

// 添加 页显示 层级分类
function atlasAddGoodsGetAllOption($data, $i = 0, $check = [], $str = '') {
    for ($j = 0; $j < $i; $j++) {
        $str .= '─ ';
    }
    foreach ($data as $val) {
        $option_tmp = session('option_tmp');
        if ($check && in_array(intval($val['cate_id']), $check)) {
            $option_tmp .= "<option selected value='" . $val['cate_id'] . "' >" . $str . $val['name'] . "</option>";

        } else {
            $option_tmp .= "<option value='" . $val['cate_id'] . "'>" . $str . $val['name'] . "</option>";
        }
        session(['option_tmp' => $option_tmp]);
        if (count($val['pid']) > 0) {
            $i = 0;
            atlasAddGoodsGetAllOption($val['pid'], ++$i, $check, $str);
        }
    }
}

//获取项目图片路径
function atlasGetImageUrl($tig, $path) {
    return url("uploads/pic_template/$tig/$path");
}

//获取图片排序
function atlasGetImageList($data, $tig) {
    foreach ($data as $key => $d) {
        $res = explode(' ', $d);
        $k_list[$key] = $res[0];
    }
    asort($k_list);
    foreach ($k_list as $k => $val) {
        $list[] = [
            'url' => atlasGetImageUrl($tig, $data[$k]),
            'name' => strchr($data[$k], '.png', true),
        ];
    }
    return $list;
}

/**
 *  * 求两个日期之间相差的天数
 *  * (针对1970年1月1日之后，求之前可以采用泰勒公式)
 *  * @param string $day1
 *  * @param string $day2
 *  * @return number
 *  */
function atlasDiffBetweenTwoDays($day1, $day2) {
    $second1 = strtotime($day1);
    $second2 = strtotime($day2);

    if ($second1 < $second2) {
        $tmp = $second2;
        $second2 = $second1;
        $second1 = $tmp;
    }
    return ($second1 - $second2) / 86400;
}