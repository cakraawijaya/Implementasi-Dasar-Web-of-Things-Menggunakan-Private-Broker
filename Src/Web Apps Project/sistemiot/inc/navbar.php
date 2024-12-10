<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <?php if (!isset($_GET['page']) || $_GET['page'] == "dashboard") { ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link" id="status" style="color:red;"><i class="fas fa-wifi mr-2"></i><b>Server:</b> Terputus</a>
      </li>
    <?php } ?>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link"><i class="fas fa-address-card mr-2"></i>Profil Saya</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link"><i class="fas fa-phone-alt mr-2"></i>Kontak</a>
    </li>
  </ul>  
</nav>