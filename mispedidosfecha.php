<?php
require('session.php');

$prueba = $_SESSION['login_user'];
/*SELECT para seleccionar el CODIGO del cliente*/
$selectCliente = "SELECT id FROM admin WHERE username = '$prueba';";
$cliente = mysqli_query($conn, $selectCliente);
$clienteCodigo = mysqli_fetch_array($cliente, MYSQLI_NUM); //Codigo del cliente
$numCliente = $clienteCodigo[0];

$inicio = $_POST['inicio'];
$fin = $_POST['fin'];

if($inicio > $fin){
	echo "La fecha de inicio tiene que ser menor a la fecha de fin.";
} else {
	
	echo "<center><table border='5px' style='font-family: Comic Sans MS; text-align: center; box-shadow: 5px 5px 5px cyan;'>";
	echo "<tr><td style='border: 2px solid red'><b>Nombre Producto</b></td>";
	echo "<td style='border: 2px solid green'><b>Cantidad</b></td>";
	echo "<td style='border: 2px solid blue'><b>Fecha</b></td></tr>";

	$resultado = "SELECT productName, SUM(quantityOrdered) AS total, orderDate FROM orderdetails, orders, products WHERE products.productCode = orderdetails.productCode AND orders.orderNumber = orderdetails.orderNumber AND orders.orderDate >= '$inicio'  AND orders.orderDate <= '$fin' AND orders.customerNumber = '$numCliente' GROUP BY productName;";
	$result = mysqli_query($conn, $resultado);
	

	while($mostrar = mysqli_fetch_array($result)){
		echo "<tr><td style='border: 2px solid red'>".$mostrar['productName']."</td>";
		echo "<td style='border: 2px solid green'>".$mostrar['total']."</td>";
		echo "<td style='border: 2px solid blue'>".$mostrar['orderDate']."</td></tr>";
	}
	echo "</table></center>";
	
}







?>