<?php
  $dbhost = 'localhost:3306';
  $dbuser = 'root';
  $dbpass = 'root';
  $dbname = 'FINALPROJECT';
  $conn = mysql_connect($dbhost, $dbuser, $dbpass);
  if(! $conn ){
	die('Could not connect: ' . mysql_error());
  }
  mysql_select_db( 'FINALPROJECT' );
  $query = "CREATE USER 'manager'@'localhost' IDENTIFIED BY 'managerpassword'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $query = "GRANT SELECT, UPDATE, DELETE, INSERT ON FINALPROJECT.* TO 'manager'@'localhost'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $query = "CREATE USER 'general'@'localhost'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $query = "GRANT SELECT ON FINALPROJECT.camera TO 'general'@'localhost'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $query = "GRANT SELECT ON FINALPROJECT.customer TO 'general'@'localhost'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $query = "GRANT SELECT ON FINALPROJECT.card_holder TO 'general'@'localhost'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  $query = "GRANT SELECT ON FINALPROJECT.credit_card TO 'general'@'localhost'";
  $result = mysql_query($query) or die('Query failed: ' . mysql_error());
  mysql_close($conn);
?>