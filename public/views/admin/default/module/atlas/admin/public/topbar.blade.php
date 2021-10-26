<div class="top-bar primary-top-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <a class="admin-logo" href="#">
                    <h1>
                        <img alt="" src="{{GetUrlByPath(cacheGlobalSettingsByKey('weblogo'))}}" class="logo-icon margin-r-10" style="max-width: 215px;">
                    </h1>
                </a>
                <div class="left-nav-toggle" >
                    <a  href="#" class="nav-collapse"><i class="fa fa-bars"></i></a>
                </div>
                <div class="left-nav-collapsed" >
                    <a  href="#" class="nav-collapsed"><i class="fa fa-bars"></i></a>
                </div>

                <ul class="list-inline top-right-nav">

                    <li class="dropdown avtar-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <img alt="" class="rounded-circle" src="{{GetUrlByPath(session("admin_info")['avatar'])}}" width="30">
                            {{session("admin_info")['username']}}(系统管理员)
                        </a>
                        <ul class="dropdown-menu top-dropdown">
                            <li>
                                <a class="dropdown-item" href="{{url('/admin')}}"><i class="icon-logout"></i> 返回主站 </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>