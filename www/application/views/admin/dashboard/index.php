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
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua-gradient">
                <div class="inner" id="gyro_inner">
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
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green-gradient">
                <div class="inner" id="gps_inner">
                    <h3>GPS</h3>
                    <div id="gps">
                        <div id="gps_lat">Lat: No Data</div>
                        <div id="gps_lon">Lon: No Data</div>
                        <div id="gps_alt">Alt: No Data</div>
                        <div id="gps_sats">Sats: No Data</div>
                    </div>
                </div>
                <div class="icon">
                    <i class="ion ion-locate"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow-gradient">
                <div class="inner" id="bmv_inner">
                    <h3 id="bmv_name">No Data</h3>
                    <div id="bmv_meter_div">
                        <meter id="bmv_meter" low="40" max="100" value="0" title="%"></meter>
                        <div id="bmv_Akkuzustand_Prozent">No Data</div>
                    </div>
                    <div id="bmv">
                        <div id="bmv_Restzeit">No Data</div>
                        <div id="bmv_Spannung_V">No Data</div>
                        <div id="bmv_Strom_A">No Data</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6" id="gas">
            <!-- small box -->
            <div class="small-box bg-red-gradient">
                <div class="inner" id="gas_inner">
                    <h3 id="gas_name">Gas Flaschen</h3>
                    <div id="gas1">
                        <meter id="gas1_meter" low="40" max="100" value="0" title="%"></meter>
                        <div id="gas1_text">No Data</div>
                    </div>
                    <div id="gas2">
                        <meter id="gas2_meter" low="40" max="100" value="0" title="%"></meter>
                        <div id="gas2_text">No Data</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div id='Akkuzustand_Prozent_container' style="float: left"></div>
        <div id='Kapazitaet_entnommen_Ah_container' style="float: left"></div>
        <div id='Restzeit_container' style="float: left"></div>
        <div id='Spannung_V_container' style="float: left"></div>
        <div id='Strom_A_container' style="float: left"></div>
        <div id='Fans_container' style="float: left"></div>
        <div id='GPS_container' style="float: left"></div>
    </div>
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
<!-- Highcharts -->
<script src='<?= base_url() ?>vendor/highcharts.js' type='text/javascript'></script>
<script src='<?= base_url() ?>vendor/highcharts-more.js' type='text/javascript'></script>
<script>
    function Chart_Akkuzustand_Prozent(data) {
        Highcharts.setOptions({
            time: {
                timezoneOffset: 5 * 60
            },
            global: {
                useUTC: false
            }
        });
        $('#Akkuzustand_Prozent_container').highcharts({
            chart: {
                zoomType: "x",
                type: 'line',
                width: 380,
                height: 250
            },
            credits: {
                href: "https://www.opencamper.de",
                text: "OpenCamper"
            },
            title: {
                text: "Akkustand"
            },
            yAxis: {
                title: {
                    text: null
                },
                min : 0,
                labels: {
                    formatter: function () {
                        return this.value + ' %';
                    }
                }
            },
            series: [{
                data: data,
                name: "BMV712"
            }],
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    hour: '%H:%M'
                }
            },
            plotOptions: {
                line: {
                    marker: {
                        enabled: false
                    }
                }
            }
        });
    }
    function Chart_Kapazitaet_entnommen_Ah(data) {
        $('#Kapazitaet_entnommen_Ah_container').highcharts({
            chart: {
                zoomType: "x",
                type: 'line',
                width: 380,
                height: 250
            },
            credits: {
                href: "https://www.opencamper.de",
                text: "OpenCamper"
            },
            title: {
                text: "Entnommen"
            },
            yAxis: {
                title: {
                    text: null
                },
                min : 0,
                labels: {
                    formatter: function () {
                        return this.value + ' Ah';
                    }
                }
            },
            series: [{
                data: data,
                name: "BMV712"
            }],
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    hour: '%H:%M'
                }
            },
            plotOptions: {
                line: {
                    marker: {
                        enabled: false
                    }
                }
            }
        });
    }
    function Chart_Spannung_V(data) {
        $('#Spannung_V_container').highcharts({
            chart: {
                zoomType: "x",
                type: 'line',
                width: 380,
                height: 250
            },
            credits: {
                href: "https://www.opencamper.de",
                text: "OpenCamper"
            },
            title: {
                text: "Spannung"
            },
            yAxis: {
                title: {
                    text: null
                },
                min : 0,
                labels: {
                    formatter: function () {
                        return this.value + ' V';
                    }
                }
            },
            series: [{
                data: data,
                name: "BMV712"
            }],
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    hour: '%H:%M'
                }
            },
            plotOptions: {
                line: {
                    marker: {
                        enabled: false
                    }
                }
            }
        });
    }
    function Chart_Strom_A(data) {
        $('#Strom_A_container').highcharts({
            chart: {
                zoomType: "x",
                type: 'line',
                width: 380,
                height: 250
            },
            credits: {
                href: "https://www.opencamper.de",
                text: "OpenCamper"
            },
            title: {
                text: "Strom"
            },
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return this.value + ' A';
                    }
                }
            },
            series: [{
                data: data,
                name: "BMV712"
            }],
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    hour: '%H:%M'
                }
            },
            plotOptions: {
                line: {
                    marker: {
                        enabled: false
                    }
                }
            }
        });
    }
    function Chart_Fans(data) {
        $('#Fans_container').highcharts({
            chart: {
                zoomType: "x",
                type: 'line',
                width: 380,
                height: 250
            },
            credits: {
                href: "https://www.opencamper.de",
                text: "OpenCamper"
            },
            title: {
                text: "Lüfter"
            },
            yAxis: {
                title: {
                    text: null
                },
                min : 0,
                labels: {
                    formatter: function () {
                        return this.value + ' %';
                    }
                }
            },
            series: data,
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    hour: '%H:%M'
                }
            },
            plotOptions: {
                line: {
                    marker: {
                        enabled: false
                    }
                }
            }
        });
    }
    function Chart_GPS(data) {
        $('#GPS_container').highcharts({
            chart: {
                zoomType: "x",
                type: 'line',
                width: 380,
                height: 250
            },
            credits: {
                href: "https://www.opencamper.de",
                text: "OpenCamper"
            },
            title: {
                text: "GPS"
            },
            yAxis: {
                title: {
                    text: null
                },
                min : 0,
                labels: {
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            series: data,
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    hour: '%H:%M'
                }
            },
            plotOptions: {
                line: {
                    marker: {
                        enabled: false
                    }
                }
            }
        });
    }
    $(document).ready(function() {
        (function bmv_worker() {
            $.ajax({
                url: '/ajax/bmv712.php?days=7&group=60',
                type: 'GET',
                async: true,
                dataType: "json",
                success: function (data) {
                    Chart_Akkuzustand_Prozent(data['Akkuzustand_Prozent']);
                    Chart_Kapazitaet_entnommen_Ah(data['Kapazitaet_entnommen_Ah']);
                    Chart_Spannung_V(data['Spannung_V']);
                    Chart_Strom_A(data['Strom_A']);
                    console.log("got data: BMV");
                },
                complete: function() {
                    // Schedule the next request when the current one's complete
                    setTimeout(bmv_worker, 60000);
                }
            });
        })();
        (function fans_worker() {
            $.ajax({
                url: '/ajax/fans.php',
                type: 'GET',
                async: true,
                dataType: "json",
                success: function (data) {
                    Chart_Fans(data['fans']);
                    console.log("got data: Fans");
                },
                complete: function() {
                    // Schedule the next request when the current one's complete
                    setTimeout(fans_worker, 60000);
                }
            });
        })();
        (function gps_worker() {
            $.ajax({
                url: '/ajax/gps.php',
                type: 'GET',
                async: true,
                dataType: "json",
                success: function (data) {
                    Chart_GPS(data['gps']);
                    console.log("got data: GPS");
                },
                complete: function() {
                    // Schedule the next request when the current one's complete
                    setTimeout(gps_worker, 60000);
                }
            });
        })();
    });
    $("#dashboard").addClass('active');
    <?php
    if(@$javascript_variables['gas_1_topic']) {
        echo '$("#gas").css("visibility", "visible");';
        echo '$("#gas1").css("visibility", "visible");';
    }
    if(@$javascript_variables['gas_2_topic']) {
        echo '$("#gas2").css("visibility", "visible");';
    }
    if(@isset($gyro)) {
        echo '$("#gyro_rotation_x").text("X: " + '.$gyro['x'].');';
        echo '$("#gyro_rotation_x_img").css("-webkit-transform", "rotate(" + '.$gyro['x'].' + "deg)");';
        echo '$("#gyro_rotation_y").text("Y: " + '.$gyro['y'].');';
        echo '$("#gyro_rotation_y_img").css("-webkit-transform", "rotate(" + '.$gyro['y'].' + "deg)");';
    }
    if(@isset($gps)) {
        echo '$(\'#gps_lat\').text("Lat: " + '.$gps['lat'].');';
        echo '$(\'#gps_lon\').text("Lon: " + '.$gps['lon'].');';
        echo '$(\'#gps_alt\').text("Alt: " + '.$gps['alt'].');';
        echo '$(\'#gps_sats\').text("Sats: " + '.$gps['sats'].');';
    }
    ?>
</script>