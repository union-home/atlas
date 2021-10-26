<?php
$model_name = get_module_name(dirname(__DIR__));
Route::group(['prefix' => strtolower($model_name), 'namespace' => $model_name . '\Home', 'middleware' => ['web']], function () {
    //http://xx.com/module/$model_name/index
    Route::any('getGanTeChart', ["uses" => "HomeController@getGanTeChart", "permissions" => ""]);
    Route::any('testGan', ["uses" => "GanTeChartController@testGan", "permissions" => ""]);
});
Route::group(['prefix' => strtolower($model_name), 'namespace' => $model_name . '\Home', 'middleware' => ['web']], function () {
    //http://xx.com/module/$model_name/index
});
