<?php

	setcookie('carrito', '', time() + (86400 * 30), "/");
	
	header('Location: hacerpedidomain.php');

?>