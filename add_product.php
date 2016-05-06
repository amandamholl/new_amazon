<?php session_start(); ?>
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
            <li><?php if(isset($_SESSION['login'])){?><a href="./logout.php">Logout</a><?php }else{?> <a href="./login.php">Login</a><?php } ?></li>
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
	<div class="row">
    <div class="col-md-12">
<?php
  		$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
		//echo 'Connected successfully'; 
		mysql_select_db('FINALPROJECT') or die('Could not select database');
  		$name=$_POST['name'];
        $model_number=$_POST['model_number'];
        $manufacturer=$_POST['manufacturer'];
        $width=$_POST['width'];
        $height=$_POST['height'];
        $depth=$_POST['depth'];
        $weight=$_POST['weight'];
        $color=$_POST['color'];
        $max_resolution=$_POST['res'];
        $sensor_size=$_POST['sensor'];
		$iso_range=$_POST['iso'];
		$display_size=$_POST['display'];
		$quantity=$_POST['quantity'];
		if($_POST['wireless']=='Yes'){
			$wireless_technology=1;
		}
		else{
			$wireless_technology=0;
		}
		//$wireless_technology=$_POST['wireless'];
		
		$image_stabilization=$_POST['stabilization'];
		$price=$_POST['price'];
		
		$formats = $_POST['format'];
		$N = count($formats);
 
		//echo("You selected $N formats(s): ");
		
		
		//print_r($_FILES);
		// Make sure the user actually

// selected and uploaded a file

if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {

//echo 'photo set';
// Temporary file name stored on the server

$tmpName = $_FILES['photo']['tmp_name'];


// Read the file

$fp = fopen($tmpName, 'r');

$data = fread($fp, filesize($tmpName));

$data = addslashes($data);

fclose($fp);
}
		
else{
	echo '<p>No picture uploaded.</p>';
}	
	
		if($name==null || $model_number==null || $manufacturer==null || $width==null || $height==null || $depth==null || $max_resolution==null || $sensor_size==null || $display_size==null || $iso_range==null || $image_stabilization==null || $price==null){
			echo "<p>There was an error processing the form</p>";
			
			//echo "'$name','$model_number','$manufacturer','$data','$width','$height','$depth','$weight','$color','$max_resolution','$sensor_size','$iso_range','$display_size','$display_size','$wireless_technology','$image_stabilization','$price'";
 
			//print("<a class='back' href="."./schedule.html".">Back to the Kids Camp Registration page.</a>");
			}
		else{
    		$sql="INSERT INTO camera (name, model_number, manufacturer, photo, width, height, depth, weight, color, max_resolution, sensor_size, iso_range, display_size, wireless_technology, image_stabilization, price) VALUES ('$name','$model_number','$manufacturer','$data','$width','$height','$depth','$weight','$color','$max_resolution','$sensor_size','$iso_range','$display_size','$wireless_technology','$image_stabilization','$price')";
				//echo $sql;
		
    			mysql_query($sql) or die (mysql_error());
				$product_id = mysql_insert_id();
				
			$sql="INSERT INTO manages (customer_id, product_id, quantity) VALUES ('{$_SESSION['login']}','$product_id','$quantity')";
				//echo $sql;
		
    			mysql_query($sql) or die (mysql_error());
			echo "<h4> Product Added! </h4><p> $name added to the catalogue of cameras </p>";
		}
		
		for($i=0; $i < $N; $i++)
		{
		  //echo($formats[$i] . " ");
		  	$sql="INSERT INTO file_format (product_id, type) VALUES ('$product_id','$formats[$i]')";
			mysql_query($sql) or die (mysql_error());
		}
  mysql_close($conn);
?>
	</div></div>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./login_files/ie10-viewport-bug-workaround.js"></script>
  	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    

</body></html>
