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
            ['breadcrumb'=>['项目管理',$tig['title']]])

            <!-- Content area -->
                <div class="content" style="margin-top: 1rem;">


                    <!-- Bordered striped table -->
                    <div class="col-sm-12">
                        <div class="table-responsive panel panel-default">
                            <div class="panel-heading">
                                <a class="label bg-info pull-right m-t-xs {{atlasPermissions('project/add')}}"
                                   href="{{atlasModuleAdminJump($moduleName,'project/add')}}">
                                    添加
                                </a>
                                列表
                            </div>
                            <table class="table table-striped m-b-none col-sm-12">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>项目名称</th>
                                    <th>项目标识</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($data as $d)
                                    <tr>
                                        <td>{{$d['id']}}</td>
                                        <td>{{$d['name']}}</td>
                                        <td>{{$d['tig']}}</td>
                                        <td>{{$d['create_at']}}</td>
                                        <td>
                                            <a href="{{atlasModuleAdminJump($moduleName,'project/edit?id='.$d['id'])}}"
                                               class="{{atlasPermissions('project/edit')}}">
                                                <button type="button" class="h-button-edit btn btn-info btn-xs">
                                                    编辑
                                                </button>
                                            </a>
                                            <a href="{{atlasModuleAdminJump($moduleName,'project/updateInterfaceDraft?id='.$d['id'])}}"
                                               class="{{atlasPermissions('project/updateInterfaceDraft')}}">
                                                <button type="button" class="h-button-edit btn btn-primary btn-xs">
                                                    项目界面稿
                                                </button>
                                            </a>
                                            <a href="{{atlasModuleAdminJump($moduleName,'project/progressList?project_id='.$d['id'])}}"
                                               class="{{atlasPermissions('project/progressList')}}">
                                                <button type="button" class="h-button-edit btn btn-success btn-xs">
                                                    进度列表
                                                </button>
                                            </a>

                                            <button type="button"
                                                    class="copyURL{{$d['id']}} btn btn-warning btn-xs {{atlasPermissions('project/progressList')}}"
                                                    onclick="copyURL({{$d['id']}})">
                                                复制进度图路径
                                            </button>

                                            <button type="button"
                                                    class="btn btn-danger btn-xs {{atlasPermissions('project/delete')}}"
                                                    onclick="_confirm('{{atlasModuleAdminJump($moduleName,'project/delete')}}',{
                                                            '_method':'DELETE','_token':'{{csrf_token()}}','id':'{{$d['id']}}'
                                                            },'你确定要删除吗？')">
                                                删除
                                            </button>

                                        </td>
                                    </tr>

                                    <input type="hidden" id="copyURL{{$d['id']}}"
                                           value="{{url("/module/{$moduleName}/getGanTeChart?project_id={$d['id']}")}}">
                                @empty
                                    <tr>
                                        <td colspan="20">
                                            暂无数据
                                        </td>
                                    </tr>
                                @endforelse


                                </tbody>
                            </table>
                            <div class="col-sm-12 text-right text-center-xs">
                                @if(count($data)>0)
                                    {{ $data->links() }}
                                @endif
                            </div>
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
        <!-- /page content -->

    </div>

    <!-- /content -->
    <!-- 						Content End		 						-->
    <!-- ============================================================== -->
    @include(atlasModuleAdminTemplate($moduleName)."public.js")
    <script type="text/javascript" src="{{ADMIN_ASSET}}assets/js/clipboard.min.js"></script>
    <script>
        function copyURL(id) {
            var content = $('#copyURL' + id).val();
            var clipboard = new Clipboard('.copyURL' + id, {
                text: function () {
                    return content;
                }
            });
            clipboard.on('success', function (e) {
                layer.msg('复制成功', {icon: 1});
            });

            clipboard.on('error', function (e) {
                console.log(e);
            });
        }
    </script>
</body>
</html>