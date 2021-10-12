@inject('request', 'Illuminate\Http\Request')
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li>
        <router-link :to="{ name: 'dashboard.index' }">
          <i class="fa fa-wrench"></i>
          <span class="title">@lang('quickadmin.qa_dashboard')</span>
        </router-link>
      </li>

      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span class="title">@lang('quickadmin.user-management.title')</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <router-link :to="{ name: 'roles.index' }">
              <i class="fa fa-briefcase"></i>
              <span class="title">
                @lang('quickadmin.roles.title')
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'permissions.index' }">
              <i class="fa fa-briefcase"></i>
              <span class="title">
                @lang('quickadmin.permissions.title')
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'titles.index' }">
              <i class="fa fa-briefcase"></i>
              <span class="title">
                @lang('quickadmin.titles.title')
              </span>
            </router-link>
          </li>
          <li>
            <router-link :to="{ name: 'users.index' }">
              <i class="fa fa-user"></i>
              <span class="title">
                @lang('quickadmin.users.title')
              </span>
            </router-link>
          </li>
        </ul>
      </li>
      <li>
        <router-link :to="{ name: 'companies.index' }">
          <i class="fa fa-tablet"></i>
          <span class="title">@lang('quickadmin.companies.title')</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'projects.index' }">
          <i class="fa fa-tablet"></i>
          <span class="title">@lang('quickadmin.projects.title')</span>
        </router-link>
      </li>
      <li>
        <router-link :to="{ name: 'auth.change_password' }">
          <i class="fa fa-key"></i>
          <span class="title">@lang('quickadmin.qa_change_password')</span>
        </router-link>
      </li>
      <li>
        <a href="#logout" onclick="$('#logout').submit();">
          <i class="fa fa-arrow-left"></i>
          <span class="title">@lang('quickadmin.qa_logout')</span>
        </a>
      </li>
    </ul>
  </section>
</aside>
