<?php
      $dbhost = 'localhost:3306';
      $dbuser = 'root';
      $dbpass = 'root';
      $conn = mysql_connect($dbhost, $dbuser, $dbpass);
      if(! $conn ){
        die('Could not connect: ' . mysql_error());
      }
      echo 'Connected successfully<br />';
      $sql = 'CREATE DATABASE FINALPROJECT';
      $retval = mysql_query( $sql, $conn );
      if(! $retval ) {
        die('Could not create database: ' . mysql_error());
      }
      echo "Database FINALPROJECT created successfully\n";
      mysql_close($conn);
?>