<?php
error_reporting(env('ERROR_LEVEL'));

use Illuminate\Support\Facades\Route;

$model_name = get_module_name(dirname(__DIR__));

//无需登录验证的
Route::group(['prefix' => strtolower($model_name), 'namespace' => $model_name . '\Api', 'middleware' => ['cors']], function () {
    //获取项目列表
    Route::any('/getProjectList', ["uses" => "IndexController@getProjectList", "permissions" => ""]);
    //获取项目图片列表
    Route::any('/getProjectImageList', ["uses" => "IndexController@getProjectImageList", "permissions" => ""]);
});

//登录验证的
Route::group(['prefix' => strtolower($model_name), 'namespace' => $model_name . '\Api', 'middleware' => ['cors', "jwt.auth"]], function () {

});