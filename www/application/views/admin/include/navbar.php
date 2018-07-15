<header class="main-header">
    <!-- Logo -->
    <a href="<?= base_url('admin'); ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>OC</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Open</b>Camper</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="status-bar">
                    <i alt="wlan" class="material-icons red" id="net_wlan0">signal_wifi_off</i>
                    <i class="material-icons red" id="net_bt">bluetooth_disabled</i>
                    <i class="material-icons red" id="net_eth0">settings_ethernet</i>
                    <i class="material-icons red" id="net_lora">not_interested</i>
                    <i class="material-icons red" id="net_ap">cloud_off</i>
                    <i class="material-icons red" id="net_lte">signal_cellular_off</i>
                    <i class="material-icons red" id="net_wan">portable_wifi_off</i>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?= ucwords($this->session->userdata('name')); ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <p><?= $this->session->userdata('name'); ?></p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="<?= site_url('admin/auth/logout'); ?>" class="btn btn-default btn-flat">Sign
                                    out</a>
                            </div>
                            <div class="pull-left">
                                <a href="<?= site_url('admin/auth/profile'); ?>" class="btn btn-default btn-flat">profile</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- MQTT Client -->
<script src="<?= base_url() ?>public/plugins/paho.mqtt.javascript/src/paho-mqtt.js"></script>
<script src="<?= base_url() ?>public/dist/js/mqtt.js"></script>