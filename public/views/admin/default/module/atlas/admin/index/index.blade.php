@include(atlasModuleAdminTemplate($moduleName)."public.header")
<style>
    .h-invitation-list {
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

    @include(atlasModuleAdminTemplate($moduleName)."public.left")


    <!-- Main content -->
        <div class="content-wrapper">

            <!-- Content area -->
            <div class="content">
                @if(session('login_type')=='admin')
                    {{--用户--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Marketing campaigns -->
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h6 class="panel-title">用户</h6>
                                    <div class="heading-elements">
                                        {{--<span class="label bg-success heading-text">28 active</span>--}}

                                    </div>
                                </div>
                            </div>
                            <!-- /marketing campaigns -->
                            <!-- Quick stats boxes -->
                            <div class="row">
                                <div class="col-lg-3">

                                    <!-- Members online -->
                                    <div class="panel bg-teal-400">
                                        <div class="panel-body">
                                            <div class="heading-elements">
                                                {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                            </div>

                                            <h3 class="no-margin">
                                                {{number_format($data['user']['all_user'])}}
                                            </h3>
                                            所有用户
                                            {{--<div class="text-muted text-size-small">489 avg</div>--}}
                                        </div>

                                        <div class="container-fluid">
                                            <div id="members-online"></div>
                                        </div>
                                    </div>
                                    <!-- /members online -->

                                </div>

                                <div class="col-lg-3">

                                    <!-- Current server load -->
                                    <div class="panel bg-pink-400">
                                        <div class="panel-body">
                                            <div class="heading-elements">
                                                {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                            </div>

                                            <h3 class="no-margin">
                                                {{number_format($data['user']['month_user'])}}
                                            </h3>
                                            本月注册用户
                                            {{--<div class="text-muted text-size-small">34.6% avg</div>--}}
                                        </div>

                                        <div id="server-load"></div>
                                    </div>
                                    <!-- /current server load -->

                                </div>

                                <div class="col-lg-3">

                                    <!-- Today's revenue -->
                                    <div class="panel bg-blue-400">
                                        <div class="panel-body">
                                            <div class="heading-elements">
                                                {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                            </div>

                                            <h3 class="no-margin">
                                                {{number_format($data['user']['day_user'])}}
                                            </h3>
                                            今天注册用户
                                            {{--<div class="text-muted text-size-small">$37,578 avg</div>--}}
                                        </div>

                                        <div id="today-revenue"></div>
                                    </div>
                                    <!-- /today's revenue -->

                                </div>
                            </div>
                            <!-- /quick stats boxes -->

                        </div>

                    </div>

                @endif
                {{--订单--}}
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Marketing campaigns -->
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h6 class="panel-title">订单</h6>
                                <div class="heading-elements">
                                    {{--<span class="label bg-success heading-text">28 active</span>--}}

                                </div>
                            </div>
                        </div>
                        <!-- /marketing campaigns -->
                        <!-- Quick stats boxes -->
                        <div class="row">
                            <div class="col-lg-3">

                                <!-- Members online -->
                                <div class="panel bg-teal-400">
                                    <div class="panel-body">
                                        <div class="heading-elements">
                                            {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                        </div>

                                        <h3 class="no-margin">
                                            {{number_format($data['order']['all_order'])}}
                                        </h3>
                                        所有支付订单
                                        {{--<div class="text-muted text-size-small">489 avg</div>--}}
                                    </div>

                                    <div class="container-fluid">
                                        <div id="members-online"></div>
                                    </div>
                                </div>
                                <!-- /members online -->

                            </div>

                            <div class="col-lg-3">

                                <!-- Current server load -->
                                <div class="panel bg-pink-400">
                                    <div class="panel-body">
                                        <div class="heading-elements">
                                            {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                        </div>

                                        <h3 class="no-margin">
                                            {{number_format($data['order']['day_order'])}}
                                        </h3>
                                        今日支付订单
                                        {{--<div class="text-muted text-size-small">34.6% avg</div>--}}
                                    </div>

                                    <div id="server-load"></div>
                                </div>
                                <!-- /current server load -->

                            </div>

                            <div class="col-lg-3">

                                <!-- Today's revenue -->
                                <div class="panel bg-blue-400">
                                    <div class="panel-body">
                                        <div class="heading-elements">
                                            {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                        </div>

                                        <h3 class="no-margin">
                                            {{number_format($data['reduce']['all_reduce'])}}
                                        </h3>
                                        所有退款订单
                                        {{--<div class="text-muted text-size-small">$37,578 avg</div>--}}
                                    </div>

                                    <div id="today-revenue"></div>
                                </div>
                                <!-- /today's revenue -->

                            </div>
                            <div class="col-lg-3">

                                <!-- Today's revenue -->
                                <div class="panel bg-info-400">
                                    <div class="panel-body">
                                        <div class="heading-elements">
                                            {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                        </div>

                                        <h3 class="no-margin">
                                            {{number_format($data['reduce']['day_reduce'])}}
                                        </h3>
                                        今日退款订单
                                        {{--<div class="text-muted text-size-small">$37,578 avg</div>--}}
                                    </div>

                                    <div id="today-revenue"></div>
                                </div>
                                <!-- /today's revenue -->

                            </div>
                        </div>
                        <!-- /quick stats boxes -->

                    </div>

                </div>

                {{--订单收益和邀请收益--}}
                @if(session('login_type')!='admin')
                    {{--用户--}}
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Marketing campaigns -->
                            <div class="panel panel-flat">
                                <div class="panel-heading">
                                    <h6 class="panel-title">收益</h6>
                                    <div class="heading-elements">
                                        {{--<span class="label bg-success heading-text">28 active</span>--}}

                                    </div>
                                </div>
                            </div>
                            <!-- /marketing campaigns -->
                            <!-- Quick stats boxes -->
                            <div class="row">
                                <div class="col-lg-3">

                                    <!-- Members online -->
                                    <div class="panel bg-teal-400">
                                        <div class="panel-body">
                                            <div class="heading-elements">
                                                {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                            </div>

                                            <h3 class="no-margin">
                                                {{number_format($data['order_money']['all_order_money'])}}
                                            </h3>
                                            所有订单收益
                                            {{--<div class="text-muted text-size-small">489 avg</div>--}}
                                        </div>

                                        <div class="container-fluid">
                                            <div id="members-online"></div>
                                        </div>
                                    </div>
                                    <!-- /members online -->

                                </div>

                                <div class="col-lg-3">

                                    <!-- Current server load -->
                                    <div class="panel bg-pink-400">
                                        <div class="panel-body">
                                            <div class="heading-elements">
                                                {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                            </div>

                                            <h3 class="no-margin">
                                                {{number_format($data['order_money']['day_order_money'])}}
                                            </h3>
                                            今日订单收益
                                            {{--<div class="text-muted text-size-small">34.6% avg</div>--}}
                                        </div>

                                        <div id="server-load"></div>
                                    </div>
                                    <!-- /current server load -->

                                </div>

                                <div class="col-lg-3">

                                    <!-- Members online -->
                                    <div class="panel bg-blue-400">
                                        <div class="panel-body">
                                            <div class="heading-elements">
                                                <a href="{{atlasModuleAdminJump($moduleName,'user/invitationList')}}">
                                                    <span class="heading-text badge bg-teal-800 h-invitation-list">
                                                        列表
                                                    </span>
                                                </a>
                                            </div>

                                            <h3 class="no-margin">
                                                {{number_format($data['invitation_money']['all_invitation_money'])}}
                                            </h3>
                                            所有邀请收益
                                            {{--<div class="text-muted text-size-small">489 avg</div>--}}
                                        </div>

                                        <div class="container-fluid">
                                            <div id="members-online"></div>
                                        </div>
                                    </div>
                                    <!-- /members online -->

                                </div>

                                <div class="col-lg-3">

                                    <!-- Current server load -->
                                    <div class="panel bg-info-400">
                                        <div class="panel-body">
                                            <div class="heading-elements">
                                                {{--<span class="heading-text badge bg-teal-800">+53,6%</span>--}}
                                            </div>

                                            <h3 class="no-margin">
                                                {{number_format($data['invitation_money']['day_invitation_money'])}}
                                            </h3>
                                            今日订单收益
                                            {{--<div class="text-muted text-size-small">34.6% avg</div>--}}
                                        </div>

                                        <div id="server-load"></div>
                                    </div>
                                    <!-- /current server load -->

                                </div>
                            </div>
                            <!-- /quick stats boxes -->

                        </div>

                    </div>

                @endif

                @include(atlasModuleAdminTemplate($moduleName)."public.footer")


            </div>
            <!-- /content area -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</div>
<!-- /page container -->

<!-- 						Content End		 						-->
<!-- ============================================================== -->
@include(atlasModuleAdminTemplate($moduleName)."public.js")
{{--<script type="text/javascript" src="{{moduleAdminResource($moduleName)}}/js/pages/dashboard.js"></script>--}}
</body>
</html>