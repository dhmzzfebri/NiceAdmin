<?php
session_start();
require_once('koneksi.php');
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
if (isset($_GET['id_psn'])) {
    $id_psn = $_GET['id_psn'];
    // ambil nama pelanggan
    $tampil_nama_plgn = mysqli_query($conn, "SELECT * FROM penjualan p, pelanggan plgn WHERE p.id_plg=plgn.id_plg AND p.id_penjualan='$id_psn'");
    if (mysqli_num_rows($tampil_nama_plgn) > 0) {
        $np = mysqli_fetch_array($tampil_nama_plgn);
        $nm_plgn = $np['nama_plg'];
    } else {
        $nm_plgn = "";
    }
} else {
    header("Location: pembelian.php");
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Nota Pembelian</title>
    <style>
        .print-button {
            display: block;
        }

        /* Tombol cetak disembunyikan saat dicetak */
        @media print {
            .print-button {
                display: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        p {
            font-weight: bold;
        }

        h2 {
            text-align: center;
        }

        h3 {
            margin-top: 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f2f2f2;
        }

        .td1 {
            text-align: right;
        }

        #thx {
            text-align: center;
            font-weight: bold;
            font-family: 'Oswald', sans-serif;
        }
    </style>
</head>

<body>
    <h2>BUKTI PEMBELIAN</h2>
    <h3>Toko</h3><br>

    <h4>Id pesanan : <?= $id_psn ?></h2>
        <h4>Nama Pelanggan : <?= $nm_plgn ?></h2>
            <table>
                <tr>
                    <th>#</th>
                    <th>Nama Barang</th>
                    <th>Harga Barang</th>
                    <th>Jumlah Beli</th>
                    <th>Total Harga</th>
                </tr>
                <?php $no = 0 ?>
                <?php
                $totalharga = 0;
                $get = mysqli_query(
                    $conn,
                    "SELECT *
            FROM detail_penjualan AS dp
            JOIN produk AS pr ON dp.id_produk = pr.id_produk
            JOIN penjualan AS pe ON dp.id_penjualan = pe.id_penjualan
            WHERE dp.id_penjualan = '$id_psn';
            "
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
                <tr>
                    <th colspan="4" class="td1">Total Harga </th>
                    <th>Rp.<?= number_format($totalharga) ?></th>
                </tr>
            </table>
            <p>Total Harga: Rp. <?= number_format($totalharga) ?></p>
            <p>Jumlah Bayar: Rp. <?= number_format($bayar, 0, ',', '.') ?></p>
            <p>Kembalian: Rp. <?= number_format($kembalian, 0, ',', '.') ?></p> <br>

            <h3 id="thx">Terima kasih atas pesanannya !</h3><br>
            <div class="" style="display: flex; justify-content: center;">
                <button class="print-button" style="width: 100px; height: 30px; background-color: blue; color: #f2f2f2;" onclick="printPage()">Cetak</button>
                <a class="print-button" style=" text-align: center; margin-left: 10px; width: 100px; height: 30px; background-color: green; color: #f2f2f2;" href="pembelian.php">selesai</a>
            </div>
            <script>
                function printPage() {
                    window.print();
                }
            </script>
</body>

</html>