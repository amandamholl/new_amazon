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
            <li class="active"><a href="#">Search</a></li>
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
        <h1>Search</h1>
        <p>Find a camera.</p>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form role="search" action="search_results.php" method="post" >
            <div class="input-group input-group-lg">
              <span class="input-group-addon" id="sizing-addon1"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></span>
              <input type="text" class="form-control" placeholder="Search" aria-describedby="sizing-addon1" name="search">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
              </span>
            </div>
          </form>
          
        </div>
      </div>
      <?php
	  if(isset($_SESSION['login'])){
		  echo "<div class='page-header'>
			<h1>Recommended for You <small>Cameras</small></h1>
		</div>";	
	  }
	  else{
		  echo "<div class='page-header'>
			<h1>You are not logged in.</h1><p><a href='./login.php'>Login to see recommendations for you.</a></p>
		</div>";	
	  }
	  ?>
      
      <div class="row">
      <div class="col-md-10">
      <div class="row">
      	<?php 
			$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
  			//echo 'Connected successfully'; 
  			mysql_select_db('FINALPROJECT') or die('Could not select database'); 
  			//print_r($_SESSION);
			if(isset($_SESSION['login'])){	
			  $query = "SELECT * FROM card_holder NATURAL JOIN cust_order WHERE customer_id='".$_SESSION['login']."'";
			  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
			 	 //echo 'logged in';
				
				if(mysql_num_rows($result) != 0){
					 //echo 'orders';
					  while($row = mysql_fetch_array($result, MYSQL_ASSOC)){ 
						  $query2 = "SELECT * FROM consists_of WHERE order_id='".$row['order_id']."'";
						  $result2 = mysql_query($query2) or die('Query failed: ' . mysql_error());
						  if(mysql_num_rows($result2) != 0){  
							  while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){ 
							  //print_r($row2);
								$query3 = "SELECT * FROM camera WHERE product_id='".$row2['product_id']."'";
								$result3 = mysql_query($query3) or die('Query failed: ' . mysql_error());
								$row3 = mysql_fetch_array($result3, MYSQL_ASSOC);
								//print_r($row3);
								$query="SELECT * FROM camera WHERE (manufacturer = '{$row3['manufacturer']}' OR color = '{$row3['color']}') AND product_id != '{$row3['product_id']}'";
							$result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
							while($row = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
                            
							<div class="col-sm-6 col-md-4">
							  <div class="thumbnail">
								<?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'" style="height:190px"/>';?>
								<div class="caption">
								  <h3><?php echo "{$row['name']}" ?> </h3>
								  <?php 
								   echo '<form method="post" action="cart_update.php">';
								  echo "Model Number: {$row['model_number']} <br> ". "Manufacturer: {$row['manufacturer']} <br> ". "Width: {$row['width']} <br> "."Height: {$row['height']} <br> "."Depth: {$row['depth']} <br> "."Weight: {$row['weight']} <br> "."Color: {$row['color']} <br> "."Max Resolution: {$row['max_resolution']} <br> "."Sensor Size: {$row['sensor_size']} <br> ". "ISO Range: {$row['iso_range']} <br> "."Display Size: {$row['display_size']} <br> ";
									if( $row['wireless_technology'] == 1){ echo "Wireless Technology: Yes <br/>";} 
									else {echo "Wireless Technology: No <br/>";}
									echo "Image Stabilization: {$row['image_stabilization']} <br> ";
									$query2 = "SELECT * FROM file_format WHERE product_id='".$row['product_id']."'"; 
									$result2 = mysql_query($query2) or die('Query failed: ' . mysql_error()); 
									echo "File formats: ";
									while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
										echo "{$row2['type']} ";
									}
									echo "<br/>";
									setlocale(LC_MONETARY, 'en_US');
									echo money_format('Price: %(#10n', $row['price']) . "<br/>";
									$query3 = "SELECT * FROM review WHERE product_id='".$row['product_id']."'"; 
									$result3 = mysql_query($query3) or die('Query failed: ' . mysql_error());
									echo "Avg. Rating: ";
									$sum = 0.0;
									$count = 0;
									while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
										$sum += $row3['rating'];
										$count += 1;
									}
									$average = $sum / $count;
									if($average == 5){
										echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';						
									}
									elseif($average >= 4 && $average < 5){
										echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
									}
									elseif($average >= 3 && $average < 4){
										echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
									}
									elseif($average >= 2 && $average < 3){
										echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
									}
									elseif($average >= 1 && $average < 2){
										echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
									}
									else{
										echo '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
									}
									echo '<br/>';
									echo '<button class="btn btn-primary add_to_Cart">Add to Cart</button>';
									echo '<input type="hidden" name="product_id" value="'.$row['product_id'].'" />';
									echo '<input type="hidden" name="type" value="add" />';
									echo '</form>';
									
								?>
								  
								</div>
							  </div>
					</div>
        
		<?php			
					
				  }
			  }
		  }
		  
	  }
	  
	   
	}
	else{
		$query = 'SELECT * FROM camera'; 
  $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
  while($row = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'" style="height: 190px"/>';?>
            <div class="caption">
              <h3><?php echo "{$row['name']}" ?> </h3>
              <?php echo '<form method="post" action="cart_update.php">';
               echo "Model Number: {$row['model_number']} <br> ". "Manufacturer: {$row['manufacturer']} <br> ". "Width: {$row['width']} <br> "."Height: {$row['height']} <br> "."Depth: {$row['depth']} <br> "."Weight: {$row['weight']} <br> "."Color: {$row['color']} <br> "."Max Resolution: {$row['max_resolution']} <br> "."Sensor Size: {$row['sensor_size']} <br> ". "ISO Range: {$row['iso_range']} <br> "."Display Size: {$row['display_size']} <br> ";
              	if( $row['wireless_technology'] == 1){ echo "Wireless Technology: Yes <br/>";} 
				else {echo "Wireless Technology: No <br/>";}
				echo "Image Stabilization: {$row['image_stabilization']} <br> ";
				$query2 = "SELECT * FROM file_format WHERE product_id='".$row['product_id']."'"; 
  				$result2 = mysql_query($query2) or die('Query failed: ' . mysql_error()); 
				echo "File formats: ";
  				while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
					echo "{$row2['type']} ";
				}
				echo "<br/>";
				setlocale(LC_MONETARY, 'en_US');
				echo money_format('Price: %(#10n', $row['price'])."<br/>";
				$query3 = "SELECT * FROM review WHERE product_id='".$row['product_id']."'"; 
  				$result3 = mysql_query($query3) or die('Query failed: ' . mysql_error()); 
				echo "Avg. Rating: ";
				$sum = 0.0;
				$count = 0;
  				while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
					$sum += $row3['rating'];
					$count += 1;
				}
				$average = $sum / $count;
				if($average == 5){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';						
				}
				elseif($average >= 4 && $average < 5){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				elseif($average >= 3 && $average < 4){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				elseif($average >= 2 && $average < 3){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				elseif($average >= 1 && $average < 2){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				else{
					echo '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
				}
				echo "<br/>";
				echo '<button class="btn btn-primary add_to_Cart">Add to Cart</button>';
				echo '<input type="hidden" name="product_id" value="'.$row['product_id'].'" />';
            	echo '<input type="hidden" name="type" value="add" />';
				echo '</form>';
				?>
            </div>
          </div>
        </div>
        
        <?php }
	}
  }
else{
	//echo "HERE";
  $query = 'SELECT * FROM camera'; 
  $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
  while($row = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
        <div class="col-sm-6 col-md-4">
          <div class="thumbnail">
            <?php echo '<img src="data:image/jpeg;base64,'.base64_encode( $row['photo'] ).'" style="height: 190px"/>';?>
            <div class="caption">
              <h3><?php echo "{$row['name']}" ?> </h3>
              <?php echo '<form method="post" action="cart_update.php">';
               echo "Model Number: {$row['model_number']} <br> ". "Manufacturer: {$row['manufacturer']} <br> ". "Width: {$row['width']} <br> "."Height: {$row['height']} <br> "."Depth: {$row['depth']} <br> "."Weight: {$row['weight']} <br> "."Color: {$row['color']} <br> "."Max Resolution: {$row['max_resolution']} <br> "."Sensor Size: {$row['sensor_size']} <br> ". "ISO Range: {$row['iso_range']} <br> "."Display Size: {$row['display_size']} <br> ";
              	if( $row['wireless_technology'] == 1){ echo "Wireless Technology: Yes <br/>";} 
				else {echo "Wireless Technology: No <br/>";}
				echo "Image Stabilization: {$row['image_stabilization']} <br> ";
				$query2 = "SELECT * FROM file_format WHERE product_id='".$row['product_id']."'"; 
  				$result2 = mysql_query($query2) or die('Query failed: ' . mysql_error()); 
				echo "File formats: ";
  				while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
					echo "{$row2['type']} ";
				}
				echo "<br/>";
				setlocale(LC_MONETARY, 'en_US');
				echo money_format('Price: %(#10n', $row['price'])."<br/>";
				$query3 = "SELECT * FROM review WHERE product_id='".$row['product_id']."'"; 
  				$result3 = mysql_query($query3) or die('Query failed: ' . mysql_error()); 
				echo "Avg. Rating: ";
				$sum = 0.0;
				$count = 0;
  				while($row3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
					$sum += $row3['rating'];
					$count += 1;
				}
				$average = $sum / $count;
				if($average == 5){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';						
				}
				elseif($average >= 4 && $average < 5){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				elseif($average >= 3 && $average < 4){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				elseif($average >= 2 && $average < 3){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span><span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				elseif($average >= 1 && $average < 2){
					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
				}
				else{
					echo '<span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>';
				}
				echo "<br/>";
				echo '<button class="btn btn-primary add_to_Cart">Add to Cart</button>';
				echo '<input type="hidden" name="product_id" value="'.$row['product_id'].'" />';
            	echo '<input type="hidden" name="type" value="add" />';
				echo '</form>';
				?>
            </div>
          </div>
        </div>
        
        <?php }} ?>
        </div>
        </div>
      
      <div class="col-md-2">
      	<table class="table table-bordered">
      	<?php 
  			
		  if(isset($_SESSION['products'])){ 
				
			  $link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
		//echo 'Connected successfully'; 
		mysql_select_db('FINALPROJECT') or die('Could not select database'); 
		// Get the ids of all of the products in the cart and just pull these for display
					foreach($_SESSION['products'] as $id => $value) { 
                        $str.=$id.","; 
                    }
					$str=substr($str, 0, -1);
					//echo "<br/>STRING:".$str;
					if($str != null){
            		$query="SELECT * FROM camera WHERE product_id IN (".$str.")";
					}
		$result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
		?>
        <tr><th>Products</th></tr>
        <?php
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)){ ?> 
				  <tr><td><?php echo $row['name'] ?> x <strong><?php echo $_SESSION['products'][$row['product_id']]['quantity'] ?></strong></td></tr> 
			  <?php 
					
			  } 
		  ?>
		  <?php 
				
		  }else{ 
				
			  echo "<tr><td>Your Cart is empty. Please add some products.</td></tr>"; 
				
		  } 
		
	  ?>
      	</table>
      <?php if(isset($_SESSION['products'])){ ?>
			  <a class="btn btn-primary" href="./cart.php">Go to Cart</a> 
      <?php } ?>
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

<?php
  
  
  echo "Fetched data successfully\n";
  // Free resultset 
  mysql_free_result($result); 
  // Closing connection 
  mysql_close($link);

?>