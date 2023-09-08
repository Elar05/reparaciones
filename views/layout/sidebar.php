<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="<?= URL ?>"> <img alt="image" src="<?= URL ?>public/img/logo.png" class="header-logo" /> <span class="logo-name">Otika</span>
      </a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Menu</li>
      <li class="dropdown">
        <a href="#" class="menu-toggle nav-link has-dropdown">
          <i data-feather="user"></i><span>Usuarios</span>
        </a>
        <ul class="dropdown-menu">
          <li><a class="nav-link" href="<?= URL ?>usuario">Listado</a></li>
          <li><a class="nav-link" href="<?= URL ?>usuariotipos">Tipos</a></li>
        </ul>
      </li>
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
          <li><a class="nav-link" href="<?= URL ?>equipotipos">Tipos</a></li>
        </ul>
      </li>
    </ul>
  </aside>
</div>