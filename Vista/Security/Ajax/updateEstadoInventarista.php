<?php 
$idInventarista = $_POST['idCliente'];
$estado = $_POST['estado'];

$inventarista = new Inventarista($idInventarista,"","","","","",$estado);

$res = $inventarista -> updateEstado();
$ajax = Array();

if($res == 1){
    $ajax['status'] = true; 
    $ajax['msj'] = "El estado ha sido actualizado correctamente";
}else{
    $ajax['status'] = false;
    $ajax['msj'] = "Hubo un inconveniente, por favor intente denuevo";
}
echo json_encode($ajax);

?>