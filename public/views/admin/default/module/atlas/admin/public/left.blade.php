<style>
    .navbar-brand>img {
        margin-top: -8px;
        height: 35px;
    }
</style>
<!-- Main sidebar -->
<div class="sidebar sidebar-main">
    <div class="sidebar-content">

        <!-- User menu -->
        <div class="sidebar-user">
            <div class="category-content">
                <div class="media">
                    <a href="#" class="media-left">
                        <img class="img-circle img-sm" alt="" src="
                        @if($userInfo['avatar'])
                        {{asset('uploads/'.$userInfo['avatar'])}}
                        @else
                        {{atlasModuleAdminResource($moduleName)}}/images/placeholder.jpg
                        @endif">
                    </a>
                    <div class="media-body">
                        <span class="media-heading text-semibold">
                            {{$userInfo['username']}}
                            {{--@if($userInfo['type']=='admin')
                                超级管理员
                            @else
                                @foreach(userType() as $u)
                                    @if($u['tig']==$userInfo['type'])
                                        {{$u['name']}}
                                    @endif
                                @endforeach
                            @endif--}}
                        </span>

                    </div>

                </div>
            </div>
        </div>
        <!-- /user menu -->


        <!-- Main navigation -->
        <div class="sidebar-category sidebar-category-visible">
            <div class="category-content no-padding">
                <ul class="navigation navigation-main navigation-accordion">


                    @foreach($menu_one as $one)

                        @if($one['url']!='#'&& $one['action']!='#')
                            <li @if($tig['controller']==$one['controller']) class="active" @endif>
                                <a href="{{atlasModuleAdminJump($moduleName,$one['url'])}}">
                                    <i class="{{$one['icon']}}"></i>
                                    <span>{{$one['title']}}</span>
                                </a>
                            </li>

                        @elseif($one['url']=='#'&& $one['action']=='#')
                            <li @if($tig['controller']==$one['controller']) class="active" @endif>
                                <a href="#">
                                    <i class="{{$one['icon']}}"></i>
                                    <span>{{$one['title']}}</span>
                                </a>
                                <ul>
                                    @foreach($menu_two as $two)
                                        @if($one['id']==$two['pid'] && $two['is_hide']==2)
                                            <li @if($tig['action']==$two['action']) class="active" @endif>
                                                <a href="{{atlasModuleAdminJump($moduleName,$two['url'])}}">
                                                    {{$two['title']}}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach


                </ul>
            </div>
        </div>
        <!-- /main navigation -->

    </div>
</div>
<!-- /main sidebar -->