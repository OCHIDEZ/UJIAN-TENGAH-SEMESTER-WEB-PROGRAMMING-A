<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_d = $_POST['nama_depan'];
    $nama_b = $_POST['nama_belakang'];
    $user = $_POST['user_name'];
    // Enkripsi password sesuai instruksi
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $foto_nama = "";

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $tipe = $finfo->file($_FILES['foto']['tmp_name']);
        
        if (in_array($tipe, ['image/jpeg', 'image/png'])) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $foto_nama = uniqid() . "." . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], 'uploads_penulis/' . $foto_nama);
        }
    }

    $stmt = $conn->prepare("INSERT INTO penulis (nama_depan, nama_belakang, user_name, password, foto) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_d, $nama_b, $user, $pass, $foto_nama);
    echo $stmt->execute() ? "sukses" : "gagal";
}
?>