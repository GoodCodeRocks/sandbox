<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">


<style >

body {
	background: #eee !important;	
}


body {
	background: #eee !important;	
}

.wrapper {	
	margin-top: 80px;
  margin-bottom: 80px;

}

.form-signin {
  max-width: 380px;
  padding: 15px 35px 45px;
  margin: 0 auto;
  background-color: #fff;
  border-radius: 15px;
  border: 3px outset rgba(0,0,0,0.1);  

  .form-signin-heading,
	.checkbox {
	  margin-bottom: 30px;
	}

	.checkbox {
	  font-weight: normal;
	}

	.form-control {
	  position: relative;
	  font-size: 16px;
	  height: auto;
	  padding: 10px;
		/*@include box-sizing(border-box);*/

		&:focus {
		  z-index: 2;
		}
	}

	input[type="text"] {
	  margin-bottom: -1px;
	  border-bottom-left-radius: 0;
	  border-bottom-right-radius: 0;
	}

	input[type="password"] {
	  margin-bottom: 20px;
	  border-top-left-radius: 0;
	  border-top-right-radius: 0;
	}
}
</style>
<script type="text/javascript">

$(document).ready(function(){

	$("form :input").attr("autocomplete", "off");
	//$("#username").attr('disabled',true);
	
});
</script>
<div class='container'>
	 <div class="wrapper">
	 	<?php 
	 		$attr = array('method'=>'post', 'class'=>'form-signin');
	 	?>
	    <?=form_open('login/login',$attr)?>       
	      <h2 class="form-signin-heading">Login</h2>
	      <input type="text" class="form-control" id="username" name="username" placeholder="Username" required=""  /><br/>
	      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="" autofocus=""/>      
	      <br/>
	      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>   
	    <?=form_close()?>
  </div>
</div>