<?php
require_once('koneksi.php');
if (isset($_POST['tambah_pelanggan'])) {
    $nama_plg = $_POST['nama_plg'];
    $alamat = $_POST['alamat'];
    $no_tlp = $_POST['no_tlp'];
    $query = "INSERT INTO pelanggan ( nama_plg, alamat, no_tlp) VALUES ( '$nama_plg', '$alamat', '$no_tlp')";
    if (mysqli_query($conn, $query)) {
        echo "<script> alert('Pelanggan Berhasil Ditambahkan'); </script>";
        header("location:pelanggan.php");
    } else {
        echo '<script>alert("tambah pelanggan gagal")</script>';
    }
}

if (isset($_POST['update_pelanggan'])) {
    $id_plg= $_POST['id_plg'];
    $nama_plg = $_POST['nama_plg'];
    $alamat = $_POST['alamat'];
    $no_tlp = $_POST['no_tlp'];
    $query = "UPDATE pelanggan SET nama_plg = '$nama_plg',alamat = '$alamat',no_tlp = '$no_tlp'
    WHERE id_plg = '$id_plg'";
    if(mysqli_query($conn, $query)){
        echo "<script> alert('Pelanggan Berhasil Diedit'); </script>";
        echo "<script> window.location.href= 'pelanggan.php' </script>";
    } else{
        echo "Gagal mengedit user";
    }
}

if (isset($_GET['hapus_plg'])) {
    $id_plg = $_GET['hapus_plg'];
    $query = "DELETE FROM pelanggan where id_plg='$id_plg' ";
    if (mysqli_query($conn, $query)) {
        echo "<script> window.location.href= 'pelanggan.php' </script>";
    } else {
        echo "<script> alert('Produk gagal Dihapus'); </script>";
    }
}
?>