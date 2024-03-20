<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['username'])) {
  header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php
  require_once('assets/layout/css.php');
  ?>
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <?php
    require_once('assets/layout/navbar.php');
    ?>

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php
  require_once('assets/layout/sidebar.php');
  ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Data Transaksi</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Blank</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <!-- Sale & Revenue Start -->
              <div class="container-fluid mb-3">
                <h2 class="mt-4">Data Pembelian</h2>
                <button class="btn btn-primary  " type="button" data-bs-toggle="modal" data-bs-target="#basicModal"><i class=" bi bi-plus-circle"> Pilih Pelanggan</i></button>
              </div>
              <!-- Modal -->
              <div class="modal fade" id="basicModal" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Pilih Pelanggan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form class="row g-3" action="transaksi_function.php" method="post">

                        <div class="col-md-12">
                          <select id="inputState" name="id_plg" class="form-select">
                            <?php
                            $getpelanggan = mysqli_query($conn, "SELECT * FROM pelanggan");
                            while ($plgn = mysqli_fetch_array($getpelanggan)) {
                              $id_plg = $plgn['id_plg'];
                              $nama_plg = $plgn['nama_plg'];
                              $alamat = $plgn['alamat'];
                            ?>
                              <option value="<?= $id_plg; ?>"><?= $nama_plg; ?> - <?= $alamat; ?></option>
                            <?php } ?>
                          </select>
                        </div>

                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary" name="tambah_pesanan">Tambah </button>
                        </div>
                      </form>
                    </div>

                  </div>
                </div>
              </div>


              <table class="table table-bordered">
                <tr>
                  <th>No</th>
                  <th>Tanggal Penjualan</th>
                  <th>Pelanggan</th>
                  <th>Total Harga</th>
                  <th>Aksi</th>
                </tr>

                <?php
                $query = mysqli_query($conn, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_plg = penjualan.id_plg");
                $no = 1;
                while ($data = mysqli_fetch_array($query)) {
                ?>
                  <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $data['tanggal']; ?></td>
                    <td><?php echo $data['nama_plg']; ?></td>
                    <td><?php echo $data['total_harga']; ?></td>
                    <td>
                      <a href="detail.php?id=<?php echo $data['id_penjualan']; ?>" class="btn btn-info">Detail</a>
                      <a onclick="return confirm('Apakah anda yakin ingin menghapus?')" class="btn btn-danger" href="transaksi_function.php?hapus_detailpenjualan=<?= $data['id_penjualan']; ?>"><i class=" ri-delete-bin-2-line"></i></a>
                    </td>
                  </tr>
                <?php } ?>
              </table>
            </div>
            <!-- Sale & Revenue End -->
          </div>
        </div>

      </div>
      </div>
    </section>


  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <?php
  require_once('assets/layout/js.php');
  ?>

</body>

</html>