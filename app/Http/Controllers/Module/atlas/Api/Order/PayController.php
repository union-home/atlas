<?php

namespace App\Http\Controllers\Module\atlas\Api\Order;

use App\Http\Controllers\Module\atlas\Common\CommonController;
use Illuminate\Http\Request;



class PayController extends CommonController {
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    //订单回调接口
    public function orderCallback($data) {
        $this->realOrderCommon($data);
    }

    public function realOrderCommon($data) {
        $order = Order::where('order_num', $data['out_trade_no'])->first();
        if (!$order) return AtlasReturn(0, '订单不存在');
        if ($order['pay_status'] != 0) return AtlasReturn(0, '状态已改');
        //更新订单
    }


}






















