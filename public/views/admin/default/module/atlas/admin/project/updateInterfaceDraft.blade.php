@include(atlasModuleAdminTemplate($moduleName)."public.header")
<style>
    .h-list{
        margin: 20px 0;
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


    @include(atlasModuleAdminTemplate($moduleName)."public.left")


    <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <div class="page-header">
                @include(atlasModuleAdminTemplate($moduleName)."public.page",
            ['breadcrumb'=>['项目管理',$tig['title']]])
            </div>
            <!-- /page header -->


            <!-- Content area -->
            <div class="content" style="margin-top: 1rem;">


                <div class="panel panel-flat">
                    <div class="panel-heading">

                        <form class="form-horizontal" id="post_form">
                            {{csrf_field()}}
                            <fieldset class="content-group">
                                <legend class="text-bold">
                                    <a class="label bg-info pull-right m-t-xs {{atlasPermissions('project/updateInterfaceDraft')}}"
                                       id="add">
                                        上传界面稿
                                    </a>
                                    <a class="label bg-danger pull-right m-t-xs mr-20"
                                    href="{{atlasModuleAdminJump($moduleName,'project/list')}}">
                                        返回
                                    </a>
                                    <input type="file" style="display: none" id="file"/>
                                    列表
                                </legend>
                                <div class="form-group local_url">
                                    @foreach($data as $list)
                                        <div class="fileinput-new-div col-lg-2" data-provides="fileinput">
                                            <div class="" data-trigger="fileinput"
                                                 style="width: 120px; height:200px;margin-bottom: .2rem;">
                                                <a href="{{$list['url']}}" target="_blank">
                                                    <img id="addImg" class="img-fluid " style="width: 120px; height:200px;"
                                                         src="{{$list['url']}}"/>
                                                </a>
                                            </div>
                                            <span class="btn btn-xs btn-success h-list">
                                                <span class="fileinput-new">
                                                    {{$list['name']}}
                                                </span>
                                            </span>
                                        </div>
                                    @endforeach
                                </div>


                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="window.location='{{atlasModuleAdminJump($moduleName,'project/list')}}'">
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
<script>
    $('#add').click(function () {
        $('#file').click();
    });

    $('#file').on('change', function () {
        var file = this.files[0];
        // if (file.size > 1024 * 2000) {
        //     alert('文件最大1M！')
        // }
        submit_add();
    });

    //表单提交
    function submit_add() {
        var data = new FormData();
        data.append('_token', '{{csrf_token()}}');
        data.append('id', '{{$_GET['id']}}');
        data.append('file', $('#file')[0].files[0]);
        layer.load(1);
        $.ajax({
            url: '{{atlasModuleAdminJump($moduleName,'project/updateInterfaceDraft')}}',
            type: 'POST',
            data: data,
            processData: false,  // 告诉jQuery不要去处理发送的数据
            contentType: false  // 告诉jQuery不要去设置Content-Type请求头
        }).done(function (ret) {
            layer.closeAll();
            $('#file').val('');
            if (ret.status == 200) {
                layer.msg(ret.msg, {icon: 1, time: 1000}, function () {
                    window.location.reload();
                });
            } else {
                layer.msg(ret.msg, {icon: 2, time: 3000}, function () {
                    window.location.reload();
                });
            }
        });
        return false;

    }
</script>
</body>
</html>