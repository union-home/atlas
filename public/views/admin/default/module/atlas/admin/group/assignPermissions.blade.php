@include(atlasModuleAdminTemplate($moduleName)."public.header")
<style>
    input[type=checkbox] {
        width: 18px;
        height: 18px;
    }

    .h-one-title {
        position: relative;
        top: -3px;
        font-size: 20px;
        cursor: pointer;
    }

    .h-two-title {
        position: relative;
        top: 2px;
        font-size: 15px;
        cursor: pointer;
    }
</style>
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

        <!-- Main sidebar -->
        <div class="sidebar sidebar-main">
            <div class="sidebar-content">
                @include(atlasModuleAdminTemplate($moduleName)."public.left")
            </div>
        </div>
        <!-- /main sidebar -->


        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">

            @include(atlasModuleAdminTemplate($moduleName)."public.page",
            ['breadcrumb'=>['权限管理','权限组分配权限']])

            <!-- Content area -->
                <div class="content" style="margin-top: 1rem;">


                    <!-- Bordered striped table -->
                    <div class="col-sm-12">
                        <div class="panel panel-default col-sm-12" style="padding-top: 10px;">
                            <form id="add" role="form" method="post"
                                  action="{{atlasModuleAdminJump($moduleName,'group/assignPermissions')}}" >
                                {{csrf_field()}}
                                <dl class="permission-list">
                                    {{--<dt><label class="middle"></label></dt>--}}
                                    <dd>
                                        @foreach($data['menu_one'] as $one)
                                            <dl class="cl permission-list2">
                                                <dt>
                                                    <label class="i-checks col-lg-2 h-checkbox-one"
                                                    style="margin-top: 20px;font-weight: bold;">
                                                        <input type="checkbox" name="role[]" value="{{$one['id']}}"
                                                               @if(in_array($one['id'],$data['role_arr'])) checked @endif >
                                                        <span class="h-one-title">{{$one['title']}}</span>
                                                    </label>
                                                </dt>
                                                <dd class="col-lg-12">
                                                    @foreach($data['menu_two'] as $two)
                                                        @if($two['pid'] == $one['id'])
                                                            <label class="checkbox-inline i-checks col-lg-1.5 h-checkbox-two">
                                                                <input type="checkbox" name="role[]"
                                                                       value="{{$two['id']}}"
                                                                       @if(in_array($two['id'],$data['role_arr'])) checked @endif >
                                                                <span class="h-two-title">{{$two['title']}}</span>
                                                            </label>
                                                        @endif
                                                    @endforeach
                                                </dd>
                                            </dl>
                                        @endforeach
                                    </dd>
                                </dl>
                                <div class="Button_operation"
                                     style="margin: 80px auto;clear: both;position: relative;top: 52px;left: 10px">
                                    <input type="hidden" name='gid' value="{{$data['id']}}">
                                    <button class="btn btn-primary radius" type="submit"><i
                                                class="fa fa-save "></i>
                                        提交
                                    </button>
                                    <button type="button" class="btn btn-danger"
                                            onclick="window.location='{{atlasModuleAdminJump($moduleName,'group/groupList')}}'">
                                        返回
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- /bordered striped table -->


                    <!-- Footer -->
                @include(atlasModuleAdminTemplate($moduleName)."public.footer")
                <!-- /footer -->

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
    </div>

    <!-- /content -->
    <!-- 						Content End		 						-->
    <!-- ============================================================== -->
    @include(atlasModuleAdminTemplate($moduleName)."public.js")
    <script>
        /*按钮选择*/
        $(function () {
            $(".permission-list dt input:checkbox").click(function () {
                $(this).closest("dl").find("dd input:checkbox").prop("checked", $(this).prop("checked"));
            });
            $(".permission-list2 dd input:checkbox").click(function () {
                var l = $(this).parent().parent().find("input:checked").length;
                var l2 = $(this).parents(".permission-list").find(".permission-list2 dd").find("input:checked").length;
                if ($(this).prop("checked")) {
                    $(this).closest("dl").find("dt input:checkbox").prop("checked", true);
                    //$(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked", true);
                } else {
                    if (l == 0) {
                        $(this).closest("dl").find("dt input:checkbox").prop("checked", false);
                    }else if (l2 == 0) {
                        $(this).parents(".permission-list").find("dt").first().find("input:checkbox").prop("checked", false);
                    }
                }

            });
        });
    </script>
</body>
</html>