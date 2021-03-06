<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ __('dict.app_name') }}</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('../css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('../css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('../css/_all-skins.min.css')}}">
  <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="{{asset('../css/toastr.min.css')}}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" media="all" rel="stylesheet" type="text/css"/>
  @yield('css')
  <link rel="stylesheet"
  href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <header class="main-header">
      <a class="logo">
        <span class="logo-mini"><b>CM</b></span>
        <span class="logo-lg"><b>{{ __('dict.app_name') }}</b></span>
      </a>
      <nav class="navbar navbar-static-top">
        <a class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown user user-menu">
              <a class="dropdown-toggle" data-toggle="dropdown">
                <img src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png" class="user-image" alt="User Image">
                <span class="hidden-xs">{{Auth::user()->name}}</span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <img src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png" class="img-circle" alt="User Image">
                  <p>
                    {{Auth::user()->name}}
                  </p>
                </li>
                <li class="user-footer">
                  <div class="pull-left">
                    <a class="btn btn-default btn-flat">Profile</a>
                  </div>
                  <div class="pull-right">
                    <a href="{{route('logout')}}" class="btn btn-default btn-flat" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                  </div>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <aside class="main-sidebar">
      <section class="sidebar">
        <div class="user-panel">
          <div class="pull-left image">
            <img src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png" class="user-image" alt="User Image">
          </div>
          <div class="pull-left info">
            <span class="hidden-xs">{{Auth::user()->name}} </span> 
          </div>
        </div>
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">Main Navigation</li>
          @if(Auth::user()->role == 1)
          <li class="">
            <a href="{{asset('')}}user">
              <i class="fa fa-user-circle-o" aria-hidden="true"></i> <span>{{__('dict.navbar.user_manager')}}</span>
            </a>
          </li>
          @endif
          <li class="treeview">
            <a>
              <i class="fa fa-braille" aria-hidden="true"></i> <span> {{__('dict.class.class_manager')}}</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              @if(Auth::user()->role == 1 || Auth::user()->role == 2)
              <li><a href="{{asset('')}}class"><i class="fa fa-braille" aria-hidden="true"></i> {{__('dict.class.class_manager')}}</a></li>
              @endif
              <li><a href="{{asset('')}}my-class"><i class="fa fa-braille" aria-hidden="true"></i> {{__('dict.class.my_class')}}</a></li>
              <li><a href="{{asset('')}}my-request"><i class="fa fa-paper-plane" aria-hidden="true"></i> {{__('dict.class.my_request')}}</a></li>
            </ul>
          </li>
          {{-- <li class="treeview">
            <a>
              <i class="fa fa-dashboard"></i> <span>Post</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="{{asset('')}}admin/post"><i class="fa fa-circle-o"></i> Post</a></li>
            </ul>
          </li>
          <li class="">
            <a href="{{asset('')}}admin/order">
              <i class="fa fa-circle-o" aria-hidden="true"></i> <span>Order</span>
            </a>
          </li> --}}
        </ul>
      </section>
    </aside>
    <div class="content-wrapper">
      {{-- <section class="content-header">
        <h1>
          Table
        </h1>
        <ol class="breadcrumb">
          <li><a><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a>Table</a></li>
        </ol>
      </section> --}}
      <section class="content">
        @yield('content')
      </section>
    </div>
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
      </div>
      <strong>Copyright &copy; 2020<a> {{ __('dict.app_name') }}</a>.</strong> Reserved
    </footer>
    <div class="control-sidebar-bg"></div>
  </div>
  <script src="{{asset('../js/jquery.min.js')}}"></script>
  <script src="{{asset('../js/bootstrap.min.js')}}"></script>
  <script src="{{asset('../js/jquery.slimscroll.min.js')}}"></script>
  <script src="{{asset('../js/fastclick.js')}}"></script>
  <script src="{{asset('../js/adminlte.min.js')}}"></script>
  <script src="{{asset('../js/demo.js')}}"></script>
  <script src="{{asset('../js/toastr.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
  <script src="https://cdn.ckeditor.com/4.10.1/standard/ckeditor.js"></script>
  @yield('foot')
</body>
</html>
