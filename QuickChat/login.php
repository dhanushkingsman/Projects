<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>QuickChat</title>
 	

<?php include('./header.php'); ?>
<?php include('./db_connect.php'); ?>
<?php 
session_start();
if(isset($_SESSION['login_id']))
header("location:index.php?page=home");

?>

</head>

<style>
	h1{
		position:absolute;
		top:80px;
		left:160px;
		font-size: 60px;
		color: white;


	}

	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:black;
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		
		background: url("chat.avif");
		background-size: cover;
		display: flex;
		align-items: center;
		
	}
	#login-right .card{
		margin: auto;
		z-index: 1;
		border-radius: 20px;
		border: solid 3px white;


	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
}
.btn-login{
	height:40px;
	width:30%;
	color: white;
	background: green;
	margin-left: 56px;
	border-radius: 15px;
	border: none;
}
.btn-login:hover{
	text-decoration: underline;
}
label{
	font-weight: bold;
}
.btn-ca{
	height:40px;
	width:50%;
	color: white;
	background:#FE8F01;
	border-radius: 15px;
	border: none;
	

}
.btn-ca:hover{
	text-decoration: underline ;

}
#username{
	border: solid 2px black;
}
#password{
	border: solid 2px black;
}
</style>

<body>
		<div id="login-left">
			
		</div>
  		<div id="login-right">
			<h1>QuickChat</h1>
  			<div class="card col-md-8">
  				<div class="card-body">
  						
  					<form id="login-form" >
  						<div class="form-group">
  							<label for="username" class="control-label">Username</label>
  							<input type="text" id="username" name="username" class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="password" class="control-label">Password</label>
  							<input type="password" id="password" name="password" class="form-control">
  						</div>
  						<div class="col-md-12">
  						<button class="btn-ca" type="button" id="create_account">Create Account</button>
  						<button class="btn-login">Login</button>
  							
  						</div>
  					</form>
  				</div>
  			</div>
  		</div>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>

</body>
<script>
	window.start_load = function(){
	    $('body').prepend('<di id="preloader2"></di>')
	  }
	  window.end_load = function(){
	    $('#preloader2').fadeOut('fast', function() {
	        $(this).remove();
	      })
	  }
	 window.uni_modal = function($title = '' , $url='',$size=""){
		start_load()
		$.ajax({
		    url:$url,
		    error:err=>{
		        console.log()
		        alert("An error occured")
		    },
		    success:function(resp){
		        if(resp){
		            $('#uni_modal .modal-title').html($title)
		            $('#uni_modal .modal-body').html(resp)
		            if($size != ''){
		                $('#uni_modal .modal-dialog').addClass($size)
		            }else{
		                $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
		            }
		            $('#uni_modal').modal({
		              show:true,
		              backdrop:'static',
		              keyboard:false,
		              focus:true
		            })
		            end_load()
		        }
		    }
		})
		}
	$('#login-form').submit(function(e){
		e.preventDefault()
		start_load()
		if($(this).find('.alert-danger').length > 0 )
			$(this).find('.alert-danger').remove();
		$.ajax({
			url:'ajax.php?action=login',
			method:'POST',
			data:$(this).serialize(),
			error:err=>{
				console.log(err)
				end_load()
			},
			success:function(resp){
				if(resp == 1){
					location.href ='index.php?page=home';
				}else if(resp == 2){
					location.href ='voting.php';
				}else{
					$('#login-form').prepend('<div class="alert alert-danger">Username or password is incorrect.</div>')
					end_load()
				}
			}
		})
	})
	$('#create_account').click(function(){
		uni_modal('Signup','signup.php')
	})
</script>	
</html>