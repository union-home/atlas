@include(atlasModuleAdminTemplate($moduleName)."public.header")
<style>
    #rang {
        cursor: pointer;
        background-color: #fff;
    }

    .select2-results, .select2-drop-active {
        z-index: 200000
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
                                <legend class="text-bold">列表</legend>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        主任务
                                    </label>
                                    <div class="col-lg-11">
                                        <select class="select-search" name="pid">
                                            <optgroup label="">
                                                <option value="0">主任务</option>
                                                @foreach($cate as $c)
                                                    <option value="{{$c['id']}}">{{$c['name']}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        任务名称
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        时间范围
                                    </label>
                                    <div class="col-lg-11">
                                        <input type="text" id="rang" name="rang" class="form-control" required
                                               readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        进度描述
                                    </label>
                                    <div class="col-lg-11">
                                        <div id="content-text" style="height: 352px;"
                                             class="form-control"></div>
                                        <textarea name="content" id="text1" style="display: none"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">
                                        状态
                                    </label>
                                    <div class="col-lg-11">
                                        <select class="select-search" name="status">
                                            <optgroup label="">
                                                @foreach(\App\Http\Controllers\Module\atlas\Models\Progress::status as $sk=>$s)
                                                    <option value="{{$sk}}">{{$s}}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" name="project_id" value="{{$_GET['project_id']}}">
                                    <label class="col-lg-1 control-label"></label>
                                    <div class="col-lg-11">
                                        <button type="button" class="btn btn-sm btn-info" id="post_button">
                                            提交
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger"
                                                onclick="window.location='{{$tig['return_url']}}'">
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
<script type="text/javascript" src="{{atlasModuleAdminResource($moduleName)}}/js/wangEditor.min.js"></script>

<script>

    $(function () {
        //创建日期范围选择
        laydate.render({
            elem: '#rang',
            range: true //或 range: '~' 来自定义分割字符
        });

        var edit = window.wangEditor;
        var editor2 = new edit('#content-text');

        // 下面两个配置，使用其中一个即可显示“上传图片”的tab。但是两者不要同时使用！！！
        //editor2.customConfig.uploadImgShowBase64 = true   // 使用 base64 保存图片
        // editor.customConfig.uploadImgServer = '/upload'  // 上传图片到服务器
        editor2.customConfig.customUploadImg = function (files, insert) {//对上传的图片进行处理，图片上传的方式
            var data = new FormData();                         //用ajax传递文件流必须用FormData，其他格式不可传递
            data.append("image", files[0]);
            data.append("_token", '{{csrf_token()}}');
            $.ajax({
                url: "{{atlasModuleAdminJump($moduleName,'project/upload')}}",
                type: "post",
                data: data,
                cache: false,                                  //上传文件不需要缓存。
                processData: false,                            //ajax里面的processData设置为false,因为data值是FormData对象，不需要对数据做处理。
                contentType: false,                            //不设置contentType值，因为是由<form>表单构造的FormData对象，且已经声明了属性enctype="multipart/form-data"，所以这里设置为false。
                success: function (data) {                     //返回的data为图片名
                    if (data.img) {
                        insert(data.img);  //上传代码返回结果之后，将图片插入到编辑器中。括号内为图片路径imgUrl
                    }
                },
                error: function () {
                    alert("图片上传错误");
                }
            })
        }
        var $text1 = $('#text1');

        editor2.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        };

        editor2.create();
        // 初始化 textarea 的值
        $text1.val(editor2.txt.html());

        $("#post_button").click(function () {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                "method": "post",
                "url": "{{$tig['sub_url']}}",
                "data": new FormData($('#post_form')[0]),                    //$("#post_form").serialize(),
                "dataType": 'json',
                "cache": false,
                "processData": false,
                "contentType": false,
                "success": function (res) {
                    if (res.status == 200) {
                        layer.msg(res.msg, {icon: 1, time: 1000}, function () {
                            window.location.href = "{{$tig['return_url']}}";
                        });
                    } else {
                        layer.msg(res.msg, {icon: 5})
                    }
                },
                "error": function (res) {
                    console.log(res);
                }
            })
        })

    })

</script>
<script type="text/javascript"
        src="{{atlasModuleAdminResource($moduleName)}}/js/plugins/forms/selects/select2.min.js"></script>
<script type="text/javascript" src="{{atlasModuleAdminResource($moduleName)}}/js/pages/form_select2.js"></script>
<script src="{{ADMIN_ASSET}}assets/laydate/laydate.js"></script>
</body>
</html>