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
            ['breadcrumb'=>['系统设置','协议列表']])

            <!-- Content area -->
                <div class="content" style="margin-top: 1rem;">


                    <!-- Bordered striped table -->
                    <div class="col-sm-12">
                        <div class="table-responsive panel panel-default">
                            <div class="panel-heading">
                                <a class="label bg-info pull-right m-t-xs {{atlasPermissions('agreement/add')}}"
                                   href="{{atlasModuleAdminJump($moduleName,'agreement/add')}}">
                                    添加
                                </a>
                                列表
                            </div>
                            <table class="table table-striped m-b-none col-sm-12">
                                <thead>
                                <tr>
                                    <th>id</th>
                                    <th>协议分类名称</th>
                                    <th>协议名称</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($data as $d)
                                    <tr>
                                        <td>{{$d['id']}}</td>
                                        <td>
                                            {{newsGetAgreementType()[$d['cid']]}}
                                        </td>
                                        <td>{{$d['title']}}</td>
                                        <td>{{$d['create_at']}}</td>
                                        <td>
                                            <a href="{{atlasModuleAdminJump($moduleName,'agreement/edit?id='.$d['id'])}}"
                                               class="{{atlasPermissions('agreement/edit')}}">
                                                <button type="button" class="h-button-edit btn btn-info btn-xs">
                                                    编辑
                                                </button>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-danger btn-xs {{atlasPermissions('agreement/delete')}}"
                                                    onclick="_confirm('{{atlasModuleAdminJump($moduleName,'agreement/delete')}}',{
                                                            '_method':'DELETE','_token':'{{csrf_token()}}','id':'{{$d['id']}}'
                                                            },'你确定要删除吗？')">
                                                删除
                                            </button>
                                        </td>
                                    </tr>

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
    <script>
        $('#addPage').click(function () {
            //页面层
            layer.open({
                type: 1,
                title: alert_info,
                skin: 'layui-layer-rim', //加上边框
                area: ['420px', '200px'], //宽高
                content: $('#groupAdd')
            });
        });
        $('#add').click(function () {
            var group_name = $('#group_name').val()
            if (!group_name) {
                layer.msg('名称不能为空', {icon: 2});
                return
            }
            $.post('{{atlasModuleAdminJump($moduleName,'group/groupAdd')}}',
                {
                    _method: 'POST',
                    _token: '{{csrf_token()}}',
                    group_name: group_name
                },
                function (data) {
                    if (data.status == 200) {
                        layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                            window.location.reload()
                        });
                    } else {
                        layer.msg(data.msg, {icon: 2});
                    }
                });
        });

        function editPage(id) {
            //页面层
            layer.open({
                type: 1,
                title: alert_info,
                skin: 'layui-layer-rim', //加上边框
                area: ['420px', '200px'], //宽高
                content: $('#groupEdit' + id)
            });
        }

        function edit(id) {
            var group_name = $('#group_name' + id).val()
            if (!group_name) {
                layer.msg('名称不能为空', {icon: 2});
                return
            }
            $.post('{{atlasModuleAdminJump($moduleName,'group/groupEdit')}}',
                {
                    _method: 'PUT',
                    _token: '{{csrf_token()}}',
                    id: id,
                    group_name: group_name
                },
                function (data) {
                    if (data.status == 200) {
                        layer.msg(data.msg, {icon: 1, time: 1000}, function () {
                            window.location.reload()
                        });
                    } else {
                        layer.msg(data.msg, {icon: 2});
                    }
                });
        }
    </script>
</body>
</html>