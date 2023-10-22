<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?= URL ?>"> <img alt="image" src="<?= URL ?>public/img/logo.png" class="header-logo" /> <span class="logo-name">Otika</span>
      </a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Menu</li>
      <?php if ($this->data['tipo'] === 1 || $this->data['tipo'] === 2) : ?>
        <li class="dropdown">
          <a href="#" class="menu-toggle nav-link has-dropdown">
            <i data-feather="user"></i><span>Usuarios</span>
          </a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="<?= URL ?>usuario">Listado</a></li>
            <li><a class="nav-link" href="<?= URL ?>usuariotipos">Tipos</a></li>
          </ul>
        </li>
      <?php endif; ?>
      <li class="dropdown">
        <a href="<?= URL ?>cliente" class="nav-link">
          <i data-feather="users"></i><span>Clientes</span>
        </a>
      </li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <i data-feather="box"></i><span>Equipos</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="<?= URL ?>equipo">Listado</a></li>
          <li><a class="nav-link" href="<?= URL ?>tipo">Tipos</a></li>
          <li><a class="nav-link" href="<?= URL ?>marca">Marcas</a></li>
          <li><a class="nav-link" href="<?= URL ?>modelo">Modelos</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="<?= URL ?>reparacion" class="nav-link">
          <i data-feather="aperture"></i><span>Reparaciones</span>
        </a>
      </li>
      <?php if ($this->data['tipo'] === 1) : ?>
        <li class="dropdown">
          <a href="<?= URL ?>vista" class="nav-link">
            <i data-feather="aperture"></i><span>Vistas</span>
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </aside>
</div>