<?php 

// Menggunakan require_once untuk memastikan file penting dimuat dan menghentikan eksekusi jika gagal.
require_once 'config/class-master.php';
// Asumsi: class-mahasiswa.php berisi class Member
require_once 'config/class-mahasiswa.php'; 

// Inisialisasi class
$master = new MasterData();
$Member = new Member(); // Menggunakan Member sesuai kode Anda

// --- 1. Sanitasi dan Validasi ID ---
$memberId = 0;
// Pengecekan apakah parameter ID ada dan merupakan nilai yang diharapkan
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Sanitasi ID sebagai integer untuk mencegah SQL Injection
    $memberId = (int)$_GET['id'];
}

// Mengambil daftar master data
$prodiList = $master->getProdi();
$provinsiList = $master->getProvinsi();
$statusList = $master->getStatus();

// Mengambil data member berdasarkan ID yang sudah disanitasi
$dataMember = $Member->getUpdateMember($memberId);

// --- 2. Pengecekan Data Ditemukan ---
// Jika data tidak ditemukan atau ID tidak valid (setelah sanitasi/query), hentikan proses
if (empty($dataMember) || $memberId === 0) {
    // Idealnya, redirect ke halaman daftar dengan pesan error "Data tidak ditemukan"
    // Untuk contoh ini, kita akan menampilkan pesan di halaman ini, tapi redirect adalah praktik yang lebih baik.
    $errorMessage = "Error: Data Mahasiswa dengan ID ini tidak ditemukan atau ID tidak valid.";
    // Jika Anda ingin menghentikan eksekusi total, gunakan:
    // header('Location: data-list.php?status=notfound'); exit;
} else {
    // Data ditemukan, inisialisasi pesan error
    $errorMessage = "";
}

// --- 3. Mengganti alert() dengan pesan inline (jika status gagal) ---
if(isset($_GET['status']) && $_GET['status'] == 'failed'){
    // Pesan ini akan ditampilkan di dalam div alert pada bagian HTML
    $errorMessage = "Gagal mengubah data mahasiswa. Silakan coba lagi.";
}
// Tambahkan penanganan untuk status lain jika ada (misal: 'success')
if(isset($_GET['status']) && $_GET['status'] == 'success'){
    $successMessage = "Data mahasiswa berhasil diubah!";
}

?>
<!doctype html>
<html lang="en">
    <head>
        <?php include 'template/header.php'; ?>
    </head>

    <body class="layout-fixed fixed-header fixed-footer sidebar-expand-lg sidebar-open bg-body-tertiary">

        <div class="app-wrapper">

            <?php include 'template/navbar.php'; ?>

            <?php include 'template/sidebar.php'; ?>

            <main class="app-main">

                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-0">Edit Mahasiswa</h3>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-end">
                                    <li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="app-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">

                                <!-- Area Pesan Status/Error -->
                                <?php if (!empty($errorMessage)): ?>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <?php echo $errorMessage; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($successMessage) && !empty($successMessage)): ?>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <?php echo $successMessage; ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Pastikan $dataMember ada sebelum menampilkan formulir -->
                                <?php if (!empty($dataMember)): ?>

                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Formulir Edit Member</h3>
                                        <div class="card-tools">
                                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
                                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <form action="proses/proses-edit.php" method="POST">
                                        <div class="card-body">
                                            <!-- Menggunakan htmlspecialchars untuk mencegah XSS pada data yang ditampilkan -->
                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($dataMember['id']); ?>">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap Mahasiswa" value="<?php echo htmlspecialchars($dataMember['nama']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="program" class="form-label">Program Latihan</label>
                                                <select class="form-select" id="program" name="program" required>
                                                    <option value="" selected disabled>Pilih Program Latihan</option>
                                                    <?php 
                                                    foreach ($prodiList as $program){
                                                        $selectedProgram = ($dataMember['program'] == $program['id']) ? "selected" : "";
                                                        echo '<option value="'.htmlspecialchars($program['id']).'" '.$selectedProgram.'>'.htmlspecialchars($program['nama']).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap Sesuai KTP" required><?php echo htmlspecialchars($dataMember['alamat']); ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="provinsi" class="form-label">Provinsi</label>
                                                <select class="form-select" id="provinsi" name="provinsi" required>
                                                    <option value="" selected disabled>Pilih Provinsi</option>
                                                    <?php
                                                    foreach ($provinsiList as $provinsi){
                                                        $selectedProvinsi = ($dataMember['provinsi'] == $provinsi['id']) ? "selected" : "";
                                                        echo '<option value="'.htmlspecialchars($provinsi['id']).'" '.$selectedProvinsi.'>'.htmlspecialchars($provinsi['nama']).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email Valid dan Benar" value="<?php echo htmlspecialchars($dataMember['email']); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="telp" class="form-label">Nomor Telepon</label>
                                                <!-- Pastikan value terisi dengan benar -->
                                                <input type="tel" class="form-control" id="telp" name="telp" placeholder="Masukkan Nomor Telpon/HP" value="<?php echo htmlspecialchars($dataMember['telp']); ?>" pattern="[0-9+\-\s()]{6,20}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="" selected disabled>Pilih Status</option>
                                                    <?php 
                                                    foreach ($statusList as $status){
                                                        $selectedStatus = ($dataMember['status'] == $status['id']) ? "selected" : "";
                                                        echo '<option value="'.htmlspecialchars($status['id']).'" '.$selectedStatus.'>'.htmlspecialchars($status['nama']).'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-danger me-2 float-start" onclick="window.location.href='data-list.php'">Batal</button>
                                            <button type="submit" class="btn btn-warning float-end">Update Data</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                </div>

            </main>

            <?php include 'template/footer.php'; ?>

        </div>
        
        <?php include 'template/script.php'; ?>

    </body>
</html>
