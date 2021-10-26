<?php

namespace App\Http\Controllers\Module\atlas\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Module\atlas\Common\CommonController;
use Illuminate\Support\Facades\DB;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Barryvdh\Snappy\Facades\SnappyImage as Image;

class ImageController extends CommonController {
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function toGanTeChartImage($data) {
        try {
            $png1 = "uploads/";
            $png2 = "ganTeChart/{$data['project_id']}.png";
            $png3 = $png1 . $png2;
            unlink(public_path($png3));
            $Image = Image::loadView(atlasModuleHomeTemplate($this->moduleName).'home.getGanTeChart', $data)->save($png3);

            return ['status' => 200, 'msg' => '生成图片成功', 'data' => [
                'image' => $png2,
                'image_view' => url($png3),
            ]];
        } catch (\Exception $e) {
            dd($e);
            return ['status' => 0, 'msg' => '生成图片失败'];
        }

    }

}






















