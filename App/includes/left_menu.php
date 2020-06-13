 <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
          <div class="menu_section">
            <h3>Geral</h3>
            <ul class="nav side-menu">
              <li><a href="../sistema/pagina-inicial.php"><i class="fa fa-home"></i> Página inicial</span></a>
                
              </li>
              <?php if($usuario['nivel'] == "Administrador"):  ?>
                <li><a><i class="fa fa-table"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="../usuario/cadastro-usuario.php">Cadastrar</a></li>
                    <li><a href="../usuario/buscar-usuarios.php">Buscar</a></li>
                    <li><a href="../usuario/usuarios-bloqueados.php">Listar bloqueados</a></li>
                  </ul>
                </li>
              <?php endif; ?>
              <li><a><i class="fa fa-edit"></i> Pesquisas <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                <?php if($usuario['nivel'] == "Administrador"): ?>
                  <li><a href="../pesquisa/cadastrar-pesquisa.php">Nova pesquisa</a></li> 
                  <li><a href="../pesquisa/buscar-pesquisa.php">Buscar pesquisa</a></li>
                <?php endif;?>
                  <li><a href="../usuario/verifica-usuario-pesquisa.php">Iniciar uma pesquisa</a></li>
                </ul>
              </li>
              <?php if($usuario['nivel'] == "Administrador"): ?>
                <li><a><i class="fa fa-clone"></i>Relatórios <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="../relatorio/resultado-pesquisa.php">Resultados de pesquisas</a></li>
                  </ul>
                </li>
              <?php endif;?>
            </ul>
          </div>
        </div>
        <!-- /sidebar menu -->

        
      </div>
    </div>
