<?php
   define('DB_SERVER', '10.129.42.103');
   define('DB_USERNAME', 'root');
   define('DB_PASSWORD', 'rootroot');
   define('DB_DATABASE', 'classicmodels');
   $conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   
   if (!$conn) {
		die("Error conexión: " . mysqli_connect_error());
				}
  
?>
