
<head>
    <link rel="stylesheet" href="estilo2.css">
</head>




<?php
$accion=$_GET["accion"];
session_start();
function guardar(){
    include ('conexion.php'); 
    
    if ((isset($_GET["id"]))&&($_GET["id"])!=""){
        $stmt = $conn->prepare("UPDATE persona SET nombre= ?, apellido= ?,edad=? WHERE id=?"); //prepare es un objeto que devuelve el statement
        //también se puede hacer VALUES (:edad, :apellido,:edad) y en  $stmt->bindParam(:nombre,$nombre)
        $stmt->bindParam(1,$_GET["nombre"]); //* vincula con el ? del VALUES
        $stmt->bindParam(2,$_GET["apellido"]);
        $stmt->bindParam(3,$_GET["edad"]);
        $stmt->bindParam(4,$_GET["id"]);
        $stmt->execute();
        session_destroy();
    
    }
    else{
        //echo "hola"; die;
    if ((isset($_GET["nombre"])) and (isset($_GET["apellido"])) and (isset($_GET["edad"]))){
        $nombre=$_GET["nombre"];
        $apellido=$_GET["apellido"];
        $edad=$_GET["edad"];
        try{
            
            echo "<br>";
            //$stmt es statement: es un objeto que devuelve un valor después que hacés el execute
            $stmt = $conn->prepare("INSERT INTO persona (nombre,apellido,edad) VALUES (?,?,?)"); //prepare es un objeto que devuelve el statement
            //también se puede hacer VALUES (:edad, :apellido,:edad) y en  $stmt->bindParam(:nombre,$nombre)
            $stmt->bindParam(1,$nombre); //* vincula con el ? del VALUES
            $stmt->bindParam(2,$apellido);
            $stmt->bindParam(3,$edad);
            $stmt->execute();
            //$stmt->close();
            
        } catch(PDOException $e){
            echo "conection failed" . $e->getMessage();
        }
    
    }
}
header("location: formulariojs.php");//para volver al formulario si no es ningunade las opciones
}

function mostrar(){
    include ('conexion.php');
    $stmt = $conn->prepare("SELECT * FROM persona WHERE id > 0");
    $stmt->execute();
    $datos=$stmt->fetchAll(PDO::FETCH_NUM);//fetchAll manda todo al array
    echo "<table>";
    // Agregar una fila para los encabezados
    echo "<tr>";
    echo "<td class='contenedor'><b>Nombre</b></td>";
    echo "<td class='titulo'><b>Apellido</b></td>";
    echo "<td class='titulo'><b>Edad</b></td>";
    echo "<td class='datos'></td>";
    echo "<td class='datos'></td>";
    echo "</tr>";
    // Iterar a través de los datos y mostrarlos en la tabla
    for ($i=0; $i<count($datos);$i++){
        echo "<tr>";
        echo "<td class='contenedor'>" . $datos[$i][1] . "</td>";
        echo "<td class='titulo'>" . $datos[$i][2] . "</td>";
        echo "<td class='titulo'>" . $datos[$i][3] . "</td>";
        echo "<td class='datos'><a href='acciones.php?accion=editar&id=".$datos[$i][0]."'>EDITAR</a></td>";
        echo "<td class='datos'><a href='acciones.php?accion=eliminar&id=".$datos[$i][0]."'>ELIMINAR</a></td>";
        echo "</tr>";
    }
    echo "</table>";
}



function editar($id){
    try{
        include ('conexion.php');
        echo "<br>";
        //$stmt es statement: es un objeto que devuelve un valor después que hacés el execute
        $stmt = $conn->prepare("SELECT * FROM persona WHERE id=?");
        $stmt->bindParam(1,$id);
        $stmt->execute();
        $vector = $stmt->fetchAll(PDO::FETCH_NUM);
        $_SESSION["nombre"]=$vector[0][1];
        $_SESSION["apellido"]=$vector[0][2];
        $_SESSION["edad"]=$vector[0][3];
        $_SESSION["id"]=$id;
        //var_dump($_SESSION);
        //$stmt->close();
        header("location: formulariojs.php");//para volver al formulario si no es ningunade las opciones
    } catch(PDOException $e){
        echo "conection failed" . $e->getMessage();
    }
}

function eliminar($id){
    try{
        include ('conexion.php');
        $stmt = $conn->prepare("DELETE FROM persona WHERE id = $id");
        $stmt->execute();
        $x=$stmt->rowCount();
        header("location: formulariojs.php");
        //header("location: acciones.php?accion=mostrar");
    } catch(PDOException $e){
        header("location: formulariojs.php?estado=2");
    }
}

switch($accion){
    case "guardar": guardar(); break;
    case "editar": editar($_GET["id"]); break;
    case "mostrar": mostrar(); break;
    case "eliminar": eliminar($_GET["id"]); break;
    default:
        header("location: formulariojs.php");
}


   

?>
<div style="text-align: center;">
<button class="boton" onclick="window.location.href='formulariojs.php'">Volver</button>
</div>

</html>