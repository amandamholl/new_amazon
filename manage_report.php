<?php 
  session_start();
  //
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
					  echo '<li class="active"><a href="./manage.php">Manage</a></li>';
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
        <h1>Manage</h1>
        <p>Generate a monthly sales summary.</p>
      </div>
      
        <div class="row">
      	<div class="col-md-12">
        	
            <?php
			//print_r($_POST);
			$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
			mysql_select_db('FINALPROJECT') or die('Could not select database');
			//$var = $_SESSION['login'];
			$month = $_POST['month'];
			?>
            <h1>Summary for <?php 
			$monthName = date("F", mktime(0, 0, 0, $month, 10));
			echo $monthName;  ?></h1>
            <?php
			$totalprice=0;
			$query="SELECT * FROM cust_order WHERE MONTH(order_date)='".$month."'";
			$result = mysql_query($query) or die('Query failed: ' . mysql_error());
			//echo mysql_num_rows($result);
			if(mysql_num_rows($result) != 0){
				while($row = mysql_fetch_array($result, MYSQL_ASSOC)){ ?>
                <table class="table table-hover"> 
          
                <tr> 
                    <th>Order ID</th> 
                    <th>Product</th> 
                    <th>Quantity</th> 
                    <th>Item Price</th> 
                    <th>Profit</th> 
                </tr> 
                  
                <?php 
                  $link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
                    //echo 'Connected successfully'; 
                    mysql_select_db('FINALPROJECT') or die('Could not select database'); 
                    
                            $query2="SELECT * FROM consists_of WHERE order_id='".$row['order_id']."'"; 
                       
                            $result2 = mysql_query($query2) or die('Query failed: ' . mysql_error()); 
                            while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)){
								$subtotal=$row2['quantity']*$row2['price']; 
                        		$totalprice+=$subtotal;
                            ?> 
                                <tr> 
                                    <td><?php echo $row['order_id']; ?></td> 
                                    <td><?php 
									$query3="SELECT * FROM camera WHERE product_id='".$row2['product_id']."'"; 
                            		$result3 = mysql_query($query3) or die('Query failed: ' . mysql_error()); 
                            		$row3 = mysql_fetch_array($result3, MYSQL_ASSOC);
									echo $row3['name']; ?></td> 
                                    <td><?php echo $row2['quantity']; ?></td> 
                                    <td>$ <?php echo $row2['price']; ?></td> 
                                    <td><?php 
									setlocale(LC_MONETARY, 'en_US');
									echo money_format('%(#10n', $row2['quantity']*$row2['price']);
									 ?></td> 
                                </tr> 
                            <?php 
                                  
                            } }
							
                ?> 
                 <tr> 
                        <td colspan="5"><strong>Total Profit:</strong> <?php 
						setlocale(LC_MONETARY, 'en_US');
						echo money_format('%(#10n', $totalprice); ?></td> 
                    </tr>  
            </table> 
            <?php
			}else{
				echo '<p>No orders during this month</p>';
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