<div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{route('admin.dashboard')}}" class="logo">
              <h2 class="text-white">{{config('app.short_name')}}</h2>
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item  @if($page_slug == 'dashboard') active @endif">
                <a href="{{route('admin.dashboard')}}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item  @if($page_slug == 'admin') active @endif">
                <a href="{{route('admin.index')}}">
                  <i class="fas fa-users"></i>
                  <p>Admins</p>
                </a>
              </li>

               {{-- <li class="nav-item  @if($page_slug == 'admin' || $page_slug == 'role') active submenu @endif">
                <a data-bs-toggle="collapse" href="#admin_management" @if($page_slug == 'admin') aria-expanded="true" @endif>
                  <i class="fas fa-bars"></i>
                  <p>Admin Management</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse @if($page_slug == 'admin' || $page_slug == 'role') show @endif" id="admin_management">
                  <ul class="nav nav-collapse">
                    <li class="@if($page_slug == 'admin') active @endif">
                      <a href="{{route('am.admin.index')}}">
                        <span class="sub-item">Admin</span>
                      </a>
                    </li>
                    <li class="@if($page_slug == 'role') active @endif">
                      <a href="{{route('am.role.index')}}">
                        <span class="sub-item">Role</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>



              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#submenu">
                  <i class="fas fa-bars"></i>
                  <p>Menu Levels</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="submenu">
                  <ul class="nav nav-collapse">
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav1">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav1">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a data-bs-toggle="collapse" href="#subnav2">
                        <span class="sub-item">Level 1</span>
                        <span class="caret"></span>
                      </a>
                      <div class="collapse" id="subnav2">
                        <ul class="nav nav-collapse subnav">
                          <li>
                            <a href="#">
                              <span class="sub-item">Level 2</span>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </li>
                    <li>
                      <a href="#">
                        <span class="sub-item">Level 1</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li> --}}
            </ul>
          </div>
        </div>
      </div>