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
            <li class="active"><a href="./cart.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>&nbsp;Cart</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="jumbotron">
        <h1>Order</h1>
        <p>This serves as a receipt of your order.</p>
      </div>
      
      <div class="row">
      	<div class="col-md-12">
			<?php
			  //print_r($_POST);
			  $link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
			  mysql_select_db('FINALPROJECT') or die('Could not select database');
			  $customer_id = $_POST['customer_id'];
			  $card_number = $_POST['card_number'];
			  $product_id = $_POST['product_id'];
			  $first_name = $_POST['first_name'];
			  $middle_name = $_POST['middle_name'];
			  $last_name = $_POST['last_name'];
			  $company = $_POST['company'];
			  $security_code = $_POST['security_code'];
			  $exp_month = $_POST['exp_month'];
			  $exp_year = $_POST['exp_year'];
			  $total_price = $_POST['total_price'];
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
			  $query="SELECT * FROM card_holder WHERE card_number='".$card_number."'";
			  //echo $query;
			  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
			  if(mysql_num_rows($result) == 0){
				  $sql="INSERT INTO credit_card (card_number, first_name, middle_name, last_name, company, security_code, exp_month, exp_year) VALUES ('$card_number','$first_name','$middle_name','$last_name','$company','$security_code','$exp_month','$exp_year')";
				  mysql_query($sql) or die (mysql_error());
				  $sql="INSERT INTO card_holder (card_number, customer_id) VALUES ('$card_number','$customer_id')";
				  mysql_query($sql) or die (mysql_error());
			  }
			  $sql="INSERT INTO cust_order (card_number, order_date, price) VALUES ('$card_number','".date("Y-m-d H:i:s")."', '$total_price')";
			  mysql_query($sql) or die (mysql_error());
			  $order_id = mysql_insert_id();
			  //echo $order_id;
			  foreach($_SESSION['products'] as $id => $value) { 
				  $quantity = $value['quantity'];
				  $price = $value['price'];
				  mysql_query("BEGIN") or die (mysql_error());
				  //echo "pid".$id;
				 $t1 = mysql_query("INSERT INTO consists_of (order_id, product_id, quantity, price) VALUES ('$order_id','$id','$quantity','$price')")or die (mysql_error());
				 $query = "UPDATE manages SET quantity=quantity-'$quantity' WHERE product_id='$id'";
				 //echo $query;
				  $t2 = mysql_query($query) or die (mysql_error());
				  
				  if ($t2 and $t1) {
					  mysql_query("COMMIT") or die (mysql_error());
				  } else {        
					  mysql_query("ROLLBACK") or die (mysql_error());
				  }
			  }
			?>
            <h4> Your order is complete. </h4>
            <p> Below is a receipt of your order. </p>
            <table class="table table-hover"> 
          
                <tr> 
                    <th>Name</th> 
                    <th>Quantity</th> 
                    <th>Price</th> 
                    <th>Items Price</th> 
                </tr> 
                  
                <?php 
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
				  $query="SELECT product_id, name, price FROM camera WHERE product_id IN (".$str.")"; 
				  $totalprice=0; 
				  $result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
				  while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
					  $subtotal=$_SESSION['products'][$row['product_id']]['quantity']*$row['price']; 
					  $totalprice+=$subtotal; 
				  ?> 
					  <tr> 
						  <td><?php echo $row['name'] ?></td> 
						  <td><?php echo $_SESSION['products'][$row['product_id']]['quantity'] ?></td> 
						  <td>$ <?php echo $row['price'] ?></td> 
						  <td><?php 
						  setlocale(LC_MONETARY, 'en_US');
						  echo money_format('%(#10n', $_SESSION['products'][$row['product_id']]['quantity']*$row['price']); ?></td> 
					  </tr> 
				  <?php 
						
				  } 
				  }
				  
					session_destroy();
                ?> 
                    <tr> 
                        <td colspan="4"><strong>Total Price:</strong> <?php 
						setlocale(LC_MONETARY, 'en_US');
						echo money_format('%(#10n', $totalprice); ?></td> 
                    </tr> 
          
    		</table> 
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