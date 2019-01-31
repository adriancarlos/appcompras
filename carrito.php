<?php
   include('session.php');

   /*entra por aqui si la array de cookie en nuestro caso 'carrito' esta creada*/
   if(isset($_COOKIE['carrito'])){
		$array = unserialize($_COOKIE['carrito']);

		$producto = $_POST['producto'];
		$cantidad = (int) $_POST['cantidad'];
		
		/*actualiza la cantidad nueva pedida si dicho producto ya estaba en el array*/
		foreach(unserialize($_COOKIE['carrito']) as $key => $value){
			if ($key == $producto){
				// echo "agregado";
				$cantidad += $value;
			}
		}
		
		/*por aqui entra si no hay stock*/
		if(comprobarStock($producto, $conn) < $cantidad){
			echo "No hay suficiente stock del <b>$producto</b>. Quedan <b>". comprobarStock($producto, $conn) ."</b> unidades en stock<br>";
			echo "Puedes volver atras, se mantendra el pedido que has realizado anteriormente<br>";
			var_dump(unserialize($_COOKIE['carrito']));
			echo "<a href='hacerpedidomain.php'>VOLVER</a>";
		} else {
			/*si hay stock guarda el producto y la nueva cantidad por si volvemos a pedir*/
			$array[$producto] = (int) $cantidad;
			
			/*añadimos la array nueva a la misma cookie*/
			setcookie('carrito', serialize($array), time() + (86400 * 30), "/");
			
			echo ("A&ntilde;adido al carrito<br>");
			echo ("Su pedido hasta ahora es:<br>");
			foreach(unserialize($_COOKIE['carrito']) as $key => $value){
				echo ("producto: $key => cantidad: $value <br>");
				
			}
		
			header('Location: hacerpedidomain.php');
		}
	}else{
		/*por aqui entra si la array cookie no esta creada, crea la array asocitiva*/
		$producto = $_POST['producto'];
		$cantidad = (int) $_POST['cantidad'];
		
		$array =[
			$producto => (int) $cantidad,
		];
		
		/*comprobamos si hay stock para NO añadirlo a la cesta*/
		if(comprobarStock($producto, $conn) < $cantidad){
			
			echo "No hay suficiente stock del $producto. Quedan ". comprobarStock($producto, $conn) ." unidades en stock<br>";
			echo "<a href='hacerpedidomain.php'>VOLVER</a>";
			
		} else { //aqui si hay stock, y lo guarda en el array
			setcookie('carrito', serialize($array), time() + (86400 * 30), "/");
			
			echo ("A&ntilde;adido al carrito<br>");
			echo ("Su pedido hasta ahora es:<br>");
			foreach($_COOKIE['carrito'] as $key => $value){
				echo ("producto: $key => cantidad: $value <br>");
			
			}
			header('Location: hacerpedidomain.php');
		}
		// header('Location: hacerpedidomain.php');
	}
	
	/*funcion que comprueba si hay stock de cada articulo seleccionado*/
	function comprobarStock($producto, $conn){
		// $esta = false;
		
		$selectStock = "SELECT quantityInStock FROM products WHERE productName = '$producto';";
		$stock = mysqli_query($conn, $selectStock);
		$ok = mysqli_fetch_array($stock, MYSQLI_NUM);
		// if ($ok[0] > $cantidad){
			// $esta = true;
		// }
		return (int)$ok[0];
	}


?>