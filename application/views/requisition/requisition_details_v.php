<script type="text/javascript">
$(document).ready(function() {
	$("#unitcost").on('keyup',function(){
	    var total = parseInt($("#quantity").val());
	    total = total*parseFloat($("#unitcost").val());
	$("#cumulativecost").val(total);
	});
	$("#quantity").on('keyup',function(){
	    var total = parseFloat($("#unitcost").val());
	    total = total*parseInt($("#quantity").val());
	$("#cumulativecost").val(total);
	});
});
</script>
		<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
			<div class="container">
				<div class="panel panel-default row">
					<div class="panel-heading"><h3>My Requisitions</h3></div>
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
            					<label for="step">Step:</label>
				            		<input type="text" class="form-control" value="<?=$details[0]['name'] ?>" readonly>
            				</div>
						</div>
						<hr>
						<div class="row" id="tabs">
							<div class=" col-md-2 col-md-offset-10">
								<button type="submit" class="btn-xs btn-success">Process</button>
			            		<button type="submit" class="btn-xs btn-danger">Cancel</button>
			            	</div>
							<ul>
								<li><a href="#tabs-status">Status</a></li>
								<li><a href="#tabs-items">Items</a></li>
							    <li><a href="#tabs-invoice">Invoice</a></li>
							</ul>
							<div class="row"  id="tabs-status">
								<div class="col-md-10 col-md-offset-1">
	            					<table class="table-striped table-hover" style="Width:100%; height: 100%;">
								<tr>
									<th>Requisition Step</th>
									<th>Status</th>
									<th>Approved By</th>
									<th>Position</th>
									<th>Date</th>
								</tr>
								<?php foreach ($processedBy as $process) :?>
								<tr>
									<td><?=$process['step'] ?></td>
									<td><?=$process['status'] ?></td>
									<td><?=$process['user'] ?></td>
									<td><?=$process['position'] ?></td>
									<td><?=$process['approved_at'] ?></td>
								</tr>
								<?php endforeach;?>
							</table>
	            				</div>
							</div>
							<div id="tabs-items">
							<?=form_open('requisition/add_Item/', array('class' => 'form-horizontal'));?>
							    <div class="col-md-6">
	            					<label for="itemname">Item Name:</label>
					            		<input type="text" class="form-control" name="itemname" value="Office Desk">
				            	</div>
				            	<div class="col-md-6">
	            					<label for="itemcategory">Category:</label>
		            					<select name="itemcategory" id="itemcategory" class="form-control">
								            <option value="" disabled selected>Select Category</option> 
										<?php foreach ($Category as $category) {?>
											 <option value="<?php echo $category['id']; ?>"><?php echo $category['category_name']; ?></option>
											<?php }?>
											</select>
				            	</div>
				            	<div class="col-md-6">
		            				<label for="quantity">Quantity:</label>
				            		<input type="text" class="form-control" name="quantity" id="quantity" value="4">
					            </div>
					            <div class="col-md-6">
		            				<label for="unitcost">Unit Cost:</label>
				            		<input type="text" class="form-control" name="unitcost" id="unitcost" value="$0.00">
					            </div>
				            	<div class="col-md-6 col-md-offset-3">
		            				<label for="cumulativecost">CumulativeCost:</label>
				            		<input type="text" class="form-control" name="cumulativecost" id="cumulativecost" value="$0.00">
				            		<input type="text" class="form-control hidden" name="requisitionid" id="requisitionid" value="<?=$this->uri->segment(3);?>">
					            </div>
					            <hr>
					            <div class=" col-md-2 col-md-offset-10">
									<button type="submit" class="btn-xs btn-success">Save</button>
				            		<button type="submit" class="btn-xs btn-danger">Cancel</button>
			            		</div>
					        <?=form_close();?>
							</div>
						  	<div id="tabs-invoice">
						  	<?php 
					        	if (!empty($details[0]['file_name']))
					        	{
					        		$path = $details[0]['file_path'].$details[0]['file_name'];
					        		  $name = $details[0]['file_name'];
									?>
					        		 		        		 
					        		  <a href="<?=base_url().'requisition/download/'.$this->uri->segment(3);?>" target="_blank">View Purchase Order: <small><?php echo $details[0]['file_name']; ?></small></a>

					        		  <br>
					        		  <small>File will be downloaded to your computer</small>
					        		  
					        		  
					        	<?php 	  
					        	}else{
					        ?>
						  	<?php echo form_open_multipart('requisition/purchaseOrder_upload/'.$this->uri->segment(3))?>
								<div class="row">
									<div class="col-md-4">
									<label for="cumulativecost">Select Upload File:</label>
									    	<input type="file" class="validate btn btn-default btn-file" name="purord" id="purord" >
									    	<input type="text" class="form-control hidden" name="requisitionid" id="requisitionid" value="<?=$this->uri->segment(3);?>">
									</div>
								</div>
								
								<br/>
								<div class="row">
									<div class="col-md-4 col-md-offset-10">
										<label class="btn btn-default btn-file">
									    	Upload <input type="submit" class="hidden">
										</label>
									</div>
								</div>
								<?php echo form_close(); }?>
						  	</div>
						</div>
						
						<hr>
						<div class="row">
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
            	</div>
			</div>
		</div>
		