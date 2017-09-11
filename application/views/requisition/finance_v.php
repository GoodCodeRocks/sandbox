<div class="container-fluid">
	<div class="panel panel-default row">
		<div class="panel-body">
			<div class="row">
      			<div class="col-md-4">
       				<label for="requisitionnumber">Requisition Number:</label>
	            	<input type="text" class="form-control" value="<?=$details[0]['requisition_no'] ?>" readonly>
       			</div>
       			<div class="col-md-4">
       				<label for="department">Department</label>
	            	<input type="text" class="form-control" value="<?=$details[0]['Department'] ?>" readonly>
       			</div>
       			<div class="col-md-4">
       				<label for="name">Name:</label>
	            	<input type="text" class="form-control" value="<?=$details[0]['name'] ?>" readonly>
       			</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-7">
       				<embed src="<?php if(!empty($details[0]['file_name'])){echo base_url('assets/uploads/'.$details[0]['file_name']);} ?>" style="width:100%">
       			</div>
       			<div class="col-md-5">
       				<table class="table-striped table-hover table-bordered " style="Width:100%; height: 100%;">
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
       				<label for="total">Total:</label>
	           		<input type="text" class="form-control" value="" readonly>
       			</div>
       			<div class="col-md-6">
       				<label for="lineitemcode">Line Item Code:</label>
	           		<input type="text" class="form-control" value="" readonly>
       			</div>
       			<div class="col-md-6">
       				<label for="departmentcode">Department Code:</label>
	           		<input type="text" class="form-control" value="" readonly>
       			</div>
       			<div class="col-md-6">
       				<label for="bank">Bank:</label>
	           		<select name="bank" id="bank" class="form-control">
	           			<option value="" disabled selected>Select Category</option> 
						<option value="">RBC</option>
						<option value="">RBTT</option>
						<option value="">First Citizens Bank</option>
						<option value="">Scotia Bank</option>
	           		</select>
       			</div>
       			<div class="col-md-6">
       				<label for="financialstatus">Financial Status:</label>
	           		<select name="financialstatus" id="financialstatus" class="form-control">
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
	</div>
</div>