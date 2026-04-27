<?php
require 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // ID dari input hidden
    $judul = $_POST['judul'];
    $id_kat = $_POST['id_kategori'];
    $id_pen = $_POST['id_penulis'];
    $isi = $_POST['isi']; // Sesuai kolom database 'isi'

    // Ambil nama gambar lama dari database
    $res = $conn->query("SELECT gambar FROM artikel WHERE id = $id");
    $dataLama = $res->fetch_assoc();
    $nama_gambar = $dataLama['gambar'];

    // Cek jika user mengunggah gambar baru
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $nama_gambar = uniqid() . "_upd." . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $nama_gambar);
    }

    // Eksekusi UPDATE
    $stmt = $conn->prepare("UPDATE artikel SET id_penulis=?, id_kategori=?, judul=?, isi=?, gambar=? WHERE id=?");
    $stmt->bind_param("iisssi", $id_pen, $id_kat, $judul, $isi, $nama_gambar, $id);
    
    echo $stmt->execute() ? "sukses" : "gagal";
}
?>