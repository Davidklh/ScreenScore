<?php
date_default_timezone_set("America/Lima");
// Iniciamos la clase de la carta
include 'La-carta.php';
$cart = new Cart;

// Include database configuration file
include 'Configuracion.php';

if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
        $productID = $_REQUEST['id'];
        // Get product details
        $query = $db->query("SELECT * FROM mis_productos WHERE id = ".$productID);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'imagen' => $row['imagen'],
            'description' => $row['description'],
            'qty' => 1
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem ? 'VerCarta.php' : 'index.php';
        header("Location: ".$redirectLoc);
    } elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem ? 'ok' : 'err'; die;
    } elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: VerCarta.php");
    } elseif($_REQUEST['action'] == 'finalizarCompra' && $cart->total_items() > 0) {
        session_start();
        
        // Obtener el ID del cliente desde la sesión
        if (!isset($_SESSION['sessCustomerID'])) {
            header("Location: login.php"); // Redirigir al login si no hay sesión activa
            exit();
        }
    
        $clienteID = $_SESSION['sessCustomerID'];

        // Generar la descripción de los productos
        $descripcion = '';
        foreach ($cart->contents() as $item) {
            $descripcion .= $item['name'] . ' x' . $item['qty'] . ', ';
        }
        $descripcion = rtrim($descripcion, ', '); // Eliminar la última coma

        // Calcular el monto total
        $monto_total = $cart->total();

        // Insertar en la tabla `ventas`
        $query = $db->prepare("INSERT INTO ventas (cliente_id, monto_total, descripcion) VALUES (?, ?, ?)");
        $query->bind_param("ids", $clienteID, $monto_total, $descripcion);

        if ($query->execute()) {
            // Limpiar el carrito después de guardar la venta
            $cart->destroy();
            echo "<script>alert('Compra finalizada con éxito. Gracias por tu compra.'); window.location.href='index.php';</script>";
        } else {
            echo "<script>alert('Error al finalizar la compra. Intenta nuevamente.'); window.location.href='VerCarta.php';</script>";
        }
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
?>
