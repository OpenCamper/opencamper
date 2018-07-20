<!-- iCheck -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/iCheck/flat/blue.css">
<!-- jvectormap -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- Date Picker -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/datepicker/datepicker3.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua-gradient">
                <div class="inner">
                    <h3>Gyro</h3>
                    <div style="height:220px;">
                        <center>
                            <img id="gyro_rotation_x_img" src="<?= base_url() ?>public/dist/img/wowa_side.png" width="200px" style="scaleX(-1)"><br/>
                            <div id="gyro_rotation_x">X: No Data</div>
                            <br/>
                            <br/>
                            <img id="gyro_rotation_y_img" src="<?= base_url() ?>public/dist/img/wowa_back.png" width="60px"><br/>
                            <div id="gyro_rotation_y">Y: No Data</div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green-gradient">
                <div class="inner">
                    <h3>GPS</h3>
                    <p>
                    <div id="gps">
                        <div id="gps_lat">Lat: No Data</div>
                        <div id="gps_lon">Lon: No Data</div>
                        <div id="gps_alt">Alt: No Data</div>
                        <div id="gps_sats">Sats: No Data</div>
                    </div>
                    </p>
                </div>
                <div class="icon">
                    <i class="ion ion-locate"></i>
                </div>
            </div>
        </div>
        <!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow-gradient">
                <div class="inner">
                    <h3 id="bmv_name">No Data</h3>
                    <p>
                    <div id="bmv">
                        <div id="bmv_Restzeit">No Data</div>
                        <div id="bmv_Spannung_V">No Data</div>
                        <div id="bmv_Strom_A">No Data</div>
                        <div id="bmv_Akkuzustand_Prozent">No Data</div>
                    </div>
                    </p>
                </div>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
</section>

<!-- Sparkline -->
<script src="<?= base_url() ?>public/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= base_url() ?>public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= base_url() ?>public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= base_url() ?>public/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?= base_url() ?>public/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= base_url() ?>public/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?= base_url() ?>public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url() ?>public/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= base_url() ?>public/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= base_url() ?>public/dist/js/demo.js"></script>
<script>
    $("#dashboard").addClass('active');
</script>