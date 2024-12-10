<?php
include 'La-carta.php';
$cart = new Cart;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;700&family=Lora:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
            height: 100vh; 
            flex-shrink: 0;
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
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
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
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #FF0000;
            padding: 10px 0;
        }

        .cart-item img {
            width: 60px;
            height: 60px;
            border-radius: 5px;
        }

        .checkout-section {
            background-color: #1a1a1a;
            border: 1px solid #FF0000;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .checkout-section .btn-primary {
            background-color: #FF0000;
            border: none;
            width: 100%;
        }

        .checkout-section .btn-primary:hover {
            background-color: #800000;
        }

        .container {
            padding: 20px;
        }

        .row > .col-md-8,
        .row > .col-md-4 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<aside>
    <ul>
    <li><a href="index.html">Inicio</a></li>
            <li><a href="SC_Sobre_nosotros.html">Sobre Nosotros</a></li>
            <li><a href="criticas.html">Críticas</a></li>
            <li><a href="TopPeliculas.html">Top Películas</a></li>
            <li><a href="recomendaciones.html">Recomendaciones</a></li>
            <li><a href="noticias.html">Noticias</a></li>
            <li><a href="SC_Contacto.html">Contacto</a></li>
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
        <h2>Carrito de Compras</h2>
        <a href="index.php" class="btn btn-secondary mt-3">Seguir Comprando</a>

        <div class="row">
            <!-- Carrito -->
            <div class="col-md-8">
                <?php if ($cart->total_items() > 0) { ?>
                    <?php foreach ($cart->contents() as $item) { ?>
                        <div class="cart-item">
                            <!-- Depuración de la ruta de la imagen -->
                            <?php 
                                // Comprobación y construcción de la ruta de la imagen
                                $rutaImagen = isset($item['imagen']) ? $item['imagen'] . '.jpg' : 'img/placeholder.jpg';
                            ?>
                            <img src="<?php echo htmlspecialchars($rutaImagen); ?>" alt="Imagen del producto" class="img-fluid rounded">
                            <div>
                                <p class="mb-1"><?php echo htmlspecialchars($item['name'] ?? 'Producto sin nombre'); ?></p>
                                <p class="mb-1"><?php echo htmlspecialchars($item['description'] ?? 'Sin descripción'); ?></p>
                            </div>
                            <span>x<?php echo htmlspecialchars($item['qty'] ?? '0'); ?></span>
                            <span>$<?php echo number_format(($item['price'] ?? 0) * ($item['qty'] ?? 1), 2); ?></span>
                            <a href="AccionCarta.php?action=removeCartItem&id=<?php echo htmlspecialchars($item['rowid']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este producto?')">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </div>
                    

                    <?php } ?>
                <?php } else { ?>
                    <p>Tu carrito está vacío.</p>
                <?php } ?>
            </div>
            

            <!-- Resumen de Pago -->
            <div class="col-md-4 checkout-section">
                <h4>Detalles del Pago</h4>
                <form method="post" action="AccionCarta.php?action=finalizarCompra">
                        <button type="submit" class="btn btn-primary mt-3">Finalizar Compra</button>
                </form>
                <form>
                    <div class="mb-3">
                        <label for="cardType" class="form-label">Tipo de Tarjeta</label>
                        <select class="form-select" id="cardType">
                            <option selected>Visa</option>
                            <option>MasterCard</option>
                            <option>American Express</option>
                            <option>PayPal</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cardName" class="form-label">Nombre en la Tarjeta</label>
                        <input type="text" class="form-control" id="cardName">
                    </div>
                    <div class="mb-3">
                        <label for="cardNumber" class="form-label">Número de Tarjeta</label>
                        <input type="text" class="form-control" id="cardNumber">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="expiryDate" class="form-label">Fecha de Expiración</label>
                            <input type="text" class="form-control" id="expiryDate">
                        </div>
                        <div class="col-md-6">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" class="form-control" id="cvv">
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span>$<?php echo number_format($cart->total(), 2); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Envío:</span>
                        <span>$2.00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>$<?php echo number_format($cart->total() + 2.00, 2); ?></strong>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
