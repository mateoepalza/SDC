<?php

$cliente = new Cliente($_SESSION['id']);

$cliente->getInfoBasic();

$categoria = new Categoria();
$categorias = $categoria->buscarTodo();

?>
<link rel="stylesheet" href="Vista/static/css/cliente.css">
<div class="container-fluid bg-white">
    <div class="row" style="height:100px;">

        <div class="col-lg-3 col-md-4 col-sm-1 col-1 ">

        </div>
        <div id="logoImg" class="col-lg-6 col-md-4 col-sm-5 col-3 ">

        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-8 row d-flex flex-row justify-content-center align-items-center ">
            <div class="menu-right">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo ($cliente->getNombre() != "") ? $cliente->getNombre() . " " . $cliente->getApellido() : $cliente->getCorreo(); ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </div>
            <div class="menu-right">
                <a class="btn btn-outline-light" style="border:0px;"><i class="fas fa-cart-arrow-down"></i></a>    
            </div>
            <div class="menu-right">
                <a class="btn btn-outline-primary" style="border:0px;" href="index.php?cerrarSesion=True"><i class="fas fa-sign-out-alt"></i></a>    
            </div>
            
            
            
            <!--<ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo ($cliente->getNombre() != "") ? $cliente->getNombre() . " " . $cliente->getApellido() : $cliente->getCorreo(); ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-light" style="border:0px;"><i class="fas fa-cart-arrow-down"></i></a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-primary" style="border:0px;" href="index.php?cerrarSesion=True"><i class="fas fa-sign-out-alt"></i></a>
                </li>
            </ul>-->
        </div>
    </div>

</div>
<nav id="navMain" class="navbar-expand-md border-top border-bottom">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav m-auto">
            <?php 
                foreach($categorias as $cate){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?pid=<?php echo base64_encode("") ?>&idCategoria=<?php $cate -> getIdCategoria() ?>"><?php echo $cate -> getNombre() ?></a>
                    </li>
                    <?php
                }
            ?>
        </ul>
    </div>
</nav>