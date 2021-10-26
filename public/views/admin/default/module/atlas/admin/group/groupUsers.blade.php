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
            ['breadcrumb'=>['权限管理','权限组成员']])

            <!-- Content area -->
                <div class="content" style="margin-top: 1rem;">


                    <!-- Bordered striped table -->
                    <div class="col-sm-12">
                        <div class="table-responsive panel panel-default">
                            <div class="panel-heading">
                                <a class="label bg-danger pull-right m-t-xs"
                                   href="{{atlasModuleAdminJump($moduleName,'group/groupList')}}">
                                    返回
                                </a>
                                <a class="label bg-info pull-right m-t-xs {{atlasPermissions('group/groupAddUser')}}"
                                   href="{{atlasModuleAdminJump($moduleName,'group/groupAddUser?id='.$_GET['id'])}}"  style="margin-right: 10px">
                                    添加
                                </a>
                                列表
                            </div>
                            <table class="table table-striped m-b-none col-sm-12">
                                <thead>
                                <tr>
                                    <th>uid</th>
                                    <th>账号</th>
                                    <th>权限组名称</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($data as $d)
                                    <tr>
                                        <td>{{$d['uid']}}</td>
                                        <td>{{$d['username']?:$d['phone']}}</td>
                                        <td>{{$d['group_name']}}</td>
                                        <td>{{date('Y-m-d H:i:s',$d['time'])}}</td>
                                        <td>
                                            <a href="{{atlasModuleAdminJump($moduleName,'group/groupAddUser?id='.$_GET['id'].'&uid='.$d['uid'])}}"
                                               class="{{atlasPermissions('group/groupAddUser')}}">
                                                <button type="button" class="h-button-edit btn btn-info btn-xs">
                                                    编辑
                                                </button>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-danger btn-xs {{atlasPermissions('group/groupDeleteUser')}}"
                                                    onclick="_confirm('{{atlasModuleAdminJump($moduleName,'group/groupDeleteUser')}}',{
                                                            '_method':'DELETE','_token':'{{csrf_token()}}','id':'{{$d['id']}}'
                                                            },'你确定要删除吗？')">
                                                删除
                                            </button>
                                        </td>
                                    </tr>
                                    {{--编辑权限组--}}
                                    <div id="groupEdit{{$d['id']}}" style="display: none">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="col-lg-4 control-label">
                                                    语言名称
                                                </label>
                                                <div class="col-lg-11">
                                                    <input type="text" id="group_name{{$d['id']}}"
                                                           class="form-control"
                                                           value="{{$d['group_name']}}" required>
                                                    <input type="hidden" id="id{{$d['id']}}" class="form-control"
                                                           value="{{$d['id']}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-lg-8 control-label"></label>
                                                <div class="col-lg-11">
                                                    <button type="button" onclick="edit({{$d['id']}})"
                                                            class="btn btn-sm btn-info">
                                                        提交
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
        {{--添加权限组--}}
        <div id="groupAdd" style="display: none">
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-lg-4 control-label">
                        语言名称
                    </label>
                    <div class="col-lg-11">
                        <input type="text" name="group_name" id="group_name" class="form-control"
                               placeholder="语言名称" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-8 control-label"></label>
                    <div class="col-lg-11">
                        <button type="button" id="add" class="btn btn-sm btn-info">
                            提交
                        </button>
                    </div>
                </div>
            </div>
        </div>
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