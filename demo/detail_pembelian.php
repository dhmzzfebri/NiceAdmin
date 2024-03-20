<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['username'])) {
  header('location:login.php');
}

if (isset($_GET['id_psn'])) {
  $id_psn = $_GET['id_psn'];
  // ambil nama pelanggan
  $tampil_nama_plgn = mysqli_query($conn, "SELECT * FROM penjualan p, pelanggan plgn WHERE p.id_plg=plgn.id_plg AND p.id_penjualan='$id_psn'");
  if (mysqli_num_rows($tampil_nama_plgn) > 0) {
    $np = mysqli_fetch_array($tampil_nama_plgn);
    $nama_pelanggan = $np['nama_plg'];
  } else {
    $nama_pelanggan = "";
  }
} else {
  header("Location: pembelian.php");
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
      <h1>Data Pemebelian</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item active">Data Pembelian</li>
        </ol>
      </nav>
    </div>
    <div class="midde_cont">
      <!-- isi -->
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <form action="transaksi_function.php" method="post">
              <div class="modal-body">
                <!-- inpputttttt -->
                <label class="col-form-label" for="val-email">Pilih Barang :</label>
                <select name="id_produk" class="form-control">
                  <?php
                  $getbrg = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk NOT IN(SELECT id_produk FROM detail_penjualan WHERE id_penjualan='$id_psn')");
                  while ($plh_brg = mysqli_fetch_array($getbrg)) {
                    $id_produk = $plh_brg['id_produk'];
                    $nama_produk = $plh_brg['nama_produk'];
                    $stok = $plh_brg['stok'];
                  ?>
                    <option value="<?= $id_produk; ?>">
                      <?= $nama_produk; ?> - ( stok: <?= $stok; ?> )
                    </option>
                  <?php
                  }
                  ?>
                </select>
                <input type="number" class="form-control mt-3" name="jumlah" placeholder="Quantity" min="1">
                <input type="hidden" class="form-control mt-3" name="id_psn" value="<?= $id_psn; ?>">
                <!-- inpputttttt end -->
              </div>
              <div class="modal-footer mt-3 ">
                <button type="submit" class="btn btn-primary" name="add_brg_pesanan">Simpan</button>
              </div>
            </form>
            <!-- isi end -->
          </div>
        </div>
      </div>

      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="table_section padding_infor_info">
              <div class="table-responsive-sm">
                <table class="table table-bordered mt-3">
                  <thead class="thead-light">
                    <tr>
                      <th>#</th>
                      <th>Nama Barang</th>
                      <th>Id Barang</th>
                      <th>Harga Satuan</th>
                      <th>Quantity</th>
                      <th>Sub-Total</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $no = 0 ?>
                    <?php
                    $totalharga = 0;
                    $id_psn = $_GET['id_psn'];
                    $get = mysqli_query(
                      $conn,
                      "SELECT * FROM detail_penjualan p, produk br WHERE p.id_produk=br.id_produk AND id_penjualan='$id_psn'"
                    );
                    while ($p = mysqli_fetch_array($get)) {
                      $id_detail = $p['id_detail'];
                      $id_psn = $p['id_penjualan'];
                      $id = $p['id_produk'];
                      $jumlah = $p['jumlah'];
                      $harga = $p['harga'];
                      $nama = $p['nama_produk'];
                      $subtotal = $jumlah * $harga;
                      $totalharga += $subtotal;
                      //hitung kembalian

                    ?>
                      <?php $no++ ?>
                      <tr>
                        <td scope="row"><?= $no; ?></td>
                        <td><?= $nama ?></td>
                        <td><?= $id ?></td>
                        <td><?= number_format($harga) ?></td>
                        <td><?= $jumlah ?></td>
                        <td>Rp.<?= number_format($subtotal) ?></td>
                        <td class="text-white">
                          <!-- hapus -->
                          <form action="transaksi_function.php" method="post">
                            <input type="hidden" name="id_psn" value="<?= $id_psn ?>">
                            <input type="hidden" name="id_detail" value="<?= $id_detail ?>">
                            <button class="btn btn-danger" name="hapus_detail" type="submit"><i class=" ri-delete-bin-2-line"></i></button>
                          </form>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <hr>

                <form class="row g-3" action="transaksi_function.php" method="post">
                  <input type="hidden" name="id_psn" value="<?= $_GET['id_psn'] ?>">
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Total Harga</label>
                    <input type="text" name="totalharga" class="form-control" id="inputEmail4" value="<?= number_format($totalharga, 0, ',', '.') ?>" readonly>
                  </div>
                  <div class="col-md-6">
                    <label for="inputPassword4" class="form-label">Bayar</label>
                    <input type="number" class="form-control" name="bayar" value="0" id="inputPassword4" required>
                  </div>
                  <div class="col-md-1 mt-5">
                    <button type="submit" name="hitung_bayar" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    </div>
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