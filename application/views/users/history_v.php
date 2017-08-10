<div class="right-panel" style="float: left; width: 80%; padding: 5px; margin: 5px;">
<div class="row">
<div class="row text-center">
	<h2> Department Requisition History </h2>
</div>
	<div class="col-md-12">
		<div class="panel-group" id="accordion">
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h3 class="panel-title">
			       <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
			        <strong>2ndSem 15-16</strong></a>
			      </h3>
			    </div>
			    <div id="collapse1" class="panel-collapse collapse">
			      <div class="panel-body">
			      	<h2 class="detail"> Processed Requisitions (ReadOnly) </h2>
			      		<img src="<?=base_url("assets/img/piechart.jpg")?>" alt="Fjords" width="350" height="200">
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h3 class="panel-title">
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
			        <strong>2ndSem 15-16</strong></a>
			      </h3>
			    </div>
			    <div id="collapse2" class="panel-collapse collapse">
			      <div class="panel-body">
			      		<h2> Processed Requisitions (ReadOnly) </h2>
			      		<img src="<?=base_url("assets/img/chart-2.png")?>" alt="Fjords" width="350" height="200">
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h3 class="panel-title">
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
			        <strong>3rdSem 15-16</strong></a>
			      </h3>
			    </div>
			    <div id="collapse3" class="panel-collapse collapse">
			      <div class="panel-body">
			      
			      	<h2> Processed Requisitions (ReadOnly) </h2>
			      		
			      		<img src="<?=base_url("assets/img/chart-1.png")?>" alt="Fjords" width="350" height="250">
						<div id="resizable" style="height: 300px;border:1px solid gray;">
							<div id="chartContainer1" style="height: 100%; width: 100%;"></div>
						</div>
			      </div>
			    </div>
			  </div>
			  <div class="panel panel-default">
			    <div class="panel-heading">
			      <h3 class="panel-title">
			        <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
			        <strong>Draggable Test</strong></a>
			      </h3>
			    </div>
			    <div id="collapse4" class="panel-collapse collapse in">
			    	<h2 id="app_status">App status</h2>
			      	<div class="panel-body">
		      			<canvas id="myChart"></canvas>
						
			      	</div>
			    </div>
			  </div>
			</div>
	</div>			

</div>
</div>
<!-- Script for Charts -->
  <script type="text/javascript">
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
      // The type of chart we want to create
      type: 'bar',

      // The data for our dataset
      data: {
          labels: ["January", "February", "March", "April", "May", "June", "July"],
          datasets: [{
              label: "My First dataset",
              backgroundColor: 'rgb(255, 156, 132)',
              //borderColor: 'rgb(255, 99, 11)',
              data: [0, 10, 5, 2, 20, 30, 45],
          }]
      },

      // Configuration options go here
      options: {}
  });
  
  </script>
