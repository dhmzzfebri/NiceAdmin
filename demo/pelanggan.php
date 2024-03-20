<?php
session_start();
require_once('koneksi.php');
if(!isset($_SESSION['username'])){
    header('location:login.php');
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
            <h1>Data Pelanggan</h1>
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
                            <h5 class="card-title">Tambah Pelanggan</h5>
                            <form class="row g-3" action="pelanggan_function.php" method="post">
                                <div class="col-md-12 mb-2">
                                    <input type="text" class="form-control" name="nama_plg" placeholder=" Nama Pelanggan">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" name=" alamat" placeholder="alamat">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="number" class="form-control" name=" no_tlp" placeholder="No Telp">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="tambah_pelanggan">Tambah </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Pelanggan</h5>
                            <table class="table table-bordered border-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Pelanggan</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">No telphone</th>
                                        <th scope="col">Tombol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambilsemuadata = mysqli_query($conn,  "select * from pelanggan order by nama_plg DESC ");
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadata)) {
                                        $id_plg = $data['id_plg'];
                                        $nama = $data['nama_plg'];
                                        $alamat = $data['alamat'];
                                        $no_tlp = $data['no_tlp'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td><?= $alamat; ?></td>
                                            <td><?= $no_tlp; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#Edit<?= $id_plg; ?>"><i class=" ri-edit-2-line"></i></button>
                                                <a onclick="return confirm('Apakah anda yakin ingin menghapus?')" class="btn btn-danger" href="pelanggan_function.php?hapus_plg=<?= $id_plg ?>"><i class=" ri-delete-bin-2-line"></i></a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="Edit<?= $id_plg ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update User</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="row g-3" action="pelanggan_function.php" method="post">
                                                            <input type="hidden" name="id_plg" value="<?= $id_plg ?>">
                                                            <div class="col-md-12 mb-2 mt-2">
                                                                <input type="text" class="form-control" name="nama_plg" value="<?= $nama ?>" placeholder=" Nama Pelanggan">
                                                            </div>
                                                            <div class="col-md-12 mb-2">
                                                                <input type="text" class="form-control" name=" alamat" value="<?= $alamat ?>" placeholder="alamat">
                                                            </div>
                                                            <div class="col-md-12 mb-2 mt-2">
                                                                <input type="number" class="form-control" name="no_tlp" value="<?= $no_tlp ?>" placeholder=" No Telphone">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" name="update_pelanggan">Tambah </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                            </table>
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