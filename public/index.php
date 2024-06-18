<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minimarket App</title>
    <link href="/public/css/tailwind.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Gestión de Productos del Minimarket</h1>

        <?php
        // Inicializamos las variables de error y el array asociativo Sproductos
        $nameErr = $priceErr = $quantityErr = "";
        $name = $price = $quantity = "";
        $Sproductos = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validación de los datos del formulario
            if (empty($_POST["name"])) {
                $nameErr = "El nombre es obligatorio";
            } else {
                $name = test_input($_POST["name"]);
            }

            if (empty($_POST["price"]) || $_POST["price"] <= 0) {
                $priceErr = "El precio debe ser un número positivo";
            } else {
                $price = test_input($_POST["price"]);
            }

            if (empty($_POST["quantity"]) || $_POST["quantity"] < 0) {
                $quantityErr = "La cantidad debe ser un número no negativo";
            } else {
                $quantity = test_input($_POST["quantity"]);
            }

            // Si no hay errores, agregamos el producto al array asociativo
            if (empty($nameErr) && empty($priceErr) && empty($quantityErr)) {
                add_product($Sproductos, $name, $price, $quantity);
            }
        }

        // Función para limpiar los datos de entrada
        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Función para agregar un producto al array asociativo
        function add_product(&$Sproductos, $name, $price, $quantity) {
            $Sproductos[] = [
                "name" => $name,
                "price" => $price,
                "quantity" => $quantity
            ];
        }

        // Función para mostrar los productos en una tabla
        function display_products($Sproductos) {
            echo '<table class="min-w-full bg-white">';
            echo '<thead><tr>';
            echo '<th class="py-2">Nombre del Producto</th>';
            echo '<th class="py-2">Precio por Unidad</th>';
            echo '<th class="py-2">Cantidad en Inventario</th>';
            echo '<th class="py-2">Valor Total</th>';
            echo '<th class="py-2">Estado</th>';
            echo '</tr></thead>';
            echo '<tbody>';
            foreach ($Sproductos as $product) {
                $total_value = $product["price"] * $product["quantity"];
                $status = $product["quantity"] == 0 ? "Agotado" : "En Stock";
                echo '<tr>';
                echo '<td class="border px-4 py-2">' . htmlspecialchars($product["name"]) . '</td>';
                echo '<td class="border px-4 py-2">' . htmlspecialchars($product["price"]) . '</td>';
                echo '<td class="border px-4 py-2">' . htmlspecialchars($product["quantity"]) . '</td>';
                echo '<td class="border px-4 py-2">' . $total_value . '</td>';
                echo '<td class="border px-4 py-2">' . $status . '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        ?>

        <form id="productForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="space-y-4">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nombre del Producto:</label>
                <input type="text" id="name" name="name" value="<?php echo $name;?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <div class="text-red-600 text-sm"><?php echo $nameErr;?></div>
            </div>

            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Precio por Unidad:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?php echo $price;?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <div class="text-red-600 text-sm"><?php echo $priceErr;?></div>
            </div>

            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700">Cantidad en Inventario:</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo $quantity;?>" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm">
                <div class="text-red-600 text-sm"><?php echo $quantityErr;?></div>
            </div>

            <div>
                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-md shadow-md hover:bg-green-600">Agregar Producto</button>
            </div>
        </form>

        <?php
        // Mostramos la tabla de productos si hay productos en el array
        if (!empty($Sproductos)) {
            display_products($Sproductos);
        }
        ?>
    </div>

    <script src="/public/js/script.js"></script>
</body>
</html>
