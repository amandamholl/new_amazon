<?php
session_start(); //start session?>
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
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="./cart.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span>&nbsp;Cart</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <!-- Main component for a primary marketing message or call to action -->
      <div class="row">
      <div class="col-md-4">
<?php 
$link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
echo 'Connected successfully'; 
mysql_select_db('FINALPROJECT') or die('Could not select database'); 

//empty cart by distroying current session
if(isset($_GET["emptycart"]) && $_GET["emptycart"]==1)
{
    //$return_url = base64_decode($_GET["return_url"]); //return url
    session_destroy();
}

//add item in shopping cart
if(isset($_POST["type"]) && $_POST["type"]=='add')
{
    $product_id   = $_POST["product_id"]; //product id

    //Get details of item from db using product id
    $query="SELECT * FROM camera WHERE product_id = '$product_id'";
	$result = mysql_query($query) or die('Query failed: ' . mysql_error()); 
  	$row = mysql_fetch_array($result, MYSQL_ASSOC);
    
    if ($row) { //we have the product info 
   		if(isset($_SESSION['products'][$product_id])){  
            $_SESSION['products'][$product_id]['quantity']++; 
			//echo $row['name'].' x '. $_SESSION['products'][$row['product_id']]['quantity'];
            //print_r( $_SESSION['products']);   
        }else{ 
                //echo 'here';  
                $_SESSION['products'][$row['product_id']]=array( 
                        "quantity" => 1, 
                        "price" => $row['price'] 
                    );
					//print_r( $_SESSION['products'][$row['product_id']]);  
        }
        
    }
    
    //redirect back to original page
    echo '<h4>'.$row['name'].' added to cart!</h4><p><a class="btn btn-primary" href="./search.php"> Continue Shopping </a></p><p><a class="btn btn-success" href="./cart.php"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Checkout </a></p>';
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