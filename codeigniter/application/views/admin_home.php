<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barnsdeal</title>
    <link href="<?php echo site_url('assets/css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="<?php echo site_url('assets/css/admin_home.css'); ?>" rel="stylesheet">
	<style> body { padding-top: 62px; background-color: rgb(246, 246, 246); } </style>
</head>

<body>
	
	<?php $this->load->view('nav_bar'); ?>
	<?php $this->load->view('side_bar'); ?>

	<div class="main_container">

		<?php $this->load->view($main_content); ?>

	</div>
	
	<script src="<?php echo site_url('assets/javascript/jquery.min.js')?>"></script>
	<script src="<?php echo site_url('assets/javascript/bootstrap.bundle.js')?>"></script>
	
</body>
</html>


