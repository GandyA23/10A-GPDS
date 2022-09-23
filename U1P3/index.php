<?php

// Variables para evitar typos al recibir variables en el post
const LBL_1 = "num1";
const LBL_2 = "num2";
const LBL_UNIT = "unidades";
const LBL_PRICE = "precio";

$bgClassSuma = $num1 = $num2 = $resultadoSuma = "";
$bgClassTienda = $unidades = $precio = $resultadoNeto = $txtDescuento = "";
$descuento = 0;

// Verifica que exista la petición
if ($_POST) {

    // Valida los tipos de dato en la suma
    if (isset($_POST[LBL_1]) && isset($_POST[LBL_2])) {
        
        $num1 = $_POST[LBL_1];
        $num2 = $_POST[LBL_2];

        // Verifica que los datos sean númericos
        if (is_numeric($num1) && is_numeric($num2)) {
            $resultadoSuma = "El resultado de la suma entre <b>$num1</b> y <b>$num2</b> es: <b>" . ($num1 + $num2) . "</b>";
            $bgClassSuma = "success";
        } else {
            $resultadoSuma = "Error: Ingrese un valor númerico válido";
            $bgClassSuma = "danger";
        }
    }
    
    // Valida los tipos de dato en la tienda de abarrotes
    if (isset($_POST[LBL_UNIT]) && isset($_POST[LBL_PRICE])) {
        $unidades = $_POST[LBL_UNIT];
        $precio = $_POST[LBL_PRICE];

        // Verifica que los datos sean númericos y mayores a 0
        if (is_numeric($unidades) && is_numeric($precio) && $unidades > 0 && $precio > 0) {
            $bgClassTienda = "success";
    
            if ($unidades > 100) {
                $txtDescuento = "40%";
                $descuento = 0.4;
            } else if ($unidades >= 25 && $unidades <= 100) {
                $txtDescuento = "20%";
                $descuento = 0.2;
            } else if ($unidades >= 10 && $unidades < 25) {
                $txtDescuento = "10%";
                $descuento = 0.1;
            }
    
            $neto = $unidades * $precio;
            
            // En caso de haber descuento, entonces realizalo y concatenalo
            if ($descuento) {
                $resultadoNeto .= "<b>-$txtDescuento</b> de descuento <br>";
                $resultadoNeto .= "Subtotal: <b>$$neto</b> <br>";
                $resultadoNeto .= "Descuento: <b>$". ($neto * $descuento) ."</b> <br>";
                $neto -= ($neto * $descuento); 
            } 
    
            $resultadoNeto .= "Total: <b>$$neto</b>";

        } else {
            $resultadoNeto = "Error: Favor de ingresar valores válidos y mayores a 0";
            $bgClassTienda = "danger";
        }
    }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suma de dos números</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid">
        <div class="w-100 h-50 my-5">
            <div class="row">
                <h2>Suma de dos números</h2>
            </div>

            <div class="row">
                <form action="index.php" method="post">
                    <div class="row g-3 align-items-center my-3">
                        <div class="col-auto">
                            <label for="<?= LBL_1 ?>" class="col-form-label">Número 1: </label>
                        </div>
                        <div class="col-auto">
                            <input type="number" id="<?= LBL_1 ?>" name="<?= LBL_1 ?>" value="<?= $num1 ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center my-3">
                        <div class="col-auto">
                            <label for="<?= LBL_2 ?>" class="col-form-label">Número 2: </label>
                        </div>
                        <div class="col-auto">
                            <input type="number" id="<?= LBL_2 ?>" name="<?= LBL_2 ?>" value="<?= $num2 ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 align-items-center my-3">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Sumar</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <?php if ($resultadoSuma): ?>
                    <div class="alert alert-<?= $bgClassSuma ?>">
                        <?= $resultadoSuma ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="w-100 h-50 my-5">
            <div class="row">
                <h2>Tienda de abarrotes</h2>
            </div>

            <div class="row">
                <form action="index.php" method="post">
                    <div class="row g-3 my-3">
                        <div class="col-auto">
                            <label for="<?= LBL_UNIT ?>" class="col-form-label">Unidades: </label>
                        </div>
                        <div class="col-auto">
                            <input type="number" id="<?= LBL_UNIT ?>" name="<?= LBL_UNIT ?>" value="<?= $unidades ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 my-3">
                        <div class="col-auto">
                            <label for="<?= LBL_PRICE ?>" class="col-form-label">Precio: </label>
                        </div>
                        <div class="col-auto">
                            <input type="number" id="<?= LBL_PRICE ?>" name="<?= LBL_PRICE ?>" value="<?= $precio ?>" class="form-control">
                        </div>
                    </div>
                    <div class="row g-3 my-3">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Calcular</button>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="row">
                <?php if ($resultadoNeto): ?>
                    <div class="alert alert-<?= $bgClassTienda ?>">
                        <?= $resultadoNeto ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>