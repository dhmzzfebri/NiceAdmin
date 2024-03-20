<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link collapsed" href="index.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link collapsed" href="pembelian.php">
        <i class="bi bi-card-list"></i>
        <span>Transaksi</span>
      </a>
    </li><!-- End Dashboard Nav -->
    <?php if (($_SESSION['level'] == "admin")) { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="produk.php">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Produk</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse">
          <i class="bi bi-menu-button-wide"></i><span>Petugas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="register.php">
              <i class="bi bi-circle"></i><span>Register</span>
            </a>
          </li>
          <li>
            <a href="components-accordion.html">
              <i class="bi bi-circle"></i><span>Laporan</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Customer</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="pelanggan.php">
              <i class="bi bi-circle"></i><span>Data Pelanggan</span>
            </a>
          </li>
        </ul>
      </li><!-- End Forms Nav -->
    <?php } else { ?>
      <li class="nav-item">
        <a class="nav-link collapsed" href="pelanggan.php">
          <i class="bi bi-person"></i>
          <span>Customer</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="produk.php">
          <i class="bi bi-bar-chart"></i>
          <span>Product</span>
        </a>
      </li>
    <?php } ?>
  </ul>

</aside>