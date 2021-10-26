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
            ['breadcrumb'=>['系统设置','菜单列表']])

            <!-- Content area -->
                <div class="content" style="margin-top: 1rem;">


                    <!-- Bordered striped table -->
                    <div class="panel panel-flat">

                        <div class="table-responsive panel panel-default">
                            <div class="panel-heading">
                                <a class="label bg-info pull-right m-t-xs {{atlasPermissions('menu/menuAdd')}}"
                                   href="{{atlasModuleAdminJump($moduleName,'menu/menuAdd')}}">
                                    添加
                                </a>
                                列表
                            </div>
                            <table class="table m-b-none col-sm-12">
                                <thead>
                                <tr>
                                    <th>标题</th>
                                    <th>控制器</th>
                                    <th>方法</th>
                                    <th>url路径</th>
                                    <th>是否隐藏</th>
                                    <th>排序</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($one as $d)
                                    <tr style="background-color: #e2e2e2">
                                        <td>{{$d['title']}}</td>
                                        <td>{{$d['controller']}}</td>
                                        <td>{{$d['action']}}</td>
                                        <td>{{$d['url']}}</td>
                                        <td>
                                            @if($d['is_hide']==1)
                                                <span class="text-danger">
                                                隐藏
                                            </span>
                                            @else
                                                <span class="text-success">
                                                显示
                                            </span>
                                            @endif
                                        </td>
                                        <td>{{$d['orders']}}</td>
                                        <td>{{date('Y-m-d H:i:s',$d['create_at'])}}</td>
                                        <td>
                                            <a href="{{atlasModuleAdminJump($moduleName,'menu/menuEdit?id='.$d['id'])}}"
                                               class="{{atlasPermissions('menu/menuEdit')}}">
                                                <button type="button" class="h-button-edit btn btn-info btn-xs">
                                                    编辑
                                                </button>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-danger btn-xs {{atlasPermissions('menu/menuDelete')}}"
                                                    onclick="_confirm('{{atlasModuleAdminJump($moduleName,'menu/menuDelete')}}',{
                                                            '_method':'DELETE','_token':'{{csrf_token()}}','id':'{{$d['id']}}'
                                                            },'你确定要删除吗？')">
                                                删除
                                            </button>
                                        </td>
                                    </tr>
                                    @foreach($two as $p)
                                        @if($p['pid']==$d['id'])
                                            <tr>
                                                <td>└─ {{$p['title']}}</td>
                                                <td>{{$p['controller']}}</td>
                                                <td>{{$p['action']}}</td>
                                                <td>{{$p['url']}}</td>
                                                <td>
                                                    @if($p['is_hide']==1)
                                                        <span class="text-danger">
                                                隐藏
                                            </span>
                                                    @else
                                                        <span class="text-success">
                                                显示
                                            </span>
                                                    @endif
                                                </td>
                                                <td>{{$p['orders']}}</td>
                                                <td>{{date('Y-m-d H:i:s',$p['create_at'])}}</td>
                                                <td>
                                                    <a href="{{atlasModuleAdminJump($moduleName,'menu/menuEdit?id='.$p['id'])}}"
                                                       class="{{atlasPermissions('menu/menuEdit')}}">
                                                        <button type="button" class="h-button-edit btn btn-info btn-xs">
                                                            编辑
                                                        </button>
                                                    </a>
                                                    <button type="button"
                                                            class="btn btn-danger btn-xs {{atlasPermissions('menu/menuDelete')}}"
                                                            onclick="_confirm('{{atlasModuleAdminJump($moduleName,'menu/menuDelete')}}',{
                                                                    '_method':'DELETE','_token':'{{csrf_token()}}','id':'{{$p['id']}}'
                                                                    },'你确定要删除吗？')">
                                                        删除
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="20">
                                            暂无数据
                                        </td>
                                    </tr>
                                @endforelse


                                </tbody>
                            </table>

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

    <!-- 						Content End		 						-->
    <!-- ============================================================== -->
@include(atlasModuleAdminTemplate($moduleName)."public.js")
</body>
</html>