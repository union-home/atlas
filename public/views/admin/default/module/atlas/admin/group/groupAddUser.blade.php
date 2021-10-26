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
         ['breadcrumb'=>['权限管理','权限组添加成员']])
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content" style="margin-top: 1rem;">


                <div class="panel panel-flat">
                    <div class="panel-heading">
                        <form class="bs-example form-horizontal" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label class="col-lg-1 control-label">
                                    权限组
                                </label>
                                <div class="col-lg-11">
                                    <select class="select-search" name="gid">
                                        <optgroup label="">
                                            <option value="0">
                                                请选择
                                            </option>
                                            @foreach($data['group'] as $group)
                                                <option value="{{$group['id']}}"
                                                        @if($data['gid']==$group['id']) selected @endif>
                                                    {{$group['group_name']}}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-1">组成员</label>
                                <div class="col-lg-11">
                                    <select class="select-search" name="uid">
                                        <optgroup label="">
                                            <option value="0">
                                                请选择
                                            </option>
                                            @foreach($data['user'] as $user)
                                                <option value="{{$user['uid']}}"
                                                        @if($data['uid']==$user['uid']) selected @endif>

                                                    {{--@if($user['type']==2)
                                                        --}}{{--普通管理员--}}{{--
                                                        ({{language(10109)}})
                                                    @elseif($user['type']==3)
                                                        --}}{{--总代理--}}{{--
                                                        ({{language(10110)}})
                                                    @elseif($user['type']==4)
                                                        --}}{{--一级代理--}}{{--
                                                        ({{language(10111)}})
                                                    @elseif($user['type']==5)
                                                        --}}{{--二级代理--}}{{--
                                                        ({{language(10112)}})
                                                    @endif--}}
                                                    {{$user['username']?:$user['phone']}}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
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