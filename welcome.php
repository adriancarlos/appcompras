<?php
   include('session.php');
?>
<html">
   
   <head>
      <title>Welcome </title>
   </head>
   
   <body>
      <h1>Bienvenido <?php echo $login_session; ?></h1> 
	  
	  
	  <nav class="dropdownmenu">
  <ul>
    <li><a href="hacerpedidomain.php">Hacer Pedido</a></li>
    <li>Mis pedidos
      <ul id="submenu">
        <li><a href="mispedidos.php">Consultar Pedidos</a></li>
        <li><a href="mispedidosfechamain.php">Consultar por fechas</a></li>      </ul>
    </li>
    <li><a href="listado.php">Listado Productos</a></li>
  
  </ul>
</nav>
	  
	  
	  
      <h2><a href = "logout.php">Cerrar Sesion</a></h2>
   </body>
   
</html>