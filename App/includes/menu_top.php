<div class="top_nav">
      <div class="nav_menu">
          <div class="nav toggle">
            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
          </div>
          <nav class="nav navbar-nav">
          <ul class=" navbar-right">
            <li class="nav-item dropdown open" style="padding-left: 15px;">
              <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                <img src="images/img.jpg" alt=""><?php echo $usuario['nome'] ?>
              </a>
              <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"  href="editar-dados.php?id=<?php echo $usuario['id']?>"> Editar dados</a>
                  <a class="dropdown-item"  href="configuracoes.php">
                    <span class="badge bg-red pull-right">50%</span>
                    <span>Configuracoes</span>
                  </a>
              <a class="dropdown-item"  href="javascript:;">Ajuda</a>
                <a class="dropdown-item"  href="../Controller/logout.php"><i class="fa fa-sign-out pull-right"></i> Sair</a>
              </div>
            </li>
          </ul>
        </nav>
      </div>
    </div>