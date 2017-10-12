<div class="container-fluid">
	<div class="panel panel-default row">
		<div class="panel-body" id="tabs">
			<ul>
				<li><a href="#tabs-invoice">Invoice</a></li>
				<li><a href="#tabs-print">Print</a></li>
			</ul>
			<div id="tabs-invoice">
				<div class="row">
					<div class="col-md-4">
						<label for="requisitionnumber">Requisition Number:</label> <input
							type="text" class="form-control"
							value="<?=$details[0]['requisition_no'] ?>" readonly>
					</div>
					<div class="col-md-4">
						<label for="department">Department</label> <input type="text"
							class="form-control" value="<?=$details[0]['Department'] ?>"
							readonly>
					</div>
					<div class="col-md-4">
						<label for="name">Name:</label> <input type="text"
							class="form-control" value="<?=$details[0]['name'] ?>" readonly>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-7">
						<embed
							src="<?php if(!empty($details[0]['file_name'])){echo base_url('assets/uploads/'.$details[0]['file_name']);} ?>"
							style="width: 100%">
					
					</div>
					<div class="col-md-5">
						<table class="table-striped table-hover table-bordered "
							style="Width: 100%; height: 100%;">
							<tr>
								<th>Item Description</th>
								<th>Category</th>
								<th>Quantity</th>
								<th>Unit Cost</th>
								<th>Cumulative Cost</th>
							</tr>
					<?php foreach ($Items as $item) {?>	
							<tr>
								<td><?=$item['description']?></td>
								<td><?=$item['category_name']?></td>
								<td><?=$item['quantity']?></td>
								<td><?=$item['unit_cost']?></td>
								<td><?=$item['cumulative_cost']?></td>
							</tr>
					<?php }?>
						</table>
					</div>
				</div>
				<hr>
				<div class="form row">
					<div class="col-md-4 col-md-offset-8">
						<label for="total">Total:</label> <input type="text"
							class="form-control" value="" readonly>
					</div>
					<div class="col-md-6">
						<label for="lineitemcode">Line Item Code:</label> <input
							type="text" class="form-control" value="" readonly>
					</div>
					<div class="col-md-6">
						<label for="departmentcode">Department Code:</label> <input
							type="text" class="form-control" value="" readonly>
					</div>
					<div class="col-md-6">
						<label for="bank">Bank:</label> <select name="bank" id="bank"
							class="form-control">
							<option value="" disabled selected>Select Category</option>
							<option value="">RBC</option>
							<option value="">RBTT</option>
							<option value="">First Citizens Bank</option>
							<option value="">Scotia Bank</option>
						</select>
					</div>
					<div class="col-md-6">
						<label for="financialstatus">Financial Status:</label> <select
							name="financialstatus" id="financialstatus" class="form-control">
							<option value="" disabled selected>Select Category</option>
							<option value="">Accounts Payable</option>
							<option value="">Information Technology</option>
							<option value="">Procurement</option>
							<option value="">Cheque Preparation</option>
							<option value="">Awaiting Delivery</option>
							<option value="">Delivered</option>
						</select>
					</div>
					<div class=" col-md-2 col-md-offset-10">
						<hr>
						<button type="submit" class="btn-xs btn-success">Save</button>
						<button type="submit" class="btn-xs btn-danger">Cancel</button>
					</div>
				</div>
			</div>
			<div class="panel panel-default" id="tabs-print">
				<div class="panel-heading">
					<div class="row">
						<div class="col-lg-1">
							<img alt="" src="<?=base_url('/assets/img/usc_logo.png')?>"
								style="width: 220%;">
						</div>
						<div class="col-lg-8 col-lg-offset-1">
							<h3>
								University of the Southern Caribbean<br>
								<small>Requisition Form</small>
							</h3>
						</div>
						<div class="col-lg-3" style="float: right;">
							<label>No:</label> <?=$details[0]['requisition_no'] ?>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="form-group col-md-4" style="float: left;">
						<label>Supplier:</label> <input class="form-control" type="text"
							value="Niall Edwards">
					</div>
					<div class="form-group col-md-4" style="float: right;">
						<label>Date:</label><br>
						<?= date("l F j \, Y");?>
					</div>
					<div class="form-group col-md-12" style="float: right;">
						<label>Payee:</label> <input class="form-control" type="text"
							value="Niall Edwards">
					</div>
					<table class="table-striped table-hover table-bordered"
						style="Width: 100%; height: 100%;">
						<thead>
							<tr>
								<th style="width: 5%;">Qty</th>
								<th style="width: 75%;">Details</th>
								<th style="width: 10%;">Unit Price</th>
								<th style="width: 10%;">Cost</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($Items as $item) {?>	
							<tr>
							<td><?=$item['quantity']?></td>
								<td><?=$item['description']?></td>
								<td><?=$item['unit_cost']?></td>
								<td><?=$item['cumulative_cost']?></td>
							</tr>
					<?php }?>
						</tbody>
					</table>
					<hr>
					<div>
						<div style="width: 60%; float: left;">
							<label>Department:</label><br>
							<?=$details[0]['Department'] ?>
						</div>
						<div style="width: 40%; float: left;">
							<label>Purchase Order Required:</label> <input type="checkbox">
						</div>
						<div style="width: 60%; float: left;">
							<label>Approval Signatures:</label><br>
							<?php foreach ($approvedBy as $approvedby) { echo $approvedby['user'].","; }?>
						</div>
						<div style="width: 40%; float: left;">
							<label>Special Request:</label> <input class="form-control"
								type="text" value="">
						</div>
					</div>

					<div>
						<div style="width: 60%; float: left;">
							<label>Finance Approval:</label> <input class="form-control"
								type="text" value="Information Technology">
						</div>
						<div style="width: 40%; float: left;">
							<label>Bank Account:</label> <input class="form-control"
								type="text" value="Information Technology">
						</div>
						<div style="width: 100%; float: left;">
							<label>Charge Account:</label> <input class="form-control"
								type="text" value="David Baynes">
						</div>
					</div>
				</div>
			</div>
			<button id="print" onclick="myFunction()">Print</button>
			<!-- <input type="button" id="btnPrint" value="print" /> -->
		</div>
	</div>
</div>
<script type="text/javascript">
	function myFunction() {
	    window.print();
	}
</script>