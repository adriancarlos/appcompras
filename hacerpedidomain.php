<?php
	if (!empty($_COOKIE['carrito'])){
		foreach(unserialize($_COOKIE['carrito']) as $key => $value){
			echo ("producto: $key cantidad: $value <br>");	
		}
	}
?>
<HTML>
<HEAD> <TITLE>Adrian&Carlos calculadora</TITLE>
</HEAD>
<BODY>
<form name='mi_formulario' action='carrito.php' method='post'>

 <h1> Realizar Pedido</h1><br>
 
Seleccione el Producto: <select name="producto">
	<?php
	include('session.php');

	$sql = "SELECT productName FROM products";
	$resultado = mysqli_query($conn,$sql);
	while($fila = mysqli_fetch_assoc($resultado)){
		echo "<option value='".$fila['productName']."'>".$fila['productName']."</option>";
	}
	?>
</select> Cantidad: <input type="number" name="cantidad"> <input type="submit" value="A&Ntilde;ADIR AL CARRITO"><br>

<a href="limpiarcarrito.php">Limpiar Carrito</a><br>
<a href="hacerpedido.php">Realizar Pedido</a>




</FORM>
</BODY>
</HTML>