<?php
require('session.php');

$prueba = $_SESSION['login_user'];
/*SELECT para seleccionar el CODIGO del cliente*/
$selectCliente = "SELECT id FROM admin WHERE username = '$prueba';";
$cliente = mysqli_query($conn, $selectCliente);
$clienteCodigo = mysqli_fetch_array($cliente, MYSQLI_NUM); //Codigo del cliente
$numCliente = $clienteCodigo[0];

	/*consultamos si dicho cliente no ha realizado ningun pedido*/
$consultaPedido = "SELECT count(orderNumber) FROM orders WHERE customerNumber = $numCliente;";
$pedido = mysqli_query($conn, $consultaPedido);
$noPedido = mysqli_fetch_array($pedido, MYSQLI_NUM);

if ($noPedido[0] == '0'){
	echo "<p style='color:red;'><b>Dicho cliente no ha realizado ningun pedido<b></p>";
	mysqli_rollback($conn);
	die();
} else {
	
	/*Si el numero de cliente existe continuamos con la ejecucion*/
	echo "<center><table border='5px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 5px 5px 5px cyan;'>";
	echo "<tr><td style='border: 2px solid red'><b>Numero Pedido</b></td>";
	echo "<td style='border: 2px solid green'><b>Fecha Pedido</b></td>";
	echo "<td style='border: 2px solid blue'><b>Estado Pedido</b></td>";
	echo "<td style='border: 2px solid blue'><b>Numero Linea</b></td>";
	echo "<td style='border: 2px solid blue'><b>Nombre Producto</b></td>";
	echo "<td style='border: 2px solid blue'><b>Cantidad Pedida</b></td>";
	echo "<td style='border: 2px solid blue'><b>Precio Unidad</b></td></tr>";

	$resultado = "SELECT orders.ordernumber AS prueba, orderDate, status, orderLineNumber, productName, quantityOrdered, priceEach FROM orders, orderdetails, products WHERE products.productCode = orderdetails.productCode AND orders.ordernumber = orderdetails.ordernumber AND orders.customernumber = $numCliente ORDER BY orderLineNumber;";
	$result = mysqli_query($conn, $resultado);
	

	while($mostrar = mysqli_fetch_array($result)){
		echo "<tr><td style='border: 2px solid red'>".$mostrar['prueba']."</td>";
		echo "<td style='border: 2px solid green'>".$mostrar['orderDate']."</td>";
		echo "<td style='border: 2px solid blue'>".$mostrar['status']."</td>";
		echo "<td style='border: 2px solid blue'>".$mostrar['orderLineNumber']."</td>";
		echo "<td style='border: 2px solid blue'>".$mostrar['productName']."</td>";
		echo "<td style='border: 2px solid blue'>".$mostrar['quantityOrdered']."</td>";
		echo "<td style='border: 2px solid blue'>".$mostrar['priceEach']."</td></tr>";
	}
	echo "</table></center>";
}


?>