<!DOCTYPE html>
<html lang="en">
    <head>
        <title>USC Requisition</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <link href="https://fonts.googleapis.com/css?family=Quattrocento+Sans" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet"  type="text/css" href="<?= base_url('assets/css/bootstrap-select.css'); ?>">
        <link rel="stylesheet"  type="text/css" href="<?= base_url('assets/css/style.css'); ?>" >

        <!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
		<!-- (Optional) Latest compiled and minified JavaScript translation files -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/i18n/defaults-*.min.js"></script>
        <script src="<? echo base_url('assets/js/bootstrap-select.js'); ?>"></script>

        <!-- For ChartsJs -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

		<!-- For tabs -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<!-- Function for Tabs -->
		<script>
		  $( function() {
		    $( "#tabs" ).tabs();
		  } );
		  </script>





    </head>
    <body>
        <div class="container-fluid">
        <div class="row">
        	<div class="col-lg-12">
            	<nav class="navbar navbar-default">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="<? echo base_url(); ?>dashboard">
                            <strong>Requisition</strong>
                        </a>
                    </div>

                    <ul class="nav navbar-nav ">
                        <li class="">
                                <a href="#">
                                    Logged in as <b>Niall Edwards</b>
                                </a>
                        </li>
                        <li class=""><a href="" >Log Out</a> </li>
                    </ul>

                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="http://www.usc.edu.tt" target="_blank">USC Webpage</a></li>
                        </ul>
                    </div>
            	</nav>
        	</div>
        	</div>

		<div class="container">
		<div class="page-content" style="min-height: 550px;">
	            <div class="left-panel" style="float: left; width: 15%; padding: 5px; margin: 5px; ">
	            <div class="panel panel-success row">
					<div class="panel-heading" style="font-family: sans-serif; font-size: 24px;; text-align: center; color: Orange; padding: 1px; margin:1px;"><h3>User</h3></div>
						<div class="panel-body">
			            	<ul class="list-unstyled">

			            		
			            		<li><a href="<?= base_url('requisition/pending'); ?>">Pending <span class="label label-warning">42</span></a></li>
			            		<li><a href="<?= base_url('index.php/welcome/processedRequisition'); ?>">Processed <span class="label label-success">42</span></a></li>
			            		<li><a href="<?= base_url('index.php/welcome/approvedRequisition'); ?>">Approved <span class="label label-danger">42</span></a></li>
			            		<li><a href="<?= base_url('requisition/form'); ?>">New Requisition</a></li>
			            		<li><a href="<?= base_url('index.php/welcome/history'); ?>">Reports</a></li>
			            	</ul>
		            	</div>
	            	</div>

	            	<hr>
	            	<div class="panel panel-success row">
					<div class="panel-heading" style="font-family: sans-serif; font-size: 24px;; text-align: center; color: Orange; padding: 1px; margin:1px;"><h3>Admin</h3></div>
						<div class="panel-body">
	            	<ul class="list-unstyled">

	            		<li><a href="<?= base_url('admin/users'); ?>">Manage Users</a></li>
	            		<li><a href="<?= base_url('admin/departments'); ?>">Manage Departments</a></li>
	            		<li><a href="<?= base_url('index.php/welcome/managePayees'); ?>">Manage Payees</a></li>
	            		<li><a href="#">Manage Admins</a></li>
	            		<li><a href="<?= base_url('index.php/welcome/manageProcesses'); ?>">Manage Processes</a></li>
	            		<li><a href="<?= base_url('admin/roles'); ?>">Manage Roles</a></li>
	            	</ul>
	            	</div>
	            	</div>
	            </div>
	        <?php $this->load->view($content); ?>
	        </div>
	    </div>

			<div class="row">
				<div class="col-lg-12" style="height: 75px; background: lightgreen;">
					<div class="row">
						<div class="col-md-4" style="border-right: 1px green solid; line-height: 75px;">
							<img alt="USC Logo" src="<?= base_url('assets/img/usc_logo.png')?>" height="60" width="60">
						</div>
						<div class="col-md-4">Center</div>
						<div class="col-md-4" style="border-left: 1px green solid; line-height: 75px;">Right</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
