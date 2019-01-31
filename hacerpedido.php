<?php
   include('session.php');

/*quito el autocomit*/
// mysqli_autocommit($conn, false);

/*VARIABLES*/
$array = array();
$clienteSesion = $_SESSION['login_user'];
$contador = 1;
$pedidoCorrecto = false;

/*SELECT para seleccionar el CODIGO del cliente*/
//$usuario = $_SESSION['login_user'];
$selectCliente = "SELECT id FROM admin WHERE username = '$clienteSesion';";
$manolo = mysqli_query($conn, $selectCliente);
$clienteCodigo = mysqli_fetch_array($manolo, MYSQLI_NUM); //Codigo del cliente
$cliente = $clienteCodigo[0];

/*for que nos guarda en una array asociativa el producto como el nombre asociado y la cantidad del producto a pedir*/
	
	$array = unserialize($_COOKIE['carrito']);


/*Comprueba si hay stock de los productos*/
	foreach($array as $key => $value){
		if($value < 1){
			unset($array[$key]);
		}else if(!comprobarStock($key, $value, $conn)){
			echo "No hay suficiente Stock del producto: $key<br>";
			unset($array[$key]);
		} else {
			actualizarStock($conn, $key, $value);
			$pedidoCorrecto = true;
		}
	}

	/*llamamos a la funcion crear pedido*/
	crearPedido($cliente, $conn);
	
	/*guardamos en la tabla detallepedido*/
	foreach($array as $key => $value){
		crearDetallePedido($cliente, $numeroPedido, $key, $value, $contador, $conn);
		$contador++;
	}

	if($pedidoCorrecto){
		echo "<p style='color: red;'><b>El pedido se ha realizado correctamente<b></p>";
		echo "Su numero de pedido es: ".$GLOBALS['numeroPedido'];
	} else {
		echo "<p style='color: red;'><b>No se ha podido realizar el pedido por falta de stock<b></p>";
	}
	
	setcookie('carrito', '', time() + (86400 * 30), "/");
	
/*Funcion que comprueba si hay Stock*/
function comprobarStock($producto, $cantidad, $conn){
	$esta = false;
	
	$selectStock = "SELECT quantityInStock FROM products WHERE productName = '$producto';";
	$stock = mysqli_query($conn, $selectStock);
	$ok = mysqli_fetch_array($stock, MYSQLI_NUM);
	if ($ok[0] > $cantidad){
		$esta = true;
	}
	return $esta;
}

/*Funcion que actualiza el Stock*/
function actualizarStock($conn, $producto, $cantidad){
	$stockAnterior = "SELECT quantityInStock FROM products WHERE productName = '$producto';";
	$anterior = mysqli_query($conn, $stockAnterior);
	$ant = mysqli_fetch_array($anterior, MYSQLI_NUM);
	$result = (int)$ant[0] - $cantidad;

	$updateStock = "UPDATE products SET quantityInStock = $result WHERE productName = '$producto';";
	
	if (mysqli_query($conn, $updateStock)) {
		echo "Stock del producto: $producto actualizado correctamente<br>";
	} else {
		echo "Error al actualizar el stock " . mysqli_error($conn);
	}
}

/*Funcion que nos crea un pedido en la tabla Order*/
function crearPedido($cliente, $conn){
	$selectContador = "SELECT MAX(orderNumber) FROM orders;";
	$contador = mysqli_query($conn, $selectContador);
	$cont = mysqli_fetch_array($contador, MYSQLI_NUM);
	$cont[0] += 1;
	
	$sentenciaPedido = mysqli_prepare($conn, "INSERT INTO orders (orderNumber, orderDate, requiredDate, status, customerNumber) VALUES (?,curdate(),curdate(),'In Process',?);");
	mysqli_stmt_bind_param($sentenciaPedido, 'ii', $cont[0], $cliente);
	mysqli_stmt_execute($sentenciaPedido);
	
	if(mysqli_stmt_execute($sentenciaPedido)){
		mysqli_rollback($conn);
		die('No se ha podido insertar');
	}
	
	/*VARIABLE GLOBAL*/
	global $numeroPedido;
	$numeroPedido = $cont[0];
}

/*funcion que crea en la tabla orderdetails el pedido*/
function crearDetallePedido($numeroPedido, $cliente, $producto, $cantidad, $contador, $conn){
	$selectProducto = "SELECT productCode, buyPrice FROM products WHERE productName = '$producto';";
	$detalles = mysqli_query($conn, $selectProducto);
	$details = mysqli_fetch_array($detalles, MYSQLI_NUM);

	/*LLAMAMOS A LA VARIABLE GLOBAL*/
	$sentenciaDetalle = mysqli_prepare($conn, "INSERT INTO orderdetails (orderNumber, productCode, quantityOrdered, priceEach, orderLineNumber) VALUES (?,?,?,?,?);");
	mysqli_stmt_bind_param($sentenciaDetalle, 'isidi', $GLOBALS['numeroPedido'], $details[0], $cantidad, $details[1], $contador);
	mysqli_stmt_execute($sentenciaDetalle);
	
	if(mysqli_stmt_execute($sentenciaDetalle)){
		mysqli_rollback($conn);
		die('No se ha podido insertar');
	}
	
}


?>