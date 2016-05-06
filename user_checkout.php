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
        <h1>User Checkout</h1>
        <p>Purchase the items in your cart.</p>
      </div>
      <?php
	  //print_r($_SESSION);
	  	$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
		mysql_select_db('FINALPROJECT') or die('Could not select database');
		$var = $_SESSION['login'];
		//print_r($var['email']);
		//print_r($var['password']);
	  	$query="SELECT * FROM customer WHERE customer_id='".$var."'";
		//echo $query;
		$result = mysql_query($query) or die('Query failed: ' . mysql_error());
		//echo mysql_num_rows($result);
		if(mysql_num_rows($result) != 0){
			$row = mysql_fetch_array($result, MYSQL_ASSOC);  			
			//echo 'here';
		}else{ 
			echo '<p> You are not logged in. Please <a href="./login.html"> login </a> before proceeding</p>';
			//print_r( $_SESSION['login'][$row['customer_id']]);  
		}
	  ?>
      <div class="row">
      	<div class="col-md-8">
        	<h1>Billing Information </h1>
            <form class="form" action="order.php" method="post">
            <input type="hidden" name="customer_id" value="<?php echo $row['customer_id'] ?>"></input>
            <label for="billingStreetNumber" >Street Number</label>
            <input type="number" id="billingStreetNumber" class="form-control" placeholder="Street Number" required="" name="billing_street_number" autofocus value="<?php echo $row['billing_street_number']; ?>">
            <label for="billingStreetName" >Street Name</label>
            <input type="text" id="billingStreetName" class="form-control" placeholder="Street Name" required="" name="billing_street_name" autofocus value="<?php echo $row['billing_street_name']; ?>">
            <label for="billingAptNumber" >Street Number</label>
            <input type="number" id="billingAptNumber" class="form-control" placeholder="Apartment Number"  name="billing_apt_num" autofocus value="<?php echo $row['billing_apt_number']; ?>">
            <label for="billingCity" >City</label>
            <input type="text" id="billingCity" class="form-control" placeholder="City" required="" name="billing_city" autofocus value="<?php echo $row['billing_city']; ?>">
            <label for="billingState" >State</label>
            <input type="text" id="billingStreetNumber" class="form-control" placeholder="State" required="" name="billing_state" autofocus value="<?php echo $row['billing_state']; ?>">
            <label for="billingZip" >Zip Code</label>
            <input type="number" id="billingZip" class="form-control" placeholder="Zip" required="" name="billing_zip" autofocus value="<?php echo $row['billing_zip']; ?>">

            <hr/>
            <h1>Shipping Information</h1>
            <label for="shippingStreetNumber" >Street Number</label>
            <input type="number" id="shippingStreetNumber" class="form-control" placeholder="Street Number" required="" name="shipping_street_number" autofocus value="<?php echo $row['shipping_street_number']; ?>">
            <label for="shippingStreetName" >Street Name</label>
            <input type="text" id="shippingStreetName" class="form-control" placeholder="Street Name" required="" name="shipping_street_name" autofocus value="<?php echo $row['shipping_street_name']; ?>">
            <label for="shippingAptNumber" >Street Number</label>
            <input type="number" id="shippingAptNumber" class="form-control" placeholder="Apartment Number"  name="shipping_apt_num" autofocus value="<?php echo $row['shipping_apt_number']; ?>">
            <label for="shippingCity" >City</label>
            <input type="text" id="shippingCity" class="form-control" placeholder="City" required="" name="shipping_city" autofocus value="<?php echo $row['shipping_city']; ?>">
            <label for="shippingState" >State</label>
            <input type="text" id="shippingStreetNumber" class="form-control" placeholder="State" required="" name="shipping_state" autofocus value="<?php echo $row['shipping_state']; ?>">
            <label for="shippingZip" >Zip Code</label>
            <input type="number" id="shippingZip" class="form-control" placeholder="Zip" required="" name="shipping_zip" autofocus value="<?php echo $row['shipping_zip']; ?>">
            <hr/>
            <h1>Credit Card</h1>
   			<p> Enter your credit card information. Change information if you want to. </p>
            <label for="cardNumber" >Card Number (no spaces)</label>
            <input type="number" id="cardNumber" class="form-control" placeholder="Card Number" required="" name="card_number" autofocus>
            <label for="firstName" >First Name</label>
            <input type="text" id="firstName" class="form-control" placeholder="First Name" required="" name="first_name" autofocus value="<?php echo $row['first_name']; ?>">
            <label for="middleName" >Middle Name</label>
            <input type="text" id="middleName" class="form-control" placeholder="Middle Name"  name="middle_name" autofocus value="<?php echo $row['middle_name']; ?>">
            <label for="lastName" >Last Name</label>
            <input type="text" id="lastName" class="form-control" placeholder="Last Name" required="" name="last_name" autofocus value="<?php echo $row['last_name']; ?>">
            <label for="company" >Company</label>
            <input type="text" id="company" class="form-control" placeholder="Company" required="" name="company" autofocus>
            <label for="securityCode" >Security Code</label>
            <input type="number" id="securityCode" class="form-control" placeholder="Security Code" required="" name="security_code" autofocus>
            <label for="expMonth" >Expiration Month</label>
            <input type="text" id="expMonth" class="form-control" placeholder="Expiration Month" required="" name="exp_month" autofocus>
            <label for="expYear" >Expiration Year</label>
            <input type="number" id="expYear" class="form-control" placeholder="Expiration Year" required="" name="exp_year" autofocus>
        </div>
      	<div class="col-md-4">
  
<h2>Cart</h2> 
<p><a href="./cart.php">Edit your cart.</a> </p>

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
			//print_r ($_SESSION['products']);
					// Get the ids of all of the products in the cart and just pull these for display
					foreach($_SESSION['products'] as $id => $value) { 
                        $str.=$id.","; 
                    }
					$str=substr($str, 0, -1);
					//echo "<br/>STRING:".$str;
					if($str != null){
            		$query="SELECT * FROM camera WHERE product_id IN (".$str.")"; 
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
					else{
						echo "Your cart is empty";
						//session_destroy();
					}
        ?> 
                    <tr> 
                        <td colspan="4"><strong>Total Price:</strong> $
                        <input type="text" name="total_price" value="<?php 
						echo $totalprice; ?>" size="15" readonly></input></td> 
                    </tr> 
          
    </table> 
    <input type="submit" class="btn btn-success" value="Checkout"></input>
    </form>
<br /> 

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