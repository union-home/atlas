<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>进度图</title>
    <style>
        body, p {
            margin: 0;
            padding: 0;
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

        .h-span {
            padding: 10px 30px;
        }

        table {

            border-right: 1px solid #804040;

            border-bottom: 1px solid #804040;

            border-collapse: collapse;

        }

        table td {
            border-left: 1px solid #804040;
            border-top: 1px solid #804040;
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
{!! $html !!}
</body>
</html>