<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>进度图</title>
    <!-- 引入jquery -->
    <script type="text/javascript" src="{{bbsModuleHomeResource($moduleName)}}/js/jquery.min.js"></script>
    <!-- 引入bootstrap的js和css文件 -->
    <!-- 最新版本的 Bootstrap 核心 CSS 文件 -->
    <link rel="stylesheet" href="{{bbsModuleHomeResource($moduleName)}}/css/bootstrap.min.css">
    <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
    <script type="text/javascript" src="{{bbsModuleHomeResource($moduleName)}}/js/bootstrap.min.js"></script>
    <!-- 固定表头所需的js和css(bootstrap-table) -->
    <link rel="stylesheet" href="{{bbsModuleHomeResource($moduleName)}}/css/bootstrap-table.min.css">
    <script type="text/javascript" src="{{bbsModuleHomeResource($moduleName)}}/js/bootstrap-table.min.js"></script>
    <!-- 固定列所需的js和css(bootstrap-table-fixed-columns) -->
    <link rel="stylesheet" href="{{bbsModuleHomeResource($moduleName)}}/css/bootstrap-table-fixed-columns.css">
    <script type="text/javascript"
            src="{{bbsModuleHomeResource($moduleName)}}/js/bootstrap-table-fixed-columns.js"></script>

    <style>
        /*.fht-cell{width:120px!important;}
        .fixed-table-body-columns {
            top: 39px !important;;
        }*/
        .info {
            background-color: #d7e6f8;
        }

        .success {
            background-color: #d8f5c9;
        }

        .primary {
            background-color: #f8d7d7;
        }

        .h-span {
            padding: 10px 30px;
        }
        .h-title {
            margin: 20px 10px;
            font-size: 30px;
            float: left;
        }

        .h-status {
            float: left;
            margin: 30px 20px 20px 20px;
            font-size: 16px;
        }
        .h-center{
            text-align: center;
        }
    </style>
</head>
<body>
<div class="h-title">
    项目: {{$find['name']}}
</div>
<div class="h-status">
    <span class="h-span info">开发中</span>
    <span class="h-span success">已完成</span>
    <span class="h-span primary">待开发</span>
</div>
<br>
<table class="table table-bordered" id="table" data-toggle="table" data-height="768">
    <thead>
    <tr>
        @foreach($title_arr as $title)
            <th class="h-center">{{$title}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)

        @foreach($d['task'] as $v)
            <tr>
                <td class="h-center">{{$d['item']}}</td>
                <td class="h-center">
                    {{$v['start']}}
                    <br>-<br>
                    {{$v['end']}}
                </td>
                <td class="h-center">
                    {{(atlasDiffBetweenTwoDays($v["end"], $v['start']) + 1)}}
                </td>
                <td class="h-center @if($v["status"]==0) primary @elseif($v["status"]==1) info @elseif($v["status"]==2) success @endif ">{!! $v['content'] !!}</td>
                <td class="h-center" style="color: @if($v["status"]==0) red @elseif($v["status"]==1) blue @elseif($v["status"]==2) green @endif ">
                    @if($v["status"]==0)
                        待开发
                    @elseif($v["status"]==1)
                        开发中
                    @elseif($v["status"]==2)
                        已完成
                    @endif
                </td>
            </tr>
        @endforeach

    @endforeach
    </tbody>
</table>

{{--<script>
    $(function () {
        //#table表示的是上面table表格中的id
        $("#table").bootstrapTable('destroy').bootstrapTable({
            fixedColumns: true,
            fixedNumber: 1 //固定列数
        });
    })
</script>--}}

<script>
    $(function () {
        $('#table').bootstrapTable();
        $(window).resize(function () {
            $('#table').bootstrapTable('resetView');
        });
    })
</script>

</body>
</html>