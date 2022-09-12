<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Segunda Actividad</title>
</head>
<body>
    <?php
        /**
         *  Determina si un año es bisiesto o no
         * @param int $anioAux
         * @return boolean   
         */
        function esBisiesto ($anioAux) {
            return ((!($anioAux % 4) && ($anioAux % 100)) || !($anioAux % 400));
        }

        $mes = 2;
        $anio = 2020;
        $dias = 0;

        $meses = array(
            // Meses con 30 días
            1 => 30, 3 => 30, 5 => 30, 7 => 30, 8 => 30, 10 => 30, 12 => 30,
            // Meses con 31 días
            4 => 31, 6 => 31, 9 => 31, 11 => 31,
            // Febrero
            2 => 28,
        );

        if (isset($meses[$mes])) {
            // Verifica que sea el mes de febrero para determinar si es bisiesto o no
            $dias = $meses[$mes] + ($mes === 2 ? esBisiesto($anio) : 0);
        }

        if (!$dias) {
            echo "<b> El mes ingresado no existe </b> <br />";
        } else {
            echo "El mes de $mes en el año $anio tiene $dias días";
        }
    ?>
</body>
</html>
