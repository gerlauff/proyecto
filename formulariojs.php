<!DOCTYPE html>

<?php
session_start();
//var_dump($_SESSION);



?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./estilo.css">
    <title>Document</title>
</head>
<html>
    <script type="text/javascript">
         <?php
        //     if(isset($_GET['estado']) && ($_GET['estado']==0)){?>
        //         alert ("NO EXISTE ID");
         <?php //}         
        //     else{
        //         echo ("alert ('SE ELIMINÓ CORRECTAMENTE');");
        //         //alert ('SE ELIMINÓ CORRECTAMENTE');
        //         //form.submit();
        //         } 
        ?>
        function validar(){
            form=document.getElementById("form"); //tambien se puede hacer document.getElementById("form").submit() y no hace falat XX
            nombre=document.getElementById("nombre").value;
            apellido=document.getElementById("apellido").value;
            edad=document.getElementById("edad").value;
            //isNaN(edad) devuelve TRUE si no es un número
            nombre=nombre.trim(); // saca los blancos de delante y atrás de la cadena de caracteres
            apellido=apellido.trim();
            
            function longitud(long){
                if ((long.length>3) && (long.length<45)){
                    return true;
                }
                else{
                    return false;
                }
            }
            
            if ((nombre=="") || (apellido=="") || (edad=="")){
                alert("Complete todos los campos");
            }  
            else{
                if (longitud(nombre)== true){
                    if (longitud(apellido)== true){
                        if (isNaN(edad)==false){
                            alert("SE GUARDÓ EXITOSAMENTE!!!");
                            form.submit();//XX
                        }
                        else{
                            alert("La edad no es un número")
                        }
                    }
                    else{
                        document.getElementById("mens_ape").innerHTML="Longitud de apellido incorrecta";
                    }
                }
                else{
                    document.getElementById("mens_nombre").innerHTML="Longitud de nombre incorrecta";
                }
            } 
                
        }
    </script>

    <form action="acciones.php" method="GET" id="form"> <!--ENVIA POR URL-->
        <label for="">Nombre</label>
        <input type="text" name="nombre" id="nombre" value="<?php 
        if (isset($_SESSION["nombre"])){
             echo $_SESSION["nombre"];
        }     
             ?>"><p id="mens_nombre"></p>
        
        <label for="">Apellido</label>
        <input type="text" name="apellido" id="apellido" value="<?php
        if (isset($_SESSION["apellido"])){
             echo $_SESSION["apellido"];
        }     
        ?>"><p id="mens_ape"></p>
        <label for="">Edad</label>
        <input type="text" name="edad" id="edad" value="<?php 
        if (isset($_SESSION["edad"])){
             echo $_SESSION["edad"];
        }     
                
        ?>">
        <input type="button" value="GUARDAR" onclick='validar()'>
        <input type="hidden" name="accion" value="guardar"/>
        <input type="hidden" name="id" value="<?php
        if (isset($_SESSION["id"])){
            echo $_SESSION["id"];
        }
        ?>"/>
      </form>
      
    <!-- <form action="acciones.php" method="GET" id="form2">
        <input type="text" name="id" id="id" placeholder="Colocar ID a editar">
        <input type="submit" value="EDITAR">
        <input type="hidden" name="accion" value="editar"/> -->
    </form>

    <form action="acciones.php" method="GET" id="form2">
        <input type="submit" value="LISTADO">
        <input type="hidden" name="accion" value="mostrar"/>
    </form>

    <!-- <form action="acciones.php" method="GET" id="form3">
        <input type="text" name="id" id="id" placeholder="Colocar ID a eliminar">
        <input type="submit" value="ELIMINAR">
        <input type="hidden" name="accion" value="eliminar"/> -->
    </form>

</html>