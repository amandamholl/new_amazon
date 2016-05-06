<?php
  $dbhost = 'localhost:3306';
  $dbuser = 'root';
  $dbpass = 'root';
  $dbname = 'FINALPROJECT';
  $conn = mysql_connect($dbhost, $dbuser, $dbpass);
  if(! $conn ){
	die('Could not connect: ' . mysql_error());
  }
  echo 'Connected successfully<br />';
  $sql = "CREATE TABLE cust_order( ".
       "order_id INT NOT NULL AUTO_INCREMENT, ".
       "card_number VARCHAR(25) NOT NULL, ".
       "order_date DATE NOT NULL, ".
	   "price FLOAT NOT NULL, ".
	   "PRIMARY KEY ( order_id )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Order created successfully\n";
  $sql = "CREATE TABLE file_format( ".
       "product_id INT NOT NULL, ".
       "type VARCHAR(25) NOT NULL ); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "File format created successfully\n";
  $sql = "CREATE TABLE card_holder( ".
       "card_number INT NOT NULL, ".
       "customer_id INT NOT NULL, ".
       "PRIMARY KEY ( card_number )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Card Holder created successfully\n";
  $sql = "CREATE TABLE manages( ".
       "customer_id INT NOT NULL, ".
       "product_id INT NOT NULL, ".
	   "quantity INT NOT NULL, ".
       "PRIMARY KEY ( customer_id, product_id )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Manages created successfully\n";
  $sql = "CREATE TABLE camera( ".
  		"product_id INT NOT NULL AUTO_INCREMENT, ".
       "name VARCHAR(100) NOT NULL, ".
       "model_number INT NOT NULL, ".
	   "manufacturer VARCHAR(100) NOT NULL, ".
	   "photo BLOB NOT NULL, ".
	   "width DECIMAL(20, 2) NOT NULL, ".
	   "height DECIMAL(20, 2) NOT NULL, ".
	   "depth DECIMAL(20, 2) NOT NULL, ".
	   "weight DECIMAL(20, 4) NOT NULL, ".
	   "color VARCHAR(100) NOT NULL, ".
	   "max_resolution INT NOT NULL, ".
	   "sensor_size INT NOT NULL, ".
	   "iso_range VARCHAR(100) NOT NULL, ".
	   "display_size VARCHAR(100) NOT NULL, ".
	   "wireless_technology BIT NOT NULL, ".
	   "image_stabilization VARCHAR(100) NOT NULL, ".
	   "price DECIMAL(20, 2) NOT NULL, ".
	   "PRIMARY KEY ( product_id )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Camera created successfully\n";
  $sql = "CREATE TABLE review( ".
  		"customer_id INT NOT NULL, ".
       "product_id INT NOT NULL, ".
	   "feedback LONGTEXT NOT NULL, ". 
	   "rating INT NOT NULL, ".
       "PRIMARY KEY ( customer_id, product_id )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Review created successfully\n";
  $sql = "CREATE TABLE consists_of( ".
  		"order_id INT NOT NULL, ".
       "product_id INT NOT NULL, ".
	   "quantity INT NOT NULL, ".
	   "price DECIMAL(20,2) NOT NULL, ".
	   "PRIMARY KEY ( order_id, product_id )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Consists of created successfully\n";
  $sql = "CREATE TABLE customer( ".
  		"customer_id INT NOT NULL AUTO_INCREMENT, ".
		"email VARCHAR(100), ".
       "first_name VARCHAR(100) NOT NULL, ".
	   "middle_name VARCHAR(100) NOT NULL, ".
	   "last_name VARCHAR(100) NOT NULL, ".
	   "password VARCHAR(100), ".
	   "permission_level VARCHAR(100), ".
	   "company VARCHAR(100), ".
	   "shipping_street_number INT, ".
	   "shipping_street_name VARCHAR(100), ".
	   "shipping_apt_num INT, ".
	   "shipping_city VARCHAR(100), ".
	   "shipping_state VARCHAR(100), ".
	   "shipping_zip INT, ".
	   "billing_street_number INT, ".
	   "billing_street_name VARCHAR(100), ".
	   "billing_apt_num INT, ".
	   "billing_city VARCHAR(100), ".
	   "billing_state VARCHAR(100), ".
	   "billing_zip INT, ".
	   "phone_number VARCHAR(100), ".
	   "PRIMARY KEY ( customer_id )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Customer created successfully\n";
  $sql = "CREATE TABLE credit_card( ".
  		"card_number INT NOT NULL, ".
       "first_name VARCHAR(100) NOT NULL, ".
	   "middle_name VARCHAR(100) NOT NULL, ".
	   "last_name VARCHAR(100) NOT NULL, ".
	   "company VARCHAR(100) NOT NULL, ".
	   "security_code INT NOT NULL, ".
	   "exp_month VARCHAR(100) NOT NULL, ".
	   "exp_year INT NOT NULL, ".
	   "PRIMARY KEY ( card_number )); ";
  mysql_select_db( 'FINALPROJECT' );
  $retval = mysql_query( $sql, $conn );
  if(! $retval ) {
	die('Could not create table: ' . mysql_error());
  }
  echo "Credit_card created successfully\n";
  mysql_close($conn);
?>