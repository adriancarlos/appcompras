<?php
	require ('session.php');

   echo "<center><table border='5px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 5px 5px 5px cyan;'>";
	echo "<tr><td style='border: 2px solid red'><b>Nombre Producto</b></td>";
	echo "<td style='border: 2px solid blue'><b>Cantidad</b></td></tr>";

	$resultado = "SELECT productName, quantityInStock FROM products ORDER BY quantityInStock DESC";
	$result = mysqli_query($conn, $resultado);
	

	while($mostrar = mysqli_fetch_array($result)){
		echo "<tr><td style='border: 2px solid red'>".$mostrar['productName']."</td>";
		echo "<td style='border: 2px solid blue'>".$mostrar['quantityInStock']."</td></tr>";
	}
	echo "</table></center>";
?>