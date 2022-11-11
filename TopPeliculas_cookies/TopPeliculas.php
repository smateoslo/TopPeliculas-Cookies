<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopPeliculas</title>  
</head>
<body>
    <?php

    require('Pelicula.php');

    class TopPeliculas{

    private $peliculaArray=[];

    public function __construct(){

    }

    public function anadirPelicula($pelicula){

        $peliculaArray = [];


        if(($pelicula->getNombre() == "") && ($pelicula->getIsan() == "")){
            //Caso 1
            echo "Nombre y ISAN vacios <br>";
       } else{
           foreach ($peliculaArray as $key => $value){
               if($key == $pelicula->getIsan()){
                   //Caso 5
                   if($pelicula->getNombre() == ""){
                       //echo "Si el usuario introduce un número ISAN y no deja el nombre de la película vacío, la película se eliminará de la lista.";
                       unset($peliculaArray[$key]);
                   } 
                   //Caso 4
                   if($pelicula->getNombre() != "" && $pelicula->getAño() != "" && $pelicula->getPuntuacion()){
                       //echo "Si el número ISAN que se introdujo YA existe en la lista y el resto de apartados no están vacíos se actualizará con la información introducida en el formulario.";
                       $value->setNombre($pelicula->getNombre());
                       $value->getAño($pelicula->getAño());
                       $value->getPuntuacion($pelicula->getPuntuacion());
                   }
               } else{
                   //Caso 3
                   if(($pelicula->getNombre() != "") && ($pelicula->getIsan() == "")){
                       //echo "Si sólo el ISAN está vacío mostrará la lista de películas que contienen ese nombre" ;
                       if(str_contains($value->getNombre(),$pelicula->getNombre())){
                           echo "<p>".$value->getNombre()." Año: ".$value->getAño()."</p>";
                           unset($peliculaArray[null]);
                       }
                   } else{
                       $peliculaArray[$pelicula->getIsan()]= $pelicula;
                   }  
               }
           } 
       } 
    }
}
?>

        <?php

            //Pongo unos valores por defecto si no se anade nda ("Ejemplo",1111,2022,2)
            $concatenado = new TopPeliculas();
            setcookie("nombre_pelicula","Ejemlo",time()+3600);
            setcookie("isan_pelicula",1111,time()+3600);
            setcookie("ano_pelicula",2022,time()+3600);
            setcookie("puntuacion_pelicula",2,time()+3600);
            echo "<br>";

        ?>

    


<form action="TopPeliculas.php" method="post">
    <h1>Ejercicio Cookies</h1>
        <p>Nombre de la pelicula: </p> 
        <input type="text" name="Nombre" value="<?php if(isset($_POST['Nombre'])){echo $_POST['Nombre'];}else{echo "";} ?>">
        <p>ISAN: </p>
        <input type="text" name="Isan" value="<?php if(isset($_POST['Isan'])){echo $_POST['Isan'];}else{echo "";} ?>">
        <br>
        <p>Anio:</p>
        <input type="text" name="año" value="<?php if(isset($_POST['año'])){echo $_POST['año'];}else{echo "";} ?>" >
        <br><br>
        <p>Puntuacion:</p>
        <select name="combo">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br><br>
        <button type="submit">Añadir</button>
        <br><br>
    </form>
    <?php
        if(isset($_POST["Nombre"])){
            $nombres=$_COOKIE["nombre_pelicula"].",".$_POST["Nombre"];
            $isans=$_COOKIE["isan_pelicula"].",".$_POST["Isan"];
            $años=$_COOKIE["ano_pelicula"].",".$_POST["año"];
            $puntuaciones=$_COOKIE["puntuacion_pelicula"].",".$_POST["combo"];
            setcookie("nombre_pelicula",$nombres,time()+3600);
            setcookie("isan_pelicula",$isans,time()+3600);
            setcookie("ano_pelicula",$años,time()+3600);
            setcookie("puntuacion_pelicula",$puntuaciones,time()+3600);


            $peli=new Pelicula(htmlentities($_POST['Isan']),htmlentities($_POST['Nombre']),htmlentities($_POST['combo']),htmlentities($_POST['año']));
            $concatenado->anadirPelicula($peli);
            echo $_COOKIE["nombre_pelicula"]."<br>";
            echo $_COOKIE["isan_pelicula"]."<br>";
            echo $_COOKIE["ano_pelicula"]."<br>";
            echo $_COOKIE["puntuacion_pelicula"]."<br>";
        
            
        }
        ?>
</body>
</html>