<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$data['title']}}</title>
    <meta name="keywords" content="{{$data['seo_keywords']}}"/>
    <meta name="description" content="{{$data['seo_description']}}"/>
</head>
<body>
    {!! $data['content'] !!}
</body>
</html>