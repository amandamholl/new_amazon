<!DOCTYPE html>
<!-- saved from url=(0050)http://getbootstrap.com/examples/navbar-fixed-top/ -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="http://getbootstrap.com/favicon.ico">

    <title>Fixed Top Navbar Example for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/navbar-fixed-top/navbar-fixed-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="./search_files/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./cover.php">COEN 280 Final Project</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="./cover.php">Home</a></li>
            <li><a href="./login.php">Login</a></li>
            <li><a href="./search.php">Search</a></li>
            <li><a href="./review.php">Review</a></li>
            <?php
				$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
				//echo 'Connected successfully'; 
				mysql_select_db('FINALPROJECT') or die('Could not select database'); 
				//print_r(($_SESSION['login']));
				if(isset($_SESSION['login'])){	
				
				  $query = "SELECT permission_level FROM customer WHERE customer_id='".$_SESSION['login']."'";
				  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
				  $row = mysql_fetch_array($result, MYSQL_ASSOC);
				  if($row['permission_level']=='manager'){
					  echo '<li><a href="./manage.php">Manage</a></li>';
				  }
				}
			?>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="./cart.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>&nbsp;Cart</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Sign Up</h1>
        <p>Enter your information to create an account.</p>
      </div>
      <div class="row">
        <div class="col-lg-12">
		<?php 
			$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
			//echo 'Connected successfully'; 
			mysql_select_db('FINALPROJECT') or die('Could not select database');
  			$email=$_POST['email'];
			$password=$_POST['password'];
			$first_name=$_POST['first_name'];
			$middle_name=$_POST['middle_name'];
			$last_name=$_POST['last_name'];
			$phone_number=$_POST['phone_number'];
			$billing_street_number=$_POST['billing_street_number'];
			$billing_street_name=$_POST['billing_street_name'];
			$billing_apt_number=$_POST['billing_apt_num'];
			$billing_city=$_POST['billing_city'];
			$billing_state=$_POST['billing_state'];
			$billing_zip=$_POST['billing_zip'];
			$shipping_street_number=$_POST['shipping_street_number'];
			$shipping_street_name=$_POST['shipping_street_name'];
			$shipping_apt_number=$_POST['shipping_apt_num'];
			$shipping_city=$_POST['shipping_city'];
			$shipping_state=$_POST['shipping_state'];
			$shipping_zip=$_POST['shipping_zip'];
			$company=$_POST['company'];
			/*echo "'$email','$password','$first_name','$middle_name','$last_name','$phone_number','$billing_street_number','$billing_street_name','$billing_apt_number','$billing_city','$billing_state','$billing_zip','$shipping_street_number','$shipping_street_name','$shipping_apt_number','$shipping_city','$shipping_state','$shipping_zip'";*/
			if($email==null || $first_name==null || $middle_name==null || $last_name==null || $password==null || $phone_number==null){
				echo "There was an error processing the form"."<br/><br/>";
			//print("<a class='back' href="."./schedule.html".">Back to the Kids Camp Registration page.</a>");
			}
			else{
				$sql="INSERT INTO customer (email,password,company, first_name,middle_name,last_name,phone_number,billing_street_number,billing_street_name,billing_apt_num,billing_city,billing_state,billing_zip,shipping_street_number,shipping_street_name,shipping_apt_num,shipping_city,shipping_state,shipping_zip) VALUES ('$email','$password','$company','$first_name','$middle_name','$last_name','$phone_number','$billing_street_number','$billing_street_name','$billing_apt_number','$billing_city','$billing_state','$billing_zip','$shipping_street_number','$shipping_street_name','$shipping_apt_number','$shipping_city','$shipping_state','$shipping_zip')";
					//echo $sql;
					echo '<h4> Thank you for signing up</h4>'.'<p><a href="./login.php">Please log in to begin shopping</a></p>';
					mysql_query($sql) or die (mysql_error());
			}
		?>
      	</div>
      </div>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./login_files/ie10-viewport-bug-workaround.js"></script>
  	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    
    <script>
		$( document ).ready(function() {
		  $('.btn-warning').click(function() {
			  window.location.assign("./search.html");
		  });
		});
	</script>

</body></html>