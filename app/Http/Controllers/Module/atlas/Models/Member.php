<?php

namespace App\Http\Controllers\Module\atlas\Models;

use App\Models\MembersVerifyLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Member extends Model {
    //设置表名
    const TABLE_NAME = 'members',
        DEFAULT_PASS = '123456',
        LOGIN_UNIQUE = 'home_info',
        ADMIN_LOGIN_UNIQUE = 'admin_info'; //登陆的 SESSION 标识
    public $table = self::TABLE_NAME;
    public $primaryKey = 'uid';
    public $timestamps = false;


    public static function makeUniqueUsername($user_name) {
        $old_name = $user_name;
        do {
            $user_name = $old_name . '_' . date('YmdHis') . '_' . random_verification_code();
        } while (self::where('username', '=', $user_name)->count() != 0);
        return $user_name;
    }

    //更改会员的登陆密码
    static function setUserPass($params) {
        $validator = Validator::make($params, [
            'phone_code' => 'required',
            'password' => 'required',
            'password_confirmation' => [
                'required',
                'same:password'
            ],
        ], [
            'phone_code.required' => '验证码为必填项！',
            'password.required' => '新密码为必填项！',
            'password_confirmation.required' => '确认密码为必填项！',
            'password_confirmation.same' => '新密码与确认密码不匹配！',
        ]);
        if ($validator->fails()) return return_api_format(['status' => 40000, 'msg' => $validator->errors()->first()]);

        if (empty($verify_code = MembersVerifyLogs::getLastVerifyCode($params['uid'], 1, 0)))
            return return_api_format(['status' => 40000, 'msg' => '验证码已失效，请重新发送！']);
        if ($verify_code->verify_receive != $params['phone'])
            return return_api_format(['status' => 40000, 'msg' => '该手机号与验证码不匹配！']);
        if (empty($params['phone_code']))
            return return_api_format(['status' => 40000, 'msg' => '请重新发送验证码！']);
        if ($verify_code->verify_code != $params['phone_code'])
            return return_api_format(['status' => 40000, 'msg' => '该验证码不匹配！']);
        if (empty($user = Member::lockForUpdate()->find($params['uid'])))
            return return_api_format(['status' => 40000, 'msg' => '账户已丢失，请重新登陆！']);


        if (empty($user = self::where([
            'uid' => $params['uid'],
        ])->lockForUpdate()->first())) {
            //return return_api_format([ 'status' => 40000, 'msg' => '旧密码不匹配！' ]);
        }

        DB::beginTransaction();
        try {
            //1.更新会员的资料
            $user->uid = !isset($params['uid']) ? 0 : $params['uid'];
            $user->update_at = date('Y-m-d H:i:s');
            $user->password = md5('union_' . md5($params['password']));
            $user->save();

            //2.认证记录表 更新操作
            MembersVerifyLogs::where('id', $verify_code->id)->update(['is_active' => 1]);

            DB::commit();

            return return_api_format(['status' => 40000, 'msg' => '更改登陆密码成功！']);
        } catch (\Exception $e) {
            DB::rollback();
            return return_api_format(['status' => 200, 'msg' => '更改登陆密码失败！']);
        }
    }


    //获取随机用户名
    public static function getRandUsername() {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $randStr = str_shuffle(str_shuffle($str));//打乱字符串
        $rands = substr($randStr, 0, 13);//substr(string,start,length);返回字符串的一部分
        return $rands;
    }

    public static function getPassword($password) {
        return md5('union_' . md5($password));
    }

    //注册插入
    function InsterArr($arr) {
        //判断是否开启注册功能
        if (__E("website_open_reg") != 1) return array("error" => "系统关闭注册功能！");

        if (!is_array($arr)) array('error' => '用户数据不全');

        if (isset($arr['reg_type']) && !$arr['password']) return array('error' => '密码不能为空');
        //密码是否一致
        if ($arr['password'] != $arr['password2']) return array('error' => '两次密码不一致！');


        //判断用户名是否重复
        $res = self::where('username', '=', $arr['username'])->count();

        if ($res) return array('error' => '用户名已存在！');


        if (isset($arr['phone'])) {
            $add['phone'] = $arr['phone'];
            $add['phone_active'] = 1;
        }
        $add['email'] = $arr['email'] ?: '';
        $add['pid'] = $arr['pid'] ?: 1;
        $add['username'] = $arr['username'] ?: '';
        $add['password'] = $arr['password'] ? self::getPassword($arr['password']) : '';
        $add['avatar'] = $arr['avatar'] ?: 'avatar/avatar.jpg';
        $add['nickname'] = $arr['nickname'] ?: '';
        $add['type'] = 'member';
        $add['status'] = 1;
        $add['create_at'] = $add['update_at'] = date('Y-m-d H:i:s');
        $bool = Member::insertGetId($add);
        if (!$bool)
            return array('error' => '注册失败！');
        else
            return $bool;
    }


    //通过filed查找数据
    function GetdataByFiled($arr, $type = 'admin') {
        $data = self::where([
            'username' => $arr['username'],
            'password' => \App\Models\Member::getPassword($arr['password'])
        ])
            ->where('type', '=', $type)
            ->orderBy('create_at', 'asc')
            ->first();
        if ($data) return $data->toArray();
        else return [];
    }

    //用户登录信息
    function getUserLogin($login_type, $arr, $type = 'admin') {
        $data = self::where('phone', $arr['phone']);
        if ($login_type == 1) {
            $data = $data->where('password', Member::getPassword($arr['password']));
        }
        return $data->where('type', '=', $type)->first();
    }

    //获取所有用户
    public static function getHomeUser($arr) {
        return self::where(function ($q) use ($arr) {
            if ($arr['user_type'] == 1) $q->where('type', '!=', 'admin');
            if ($arr['month'] == 1) $q->where(DB::Raw('DATE_FORMAT(create_at, "%Y-%m")'), date('Y-m'));
            if ($arr['day'] == 1) $q->where(DB::Raw('DATE_FORMAT(create_at, "%Y-%m-%d")'), date('Y-m-d'));
        })->count();
    }

    /*************************************************************/
    //用户列表
    public static function getAdminUserList($all) {
        $user = new Member();
        return self::where(self::TABLE_NAME . '.type', 'member')
            ->where(function ($q) use ($all) {
                if ($all['username']) $q->where(self::TABLE_NAME . '.username', $all['username'])
                    ->orWhere(self::TABLE_NAME . '.phone', $all['username']);
            })
            ->where(function ($q) use ($all) {
                if ($all['status'] > 0) $q->where(self::TABLE_NAME . '.status', $all['status'] - 1);
            })
            ->leftJoin($user->table . ' as user', 'user.uid', '=', self::TABLE_NAME . '.pid')
            ->orderByDesc(self::TABLE_NAME . '.create_at')
            ->select([
                self::TABLE_NAME . '.*',
                'user.username as pid_name',
            ])
            ->paginate(__E('admin_page_count'));
    }

    //商家列表
    public static function getAdminMerchantList($all) {
        $user = new Member();
        $personal = new PersonalSettings();
        return self::where(self::TABLE_NAME . '.type', 'merchant')
            ->where(function ($q) use ($all) {
                if ($all['username']) $q->where(self::TABLE_NAME . '.username', $all['username'])
                    ->orWhere(self::TABLE_NAME . '.phone', $all['username']);
            })
            ->where(function ($q) use ($all) {
                if ($all['status'] > 0) $q->where(self::TABLE_NAME . '.status', $all['status'] - 1);
            })
            ->join($personal->table . ' as personal', 'personal.uid', self::TABLE_NAME . '.uid')
            ->leftJoin($user->table . ' as user', 'user.uid', '=', self::TABLE_NAME . '.pid')
            ->orderByDesc(self::TABLE_NAME . '.create_at')
            ->select([
                self::TABLE_NAME . '.*',
                'user.username as pid_name',
                'personal.order_rate',
                'personal.withdrawal_rate',
            ])
            ->paginate(__E('admin_page_count'));
    }


    //店员列表
    public static function getAdminClerkList($all) {
        $user = new Member();
        $identity = new Identity();
        return self::where(self::TABLE_NAME . '.type', 'member')
            ->where(function ($q) use ($all) {
                if ($all['username']) $q->where(self::TABLE_NAME . '.username', $all['username'])
                    ->orWhere(self::TABLE_NAME . '.phone', $all['username']);
            })
            ->where(function ($q) use ($all) {
                if ($all['status'] > 0) $q->where(self::TABLE_NAME . '.status', $all['status'] - 1);
                if ($all['pid'] > 0) $q->where(self::TABLE_NAME . '.pid', $all['pid']);
            })
            ->join($identity->table . ' as identity', function ($q){
                $q->on('identity.uid', self::TABLE_NAME . '.uid')->where('identity.user_type',2);
            })
            ->leftJoin($user->table . ' as user', 'user.uid', '=', self::TABLE_NAME . '.pid')
            ->orderByDesc(self::TABLE_NAME . '.create_at')
            ->select([
                self::TABLE_NAME . '.*',
                'user.username as pid_name',
            ])
            ->paginate(__E('admin_page_count'));
    }

    //编辑
    public static function edit($w, $up) {
        if (count($w) <= 0 || count($up) <= 0) return false;
        return self::where($w)->update($up);
    }
}
