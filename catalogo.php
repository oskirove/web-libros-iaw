<?php
session_start();

// Manejar la solicitud para alquilar un libro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alquilar'])) {
    // Realizar operaciones en la base de datos para insertar el libro alquilado
    $servername = "localhost";
    $username = "root";
    $password = "Prueba_123";
    $dbname = "Catálogo";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener información del libro seleccionado
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $foto = $_POST['foto'];

    // Insertar el libro alquilado en la tabla libro_alugado con cantidad 1
    $sqlInsert = "INSERT INTO libro_alugado (titulo, cantidade, descripcion, editorial, foto, usuario) VALUES ('$titulo', 1, '$descripcion', 'Editorial Ejemplo', '$foto', 'usuario_prueba')";
    if ($conn->query($sqlInsert) === TRUE) {
        header("Location: carrito.php");
        exit();
    } else {
        echo '<script>alert("Error al alquilar el libro. Por favor, inténtalo de nuevo.");</script>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros en Alquiler</title>
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header img {
            max-width: 200px;
            height: auto;
            display: center;
            margin: 0 auto;
            filter: brightness(0) invert(1); 
        }

        .cart {
            display: flex;
            align-items: center;
        }

        .cart img {
            max-width: 30px;
            margin-right: 10px;
        }

        .cart a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
        }

        .perfil {
            display: flex;
            align-items: center;
        }

        .perfil img {
            max-width: 30px;
            margin-right: 10px;
        }

        .perfil a {
            color: #fff;
            text-decoration: none;
            font-size: 1.2em;
        }

        main {
            flex: 1;
            margin: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .book-column {
            flex: 1;
            max-width: calc(25% - 20px);
            box-sizing: border-box;
            margin: 10px;
        }

        .book {
            position: relative;
            border: 1px solid #ccc;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        .book:hover {
            transform: scale(1.05);
        }

        .book img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
        }

        .book-info {
            padding: 10px;
            text-align: center;
        }

        .book-info h3 {
            margin: 0;
            font-size: 1.2em;
            color: #333;
        }

        .book-info p {
            margin: 5px 0;
            font-size: 1em;
            color: #666;
        }

        .book-info p::before {
            content: '\20AC';
        }

        footer {
            background-color: #141414;
            color: #fff;
            padding: 1em;
            text-align: center;
            margin-top: auto;
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

        button {
            font-size: 15px;
            padding: 15px;
            background-color: #141414;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 40px;
            width: 100%;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>

    <header>
        <img src="/imagenes/BookPlanet.png" alt="Logo BookPlanet">
        <div class="cart">
            <a href="carrito.php"><img src="https://cdn-icons-png.freepik.com/512/6652/6652151.png" alt="Carrito de compras"></a>
        </div>
        <div class="perfil">
            <a href="perfil.php"><img src="https://cdn-icons-png.freepik.com/512/64/64572.png" alt="Perfil"></a>
        </div>
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

        // Consulta a la base de datos
        $sql = "SELECT titulo, descripcion, prezo, foto FROM libro_aluguer";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Imprime los resultados
            while ($row = $result->fetch_assoc()) {
                echo '<div class="book-column">';
                echo '<div class="book">';
                echo '<img src="' . $row["foto"] . '" alt="' . $row["titulo"] . '">';
                echo '<div class="book-info">';
                echo '<h3>' . $row["titulo"] . '</h3>';
                echo '<p>' . number_format($row["prezo"], 2, ',', '.') . ' €</p>';
                echo '<form method="post" action=""><input type="hidden" name="titulo" value="' . $row["titulo"] . '"><input type="hidden" name="descripcion" value="' . $row["descripcion"] . '"><input type="hidden" name="foto" value="' . $row["foto"] . '"><button type="submit" name="alquilar" class="alquilar-btn">Alquilar</button></form>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No se encontraron libros en alquiler.";
        }

        $conn->close();
        ?>
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
