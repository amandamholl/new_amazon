<?php
  $link = mysql_connect('localhost:3306', 'root', 'root') or die('Could not connect: ' . mysql_error()); 
		//echo 'Connected successfully'; 
  mysql_select_db('FINALPROJECT') or die('Could not select database');
  $sql = "GRANT ALL PRIVILEGES ON *.* TO 'manager'@'localhost'WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0;";
  $result = mysql_query($sql) or die (mysql_error());	
  if (!$result)
  {
	  $error = 'Error in granting privileges to new user.';
	  echo $error;
	  error_log($error);
	  exit();
  }
  else{
	 echo 'Granted privilege';
  }
  $sql = "GRANT SELECT, INSERT, CREATE, DROP, RELOAD, SHUTDOWN, PROCESS, FILE, REFERENCES, INDEX, ALTER, SHOW DATABASES, SUPER, CREATE TEMPORARY TABLES, LOCK TABLES, REPLICATION SLAVE, REPLICATION CLIENT, CREATE VIEW, EVENT, TRIGGER, SHOW VIEW, CREATE ROUTINE, ALTER ROUTINE, CREATE USER, EXECUTE ON *.* TO '$user'@'localhost' WITH GRANT OPTION MAX_QUERIES_PER_HOUR 0 MAX_CONNECTIONS_PER_HOUR 0 MAX_UPDATES_PER_HOUR 0 MAX_USER_CONNECTIONS 0";
  $result = mysql_query($sql) or die (mysql_error());	
  if (!$result)
  {
	  $error = 'Error in granting privileges to new user.';
	  echo $error;
	  error_log($error);
	  exit();
  }
  else{
	 echo 'Granted privilege to general user';
  }
			
?>