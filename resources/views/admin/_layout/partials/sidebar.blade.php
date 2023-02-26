<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('front.index.index')}}" class="brand-link">
        <img src="{{url('/themes/admin/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">@lang('Blog')</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{\Auth::user()->getPhotoUrl()}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <span class="d-block" style="color:white;">{{\Auth::user()->name}}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link active">
                        <i class="fab fa-blogger"></i>
                        <p>
                            @lang('Blog Posts')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.posts.index')}}" class="nav-link">
                                <i class="fab fa-readme"></i>
                                <p>@lang('All Posts')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.posts.add')}}" class="nav-link">
                                <i class="fas fa-plus-circle"></i>
                                <p>@lang('Add New Post')</p>
                            </a>
                        </li>
                    </ul>
                </li> 
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link active">
                        <i class="fab fa-blogger"></i>
                        <p>
                           @lang('Blog Posts Slider')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.slider.index')}}" class="nav-link">
                                <i class="fab fa-readme"></i>
                                <p>@lang('All Posts Slider') </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.slider.add')}}" class="nav-link">
                                <i class="fas fa-plus-circle"></i>
                                <p>@lang('Add New Post Slider')</p>
                            </a>
                        </li>
                    </ul>
                </li> 
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-copy"></i>
                        <p>
                            @lang('Post Categories')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.post_categories.index')}}" class="nav-link">
                                <i class="fab fa-readme"></i>
                                <p>@lang('All Categories')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.post_categories.add')}}" class="nav-link">
                                <i class="fas fa-plus-circle"></i>
                                <p>@lang('Add New Category')</p>
                            </a>
                        </li>
                    </ul>
                </li> 
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-tags"></i>
                        <p>
                            @lang('Post Tags')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.tags.index')}}" class="nav-link">
                                <i class="fab fa-readme"></i>
                                <p>@lang('All Tags')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.tags.add')}}" class="nav-link">
                                <i class="fas fa-plus-circle"></i>
                                <p>@lang('Add New Tag')</p>
                            </a>
                        </li>
                    </ul>
                </li> 
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-comments"></i>
                        <p>
                            @lang('Comments')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.comments.index')}}" class="nav-link">
                                <i class="fab fa-readme"></i>
                                <p>@lang('All Comments')</p>
                            </a>
                        </li>
                    </ul>
                </li> 
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link active">
                        <i class="fas fa-users"></i>
                        <p>
                            @lang('Users')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('admin.users.index')}}" class="nav-link">
                                <i class="fab fa-readme"></i>
                                <p>@lang('All Users')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('admin.users.add')}}" class="nav-link">
                                <i class="fas fa-plus-circle"></i>
                                <p>@lang('Add User')</p>
                            </a>
                        </li>
                    </ul>
                </li> 


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>