<?php
session_start();

// Manejar la solicitud para devolver un libro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $servername = "localhost";
    $username = "root";
    $password = "Prueba_123";
    $dbname = "Catálogo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener información del libro seleccionado (utilizar consultas preparadas)
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descripcion = $conn->real_escape_string($_POST['descripcion']);
    $foto = $conn->real_escape_string($_POST['foto']);
    $usuario_actual = $_SESSION['nombreUsuario'];

    // Consulta preparada para eliminar el libro alquilado de la tabla libro_alugado
    $sqlDelete = $conn->prepare("DELETE FROM libro_alugado WHERE titulo = ?");
    $sqlDelete->bind_param("s", $titulo);

    if ($sqlDelete->execute()) {
        // Consulta preparada para insertar el libro devuelto en la tabla libro_devolto
        $sqlInsertDevuelto = $conn->prepare("INSERT INTO libro_devolto (titulo, cantidade, descripcion, foto, usuario, editorial) VALUES (?, 1, ?, ?, ?, 'Editorial Ejemplo')");
        $sqlInsertDevuelto->bind_param("ssss", $titulo, $descripcion, $foto, $usuario_actual);

        if ($sqlInsertDevuelto->execute()) {
            header("Location: carrito.php?mensaje=Libro devuelto exitosamente");
            exit();
        } else {
            $error_message = "Error al devolver el libro. Por favor, inténtalo de nuevo.";
        }
    } else {
        $error_message = "Error al devolver el libro. Por favor, inténtalo de nuevo.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #eae0d5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            background-color: #141414;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 1.5em;
        }

        header img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
            filter: brightness(0) invert(1);
        }

        main {
            flex: 1;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }

        .cart-item img {
            max-width: 50px;
            height: auto;
            margin-right: 10px;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-info h3 {
            margin: 0;
            font-size: 1.2em;
        }

        .cart-item-info p {
            margin: 5px 0;
            font-size: 1em;
            color: #666;
        }

        .cart-item-info p::before {
            content: '\20AC';
        }

        .devolver-btn {
            background-color: #f44336;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            background-color: #141414;
            color: #fff;
            padding: 1em;
            text-align: center;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .footer-links a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        a {
            font-size: 15px;
            padding: 15px;
            background-color: #141414;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 40px;
            width: 100%;
            margin-bottom: 10px;
            text-align: center;
            text-decoration: none;
            display: block; 
            box-sizing: border-box; 
            
        }

    </style>
</head>

<body>

    <header>
        <img src="/imagenes/BookPlanet.png" alt="Logo de Planeta del libro">
    </header>

    <main>
        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "Prueba_123";
        $dbname = "Catálogo";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Obtener el usuario actual (deberías tener la lógica para obtener el usuario actual)
        $usuario_actual = "usuario_prueba";

        // Consulta a la base de datos para obtener libros alquilados por el usuario
        $sql = "SELECT titulo, cantidade, descripcion, foto FROM libro_alugado WHERE usuario = '$usuario_actual'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cart-item">';
                echo '<img src="' . $row["foto"] . '" alt="' . $row["titulo"] . '">';
                echo '<div class="cart-item-info">';
                echo '<h3>' . $row["titulo"] . '</h3>';
                echo '<p>Cantidad: ' . $row["cantidade"] . '</p>';
                echo '<p>Descripción: ' . $row["descripcion"] . '</p>';
                echo '</div>';
                echo '<form method="post" action=""><input type="hidden" name="titulo" value="' . $row["titulo"] . '"><input type="hidden" name="descripcion" value="' . $row["descripcion"] . '"><input type="hidden" name="foto" value="' . $row["foto"] . '"><button type="submit" name="devolver" class="devolver-btn">Devolver</button></form>';
                echo '</div>';
            }
        } else {
            echo "No tienes libros en el carrito.";
        }

        $conn->close();
        ?>

        <a href="catalogo.php">Volver</a>

    </main>

    <footer>
        <div class="footer-links">
            <a href="#">Políticas</a>
            <a href="#">Aviso Legal</a>
            <a href="#">Términos y Condiciones</a>
        </div>
    </footer>

</body>

</html>
