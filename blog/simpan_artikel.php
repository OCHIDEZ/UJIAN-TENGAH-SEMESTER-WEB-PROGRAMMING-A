<?php
require 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $id_kat = $_POST['id_kategori'];
    $id_pen = $_POST['id_penulis'];
    $isi = $_POST['isi']; 
    $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    $bulan = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $sekarang = new DateTime();
    $hari_tanggal = $hari[$sekarang->format('w')] . ", " . $sekarang->format('j') . " " . $bulan[(int)$sekarang->format('n')] . " " . $sekarang->format('Y') . " | " . $sekarang->format('H:i');
    $nama_gambar = ""; 

    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        $nama_gambar = uniqid() . "." . $ext;
        move_uploaded_file($_FILES['gambar']['tmp_name'], 'uploads_artikel/' . $nama_gambar);
    }

    $stmt = $conn->prepare("INSERT INTO artikel (id_penulis, id_kategori, judul, isi, gambar, hari_tanggal) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $id_pen, $id_kat, $judul, $isi, $nama_gambar, $hari_tanggal);
    
    echo $stmt->execute() ? "sukses" : "gagal";
}
?>