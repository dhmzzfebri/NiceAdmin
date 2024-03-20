<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['username'])) {
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
            <h1>Data Petugas</h1>
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
                            <h5 class="card-title">Tambah Petugas</h5>

                            <form class="row g-3" action="user_function.php" method="post">
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" name="nama" placeholder=" Nama Petugas">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" name="username" placeholder=" Username">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" name=" password" placeholder="Password">
                                </div>
                                <div class="col-md-6">
                                    <select name="level" class="form-select form-control">
                                        <option value="kasir">Kasir</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="register">Tambah </button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Data Petugas</h5>
                            <table class="table table-bordered border-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Petugas</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Level</th>
                                        <th scope="col">Tombol</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ambilsemuadata = mysqli_query($conn,  "select * from user order by username DESC ");
                                    $no = 1;
                                    while ($data = mysqli_fetch_array($ambilsemuadata)) {
                                        $id_user = $data['id_user'];
                                        $nama = $data['nama'];
                                        $username = $data['username'];
                                        $level = $data['level'];
                                    ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $nama; ?></td>
                                            <td><?= $username; ?></td>
                                            <td><?= $level; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#Edit<?= $id_user ?> "><i class=" ri-edit-2-line"></i></button>
                                                <a onclick="return confirm('Apakah anda yakin ingin menghapus?')" class="btn btn-danger" href="user_function.php?hapus_user=<?= $id_user ?>"><i class=" ri-delete-bin-2-line"></i></a>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="Edit<?= $id_user; ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update User</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="row g-3" action="user_function.php" method="post">
                                                            <input type="hidden" name="id_username" value="<?= $id_user ?>">
                                                            <div class="col-md-6 mb-2 mt-2">
                                                                <input type="text" class="form-control" name="username" value="<?= $nama ?>" placeholder=" Nama">
                                                            </div>
                                                            <div class="col-md-6 mb-2 mt-2">
                                                                <input type="text" class="form-control" name="username" value="<?= $username ?>" placeholder=" Username">
                                                            </div>
                                                            <div class="col-md-6 mb-2">
                                                                <input type="text" class="form-control" name=" password" placeholder="Password">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <select name="level" class="form-select form-control">
                                                                    <option value="Kasir" <?php if ($level == 'petugas') echo 'selected'; ?>>Kasir</option>
                                                                    <option value="Admin" <?php if ($level == 'admin') echo 'selected'; ?>>Admin</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" name="update_user">Tambah </button>
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