<?php
include '../../koneksi.php';
session_start();
if ($_SESSION['status'] != "sudah_login") {
    header("location:../../login.php");
    die;
} elseif ($_SESSION['level'] != "admin") {
    header("location:../../user/index.php");
    die;
}
if (!isset($_POST['submit'])) {
    echo '<a href="https://instagram.com/al_nv23">Report Here</a><br>';
    die('Go-To Hell Shit. Anyway if you find any other bugs. reports it right away!');
}

$nama_pengusaha = $_POST['nama'];
$jenis_kelamin = $_POST['gender'];
$jenis_usaha = $_POST['jenisusaha'];
$alamat_usaha = $_POST['alamatusaha'];
$tahun_usaha = $_POST['tahunusaha'];
$gambar = $_FILES['gambar']['name'];

if ($gambar != "") {
    $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
    $x = explode('.', $gambar);
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['gambar']['tmp_name'];
    $angka_acak     = rand(1, 999);
    $nama_gambar_baru = $angka_acak . '-' . $gambar;
    if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
        move_uploaded_file($file_tmp, 'gambar/' . $nama_gambar_baru);
        $query = "INSERT INTO usaha (nama,jenis_kelamin,jenis_usaha,alamat_usaha,tahun_usaha,gambar) values ('$nama_pengusaha','$jenis_kelamin','$jenis_usaha'
            ,'$alamat_usaha','$tahun_usaha','$nama_gambar_baru')";
        $result = mysqli_query($koneksi, $query);
        if (!$result) {
            die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
                " - " . mysqli_error($koneksi));
        } else {
            header("location:../usaha.php?pesan=Data berhasil ditambah.");
        }
    } else {
        header("location:../usaha.php?pesan=Ekstensi yang diperbolehkan hanya PNG dan JPG");
    }
} else {
    $query =  "INSERT INTO usaha (nama,jenis_kelamin,jenis_usaha,alamat_usaha,tahun_usaha,gambar) values ('$nama_pengusaha','$jenis_kelamin','$jenis_usaha'
        ,'$alamat_usaha','$tahun_usaha',null)";
    $result = mysqli_query($koneksi, $query);
    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_errno($koneksi) .
            " - " . mysqli_error($koneksi));
    } else {
        header("location:../usaha.php?pesan=Data berhasil ditambah.");
    }
}