<!DOCTYPE html>
<html lang="en">
	<head>
        <title><?=isset($title)?$title.' - Codeigniter AdminLTE':'Codeigniter AdminLTE' ?></title>
        <meta name="keywords" content="codeigniter adminlte, adminlte, admin lte, codeigniter admin lte, codeigniter adminlte integration" />

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?= base_url() ?>public/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/AdminLTE.min.css">
        <!-- Custom CSS -->
        <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/style.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins. -->
        <link rel="stylesheet" href="<?= base_url() ?>public/dist/css/skins/skin-blue.min.css">
        <!-- jQuery 2.2.3 -->
        <script src="<?= base_url() ?>public/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- jQuery UI 1.11.4 -->
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript">
            <?php
            foreach ($javascript_variables as $key => $variable) {
                echo "var ".$key." = '".$variable."';";
            }
            ?>
        </script>
	</head>
	<body class="hold-transition skin-blue sidebar-mini">
		<div class="wrapper" style="height: auto;">
			 <?php if($this->session->flashdata('msg') != ''): ?>
			    <div class="alert alert-warning flash-msg alert-dismissible">
			      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			      <h4> Success!</h4>
			      <?= $this->session->flashdata('msg'); ?> 
			    </div>
			  <?php endif; ?> 
			
			<section id="container">
				<!--header start-->
				<header class="header white-bg">
					<?php include('include/navbar.php'); ?>
				</header>
				<!--header end-->
				<!--sidebar start-->
				<aside>
					<?php include('include/sidebar.php'); ?>
				</aside>
				<!--sidebar end-->
				<!--main content start-->
				<section id="main-content">
					<div class="content-wrapper" style="min-height: 394px; padding:15px;">
						<!-- page start-->
						<?php $this->load->view($view);?>
						<!-- page end-->
					</div>
				</section>
				<!--main content end-->
				<!--footer start-->
				<footer class="main-footer">
					<strong>Copyright © 2018 <a href="#">OpenCamper</a></strong> All rights
					reserved.
				</footer>
				<!--footer end-->
			</section>

			<!-- /.control-sidebar -->
			<?php include('include/control_sidebar.php'); ?>

	</div>	
    
	
	<!-- Bootstrap 3.3.6 -->
	<script src="<?= base_url() ?>public/bootstrap/js/bootstrap.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?= base_url() ?>public/dist/js/app.min.js"></script>
	<!-- AdminLTE for demo purposes -->
	<script src="<?= base_url() ?>public/dist/js/demo.js"></script>
	<!-- page script -->
	<script type="text/javascript">
	  $(".flash-msg").fadeTo(2000, 500).slideUp(500, function(){
	    $(".flash-msg").slideUp(500);
	});
	</script>
	
	</body>
</html>