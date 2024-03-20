<?php
require_once('koneksi.php');
if (isset($_POST['tambah_produk'])) {
    $kd = $_POST['kd_produk'];
    $nama_produk = $_POST['nama_produk'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $query = "INSERT INTO produk ( kd_produk, nama_produk, stok, harga) VALUES ( '$kd', '$nama_produk', '$stok', '$harga')";
    if (mysqli_query($conn, $query)) {
        echo "<script> alert('Produk Berhasil Ditambahkan'); </script>";
        header("location:produk.php");
    } else {
        echo '<script>alert("tambah Produk gagal")</script>';
    }
}

if (isset($_GET['hapus_produk'])) {
    $id_produk = $_GET['hapus_produk'];
    $query = "DELETE FROM produk where id_produk='$id_produk' ";
    if (mysqli_query($conn, $query)) {
        echo "<script> window.location.href= 'produk.php' </script>";
    } else {
        echo "<script> alert('Produk gagal Dihapus'); </script>";
    }
}

if (isset($_POST['update_Produk'])) {
    $idp = $_POST['id_produk'];
    $nama_produk = $_POST['nama_produk'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];
    $query = "UPDATE produk SET nama_produk = '$nama_produk',stok = '$stok',harga = '$harga'
    WHERE id_produk = '$idp'";
    if (mysqli_query($conn, $query)) {
        echo "<script> alert('Barang Berhasil Diedit'); </script>";
        echo "<script> window.location.href= 'produk.php' </script>";
    } else {
        echo "Gagal mengedit barang";
    }
}


if (isset($_POST['tambah_pesanan'])) {
    $id_plg = $_POST['id_plg'];
    $query = "INSERT INTO penjualan (id_plg) VALUES ('$id_plg')";

    if (mysqli_query($conn, $query)) {
        // Mendapatkan ID pesanan yang baru ditambahkan
        $id_pesanan = mysqli_insert_id($conn);

        echo "<script> alert('Pemesan Berhasil Ditambahkan'); </script>";

        // Arahkan pengguna ke halaman _view.php?id_psn=<ID_PESANAN>
        echo "<script> window.location.href= 'detail_pembelian.php?id_psn=" . $id_pesanan . "' </script>";
    } else {
        echo "Gagal menambah orderan/pesanan";
    }
}

if (isset($_POST['add_brg_pesanan'])) {
    // Mengambil data dari form
    $id_produk = $_POST['id_produk'];
    $id_psn = $_POST['id_psn'];
    $jumlah = $_POST['jumlah'];


    // Menghitung stok sekarang
    $query_hitung_stok = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk='$id_produk'");
    $data_stok = mysqli_fetch_array($query_hitung_stok);
    $stok_sekarang = $data_stok['stok'];
    $harga = $data_stok['harga'];


    // Memeriksa apakah stok mencukupi
    if ($stok_sekarang >= $jumlah) {
        // Mengurangi stok
        $sisa_stok = $stok_sekarang - $jumlah;
        $subtotal = $jumlah * $harga;

        // Menambahkan detail penjualan
        $query_insert_detail = "INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah,sub_total) VALUES ('$id_psn', '$id_produk', '$jumlah','$subtotal')";

        // Mengupdate stok produk
        $query_update_stok = "UPDATE produk SET stok='$sisa_stok' WHERE id_produk='$id_produk'";

        // Eksekusi query insert dan update
        $insert_result = mysqli_query($conn, $query_insert_detail);
        $update_result = mysqli_query($conn, $query_update_stok);

        // Memeriksa apakah query berhasil dieksekusi
        if ($insert_result && $update_result) {
            echo "<script> alert('Barang Pesanan Berhasil Ditambahkan'); window.location.href='detail_pembelian.php?id_psn=$id_psn';</script>";
        } else {
            echo "<script> alert('Gagal menambah barang pesanan'); window.location.href='detail_pembelian.php?id_psn=$id_psn';</script>";
        }
    } else {
        // Jika stok tidak mencukupi
        echo "<script> alert('Gagal menambah barang pesanan'); window.location.href='detail_pembelian.php?id_psn=$id_psn';</script>";
    }
}

if (isset($_POST['hapus_detail'])) {
    $id_detail = $_POST['id_detail'];
    $id_psn = $_POST['id_psn'];


    $query_barang = "SELECT id_produk, jumlah FROM detail_penjualan WHERE id_detail='$id_detail'";
    $result_barang = mysqli_query($conn, $query_barang);
    $barang = mysqli_fetch_assoc($result_barang);

    $id_produk = $barang['id_produk'];
    $jumlah = $barang['jumlah'];

    $query_hapus = "DELETE FROM detail_penjualan WHERE id_detail='$id_detail' ";
    if (mysqli_query($conn, $query_hapus)) {
        // Mengembalikan stok barang yang dihapus
        $query_update = "UPDATE produk SET stok = stok + '$jumlah' WHERE id_produk='$id_produk'";
        if (mysqli_query($conn, $query_update)) {
            echo "<script> alert('Berhasil Dihapus'); </script>";
            echo "<script> window.location.href= 'detail_pembelian.php?id_psn=$id_psn'; </script>";
            exit;
        } else {
            echo "Gagal mengembalikan stok";
        }
    } else {
        echo "Gagal menghapus";
    }
}

if (isset($_POST['hitung_bayar'])) {
    $id_psn = $_POST['id_psn'];
    $bayar = $_POST['bayar'];
    $query = mysqli_query($conn, "SELECT SUM(sub_total) AS total_subtotal FROM detail_penjualan WHERE id_penjualan='$id_psn'");
    $data = mysqli_fetch_assoc($query);
    $total_subtotal = $data['total_subtotal'];
    $kembalian = $bayar - $total_subtotal;
    if ($bayar < $total_subtotal) {
        echo "<script> alert('Uang Kurang! Tolong masukan uang yang pas'); </script>";
        echo "<script> window.location.href = 'detail_pembelian.php?id_psn=$id_psn'; </script>";
    } else {
        $query_update_stok = "UPDATE penjualan SET total_harga='$total_subtotal', bayar='$bayar' WHERE id_penjualan='$id_psn'";
        $update_result = mysqli_query($conn, $query_update_stok);
        echo "<script> alert('Pembayaran berhasil!'); </script>";
        echo "<script> window.location.href = 'nota.php?id_psn=$id_psn'; </script>";
    }
}

if (isset($_GET['hapus_detailpenjualan'])) {
    $id= $_GET['hapus_detailpenjualan'];
    $query = "DELETE FROM penjualan where id_penjualan='$id' ";
    if (mysqli_query($conn, $query)) {
        echo "<script> window.location.href= 'pembelian.php' </script>";
    } else {
        echo "<script> alert('Produk gagal Dihapus'); </script>";
    }
    
    $query1 = "DELETE FROM detail_penjualan where id_penjualan='$id' ";
    if (mysqli_query($conn, $query1)) {
        echo "<script> window.location.href= 'pembelian.php' </script>";
    } else {
        echo "<script> alert('Produk gagal Dihapus'); </script>";
    }
}
