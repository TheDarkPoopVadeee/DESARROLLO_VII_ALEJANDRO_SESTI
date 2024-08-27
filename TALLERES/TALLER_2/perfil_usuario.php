<?php
    $nombre_completo="ALEJANDRO SESTI";
    $edad=27;
    $correo="alejandro.sesti.diaz@utp.ac.pa";
    $telefono= 64968908;
    define("OCUPACION", "estudiante");

   echo $presentacion1 = "Hola, mi nombre es " . $nombre_completo . " y tengo " . $edad . " años.";
   echo "<br>";
   echo $presentacion2 = "Con correo ". $correo . " y numero celular ". $telefono . " ocupacion ". OCUPACION;
   echo "<br>";

    echo "<br>Información de debugging:<br>";
    var_dump($nombre_completo);
    echo "<br>";
    var_dump($edad);
    echo "<br>";
    var_dump($correo);
    echo "<br>";
    var_dump(OCUPACION);
    echo "<br>";
?>
