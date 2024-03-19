<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "Prueba_123";
    $database = "Catálogo";

    $conn = new mysqli($servername, $username, $password, $database);

    // Verifica la conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Obtiene los valores del formulario
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Consulta SQL para verificar la existencia del usuario y contraseña
    $sql = "SELECT * FROM usuario WHERE usuario = '$username' AND contrasinal = '$password'";
    $result = $conn->query($sql);

    // Verifica si se encontraron resultados
    if ($result->num_rows > 0) {
        // Inicio de sesión exitoso, establece la variable de sesión y redirige a catalogo.php
        $_SESSION['nombreUsuario'] = $username;
        header("Location: catalogo.php");
        exit();
    } else {
        // Credenciales incorrectas
        $error_message = "Nombre de usuario o contraseña incorrectos";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
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

        header img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
            filter: brightness(0) invert(1); 
        }

        footer {
            background-color: #141414;
            color: #fff;
            padding: 2em;
            text-align: center;
            margin-top: auto;
        }

        main {
            flex: 1;
            max-width: 800px;
            margin: 100px auto;
            padding: 80px;
            background-color: #fff;
            border-radius: 40px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input {
            padding: 10px;
            margin-bottom: 20px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 20px;
        }

        button,
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

        button:hover,
        a:hover {
            background-color: #eae0d5;
            color: #0a0908;
        }
    </style>
</head>

<body>

    <header>
        <img src="/imagenes/BookPlanet.png" alt="Logo de Planeta del libro">
    </header>

    <main>
        <h1>Inicio de Sesión</h1>
        <?php
            if (isset($error_message)) {
                echo "<p>$error_message</p>";
            }
        ?>
        <form action="inicio_sesion.php" method="POST">
            <input type="text" id="username" name="username" required placeholder="Nombre de Usuario">
            <input type="password" id="password" name="password" required placeholder="Contraseña">
            <button type="submit">Acceder</button>
            <a href="registro.php">Registrarse</a>
            <a href="index.html">Volver</a>
        </form>
    </main>

    <footer>
    </footer>

</body>

</html>
