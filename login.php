<?php
// Incluye el archivo de conexión a la base de datos
include 'Configuracion.php';

// Verifica si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtiene los valores ingresados en el formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica que no estén vacíos
    if (!empty($email) && !empty($password)) {
        // Prepara la consulta para buscar al usuario
        $query = $db->prepare("SELECT * FROM clientes WHERE email = ? LIMIT 1");
        $query->bind_param("s", $email);
        $query->execute();
        $result = $query->get_result();

        // Si el usuario existe
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verifica la contraseña
            if ($user['password'] === $password) {
                // Inicio de sesión exitoso
                session_start();
                $_SESSION['sessCustomerID'] = $user['id']; // Cambiar la clave a 'sessCustomerID'
                $_SESSION['user_name'] = $user['name'];

                // Redirige al usuario a la página principal
                header("Location: index.php");
                exit();
            } else {
                $error = "La contraseña es incorrecta.";
            }
        } else {
            $error = "El correo no está registrado.";
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ScreenScore - Iniciar Sesión</title>
    <link rel="stylesheet" href="./css/inciar_sesion.css">
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <form method="POST" action="">
            <input type="email" name="email" placeholder="Correo Electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <p>¿No tienes cuenta? <a href="register.html">Regístrate aquí</a></p>
    </div>
</body>
</html>
