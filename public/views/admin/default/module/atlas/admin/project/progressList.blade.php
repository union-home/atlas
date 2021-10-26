@include(atlasModuleAdminTemplate($moduleName)."public.header")
<style>
    .h-one {
        background-color: #efefef;
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
            ['breadcrumb'=>['项目管理',$tig['title']]])

            <!-- Content area -->
                <div class="content" style="margin-top: 1rem;">


                    <!-- Bordered striped table -->
                    <div class="col-sm-12">
                        <div class="table-responsive panel panel-default">
                            <div class="panel-heading">
                                <a class="label bg-info pull-right m-t-xs {{atlasPermissions('project/progressAdd')}}"
                                   href="{{atlasModuleAdminJump($moduleName,'project/progressAdd?project_id='.$_GET['project_id'])}}">
                                    添加
                                </a>

                                <a class="mr-5 label bg-danger pull-right m-t-xs {{atlasPermissions('project/list')}}"
                                   href="{{atlasModuleAdminJump($moduleName,'project/list')}}">
                                    返回
                                </a>
                                列表
                            </div>
                            <table class="table m-b-none col-sm-12">
                                <thead>
                                <tr>
                                    {{--<th>id</th>--}}
                                    <th>项目名称</th>
                                    <th>时间范围</th>
                                    <th>状态</th>
                                    <th>时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($data as $d)
                                    <tr class="h-one">
                                        {{--<td>{{$d['id']}}</td>--}}
                                        <td>{{$d['name']}}</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$d['created_at']}}</td>
                                        <td>
                                            <a href="{{atlasModuleAdminJump($moduleName,'project/progressEdit?project_id='.$_GET['project_id'].'&id='.$d['id'])}}"
                                               class="{{atlasPermissions('project/progressEdit')}}">
                                                <button type="button" class="h-button-edit btn btn-info btn-xs">
                                                    编辑
                                                </button>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-danger btn-xs {{atlasPermissions('project/progressDelete')}}"
                                                    onclick="_confirm('{{atlasModuleAdminJump($moduleName,'project/progressDelete')}}',{
                                                            '_method':'DELETE','_token':'{{csrf_token()}}','id':'{{$d['id']}}'
                                                            },'你确定要删除吗？')">
                                                删除
                                            </button>
                                        </td>
                                    </tr>
                                    @foreach($d['cate_list'] as $list)
                                        <tr>
                                            {{--<td>{{$list['id']}}</td>--}}
                                            <td>━━ {{$list['name']}}</td>
                                            <td>{{$list['start']}} - {{$list['end']}}</td>
                                            <td>
                                                @if($list['status']==1)
                                                    <label class="label label-info">
                                                        {{\App\Http\Controllers\Module\atlas\Models\Progress::status[$list['status']]}}
                                                    </label>
                                                @elseif($list['status']==2)
                                                    <label class="label label-success">
                                                        {{\App\Http\Controllers\Module\atlas\Models\Progress::status[$list['status']]}}
                                                    </label>
                                                @else
                                                    <label class="label label-primary">
                                                        {{\App\Http\Controllers\Module\atlas\Models\Progress::status[$list['status']]}}
                                                    </label>
                                                @endif
                                            </td>
                                            <td>{{$list['created_at']}}</td>
                                            <td>
                                                <a href="{{atlasModuleAdminJump($moduleName,'project/progressEdit?project_id='.$list['project_id'].'&id='.$list['id'])}}"
                                                   class="{{atlasPermissions('project/progressEdit')}}">
                                                    <button type="button" class="h-button-edit btn btn-info btn-xs">
                                                        编辑
                                                    </button>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-danger btn-xs {{atlasPermissions('project/progressDelete')}}"
                                                        onclick="_confirm('{{atlasModuleAdminJump($moduleName,'project/progressDelete')}}',{
                                                                '_method':'DELETE','_token':'{{csrf_token()}}','id':'{{$list['id']}}'
                                                                },'你确定要删除吗？')">
                                                    删除
                                                </button>
                                            </td>
                                        </tr>
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
</body>
</html>