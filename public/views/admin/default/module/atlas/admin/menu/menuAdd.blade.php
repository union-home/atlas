@include(atlasModuleAdminTemplate($moduleName)."public.header")

<body>

<!--                        Topbar End                              -->
<!-- ============================================================== -->


<!-- ============================================================== -->
<!-- 						Navigation Start 						-->
<!-- ============================================================== -->

@include(atlasModuleAdminTemplate($moduleName)."public.nav")
<!-- ============================================================== -->
<!-- 						Navigation End	 						-->
<!-- ============================================================== -->

<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">


    @include(atlasModuleAdminTemplate($moduleName)."public.left")


    <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                @include(atlasModuleAdminTemplate($moduleName)."public.page",
         ['breadcrumb'=>['系统设置','菜单添加']])
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content" style="margin-top: 1rem;">


                <div class="panel panel-flat">
                    <div class="panel-heading">

                        <form class="form-horizontal" method="post">
                            {{csrf_field()}}
                            <fieldset class="content-group">
                                <legend class="text-bold">列表</legend>

                                <div class="form-group">
                                    <label class="control-label col-lg-1">是否需要权限</label>
                                    <div class="col-lg-11">
                                        <label class="radio-inline">
                                            <input type="radio" name="type" class="styled h-radio"
                                                   checked value="1">
                                            <span class="h-span-val">是</span>
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="type" class="styled h-radio"
                                                   value="2">
                                            <span class="h-span-val">否</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-1">是否隐藏</label>
                                    <div class="col-lg-11">

                                        <label class="radio-inline">
                                            <input type="radio" name="is_hide" class="styled h-radio"
                                                   value="1">
                                            <span class="h-span-val">是</span>
                                        </label>

                                        <label class="radio-inline">
                                            <input type="radio" name="is_hide" class="styled h-radio"
                                                   checked value="2">
                                            <span class="h-span-val">否</span>
                                        </label>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-1">上级</label>
                                    <div class="col-lg-11">
                                        <select class="select-search" name="pid">
                                            <optgroup label="">
                                                <option value="0">
                                                    顶级
                                                </option>
                                                @foreach($menu_one as $one)
                                                    <option value="{{$one['id']}}">
                                                        {{$one['title']}}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        标题
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" id="title" name="title" class="form-control"
                                               style="float: left"
                                               placeholder="标题" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        控制器
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" name="controller" class="form-control"
                                               placeholder="控制器" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        方法
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" name="action" class="form-control"
                                               placeholder="方法" required>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        url路径
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" name="url" class="form-control"
                                               placeholder="url路径">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        顶级菜单图标
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" name="icon" class="form-control"
                                               placeholder="顶级菜单图标">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        排序
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" name="orders" class="form-control"
                                               placeholder="排序" value="0">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-lg-1 control-label"></label>
                                    <div class="col-lg-11">
                                        <button type="submit" class="btn btn-sm btn-info">
                                            提交
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="history.go(-1)">
                                            返回
                                        </button>
                                    </div>
                                </div>
                            </fieldset>

                        </form>
                    </div>
                </div>

                <!-- Footer -->
            @include(atlasModuleAdminTemplate($moduleName)."public.footer")
            <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>

<!-- 						Content End		 						-->
<!-- ============================================================== -->
@include(atlasModuleAdminTemplate($moduleName)."public.js")
<script type="text/javascript"
        src="{{atlasModuleAdminResource($moduleName)}}/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="{{atlasModuleAdminResource($moduleName)}}/js/pages/form_select2.js"></script>
</body>
</html>