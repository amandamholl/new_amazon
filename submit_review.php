<?php 
  session_start();
 ?>
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
            <span >Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="./cover.php">COEN 280 Final Project</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="./cover.php">Home</a></li>
            <li><?php if(isset($_SESSION['login'])){?><a href="./logout.php">Logout</a><?php }else{?> <a href="./login.php">Login</a><?php } ?></li>
            <li><a href="./search.php">Search</a></li>
            <li class="active"><a href="#">Review</a></li>
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
        <h1>Review</h1>
        <p>Write a review about a camera.</p>
      </div>
      <?php
	  //print_r($_SESSION);
	  	$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
		mysql_select_db('FINALPROJECT') or die('Could not select database');
		$var = $_SESSION['login'];
		//print_r($var['email']);
		//print_r($var['password']);
	  	$query="SELECT customer_id FROM customer WHERE customer_id='".$var."'";
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		//echo mysql_num_rows($result);
		if(mysql_num_rows($result) != 0){
			$row = mysql_fetch_array($result, MYSQL_ASSOC);  			
			//echo 'here';
		}else{ 
			echo '<p> You are not logged in. Please <a href="./login.php"> login </a> before proceeding</p>';
			//print_r( $_SESSION['login'][$row['customer_id']]);  
		}
	  ?>
      <div class="row">
      	<div class="col-md-12">
        	<h1>Review</h1>
            <?php
				$customer_id = $_POST['customer_id'];
				$product_id = $_POST['product_id'];
				$rating = $_POST['rating'];
				$review = mysql_real_escape_string($_POST['review']);
				if($customer_id==null || $product_id==null || $rating==null || $review==null){
					echo "There was an error processing the form"."<br/><br/>";
				//print("<a class='back' href="."./schedule.html".">Back to the Kids Camp Registration page.</a>");
				}
				else{
					$sql="INSERT INTO review (customer_id,product_id,rating,feedback) VALUES ('$customer_id','$product_id','$rating','$review')";
					mysql_query($sql) or die (mysql_error());
					echo "<h4> Your review has been submitted </h4>";
					echo "<p><strong>Rating:</strong> {$rating} </p>";
					echo "<p><strong>Review: </strong>".nl2br(stripslashes(($review)))."</p>";
			}
			?>
        </div>
      	
    </div>
    
        
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="./search_files/jquery.min.js"></script>
    <script src="./search_files/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./search_files/ie10-viewport-bug-workaround.js"></script>
  

</body></html>