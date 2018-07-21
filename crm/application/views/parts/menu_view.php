<!-- Horizontal navigation-->
<div role="navigation" data-menu="menu-wrapper" class="header-navbar navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-bordered navbar-shadow">
    <!-- Horizontal menu content-->
    <div data-menu="menu-container" class="navbar-container main-menu-content container center-layout">
        <!-- include <?= ASSETS ?>adminApp/theme/includes/mixins-->
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">
            <li  id="dashboard_li" class="dropdown nav-item menu-li"><a href="<?= base_url('dashboard')?>" data-toggle="" class="nav-link"><i class="icon-home3"></i><span data-i18n="nav.dash.main">Dashboard</span></a>
            </li>

            <li  id="template_li" class="dropdown nav-item menu-li"><a href="<?= base_url('templates/view')?>" data-toggle="" class="nav-link"><i class="icon-credit-card2"></i><span data-i18n="nav.dash.main">Templates</span></a>
            </li>
            
            <li  id="dashboard_li" class="dropdown nav-item menu-li"><a href="<?= base_url('settings/material-type')?>" data-toggle="" class="nav-link"><i class="icon-gear"></i><span data-i18n="nav.dash.main">Settings</span></a>
            </li>

        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>
<!-- Horizontal navigation-->