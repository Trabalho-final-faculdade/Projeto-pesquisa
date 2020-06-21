<div class="top_nav">
      <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
          <ul class=" navbar-right">
            <li class="nav-item dropdown open" style="padding-left: 15px;">
              <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
              <img src="../../Public/imagens/<?php echo  $usuario['foto']?>" class="profile_img" /><br /><?php echo $usuario['nome'] ?>
              </a>
              <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"  href="../usuario/editar-dados.php?id=<?php echo $_SESSION['id']?>"> Editar dados</a>
              <?php if($usuario['nivel'] == "Administrador"): ?>  
                <a class="dropdown-item"  href="../sistema/configuracoes.php">
                    <span>Configuracoes</span>
                </a>
              <?php endif; ?>
              <a class="dropdown-item"  href="../../Controller/sistema_controller/logout.php"><i class="fa fa-sign-out pull-right"></i> Sair</a>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>