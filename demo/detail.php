<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['username'])) {
    header('location:login.php');
}

$id = $_GET['id'];
$kd_penjualan = $_GET['kd_penjualan'];
$query = mysqli_query($conn, "SELECT * FROM penjualan LEFT JOIN pelanggan ON pelanggan.id_plg = penjualan.id_plg WHERE id_penjualan = $id");
$data = mysqli_fetch_array($query);
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
            <h1>Data Produk</h1>
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
                            <div class="container-fluid">
                                <h2 class="mt-4">Detail pembelian</h2>
                                <br><br>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                            <tr>
                                                <td width="200">Nama Pelanggan</td>
                                                <td width="1">:</td>
                                                <td>
                                                    <?php echo $data['nama_plg']; ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $pr = mysqli_query($conn, "SELECT * FROM detail_penjualan JOIN produk ON produk.id_produk = detail_penjualan.id_produk WHERE id_detail = '$id'");
                                            while ($prod = mysqli_fetch_array($pr)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $prod['nama_produk']; ?></td>
                                                    <td>:</td>
                                                    <td>
                                                        Harga Satuan : <?php echo $prod['harga']; ?><br>
                                                        Jumlah : <?php echo $prod['jumlah']; ?><br>
                                                        Sub Total : <?php echo $prod['sub_total']; ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="table_section padding_infor_info">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nama Barang</th>
                                                    <th>Harga Barang</th>
                                                    <th>Jumlah Beli</th>
                                                    <th>Total Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 0 ?>
                                                <?php
                                                $totalharga = 0;
                                                $get = mysqli_query(
                                                    $conn,
                                                    "SELECT * FROM detail_penjualan AS dp JOIN produk AS pr ON dp.id_produk = pr.id_produk JOIN penjualan AS pe ON dp.id_penjualan = pe.id_penjualan WHERE dp.id_penjualan = '$id'; "
                                                );
                                                while ($p = mysqli_fetch_array($get)) {
                                                    $id_detailpesanan = $p['id_detail'];
                                                    $jumlah = $p['jumlah'];
                                                    $harga = $p['harga'];
                                                    $nama_produk = $p['nama_produk'];
                                                    $subtotal = $p['sub_total'];
                                                    $totalharga = $p['total_harga'];
                                                    $bayar = $p['bayar'];
                                                    $kembalian = $bayar - $totalharga;
                                                    //hitung kembalian

                                                ?>
                                                    <?php $no++ ?>
                                                    <tr>
                                                        <td scope="row"><?= $no; ?></td>
                                                        <td><?= $nama_produk ?></td>
                                                        <td><?= number_format($harga) ?></td>
                                                        <td><?= $jumlah ?></td>
                                                        <td>Rp.<?= number_format($subtotal) ?></td>
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