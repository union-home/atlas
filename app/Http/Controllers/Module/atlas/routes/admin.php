<?php
$model_name = get_module_name(dirname(__DIR__));
Route::group(['prefix' => $model_name, 'namespace' => $model_name . '\Admin', 'middleware' => ['AdminLanguage']], function () {

    // 后台不需要登录 http://xx.com/module/admin/$model_name/login
    //后台登录
    Route::any('login', ["uses" => "IndexController@login", "permissions" => ""]);
    //后台退出
    Route::any('logout', ["uses" => "IndexController@logout", "permissions" => ""]);


});

Route::group(['prefix' => $model_name, 'namespace' => $model_name . '\Admin', 'middleware' => ['CheckAtlasAdmin']], function () {
    // 后台首页
    Route::any('/index', ["uses" => "IndexController@index", "permissions" => "index"]);

    // 项目
    Route::group(["prefix" => "project"], function () {
        Route::any('list', ["uses" => "ProjectController@list", "permissions" => "project/list"]);
        Route::any('add', ["uses" => "ProjectController@add", "permissions" => "project/add"]);
        Route::any('edit', ["uses" => "ProjectController@edit", "permissions" => "project/edit"]);
        Route::any('delete', ["uses" => "ProjectController@delete", "permissions" => "project/delete"]);
        Route::any('upload', ["uses" => "ProjectController@upload", "permissions" => ""]);
        Route::any('updateInterfaceDraft', ["uses" => "ProjectController@updateInterfaceDraft", "permissions" => "project/updateInterfaceDraft"]);

        Route::any('progressList', ["uses" => "GanTeChartController@progressList", "permissions" => "project/progressList"]);
        Route::any('progressAdd', ["uses" => "GanTeChartController@progressAdd", "permissions" => "project/progressAdd"]);
        Route::any('progressEdit', ["uses" => "GanTeChartController@progressEdit", "permissions" => "project/progressEdit"]);
        Route::any('progressDelete', ["uses" => "GanTeChartController@progressDelete", "permissions" => "project/progressDelete"]);
    });
    // 菜单设置
    Route::group(["prefix" => "menu"], function () {
        // 菜单导航
        Route::any('menuList', ["uses" => "MenuController@menuList", "permissions" => "menu/menuList"]);
        Route::any('menuAdd', ["uses" => "MenuController@menuAdd", "permissions" => "menu/menuAdd"]);
        Route::any('menuEdit', ["uses" => "MenuController@menuEdit", "permissions" => "menu/menuEdit"]);
        Route::any('menuDelete', ["uses" => "MenuController@menuDelete", "permissions" => "menu/menuDelete"]);
    });

    //基本配置
    Route::group(["prefix" => "base"], function () {
        Route::any('baseConfig', ["uses" => "BaseController@baseConfig", "permissions" => "base/baseConfig"]);
        Route::any('baseConfigSubmit', ["uses" => "BaseController@baseConfigSubmit", "permissions" => "base/baseConfigSubmit"]);

    });
    //用户
    Route::group(["prefix" => "user"], function () {
        Route::any('info', ["uses" => "UserController@info", "permissions" => "user/info"]);
    });

    // 权限组
    Route::group(["prefix" => "group"], function () {
        Route::any('groupList', ["uses" => "GroupController@groupList", "permissions" => "group/groupList"]);
        Route::any('groupAdd', ["uses" => "GroupController@groupAdd", "permissions" => "group/groupAdd"]);
        Route::any('groupEdit', ["uses" => "GroupController@groupEdit", "permissions" => "group/groupEdit"]);
        Route::any('groupDelete', ["uses" => "GroupController@groupDelete", "permissions" => "group/groupDelete"]);
        Route::any('assignPermissions', ["uses" => "GroupController@assignPermissions", "permissions" => "group/assignPermissions"]);
        Route::any('groupUsers', ["uses" => "GroupController@groupUsers", "permissions" => "group/groupUsers"]);
        Route::any('groupAddUser', ["uses" => "GroupController@groupAddUser", "permissions" => "group/groupAddUser"]);
        Route::any('groupDeleteUser', ["uses" => "GroupController@groupDeleteUser", "permissions" => "group/groupDeleteUser"]);
    });




});