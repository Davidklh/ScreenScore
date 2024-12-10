<?php
include 'Configuracion.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Merchandising de Películas</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Lora', serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            height: 100vh;
        }

        aside {
            width: 200px;
            background-color: #a93232; 
            padding: 15px;
            height: 100%; /* Asegura que el aside ocupe toda la altura */
            flex-shrink: 0; /* Evita que el aside se reduzca */
        }

        aside ul {
            list-style: none;
            padding: 0;
        }

        aside ul li {
            margin-bottom: 10px;
        }

        aside ul li a {
            color: #ffffff; 
            text-decoration: none;
            font-weight: bold;
            font-family: 'Oswald', sans-serif; 
        }

        aside ul li a:hover {
            color: #ff0000; 
        }

        .main-content {
            flex-grow: 1; /* Hace que el contenido principal ocupe todo el espacio disponible */
            display: flex;
            flex-direction: column; /* Para organizar header y el contenido */
        }

        header {
            width: 100%;
            padding: 10px;
            background-color: #222222; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #ffffff; 
        }

        header #logo {
            font-size: 1.5em;
            font-weight: bold;
            font-family: 'Oswald', sans-serif; 
        }

        header input[type="text"] {
            padding: 5px;
            border: 1px solid #ff0000; 
            background-color: #333333; 
            color: #ffffff; 
        }

        header button {
            padding: 5px 10px;
            background-color: #ff0000; 
            color: #ffffff; 
            border: none;
            cursor: pointer;
        }

        header button:hover {
            background-color: #cc0000; 
        }

        h2 {
            font-family: 'Oswald', sans-serif;
            color: #FF0000;
        }

        .card {
            background-color: #1a1a1a;
            border: 1px solid #FF0000;
            border-radius: 10px;
            color: #fff;
            text-align: center; /* Centra el contenido de la tarjeta */
        }

        .card img {
            width: auto; /* Mantiene la proporción de la imagen */
            height: 150px; /* Establece una altura fija */
            display: block;
            margin: 0 auto; /* Centra la imagen horizontalmente */
        }

        .card .btn {
            background-color: #FF0000;
            border: none;
        }

        .card .btn:hover {
            background-color: #800000;
        }

        .container {
            padding: 20px;
        }
        
    </style>
</head>
<body>
    <aside>
        <ul>
            <li><a href="index.html">Inicio</a></li>
            <li><a href="SC_Sobre_nosotros.html">Sobre Nosotros</a></li>
            <li><a href="criticas.html">Críticas</a></li>
            <li><a href="Tp.html">Top Películas</a></li>
            <li><a href="recomendaciones.html">Recomendaciones</a></li>
            <li><a href="noticias.html">Noticias</a></li>
            <li><a href="#">Contacto</a></li>
            <li><a href="index.php">Merch</a></li>
        </ul>
    </aside>
    <div class="main-content">
        <header>
            <div id="logo">ScreenScore</div>
            <input type="text" placeholder="Buscar...">
            <button>Buscar</button>
            <div>
                <button onclick="window.location.href='login.php'">Iniciar sesión</button>
            </div>
        </header>
        <div class="container">
            <div class="row mt-4">
                <?php
                $query = $db->query("SELECT * FROM mis_productos ORDER BY id DESC");
                if ($query->num_rows > 0) {
                    while ($row = $query->fetch_assoc()) {
                ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="<?php echo $row['imagen']; ?>.jpg" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                                <p class="text-danger">$<?php echo number_format($row['price'], 2); ?></p>
                                <a href="AccionCarta.php?action=addToCart&id=<?php echo $row['id']; ?>" class="btn btn-danger w-100">Añadir al carrito</a>
                            </div>
                        </div>
                    </div>
                <?php } } else { ?>
                    <p class="text-center">No hay productos disponibles.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>
