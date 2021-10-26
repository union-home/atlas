<!-- Main navbar -->
<div class="navbar navbar-default header-highlight">
    <div class="navbar-header">
        <a class="navbar-brand" href="{{atlasModuleAdminJump($moduleName,'index')}}"><img
                    src="{{GetUrlByPath(cacheGlobalSettingsByKey('weblogo'))}}" alt=""></a>

        <ul class="nav navbar-nav visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
            </li>

            {{-- <li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="icon-git-compare"></i>
                     <span class="visible-xs-inline-block position-right">Git updates</span>
                     <span class="badge bg-warning-400">9</span>
                 </a>

                 <div class="dropdown-menu dropdown-content">
                     <div class="dropdown-content-heading">
                         Git updates
                         <ul class="icons-list">
                             <li><a href="#"><i class="icon-sync"></i></a></li>
                         </ul>
                     </div>

                     <ul class="media-list dropdown-content-body width-350">
                         <li class="media">
                             <div class="media-left">
                                 <a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
                             </div>

                             <div class="media-body">
                                 Drop the IE <a href="#">specific hacks</a> for temporal inputs
                                 <div class="media-annotation">4 minutes ago</div>
                             </div>
                         </li>

                         <li class="media">
                             <div class="media-left">
                                 <a href="#" class="btn border-warning text-warning btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-commit"></i></a>
                             </div>

                             <div class="media-body">
                                 Add full font overrides for popovers and tooltips
                                 <div class="media-annotation">36 minutes ago</div>
                             </div>
                         </li>

                         <li class="media">
                             <div class="media-left">
                                 <a href="#" class="btn border-info text-info btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-branch"></i></a>
                             </div>

                             <div class="media-body">
                                 <a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch
                                 <div class="media-annotation">2 hours ago</div>
                             </div>
                         </li>

                         <li class="media">
                             <div class="media-left">
                                 <a href="#" class="btn border-success text-success btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-merge"></i></a>
                             </div>

                             <div class="media-body">
                                 <a href="#">Eugene Kopyov</a> merged <span class="text-semibold">Master</span> and <span class="text-semibold">Dev</span> branches
                                 <div class="media-annotation">Dec 18, 18:36</div>
                             </div>
                         </li>

                         <li class="media">
                             <div class="media-left">
                                 <a href="#" class="btn border-primary text-primary btn-flat btn-rounded btn-icon btn-sm"><i class="icon-git-pull-request"></i></a>
                             </div>

                             <div class="media-body">
                                 Have Carousel ignore keyboard events
                                 <div class="media-annotation">Dec 12, 05:46</div>
                             </div>
                         </li>
                     </ul>

                     <div class="dropdown-content-footer">
                         <a href="#" data-popup="tooltip" title="All activity"><i class="icon-menu display-block"></i></a>
                     </div>
                 </div>
             </li>--}}
        </ul>

        {{--  <p class="navbar-text"><span class="label bg-success">Online</span></p>--}}

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <span>{{$userInfo['username']}}</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li>
                        <a href="{{atlasModuleAdminJump($moduleName,'user/info')}}">
                            <i class="icon-user-plus"></i>
                            我的信息
                        </a>
                    </li>
                    {{--  <li><a href="#"><i class="icon-coins"></i> My balance</a></li>
                    <li><a href="#"><span class="badge bg-teal-400 pull-right">58</span> <i
                                    class="icon-comment-discussion"></i> 我的消息</a></li>
                    <li class="divider"></li>
                     <li><a href="#"><i class="icon-cog5"></i> Account settings</a></li>--}}
                    @if($userInfo['type']=='admin')
                        <li><a href="{{url('/admin')}}"><i class="icon-switch2"></i> 返回主站</a></li>
                    @else
                        <li><a href="{{atlasModuleAdminJump($moduleName,'logout')}}"><i class="icon-switch2"></i> 退出</a></li>
                    @endif
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->
