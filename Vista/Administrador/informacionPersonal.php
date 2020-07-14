<?php

$idAdmin = $_SESSION['id'];

if (isset($_POST['actualizarInfoAdministrador'])) {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $oldUrl = $_POST['url_hidden'];
    $archivo = $_FILES['archivo']['name'];

    $cliente = new Cliente("", "", "", $correo);
    $inventarista = new Inventarista("", "", "", $correo);
    $administrador = new Administrador($idAdmin);
    $administrador->getInfoBasic();

    if ($administrador->getCorreo() != $correo && ($inventarista->existeCorreo() || $cliente->existeCorreo() || $administrador->existeNuevoCorreo($correo))) {

        $msj = "El correo proporcionado ya se encuentra en uso.";
        $class = "alert-danger";
    } else {

        if (isset($archivo) && $archivo != "") {

            $archivo = date("Y_m_d_H_i_s_") . $archivo;

            $tipo = $_FILES['archivo']['type'];
            $tamano = $_FILES['archivo']['size'];
            $temp = $_FILES['archivo']['tmp_name'];
            $url = 'static/img/Users/' . $archivo;

            if (!((strpos($tipo, "gif") || strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png")) && ($tamano < 9000000))) {

                $class = "alert-danger";
                $msj = "El tipo de archivo no es valido o el tamañano es demasiado grande";
            } else {
                if (move_uploaded_file($temp, $url)) {

                    if (file_exists($oldUrl)) {
                        unlink(trim($oldUrl));
                    }

                    $administrador = new Administrador($idAdmin, $nombre, $apellido, $correo, "", trim($url));

                    $resInsert = $administrador->actualizarAdministrador();

                    if ($resInsert == 1) {

                        /**
                         * Creo un objeto para retornar el dia y la hora
                         */
                        $date = new DateTime();

                        if ($_SESSION['rol'] == 1) {
                            /**
                             * Creo el objeto de log
                             */
                            $logAdmin = new LogAdmin("", $date->format('Y-m-d H:i:s'), LogHActualizarAdministrador($idAdmin, $nombre, $apellido, $correo, $url), 22, getBrowser(), getOS(), $_SESSION['id']);
                            /**
                             * Inserto el registro del log
                             */
                            $logAdmin->insertar();

                            /**
                             * Log para el Inventarista
                             */
                        }

                        $class = "alert-success";
                        $msj = "La información de ha actualizado correctamente.";
                    } else if ($resInsert == 0) {
                        $class = "alert-warning";
                        $msj = "No se ha modificado ningún valor.";
                    } else {
                        $class = "alert-danger";
                        $msj = "Ocurrió algo inesperado";
                    }
                } else {
                    $class = "alert-danger";
                    $msj = "Ocurrió algo inesperado";
                }
            }
        } else {

            $administrador = new Administrador($idAdmin, $nombre, $apellido, $correo, "", trim($oldUrl));

            $resInsert = $administrador->actualizarAdministrador();

            if ($resInsert == 1) {
                /**
                 * Creo un objeto para retornar el dia y la hora
                 */
                $date = new DateTime();

                if ($_SESSION['rol'] == 1) {
                    /**
                     * Creo el objeto de log
                     */
                    $logAdmin = new LogAdmin("", $date->format('Y-m-d H:i:s'), LogHActualizarAdministrador($idAdmin, $nombre, $apellido, $correo, $oldUrl), 22, getBrowser(), getOS(), $_SESSION['id']);
                    /**
                     * Inserto el registro del log
                     */
                    $logAdmin->insertar();

                    /**
                     * Log para el Inventarista
                     */
                }

                $class = "alert-success";
                $msj = "La información de ha actualizado correctamente.";
            } else if ($resInsert == 0) {
                $class = "alert-warning";
                $msj = "No se ha modificado ningún valor.";
            } else {
                $class = "alert-danger";
                $msj = "Ocurrió algo inesperado";
            }
        }
    }

    include "Vista/Main/error.php";
} else {

    $administrador = new Administrador($idAdmin);
    $administrador->getInfoBasic();
}


?>

<div class="container  mt-5 mb-5">
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-8 form-personal">
            <form novalidate class="needs-validation" action="index.php?pid=<?php echo base64_encode("Vista/Administrador/informacionPersonal.php") ?>" method=POST enctype="multipart/form-data">
                <div class="form-title">
                    <h1>Información Personal</h1>
                </div>
                <div class="row d-flex flex-row justify-content-center mb-5">
                    <div style="border-radius: 500px; overflow:hidden; width: 200px; height: 200px; background-image: url('<?php echo ($administrador->getFoto() != "") ? $administrador->getFoto() : "static/img/users/basic.png"; ?>'); background-repeat: no-repeat; background-position: center; background-size: cover;">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label>Nombre</label>
                        <input type="text" name="nombre" value="<?php echo $administrador->getNombre() ?>" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor ingrese su nombre.
                        </div>
                        <div class="valid-feedback">
                            ¡Enhorabuena!
                        </div>
                    </div>
                    <div class="col-6">
                        <label>Apellido</label>
                        <input type="text" name="apellido" value="<?php echo $administrador->getApellido() ?>" class="form-control" required>
                        <div class="invalid-feedback">
                            Por favor ingrese su apellido.
                        </div>
                        <div class="valid-feedback">
                            ¡Enhorabuena!
                        </div>
                    </div>
                </div>
                <div class="form-group mt-4">
                    <label>Correo</label>
                    <input type="email" name="correo" value="<?php echo $administrador->getCorreo() ?>" class="form-control" required>
                    <div class="invalid-feedback">
                        Por favor ingrese su correo.
                    </div>
                    <div class="valid-feedback">
                        ¡Enhorabuena!
                    </div>
                </div>
                <div class="form-group mt-4">

                    <label>Actualizar foto</label>
                    <input type="hidden" name="url_hidden" value="<?php echo $administrador->getFoto() ?> ">

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" name="archivo" class="custom-file-input" id="imageUpload">
                            <label class="custom-file-label" for="imageUpload">Choose file</label>
                        </div>
                    </div>

                </div>
                <div class="form-group mt-5">
                    <button type="submit" name="actualizarInfoAdministrador" class="btn btn-primary w-100">Actualizar información</button>
                </div>
            </form>
        </div>
    </div>
</div>