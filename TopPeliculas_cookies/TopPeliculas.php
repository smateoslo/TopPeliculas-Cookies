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

    //metodo para mostrar los datos
    public function mostrar_tabla(){
        $nombres_=explode(",",$_COOKIE["nombre_pelicula"]);
        $isans_=explode(",",$_COOKIE["isan_pelicula"]);
        $años_=explode(",",$_COOKIE["ano_pelicula"]);
        $puntuaciones_=explode(",",$_COOKIE["puntuacion_pelicula"]);

        for($i=0;$i<count($nombres_);$i++){
            if($nombres_[$i]!=""){
                $datos.="Nombre: ".$nombres_[$i]." ISAN: ".$isans_[$i]." Anio: ".$años_[$i]." Puntuacion: ".$puntuaciones_[$i]."<br>";
            }
        }
        echo $datos;
    }


}
?>

    <?php

        $concatenado = new TopPeliculas();
        setcookie("nombre_pelicula","",time()+3600);
        setcookie("isan_pelicula","",time()+3600);
        setcookie("ano_pelicula","",time()+3600);
        setcookie("puntuacion_pelicula","",time()+3600);
        echo "<br>";

    ?>

    <?php
    //cookie usuario
    if(isset($_POST['usuario'])){
        $usuario = $_POST['usuario'];
        setcookie('usuario',$usuario,time()+3600);
    }
    ?>
    
<h1>Usuario: <?php {echo $_COOKIE["usuario"] ; } ?></h1>

<form action="TopPeliculas.php" method="post">
    <h2>Ejercicio Cookies</h2>
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
    
    <?php
            if(isset($_POST["Isan"]) && isset($_POST["Nombre"]) && isset($_POST["año"]) && isset($_POST["combo"])){
            if($_POST["Isan"]!="" && $_POST["Nombre"]!=""){
                $posicion=0;
                $encontrado=false;
                $isans=explode(",",$_COOKIE["isan_pelicula"]);
                for ($i=0; $i < count($isans); $i++) { 
                    if($isans[$i]==$_POST["Isan"]){
                        $encontrado=true;
                        $posicion=$i;
                    }
                }
                if($encontrado){
                    $nombres=explode(",",$_COOKIE["nombre_pelicula"]);
                    $años=explode(",",$_COOKIE["ano_pelicula"]);
                    $puntuaciones=explode(",",$_COOKIE["puntuacion_pelicula"]);
                    $años[$posicion]=$_POST["año"];
                    $puntuaciones[$posicion]=$_POST["combo"];
                    $nombres[$posicion]=$_POST["Nombre"];
                    $isans[$posicion]=$_POST["Isan"];

                    for ($i=0; $i < count($nombres); $i++) { 
                        $nombres_corregido.=$nombres[$i].",";
                        $isans_corregido.=$isans[$i].",";
                        $puntuaciones_corregido.=$puntuaciones[$i].",";
                        $años_corregido.=$años[$i].",";
                    }
                    setcookie("nombre_pelicula",$nombres_corregido,time()+3600);
                    setcookie("isan_pelicula",$isans_corregido,time()+3600);
                    setcookie("ano_pelicula",$años_corregido,time()+3600);
                    setcookie("puntuacion_pelicula",$puntuaciones_corregido,time()+3600);

                }else{
                    $nombres=$_COOKIE["nombre_pelicula"].$_POST["Nombre"].",";
                    $isans=$_COOKIE["isan_pelicula"].$_POST["Isan"].",";
                    $años=$_COOKIE["ano_pelicula"].$_POST["año"].",";
                    $puntuaciones=$_COOKIE["puntuacion_pelicula"].$_POST["combo"].",";
                    setcookie("nombre_pelicula",$nombres,time()+3600);
                    setcookie("isan_pelicula",$isans,time()+3600);
                    setcookie("ano_pelicula",$años,time()+3600);
                    setcookie("puntuacion_pelicula",$puntuaciones,time()+3600);
                }

            }else if($_POST["Isan"]!="" && $_POST["Nombre"]==""){
                $isans=explode(",",$_COOKIE["isan_pelicula"]);
                for ($i=0; $i < count($isans); $i++) { 
                    if($isans[$i]==$_POST["Isan"]){
                        $posicion=$i;
                    }
                }

                $nombres=explode(",",$_COOKIE["nombre_pelicula"]);
                $años=explode(",",$_COOKIE["ano_pelicula"]);
                $puntuaciones=explode(",",$_COOKIE["puntuacion_pelicula"]);
                
                for ($i=0; $i < count($nombres); $i++) { 
                    if($i!=$posicion){
                        $nombres_corregido.=$nombres[$i].",";
                        $años_corregido.=$años[$i].",";
                        $puntuaciones_corregido.=$puntuaciones[$i].",";
                        $isans_corregido.=$isans[$i].",";
                    }  
                }

                setcookie("nombre_pelicula",$nombres_corregido,time()+3600);
                setcookie("isan_pelicula",$isans_corregido,time()+3600);
                setcookie("ano_pelicula",$años_corregido,time()+3600);
                setcookie("puntuacion_pelicula",$puntuaciones_corregido,time()+3600);

            }else if($_POST["Isan"]=="" && $_POST["Nombre"]!=""){
                $nombres=explode(",",$_COOKIE["nombre_pelicula"]);
                $años=explode(",",$_COOKIE["ano_pelicula"]);
                for ($i=0; $i < count($nombres); $i++) { 
                    if(str_contains($nombres[$i],$_POST["Nombre"])){
                        echo "<p>".$nombres[$i]." from ".$años[$i]."</p>";
                    }
                }
            }


            
            $pelicula=new Pelicula(htmlentities($_POST['Isan']),htmlentities($_POST['Nombre']),htmlentities($_POST['combo']),htmlentities($_POST['año']));
            $concatenado->anadirPelicula($pelicula);
            $concatenado->mostrar_tabla();
        }
    ?>
</form>
</body>
</html>