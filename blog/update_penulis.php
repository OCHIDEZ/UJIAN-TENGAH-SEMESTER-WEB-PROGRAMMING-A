<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $nama_d = $_POST['nama_depan'];
    $nama_b = $_POST['nama_belakang'];
    $user = $_POST['user_name'];

    // Ambil data lama
    $res = $conn->query("SELECT foto, password FROM penulis WHERE id = $id");
    $lama = $res->fetch_assoc();

    $pass = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : $lama['password'];
    $foto_nama = $lama['foto'];

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nama = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto_nama);
    }

    $stmt = $conn->prepare("UPDATE penulis SET nama_depan=?, nama_belakang=?, user_name=?, password=?, foto=? WHERE id=?");
    $stmt->bind_param("sssssi", $nama_d, $nama_b, $user, $pass, $foto_nama, $id);
    echo $stmt->execute() ? "sukses" : "gagal";
}
?>