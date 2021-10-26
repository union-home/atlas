<?php

namespace App\Http\Controllers\Module\atlas\Home;

use App\Http\Controllers\Module\atlas\Common\CommonController;
use Illuminate\Http\Request;

class GanTeChartController extends CommonController {
    public function __construct(Request $request) {
        parent::__construct($request);
    }

    public function getGanTeChartOLd($arr, $data) {
        $html = '';
        $begin = new \DateTime($arr['start']);
        $end = (new \DateTime($arr['end']))->modify('+1 day');

        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval, $end);
        $html .= "<table style='width: 100%;border: 1px solid lightgrey'><tr>";
        $count = 0;
        foreach ($daterange as $date) {
            $html .= "<td style='min-width: 120px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;background-color:#d9edf7;'>" . $date->format("Y-m") . "</td>";
        }
        $html .= "</tr><tr>";
        foreach ($daterange as $date) {
            $count++;
            $html .= "<td style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;background-color:#999999;'>" . $date->format("d") . "</td>";
        }
        $html .= "</tr>";

        foreach ($data as $key => $value) {
            $html .= "<tr><td style='border: 1px solid lightgrey;background-color:#e6e6e6;' colspan='" . $count . "'>" . $value["item"] . "</td></tr>";
            foreach ($value["task"] as $key2 => &$value1) {
                $emp = false;
                $html .= "<tr>";
                foreach ($daterange as $date) {
                    switch ($value1["status"]) {
                        case 0:
                            $bg = 'primary';
                            break;
                        case 1:
                            $bg = 'info';
                            break;
                        case 2:
                            $bg = 'success';
                            break;
                    }
                    $date = $date->format("Y-m-d");
                    if ($date < $value1["start"]) {

                        /*if (!$value1["start_tig"]) {
                            $html .= "<td style='border: 1px solid lightgrey;text-align: center;' colspan='" . atlasDiffBetweenTwoDays($value1["start"], $arr['start']) . "'></td>";
                            $value1["start_tig"] = true;
                        }*/
                        $html .= "<td style='border: 1px solid lightgrey;text-align: center'></td>";
                    } else if ($date >= $value1["start"] && $date <= $value1["end"]) {
                        if ($emp) {

                        } else {
                            $emp = true;
                            $html .= "<td class='{$bg}' style='b;border: 1px solid lightgrey;text-align: center' colspan='" . (atlasDiffBetweenTwoDays($value1["end"], $value1["start"]) + 1) . "'>" . $value1["content"] . "</td>";
                        }

                    } else if ($date > $value1["end"]) {
                        /*if (!$value1["end_tig"]) {
                            $html .= "<td style='border: 1px solid lightgrey;text-align: center;' colspan='" . atlasDiffBetweenTwoDays($arr['end'], $value1["end"]) . "'></td>";
                            $value1["end_tig"] = true;
                        }*/
                        $html .= "<td style='border: 1px solid lightgrey;text-align: center'></td>";
                    }
                }
                $html .= "</tr>";

            }
        }


