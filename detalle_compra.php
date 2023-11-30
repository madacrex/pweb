<?php

session_start();

if (isset($_SESSION['email'])) {
    $userLoggedIn = true;
} else {
    $userLoggedIn = false;
}

if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("location: pagina.php");
    exit();
}


include 'con_db.php';

// Verificar si se proporciona un ID de compra para eliminar
if (isset($_GET['eliminar_id'])) {
    $idCompraEliminar = $_GET['eliminar_id'];

    // Realizar la eliminación del registro en la base de datos
    $sqlEliminar = "DELETE FROM compras WHERE id_compra = '$idCompraEliminar'";
    $conn->query($sqlEliminar);
}

// Consulta SQL para obtener todos los detalles de las compras
$sqlDetalleCompras = "SELECT id_compra, fecha, hora, nombre_producto, precio, SUM(cantidad) AS cantidad_total FROM compras GROUP BY id_compra, nombre_producto";
$resultDetalleCompras = $conn->query($sqlDetalleCompras);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledetail.css">
    <link rel="stylesheet" href="stylesmain.css">
    <title>Detalles de Compras</title>
</head>
<body>
    
<header>
        <div class="logo">
            <img src="tu_logo.png" alt="Logo de la Página">
        </div>
        <nav>
        <ul>
                <li><a href="pagina.php">Home</a></li>
                <li><a href="quienes_somos.php">Quienes Somos</a></li>
                <li><a href="alta_productos.php">Alta de Productos</a></li>
                <li><a href="mostrar_tabla.php">Tabla de Productos</a></li>
                <li><a href="detalle_compra.php">Detalle de Compra</a></li>
        </ul>
        </nav>
        <?php
                // Mostrar botones según el estado de inicio de sesión
                if ($userLoggedIn) {
                    echo '<ul><form method="post" action=""><input type="submit" name="cerrar_sesion" class="cerrar_sesion" value="Cerrar Sesión"></form></ul>';
                } else {
                    echo '<li><a href="signup.php" class="signup-link">Sign Up</a></li>';
                    echo '<li><a href="login.php" class="login-link">Login</a></li>';
                }
                ?>
</header>   
    <main>
        <h2>Detalles de Compras</h2>
        <table>
            <tr>
                <th>ID de Compra</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Nombre del Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            <?php
            while ($row = $resultDetalleCompras->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id_compra'] . "</td>";
                echo "<td>" . $row['fecha'] . "</td>";
                echo "<td>" . $row['hora'] . "</td>";
                echo "<td>" . $row['nombre_producto'] . "</td>";
                echo "<td>" . $row['precio'] . "</td>";
                echo "<td>" . $row['cantidad_total'] . "</td>";
                echo "<td><a href='detalle_compra.php?eliminar_id=" . $row['id_compra'] . "'>Eliminar</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </main>

    <footer>
        <div class="social-media">
            <a href="http://www.facebook.com" target="_blank"><img src="logof.png" alt="Facebook"></a>
            <a href="http://www.twitter.com" target="_blank"><img src="x.png" alt="Twitter" class="twitter"></a>
            <a href="http://www.instagram.com" target="_blank"><img src="instagram.png" alt="Instagram" class="instagram"></a>
        </div>
    </footer>

</body>
</html>
