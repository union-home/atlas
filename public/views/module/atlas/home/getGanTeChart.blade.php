<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>《{{$find['name']}}》任务进度时程表</title>
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
        .grey {
            background-color: #e6e6e6;
        }

        .info {
            background-color: #d7e6f8;
        }

        .success {
            background-color: #d8f5c9;
        }

        .primary {
            background-color: #f8d7d7;
        }

        .sky-blue {
            background-color: #00BCF9;
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

        .h-center {
            text-align: center;
        }

        .h-cp {
            cursor: pointer;
        }

        .h-download {
            float: right;
            padding-top: 22px;
            padding-right: 50px;

        }

        img {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div>
    <div class="h-title">
        项目: {{$find['name']}}
    </div>
    <div class="h-status">
        <span class="h-span grey">主任务</span>
        <span class="h-span info">开发中</span>
        <span class="h-span success">已完成</span>
        <span class="h-span primary">待开发</span>

    </div>
    @if($downloadGanTeChartImage)
        <div class="h-download">
            <img src="{{bbsModuleHomeResource($moduleName)}}/img/download.png" width="40"
                 onclick="window.location='{{atlasModuleHomeJump($moduleName,"getGanTeChart?project_id={$_GET['project_id']}&view_type=3")}}'">
        </div>
    @endif
</div>
<br>
<table class="table table-bordered" id="table" data-toggle="table" data-height="800">
    <thead>
    <tr>
        {!! $th !!}
    </tr>
    </thead>
    <tbody>
    {!! $html !!}
    </tbody>
</table>

<script>
    $(function () {
        $('#table').bootstrapTable();
        $(window).resize(function () {
            $('#table').bootstrapTable('resetView');
        });
    })
    // alert(document.documentElement.clientHeight);
    // alert(document.documentElement.clientWidth);

</script>

</body>
</html>