@include(atlasModuleAdminTemplate($moduleName)."public.header")

<body>





<!-- Page container -->
<div class="page-container login-container">

    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">

                <!-- Simple login form -->
                <form id="login_form">
                    <div class="panel panel-body login-form">
                        <div class="text-center">
                            <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div>
                            <h5 class="content-group">
                                登录你的帐户
                                {{--<small class="display-block">在下面输入您的凭证</small>--}}
                            </h5>
                        </div>

                        {{csrf_field()}}

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="text" class="form-control" placeholder="用户名/手机号码" name="loginFlag">
                            <div class="form-control-feedback">
                                <i class="icon-user text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group has-feedback has-feedback-left">
                            <input type="password" class="form-control" placeholder="登录密码" name="password">
                            <div class="form-control-feedback">
                                <i class="icon-lock2 text-muted"></i>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary btn-block" onclick="loginMaterials()">登 录 <i
                                        class="icon-circle-right2 position-right"></i></button>
                        </div>

                        {{--  <div class="text-center">
                              <a href="{{moduleAdminJump($moduleName,'forget')}}">忘记密码?</a>
                          </div>--}}
                    </div>
                </form>
                <!-- /simple login form -->

            @include(atlasModuleAdminTemplate($moduleName)."public.footer")
            <!-- /footer -->

            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->


@include(atlasModuleAdminTemplate($moduleName)."public.js")


<script>

    //登录 材质库
    function loginMaterials() {

        var loginFlag = $("input[name='loginFlag']").val();
        var password = $("input[name='password']").val();

        // 检测
        if (!loginFlag) return layer.msg('请输入登录账户或手机号码', {time: 2500, icon: 5});
        if (!password) return layer.msg('请输入登录密码', {time: 2500, icon: 5});


        var index = layer.load(1, {
            shade: [0.1, '#fff'] //0.1透明度的白色背景
        });

        $.ajax({
            "method": "post",
            "url": "{{atlasModuleAdminJump($moduleName,'login')}}",
            "data": new FormData($('#login_form')[0]),                    //$("#post_form").serialize(),
            "dataType": 'json',
            "cache": false,
            "processData": false,
            "contentType": false,
            "success": function (res) {


                layer.close(index);

                if (res.status == 200) {
                    layer.msg(res.msg, {time: 1000, icon: 6}, function () {
                        window.location.href = res.data.url;
                    });

                } else {
                    layer.msg(res.msg, {time: 1000, icon: 5}, function () {
                        // window.location.reload();
                    });
                }
            },
            "error": function (res) {
                layer.close(index);
                layer.msg('登录失败，请联系管理员', {time: 2500, icon: 5});
            }
        });


    }
</script>
</body>
</html>