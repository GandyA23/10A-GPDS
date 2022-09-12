<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Mi Primera App</title>
    </head>
    <body>
        <?php
        // Declaración de una variable
        $dobleSalto = " <br /><br />";
        $name = "Gandy";
        $array1 = [1, 2, 3, 4, 5];
        $array2 = array(1, 2, 3, 4, 5);
        $suma = 10 + 20;

        // Impresión de mensajes 
        // Es posible colocar los parentesís para encapsular el mensaje
        echo "My first PHP script $dobleSalto";
        echo "Hola $name $dobleSalto";
        echo "Hola " . $name . $dobleSalto;
        echo $suma . $dobleSalto;
        echo $array1 . $dobleSalto; // No es posible imprimir un arreglo de esta manera, es mejor usar var_dump
        echo $array2 . $dobleSalto; // No es posible imprimir un arreglo de esta manera, es mejor usar var_dump

        // var_dump
        // Nos ayuda a ver información relevante de la variable, tal como su tipo, su cantidad y su valor 
        echo var_dump($name) . $dobleSalto;     // string
        echo var_dump($suma) . $dobleSalto;     // int
        echo var_dump($array1) . $dobleSalto;   // array
        echo var_dump($array2) . $dobleSalto;   // array

        // Sentencias de control 
        if (1) {
            echo "Hola... $dobleSalto";
        } else if (2) {
            // haz algo
        } else {
            // haz otra cosa
        }

        // Ternario
        $mensaje = (8 >= 8) ? "Aprobado" : "Reprobado";
        echo $mensaje . $dobleSalto;
        
        // switch
        switch($suma) {
            // Varios casos que hacen una misma cosa
            case 30:
            case 31:
            case 32:
                /// Haz algo
                break;
                
            default:
        }

        // Ciclos
        for ($i = 1; $i <= 10; $i++) {
            echo "$i <br />";
        }

        echo $dobleSalto;
        ?> 
    </body>
</html>
