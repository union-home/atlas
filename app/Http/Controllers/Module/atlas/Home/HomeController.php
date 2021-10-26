<?php

namespace App\Http\Controllers\Module\atlas\Home;

use App\Http\Controllers\Module\atlas\Api\ImageController;
use App\Http\Controllers\Module\atlas\Common\CommonController;
use App\Http\Controllers\Module\atlas\Models\Progress;
use App\Http\Controllers\Module\atlas\Models\Project;
use Illuminate\Http\Request;

class HomeController extends CommonController {
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function getGanTeChart() {
        set_time_limit(0);
        $all = $this->request->all();
        if ($all['project_id'] <= 0) exit();
        $find = Project::find($all['project_id']);
        if (!$find) exit;
        $data = Progress::homeGetProgressList($all);
        $start = Progress::homeGetProgressInfo([
            'project_id' => $all['project_id'],
            'sort_key' => 'start',
            'sort_val' => 'ASC',
        ]);
        $end = Progress::homeGetProgressInfo([
            'project_id' => $all['project_id'],
            'sort_key' => 'end',
            'sort_val' => 'DESC',
        ]);

        $gan = new GanTeChartController($this->request);

        $arr = [
            'start' => $start['start'],
            'end' => $end['end'],
        ];
        if ($all['view_type'] == 3) {
            $arr['return_type'] = 'image';
            $data = $gan->getGanTeChart($find, $arr, $data);
            unset($data['downloadGanTeChartImage']);
            $data['project_id'] = $all['project_id'];
            $data['moduleName'] = $this->moduleName;

            $image = new ImageController($this->request);
            $img = $image->toGanTeChartImage($data);
            if ($img['status'] == 0) die($img['msg']);
            $file = 'public/uploads';
            return response()->download(realpath(base_path($file)) . '/' . $img['data']['image'],
                "《{$find['name']}》任务进度时程表.png");
        } elseif ($all['view_type'] == 2) {
            return $gan->getGanTeChart2($find, $data);
        } else {
            return $gan->getGanTeChart($find, $arr, $data);
        }
    }
}
