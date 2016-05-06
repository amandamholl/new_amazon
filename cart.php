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
            <li class="active"><a href="./cart.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>&nbsp;Cart</a></li>
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
      	<div class="col-md-10">
 <?
    if(isset($_POST['submit'])){ 
          
        foreach($_POST['quantity'] as $key => $val) { 
            if($val==0) { 
                unset($_SESSION['products'][$key]); 
            }else{ 
                $_SESSION['products'][$key]['quantity']=$val; 
            } 
        } 
          
    } 
  
?> 
  
<h1>View cart</h1> 
<p><a href="./search.php">Go back to the products page.</a> </p>
<p>To remove an item set its quantity to 0. </p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> 

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
                            <td><input type="text" name="quantity[<?php echo $row['product_id'] ?>]" size="5" value="<?php echo $_SESSION['products'][$row['product_id']]['quantity'] ?>" /></td> 
                            <td>$ <?php echo $row['price'] ?></td> 
                            <td><?php 
							setlocale(LC_MONETARY, 'en_US');
							echo money_format('%(#10n', $_SESSION['products'][$row['product_id']]['quantity']*$row['price']); ?></td> 
                        </tr> 
                    <?php 
                          
                    } 
					}
					else{
						//echo "Your cart is empty";
						//session_destroy();
					}
        ?> 
                    <tr> 
                        <td colspan="4"><strong>Total Price:</strong> <?php 
						setlocale(LC_MONETARY, 'en_US');
						echo money_format('%(#10n', $totalprice); ?></td> 
                    </tr> 
          
    </table> 
    <br /> 
    <button class="btn btn-warning" type="submit" name="submit">Update Cart</button> 
    
</form> 
<br /> 

	</div>
    <div class="col-md-2">
    	<a href="./user_checkout.php" class="btn btn-success">Checkout as User</a><br/><br/>
    	<a href="./guest_checkout.php" class="btn btn-info">Checkout as Guest</a>
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