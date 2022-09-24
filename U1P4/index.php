<?php 

const LBL_X = "x";
const LBL_Y = "y";

$asc = $pares = $impares = $error = "";
$bgClass = "";
$numMayor = $numMenor = $y = $x = "";

if ($_POST) {
    if (isset($_POST[LBL_X]) && isset($_POST[LBL_Y]) ) {

        $x = $_POST[LBL_X]; 
        $y = $_POST[LBL_Y];

        // Verifica que sean valores númericos y mayores a 0
        if (is_numeric($_POST[LBL_X]) && is_numeric($_POST[LBL_Y]) && $_POST[LBL_X] > 0 && $_POST[LBL_Y] > 0) {
            // Realiza el cambio de variables para tener el valor mayor y menor
            if ($x > $y) {
                $numMayor = $x;
                $numMenor = $y;
            } else {
                $numMayor = $y;
                $numMenor = $x;
            }
            
            // Crea la lista ascendente
            for ($i = $numMenor; $i <= $numMayor; $i++) {
                $asc .= "$i, ";
            }
            
            // Crea la lista descendente con los pares y los impares
            for ($i = $numMayor; $i >= $numMenor; $i--) {
                if ($i % 2) {
                    $impares .= "$i, ";
                } else {
                    $pares .= "$i, ";
                }
            }
    
            $bgClass = "success";
        } else {
            $error = "Error, favor de agregar números válidos mayores a 0";
            $bgClass = "danger";    
        }
    } else {    
        $error = "Error, favor de agregar números válidos mayores a 0";
        $bgClass = "danger";
    }
} 

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Funciones de cadena</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-fluid">
        <div class="row">
            <h2>Funciones de cadena</h2>
        </div>

        <div class="row">
            <form action="index.php" method="post">
                <div class="row g-3 align-items-center my-3">
                    <div class="col-auto">
                        <label for="<?= LBL_X ?>" class="col-form-label">Número 1: </label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="<?= LBL_X ?>" name="<?= LBL_X ?>" value="<?= $x ?>" class="form-control">
                    </div>
                </div>
                <div class="row g-3 align-items-center my-3">
                    <div class="col-auto">
                        <label for="<?= LBL_Y ?>" class="col-form-label">Número 2: </label>
                    </div>
                    <div class="col-auto">
                        <input type="number" id="<?= LBL_Y ?>" name="<?= LBL_Y ?>" value="<?= $y ?>" class="form-control">
                    </div>
                </div>
                <div class="row g-3 align-items-center my-3">
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">Realizar listas</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="row">
            <?php if ($asc): ?>
                <div class="alert alert-<?= $bgClass ?>">
                    <h5>Lista de números enteros entre <?= $numMenor ?> y <?= $numMayor ?></h5>
                    <br />
                    <?= $asc ?>
                </div>
            <?php endif; ?>
            <?php if ($pares): ?>
                <div class="alert alert-<?= $bgClass ?>">
                    <h5>Lista de números pares entre <?= $numMenor ?> y <?= $numMayor ?></h5>
                    <br />
                    <?= $pares ?>
                </div>
            <?php endif; ?> 
            <?php if ($impares): ?>
                <div class="alert alert-<?= $bgClass ?>">
                    <h5>Lista de números impares entre <?= $numMenor ?> y <?= $numMayor ?></h5>
                    <br />
                    <?= $impares ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div class="alert alert-<?= $bgClass ?>">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
