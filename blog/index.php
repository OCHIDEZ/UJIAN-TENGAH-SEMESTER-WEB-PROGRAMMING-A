<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Manajemen Blog (CMS)</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; background-color: #f0f2f5; color: #333; }
        
        .header { 
            background-color: #2c3e50; 
            color: white; 
            padding: 10px 25px;
            display: flex; 
            align-items: center; 
        }

        .header-icon {
            background-color: #455a64; 
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 18px;
            color: #bdc3c7;
        }

        .header-text {
            display: flex;
            flex-direction: column;
        }

        .header-text .main-title {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            line-height: 1.2;
        }

        .header-text .sub-title {
            font-size: 11px;
            color: #95a5a6;
            margin-top: 2px;
        }

        .container { 
            display: flex; 
            height: calc(100vh - 60px);
            align-items: flex-start; 
        }

        .main-content { 
            flex: 1; 
            padding: 25px; 
        }
        .sidebar { width: 260px; padding: 20px; }
        .sidebar-inner { background: white; border-radius: 15px; padding: 20px 0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .menu-title { padding: 0 25px 15px; font-size: 11px; color: #b0b0b0; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; }
        
        .sidebar ul { list-style: none; padding: 0; margin: 0; }
        .sidebar li { 
            padding: 12px 25px; 
            display: flex; 
            align-items: center; 
            cursor: pointer; 
            color: #555; 
            font-size: 14px; 
            transition: 0.3s; 
            border-left: 4px solid transparent; 
            margin-bottom: 2px;
        }
        
        .sidebar li i { margin-right: 15px; width: 20px; text-align: center; color: #888; }
        .sidebar li.active i { 
        color: #27ae60;
        }
        .sidebar li:hover { background-color: #f8f9fa; color: #27ae60; }
        
        .sidebar li.active { 
            background-color: #f0fdf4;
            color: #27ae60; 
            font-weight: 600; 
            border-left: 4px solid #27ae60;
        }
        .sidebar li.active i { color: #27ae60; }

        .main-content { flex: 1; padding: 25px; overflow-y: auto; }
        .content-card { background: white; border-radius: 15px; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        .card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        .card-header h3 { margin: 0; font-size: 18px; color: #333; }

        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; font-size: 11px; color: #999; padding: 12px; text-transform: uppercase; border-bottom: 1px solid #eee; letter-spacing: 0.5px; }
        td { padding: 15px 12px; font-size: 13px; border-bottom: 1px solid #f9f9f9; vertical-align: middle; }

        .btn { padding: 9px 18px; border: none; border-radius: 6px; cursor: pointer; color: white; font-size: 12px; font-weight: bold; transition: 0.2s; display: inline-flex; align-items: center; justify-content: center; }
        .btn-tambah { background-color: #2ecc71; }
        .btn-edit { background-color: #3498db; margin-right: 5px; }
        .btn-hapus { background-color: #e74c3c; }
        .btn:hover { opacity: 0.8; transform: translateY(-1px); }

        .badge { padding: 5px 12px; border-radius: 4px; font-size: 11px; font-weight: bold; background: #e3f2fd; color: #1976d2; }
        
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(3px); }
        .modal-content { background: white; border-radius: 15px; width: 480px; margin: 50px auto; padding: 30px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.2); }
        
        input, textarea, select { width: 100%; padding: 12px; margin-top: 8px; border: 1px solid #ddd; border-radius: 8px; background: #fcfcfc; font-size: 13px; box-sizing: border-box; }
        input:focus, textarea:focus { border-color: #27ae60; outline: none; background: #fff; }
        .label { font-size: 12px; font-weight: bold; color: #555; display: block; margin-top: 15px; }
        
        .btn {
            position: relative;
            z-index: 10;
            cursor: pointer !important;
        }

        .modal {
            z-index: 9999 !important; 
        } 
        .modal-footer { margin-top: 25px; display: flex; justify-content: flex-end; gap: 10px; }
        .btn-batal { background-color: #95a5a6; }
        
    </style>
</head>
<body>

            <div class="header">
            <div class="header-icon">
                <i class="fa-solid fa-table-columns"></i>
            </div>
            <div class="header-text">
                <div class="main-title">Sistem Manajemen Blog (CMS)</div>
                <div class="sub-title">Blog Keren</div>
            </div>
        </div>

        <div class="container">
            <div class="sidebar">
                <div class="sidebar-inner">
                    <div class="menu-title">Menu Utama</div>
                    <ul>
                        <li id="menu-penulis" onclick="loadMenu('penulis')"><i class="fa-regular fa-user"></i> Kelola Penulis</li>
                        <li id="menu-artikel" onclick="loadMenu('artikel')"><i class="fa-regular fa-file-lines"></i> Kelola Artikel</li>
                        <li id="menu-kategori" onclick="loadMenu('kategori')"><i class="fa-regular fa-folder"></i> Kelola Kategori</li>
                    </ul>
                </div>
            </div>

            <div class="main-content" id="app-content">
                </div>
        </div>

    <script>
        let idYangAkanDihapus = null;
        let tipeYangAkanDihapus = '';       
        
        function loadMenu(menu) {
            document.querySelectorAll('.sidebar li').forEach(el => el.classList.remove('active'));
            document.getElementById('menu-' + menu).classList.add('active');
            const contentDiv = document.getElementById('app-content');

    if (menu === 'kategori') {
            contentDiv.innerHTML = `
                <div class="content-card">
                    <div class="card-header">
                        <h3>Data Kategori Artikel</h3>
                        <button class="btn btn-tambah" onclick="bukaModalKategori()">+ Tambah Kategori</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>NAMA KATEGORI</th>
                                <th>KETERANGAN</th>
                                <th width="140">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-kategori">
                            <tr><td colspan="3">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>`;
            loadDataKategori(); 
        } else if (menu === 'penulis') {
            contentDiv.innerHTML = `
                <div class="content-card">
                    <div class="card-header">
                        <h3>Data Penulis</h3>
                        <button class="btn btn-tambah" onclick="bukaModalPenulis()">+ Tambah Penulis</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>FOTO</th>
                                <th>NAMA</th>
                                <th>USERNAME</th>
                                <th>PASSWORD</th> 
                                <th width="150">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-penulis">
                            <tr><td colspan="5">Memuat data...</td></tr> 
                        </tbody>
                    </table>
                </div>`;
            loadDataPenulis();
        } else if (menu === 'artikel') {
            contentDiv.innerHTML = `
                <div class="content-card">
                    <div class="card-header">
                        <h3>Data Artikel</h3>
                        <button class="btn btn-tambah" onclick="bukaModalArtikel()">+ Tambah Artikel</button>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>GAMBAR</th>
                                <th>JUDUL</th>
                                <th>KATEGORI</th>
                                <th>PENULIS</th>
                                <th>TANGGAL</th>
                                <th width="150">AKSI</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-artikel">
                            <tr><td colspan="6">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>`;
            loadDataArtikel(); 
        }
    }
    function loadDataArtikel() {
    fetch('ambil_artikel.php')
    .then(response => response.json())
    .then(data => {
        let html = '';
        if(data.length === 0) {
            html = '<tr><td colspan="6" style="text-align:center;">Belum ada artikel</td></tr>';
        } else {
            data.forEach(item => {
                html += `
                    <tr>
                        <td><img src="${item.gambar_url}" style="width: 50px; height: 50px; border-radius: 4px; object-fit: cover;"></td>
                        <td><b>${item.judul}</b></td>
                        <td><span class="badge">${item.nama_kategori}</span></td>
                        <td>${item.nama_depan}</td>
                        <td style="font-size:11px; color:#888;">${item.hari_tanggal}</td>
                        <td>
                            <button class="btn btn-edit" onclick="editArtikel(${item.id})">Edit</button>
                            <button class="btn btn-hapus" onclick="hapusArtikel(${item.id})">Hapus</button>
                        </td>
                    </tr>`;
            });
        }
        document.getElementById('tabel-artikel').innerHTML = html;
    });
}

        window.onload = () => loadMenu('penulis');

        function loadDataKategori() {
        fetch('ambil_kategori.php').then(res => res.json()).then(data => {
            let html = '';
            data.forEach(item => {
                html += `<tr><td><span class="badge">${item.nama_kategori}</span></td><td>${item.keterangan}</td>
                <td><button class="btn btn-edit" onclick="editKategori(${item.id})">Edit</button>
                <button class="btn btn-hapus" onclick="hapusKategori(${item.id})">Hapus</button></td></tr>`;
            });
            document.getElementById('tabel-kategori').innerHTML = html || '<tr><td colspan="3">Data kosong</td></tr>';
        });
    }

        function submitKategori(e) {
    e.preventDefault();
    const form = document.getElementById('formKategori');
    const formData = new FormData(form);
    const id = document.getElementById('id_kategori').value;
    
    const url = id ? 'update_kategori.php' : 'simpan_kategori.php';

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(hasil => {
        if(hasil.trim() === 'sukses') {
            tutupModalKategori();
            loadDataKategori(); 
            
            tampilkanSukses('Data kategori berhasil ' + (id ? 'diperbarui' : 'ditambahkan') + '!');
            
        } else {
            alert('Gagal menyimpan data!');
        }
    });
}

        function editKategori(id) {
            fetch(`ambil_satu_kategori.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalTitleKategori').innerText = 'Edit Kategori'; // SESUAI GAMBAR 12
                document.querySelector('#formKategori button[type="submit"]').innerText = 'Simpan Perubahan';
                
                document.getElementById('id_kategori').value = data.id;
                document.getElementsByName('nama_kategori')[0].value = data.nama_kategori;
                document.getElementsByName('keterangan')[0].value = data.keterangan;
                document.getElementById('modalKategori').style.display = 'block';
            });
        }

        function hapusKategori(id) { 
            idYangAkanDihapus = id;
            tipeYangAkanDihapus = 'kategori';
         document.getElementById('modalKonfirmasi').style.display = 'block'; 
        }

        function bukaModalKategori() {
        document.getElementById('formKategori').reset();
        document.getElementById('id_kategori').value = '';
        document.getElementById('modalKategori').style.display = 'block';
    }

        function tutupModalKategori() {
            document.getElementById('modalKategori').style.display = 'none';
        }
        // --- FETCH API: KELOLA PENULIS ---
function loadDataPenulis() {
        fetch('ambil_penulis.php').then(res => res.json()).then(data => {
            let html = '';
            data.forEach(item => {
                html += `<tr><td><img src="${item.foto_url}" width="40" height="40" style="border-radius:50%; object-fit: cover;"></td>
                <td>${item.nama_depan} ${item.nama_belakang}</td><td><span class="badge">${item.user_name}</span></td>
                <td>$2y$10$def...</td><td><button class="btn btn-edit" onclick="editPenulis(${item.id})">Edit</button>
                <button class="btn btn-hapus" onclick="hapusPenulis(${item.id})">Hapus</button></td></tr>`;
            });
            document.getElementById('tabel-penulis').innerHTML = html || '<tr><td colspan="5">Data kosong</td></tr>';
        });
    }function submitPenulis(e) {
        e.preventDefault();
        const form = document.getElementById('formPenulis');
        const formData = new FormData(form);
        const id = document.getElementById('id_penulis').value;

        if (!id && !formData.get('password')) {
            alert("Peringatan: Password wajib diisi untuk penulis baru!");
            return; // Hentikan proses jika gagal validasi
        }
        if (formData.get('password') && formData.get('password').length < 6) {
            alert("Peringatan: Password minimal harus 6 karakter!");
            return;
        }

        const fileFoto = form.querySelector('input[type="file"]').files[0];
        if (fileFoto) {
            const tipeFile = fileFoto.type;
            const ukuranFile = fileFoto.size / 1024 / 1024; // Convert ke MB
            
            if (tipeFile !== 'image/jpeg' && tipeFile !== 'image/png') {
                alert("Validasi Gagal: Format foto harus JPG atau PNG!");
                return;
            }
            if (ukuranFile > 2) {
                alert("Validasi Gagal: Ukuran foto maksimal 2 MB!");
                return;
            }
        }

        const url = id ? 'update_penulis.php' : 'simpan_penulis.php';
        fetch(url, { method: 'POST', body: formData })
        .then(response => response.text())
        .then(hasil => {
            const status = hasil.trim();
            if (status === 'sukses') {
                tutupModal('modalPenulis');
                loadDataPenulis();
                tampilkanSukses('Data penulis berhasil disimpan!');
            } else {
                alert("Terjadi kesalahan sistem: " + hasil);
            }
        });
    }
function editPenulis(id) {
    fetch(`ambil_satu_penulis.php?id=${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('modalTitlePenulis').innerText = 'Edit Penulis'; // SESUAI GAMBAR 4
        document.getElementById('btnSubmitPenulis').innerText = 'Simpan Perubahan'; // SESUAI GAMBAR 4
        document.getElementById('btnSubmitPenulis').style.backgroundColor = '#2ecc71';
        
        document.getElementById('pass_note').style.display = 'block';
        document.getElementById('input_password').placeholder = '••••••••';
        
        document.getElementById('id_penulis').value = data.id;
        document.getElementsByName('nama_depan')[0].value = data.nama_depan;
        document.getElementsByName('nama_belakang')[0].value = data.nama_belakang;
        document.getElementsByName('user_name')[0].value = data.user_name;
        document.getElementById('modalPenulis').style.display = 'block';
    });
}

function hapusPenulis(id) { 
    idYangAkanDihapus = id; 
    tipeYangAkanDihapus = 'penulis'; 
document.getElementById('modalKonfirmasi').style.display = 'block'; }
function bukaModalPenulis() {
        document.getElementById('formPenulis').reset();
        document.getElementById('id_penulis').value = '';
        document.getElementById('modalPenulis').style.display = 'block';
    }

function tutupModal(id) {
     document.getElementById(id).style.display = 'none'; }
function tutupModalKategori() {
     tutupModal('modalKategori'); }

function loadDataArtikel() {
        fetch('ambil_artikel.php').then(res => res.json()).then(data => {
            let html = '';
            data.forEach(item => {
                html += `<tr><td><img src="${item.gambar_url}" width="50"></td><td><b>${item.judul}</b></td>
                <td><span class="badge">${item.nama_kategori}</span></td><td>${item.nama_depan}</td>
                <td>${item.hari_tanggal}</td><td><button class="btn btn-edit" onclick="editArtikel(${item.id})">Edit</button>
                <button class="btn btn-hapus" onclick="hapusArtikel(${item.id})">Hapus</button></td></tr>`;
            });
            document.getElementById('tabel-artikel').innerHTML = html || '<tr><td colspan="6">Data kosong</td></tr>';
        });
    }
function bukaModalArtikel() {
    const form = document.getElementById('formArtikel');
    if(form) form.reset();
    
    document.getElementById('id_artikel').value = '';
    document.getElementById('modalTitleArtikel').innerText = 'Tambah Artikel'; 
    document.querySelector('#formArtikel button[type="submit"]').innerText = 'Simpan Data';
    
    fetch('ambil_penulis.php').then(res => res.json()).then(data => {
        let opt = '<option value="">Pilih Penulis</option>';
        data.forEach(p => opt += `<option value="${p.id}">${p.nama_depan} ${p.nama_belakang}</option>`);
        document.getElementById('opt_penulis').innerHTML = opt;
    });
    fetch('ambil_kategori.php').then(res => res.json()).then(data => {
        let opt = '<option value="">Pilih Kategori</option>';
        data.forEach(k => opt += `<option value="${k.id}">${k.nama_kategori}</option>`);
        document.getElementById('opt_kategori').innerHTML = opt;
    });

    document.getElementById('modalArtikel').style.display = 'block';
}
        function submitArtikel(e) {
            e.preventDefault();
            const form = document.getElementById('formArtikel');
            const formData = new FormData(form);
            const idArtikel = document.getElementById('id_artikel').value;
            
            const fileGambar = form.querySelector('input[name="gambar"]').files[0];
            if (fileGambar) {
                const tipeFile = fileGambar.type;
                const ukuranFile = fileGambar.size / 1024 / 1024; 
                
                if (tipeFile !== 'image/jpeg' && tipeFile !== 'image/png') {
                    alert("Validasi Gagal: Format gambar artikel harus JPG atau PNG!");
                    return;
                }
                if (ukuranFile > 2) {
                    alert("Validasi Gagal: Ukuran gambar artikel maksimal 2 MB!");
                    return;
                }
            }

            if (formData.get('id_penulis') === "" || formData.get('id_kategori') === "") {
                alert("Peringatan: Penulis dan Kategori wajib dipilih!");
                return;
            }
            
            const fileTujuan = (idArtikel === "") ? 'simpan_artikel.php' : 'update_artikel.php';
            
            fetch(fileTujuan, { method: 'POST', body: formData })
            .then(res => res.text())
            .then(hasil => {
                if(hasil.trim() === 'sukses') {
                    tutupModal('modalArtikel');
                    loadDataArtikel();
                    tampilkanSukses('Data artikel berhasil ' + (idArtikel === "" ? 'disimpan' : 'diperbarui') + '!');
                } else {
                    alert('Gagal: ' + hasil);
                }
            });
        }
        function editArtikel(id) {
            fetch(`ambil_satu_artikel.php?id=${id}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('modalTitleArtikel').innerText = 'Edit Artikel';
                document.querySelector('#formArtikel button[type="submit"]').innerText = 'Simpan Perubahan';
                
                document.getElementById('id_artikel').value = data.id;
                document.getElementsByName('judul')[0].value = data.judul;
                document.getElementsByName('isi')[0].value = data.isi;
                
                document.getElementById('modalArtikel').style.display = 'block';
                setTimeout(() => {
                    document.getElementById('opt_penulis').value = data.id_penulis;
                    document.getElementById('opt_kategori').value = data.id_kategori;
                }, 500);
            });
        }

function hapusArtikel(id) {
    idYangAkanDihapus = id;
        tipeYangAkanDihapus = 'artikel';
        document.getElementById('modalKonfirmasi').style.display = 'block';
    }
        
        function tutupModal(idModal) {
            document.getElementById(idModal).style.display = 'none';
        }

    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('btnYaHapus').onclick = function() {
            let url = '';
            let refreshFunc = null;

            if (tipeYangAkanDihapus === 'penulis') { url = 'hapus_penulis.php'; refreshFunc = loadDataPenulis; }
            else if (tipeYangAkanDihapus === 'artikel') { url = 'hapus_artikel.php'; refreshFunc = loadDataArtikel; }
            else if (tipeYangAkanDihapus === 'kategori') { url = 'hapus_kategori.php'; refreshFunc = loadDataKategori; }

            let formData = new FormData();
            formData.append('id', idYangAkanDihapus);

            fetch(url, { method: 'POST', body: formData })
            .then(res => res.text())
            .then(hasil => {
                if (hasil.trim() === 'sukses') {
                    document.getElementById('modalKonfirmasi').style.display = 'none';
                    refreshFunc(); 
                } else {
                    alert('Gagal menghapus: ' + hasil);
                }
            });
        };
    });

    function tampilkanSukses(pesan) {
        document.getElementById('pesanSukses').innerText = pesan;
        document.getElementById('modalSukses').style.display = 'block';
    }
    </script>
    <div id="modalKategori" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); padding-top:100px;">
        <div style="background:#fff; width:400px; margin:auto; padding:20px; border-radius:8px;">
            <h3 id="modalTitleKategori">Tambah Kategori</h3>
            <form id="formKategori" onsubmit="submitKategori(event)">
                <input type="hidden" id="id_kategori" name="id">
                
                <p>Nama Kategori<br>
                <input type="text" id="nama_kategori" name="nama_kategori" required style="width:90%; padding:8px;" placeholder="Nama kategori..."></p>
                
                <p>Keterangan<br>
                <textarea id="keterangan" name="keterangan" required style="width:90%; height:80px; padding:8px;" placeholder="Deskripsi kategori..."></textarea></p>
                
                <div style="text-align:right;">
                    <button type="button" class="btn" style="background:#95a5a6;" onclick="tutupModalKategori()">Batal</button>
                    <button type="submit" class="btn btn-tambah">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
    <div id="modalPenulis" class="modal">
        <div class="modal-content">
            <h3 id="modalTitlePenulis">Tambah Penulis</h3> 
            <form id="formPenulis" onsubmit="submitPenulis(event)">
                <input type="hidden" name="id" id="id_penulis">
                
                <div style="display:flex; gap:10px;">
                    <div style="flex:1;"><p>Nama Depan<br><input type="text" name="nama_depan" required placeholder="Nama Depan"></p></div>
                    <div style="flex:1;"><p>Nama Belakang<br><input type="text" name="nama_belakang" required placeholder="Nama Belakang"></p></div>
                </div>
                
                <p>Username<br><input type="text" name="user_name" required placeholder="username"></p>
                
                <p id="label_password">Password<br>
                    <input type="password" name="password" id="input_password" placeholder="••••••••">
                    <small id="pass_note" style="display:none; color: gray;">Password Baru (kosongkan jika tidak diganti)</small>
                </p>
                
                <p id="label_foto">Foto Profil<br><input type="file" name="foto"></p>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-batal" onclick="tutupModal('modalPenulis')">Batal</button>
                    <button type="submit" class="btn btn-tambah" id="btnSubmitPenulis">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
<div id="modalArtikel" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); padding-top:20px; overflow-y:auto;">
    <div style="background:#fff; width:600px; margin:auto; padding:20px; border-radius:8px; margin-bottom:20px;">
        <h3 id="modalTitleArtikel">Kelola Artikel</h3>
        <form id="formArtikel" onsubmit="submitArtikel(event)">
            <input type="hidden" name="id" id="id_artikel">
            <p>Judul Artikel<br><input type="text" name="judul" required style="width:96%; padding:8px;"></p>
            
            <div style="display:flex; gap:10px;">
                <div style="flex:1;">
                    <p>Penulis<br>
                    <select name="id_penulis" id="opt_penulis" required style="width:100%; padding:8px;"></select></p>
                </div>
                <div style="flex:1;">
                    <p>Kategori<br>
                    <select name="id_kategori" id="opt_kategori" required style="width:100%; padding:8px;"></select></p>
                </div>
            </div>

            <p>Isi Artikel<br>
<textarea name="isi" id="isi_artikel" required style="width:96%; height:150px; padding:8px;"></textarea></p>
            <p>Gambar Artikel<br><input type="file" name="gambar" accept="image/*" style="width:96%; padding:8px;"></p>
            
            <div style="text-align:right; margin-top:15px;">
                <button type="button" class="btn" style="background:#95a5a6;" onclick="tutupModal('modalArtikel')">Batal</button>
                <button type="submit" class="btn btn-tambah">Simpan Artikel</button>
            </div>
        </form>
    </div>
</div>
<div id="modalKonfirmasi" class="modal">
    <div class="modal-content" style="width: 350px; text-align: center; padding: 40px;">
        <div style="background: #fff0f0; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-trash-can" style="color: #e74c3c; font-size: 24px;"></i>
        </div>
        
        <h3 style="margin: 0 0 10px; font-size: 18px; color: #333;">Hapus data ini?</h3>
        <p style="color: #999; font-size: 13px; margin: 0 0 25px;">Data yang dihapus tidak dapat dikembalikan.</p>
        
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" class="btn" style="background: #a0a0a0; width: 100px;" onclick="tutupModal('modalKonfirmasi')">Batal</button>
            <button type="button" id="btnYaHapus" class="btn" style="background: #e74c3c; width: 100px;">Ya, Hapus</button>
        </div>
    </div>
</div>
<div id="modalSukses" class="modal">
    <div class="modal-content" style="width: 350px; text-align: center; padding: 40px; border-top: 5px solid #2ecc71;">
        
        <div style="background: #e8f8f5; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
            <i class="fa-solid fa-check" style="color: #2ecc71; font-size: 28px;"></i>
        </div>
        
        <h3 style="margin: 0 0 10px; font-size: 20px; color: #333;">Berhasil!</h3>
        <p id="pesanSukses" style="color: #777; font-size: 14px; margin: 0 0 25px;">Data berhasil disimpan.</p>
        
        <button type="button" class="btn" style="background: #2ecc71; width: 100px; padding: 10px;" onclick="tutupModal('modalSukses')">OK</button>
    </div>
</div>
</body>
</html>