        $html .= "</table>";
        return $html;
    }

    public function getGanTeChart($find, $arr, $data) {
        $html = '';
        $begin = new \DateTime($arr['start']);
        $end = (new \DateTime($arr['end']))->modify('+1 day');

        $interval = new \DateInterval('P1D');
        $daterange = new \DatePeriod($begin, $interval, $end);
        $count = 0;

        $th = '';
        foreach ($daterange as $date) {
            $count++;
            //$th .= "<th style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;background-color:#999999;'>" . $date->format("Y-m-d") . "</th>";
            $th .= "<th>" . $date->format("Y") . '<br>' . $date->format("m") . '<br>' . $date->format("d") . "</th>";
        }


        foreach ($data as $key => $value) {
            $html .= "<tr><td style='border: 1px solid lightgrey;background-color:#e6e6e6;height: 60px;line-height: 60px;' colspan='" . $count . "'>( 主任务 ) " . $value["item"] . "</td></tr>";
            foreach ($value["task"] as $key2 => &$value1) {
                $emp = false;
                $html .= "<tr>";
                $value1["day_num"] = atlasDiffBetweenTwoDays($value1["end"], $value1["start"]) + 1;
                foreach ($daterange as $date) {
                    switch ($value1["status"]) {
                        case 0:
                            $bg = 'primary';
                            break;
                        case 1:
                            $bg = 'info';
                            break;
                        case 2:
                            $bg = 'success';
                            break;
                    }
                    $date = $date->format("Y-m-d");
                    if ($date < $value1["start"]) {

                        /*if (!$value1["start_tig"]) {
                            $html .= "<td style='border: 1px solid lightgrey;text-align: center;' colspan='" . atlasDiffBetweenTwoDays($value1["start"], $arr['start']) . "'></td>";
                            $value1["start_tig"] = true;
                        }*/
                        $html .= "<td style='border: 1px solid lightgrey;text-align: center'></td>";
                    } else if ($date >= $value1["start"] && $date <= $value1["end"]) {
                        if ($emp) {

                        } else {
                            $emp = true;
                            $day_str = "<br>( {$value1["day_num"]} 天 )";
                            $html .= "<td class='{$bg}' style='b;border: 1px solid lightgrey;text-align: center' colspan='" . $value1["day_num"] . "'>{$value1['name']} <br /> " ."描述：". $value1["content"] . "{$day_str}</td>";
                        }

                    } else if ($date > $value1["end"]) {
                        /*if (!$value1["end_tig"]) {
                            $html .= "<td style='border: 1px solid lightgrey;text-align: center;' colspan='" . atlasDiffBetweenTwoDays($arr['end'], $value1["end"]) . "'></td>";
                            $value1["end_tig"] = true;
                        }*/
                        $html .= "<td style='border: 1px solid lightgrey;text-align: center'></td>";
                    }
                }
                $html .= "</tr>";

            }
        }
        $row = [
            'find' => $find,
            'th' => $th,
            'html' => $html,
            'downloadGanTeChartImage' => true,
        ];
        if ($arr['return_type']) {
            return $row;
        } else {
            return $this->homeView('home.getGanTeChart', $row);
        }
    }

    public function getGanTeChart2($find, $data) {
        $title_arr = [
            '岗位', '周期', '天数', '内容', '状态'
        ];
        /*$html = '';
        $html .= "<table style='width: 80%;border: 1px solid lightgrey'><tr>";
        //标题
        foreach ($title_arr as $title) {
            $html .= "<td style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;background-color:#999999;'>" . $title . "</td>";
        }
        $html .= "</tr>";

        foreach ($data as $key => $value) {
            $task_count = count($value["task"]);

            foreach ($value["task"] as $key2 => &$value1) {
                switch ($value1["status"]) {
                    case 0:
                        $bg = 'primary';
                        $status_msg = '待开发';
                        $color = 'color:red;';
                        break;
                    case 1:
                        $bg = 'info';
                        $status_msg = '开发中';
                        $color = 'color:blue;';
                        break;
                    case 2:
                        $bg = 'success';
                        $status_msg = '已完成';
                        $color = 'color:green;';
                        break;
                }

                $html .= "<tr>";
                if ($key2 == 0) {
                    $html .= "<td style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;background-color:#e6e6e6;' rowspan='{$task_count}'>" . $value['item'] . "</td>";
                }
                $html .= "<td style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;padding: 14px 5px;'>" . $value1['start'] . '<br />-<br />' . $value1['end'] . "</td>";
                $html .= "<td style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;'>" . (atlasDiffBetweenTwoDays($value1["end"], $value1['start']) + 1) . "</td>";
                $html .= "<td style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;padding: 10px 0px;' class='{$bg}'>" . $value1['content'] . "</td>";
                $html .= "<td style='min-width: 20px !important;white-space:nowrap;border: 1px solid lightgrey;text-align: center;{$color}'>" . $status_msg . "</td>";
                $html .= "</tr>";
            }

        }


        $html .= "</table>";*/

        return $this->homeView('home.getGanTeChartTwo', [
            'find' => $find,
            'title_arr' => $title_arr,
            'data' => $data,
        ]);
    }
}
