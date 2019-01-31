<HTML>
<HEAD> <TITLE>Adrian&Carlos calculadora</TITLE>
</HEAD>
<BODY>
<form name='mi_formulario' action='mispedidosfecha.php' method='post'>

 <h1> Consultar pedidos</h1><br>
 
 Fecha de inicio: <select name="inicio">
	<?php
	include('session.php');

	$sql = "SELECT DISTINCT orderDate FROM orders ORDER BY orderDate";
	$resultado = mysqli_query($conn,$sql);
	while($fila = mysqli_fetch_assoc($resultado)){
		echo "<option value='".$fila['orderDate']."'>".$fila['orderDate']."</option>";
	}
	?>
 </select><br>

 Fecha de fin: <select name="fin">
	<?php
	include('session.php');

	$sql = "SELECT DISTINCT orderDate FROM orders ORDER BY orderDate";
	$resultado = mysqli_query($conn,$sql);
	while($fila = mysqli_fetch_assoc($resultado)){
		echo "<option value='".$fila['orderDate']."'>".$fila['orderDate']."</option>";
	}
	?>
 </select><br>
 

<!--<input type='text' name='categoria' value=''><br>-->

<input type="submit" value="Consultar Stock Total">

</FORM>
</BODY>
</HTML>
