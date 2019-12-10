<?php
//Headers del WS
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-With");
header('Content-Type: application/json; Charset=UTF-8');

include "config/database.php";

$mysqli = new database();

$conect = $mysqli->conectar('xtecuasc_repertorio');

$postjson = json_decode(file_get_contents('php://input'), true);

$conect->set_charset("utf8");

if($postjson['tipoMov'] == "login"){
    $query = mysqli_query($conect, "SELECT * FROM usuarios");
    
    $check = mysqli_num_rows($query);


if($check>0){
    $data = mysqli_fetch_array($query);

    $data = array(
        'id' => $data['id'],
        'nombre' => $data['nombre']
    );

$result = json_encode(array('success'=> true, 'result' => $data));
}else{
    $result = json_encode(array('success'=> false, 'msg' => 'No hay datos'));
    }
    echo $result;
} elseif ($postjson['tipoMov'] == 'getData2') {
    $query = mysqli_query($conect, "select * from usuarios");

    $check = mysqli_num_rows($query);
    
    if($check > 0) {
        while ($object = $query->fetch_object()) {
            $datos[] = $object;
        }
        $result = json_encode(array('success' => true, 'result' => $datos));
    } else {
        $result = json_encode(array('success' => false, 'msg' => 'No hay datos'));
    }
  
    echo $result;
}
//Cerramos la conexion
$mysqli->desconectar();
?>
