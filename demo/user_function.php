<?php
session_start();
 require_once('koneksi.php');
 if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $hasil = mysqli_query($conn, $query);
    if (mysqli_num_rows($hasil) == 1) {
        $data = mysqli_fetch_assoc($hasil);
        $_SESSION['username'] = $data['username'];
        $_SESSION['level'] = $data['level'];
        header("Location: index.php");
    } else {
        echo "<script> alert('Username/password tidak ditemukan');
        window.location.replace('login.php'); </script>";
    }
}

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $level = $_POST['level'];
    $password = md5($_POST['password']);
    $query = "INSERT INTO user (nama,username, password, level) VALUES ('$nama','$username', '$password', '$level')";
    mysqli_query($conn, $query);
    header("Location: register.php");
}

if (isset($_POST['update_user'])) {
    $id_user= $_POST['id_username'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $level = $_POST['level'];
    $query = "UPDATE user SET username = '$username',password = '$password',level = '$level'
    WHERE id_user = '$id_user'";
    if(mysqli_query($conn, $query)){
        echo "<script> alert('Username Berhasil Diedit'); </script>";
        echo "<script> window.location.href= 'register.php' </script>";
    } else{
        echo "Gagal mengedit user";
    }
}

if (isset($_GET['hapus_user'])) {
    $id_user = $_GET['hapus_user'];
    $query = "DELETE FROM user where id_user='$id_user' ";
    if (mysqli_query($conn, $query)) {
        echo "<script> window.location.href= 'register.php' </script>";
    } else {
        echo "<script> alert('Produk gagal Dihapus'); </script>";
    }
}
?>