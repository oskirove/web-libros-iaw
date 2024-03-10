<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookPlanet - Perfil de Usuario</title>
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
            z-index: 1;
        }

        header img {
            max-width: 200px;
            height: auto;
            display: block;
            margin: 0 auto;
            filter: brightness(0) invert(1);
            position: relative;
            z-index: 2;
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
            width: 400px;
            margin: 30px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            z-index: 0;
        }

        .profile-section {
            margin-top: 80px;
            text-align: center;
        }

        .data-section {
            margin-bottom: 30px;
        }

        .profile-label {
            font-size: 1em; /* Ajustado el tamaño del texto */
            font-weight: bold;
            display: block;
            margin-bottom: 5px; /* Reducido el margen inferior */
            color: #333;
        }

        .profile-value {
            font-size: 1.2em;
            margin-bottom: 20px;
            display: inline-block;
            color: #333;
        }

        a {
            padding: 15px;
            font-size: 1em;
            color: #0a0908;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            position: absolute;
            bottom: 55px;
            left: 50%;
            transform: translateX(-50%);
            width: 40%;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }

        .profile-button:hover {
            background-color: #0a0908;
        }

        .profile-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            position: absolute;
            top: 13px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        .profile-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        .back-button {
            padding: 15px;
            font-size: 1em;
            background-color: #141414;
            color: #fff;
            border: none;
            border-radius: 40px;
            cursor: pointer;
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80%;
            text-align: center;
            transition: background-color 0.3s ease-in-out;
        }

        .back-button:hover {
            background-color: #0a0908;
        }
    </style>
</head>

<body>

    <header>
        <img src="/imagenes/BookPlanet.png" alt="Logo de Planeta del libro">
    </header>

    <main>
        <div class="profile-image">
            <img src="https://cdn-icons-png.freepik.com/512/64/64572.png" alt="Imagen de perfil">
        </div>
        <?php
        // Inicia la sesión
        session_start();

        // Verifica si el usuario está autenticado
        if (isset($_SESSION['nombreUsuario'])) {
            // Aquí debes agregar la lógica PHP para obtener los datos del usuario de la base de datos
            $servername = "localhost";
            $username = "root";
            $password = "Prueba_123";
            $database = "Catálogo";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Conexión fallida: " . $conn->connect_error);
            }

            // Obtén el nombre de usuario de la sesión
            $nombreUsuario = $_SESSION['nombreUsuario'];

            // Consulta SQL para obtener los datos del usuario
            $sql = "SELECT * FROM usuario WHERE usuario = '$nombreUsuario'";
            $result = $conn->query($sql);

            // Verifica si se encontraron resultados
            if ($result->num_rows > 0) {
                // Obtiene la fila de resultados como un array asociativo
                $row = $result->fetch_assoc();

                // Muestra el nombre de usuario
                echo '<div class="profile-section"><span class="profile-value">' . $row["usuario"] . '</span></div>';

                // Muestra los datos del usuario
                echo '<div class="data-section">';
                echo '<span class="profile-label">Contraseña:</span>';
                echo '<span class="profile-value">' . $row["contrasinal"] . '</span>';
                echo '</div>';
                echo '<div class="data-section">';
                echo '<span class="profile-label">Nombre:</span>';
                echo '<span class="profile-value">' . $row["nome"] . '</span>';
                echo '</div>';
                echo '<div class="data-section">';
                echo '<span class="profile-label">Teléfono:</span>';
                echo '<span class="profile-value">' . $row["telefono"] . '</span>';
                echo '</div>';
                echo '<div class="data-section">';
                echo '<span class="profile-label">Dirección:</span>';
                echo '<span class="profile-value">' . $row["direccion"] . '</span>';
                echo '</div>';
                echo '<div class="data-section">';
                echo '<span class="profile-label">NIF/DNI:</span>';
                echo '<span class="profile-value">' . $row["nifdni"] . '</span>';
                echo '</div>';
            } else {
                echo '<p>No se encontraron datos para el usuario.</p>';
            }

            // Cierra la conexión a la base de datos
            $conn->close();
        } else {
            // Redirige a la página de inicio de sesión si el usuario no está autenticado
            header("Location: inicio_sesion.php");
            exit();
        }
        ?>

        <!-- Repite el formato para otros campos -->
        
        <a href="modificar_datos.php">Modificar datos</a>
    
        <button class="back-button" onclick="window.location.href='catalogo.php'">Volver</button>

    </main>

    <footer>
    </footer>

</body>

</html>
