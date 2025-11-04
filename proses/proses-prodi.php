<?php

// Memasukkan file class-master.php untuk mengakses class MasterData
include '../config/class-master.php';
// Membuat objek dari class MasterData
$master = new MasterData();
// Mengecek aksi yang dilakukan berdasarkan parameter GET 'aksi'
if($_GET['aksi'] == 'inputprodi'){
    // Mengambil data prodi dari form input menggunakan metode POST dan menyimpannya dalam array
    $dataProgram = [
        'kode' => $_POST['kode'],
        'nama' => $_POST['nama']
    ];
    // Memanggil method inputProdi untuk memasukkan data prodi dengan parameter array $dataProdi
    $input = $master->inputProdi($dataProgram);
    if($input){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status inputsuccess
        header("Location: ../master-prodi-list.php?status=inputsuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-input.php dengan status failed
        header("Location: ../master-prodi-input.php?status=failed");
    }
} elseif($_GET['aksi'] == 'updateprodi'){
    // Mengambil data prodi dari form edit menggunakan metode POST dan menyimpannya dalam array
    $dataProgram = [
   
        'kode' => $_POST['kode'],
        'nama' => $_POST['nama']
    ];
    // Memanggil method updateProdi untuk mengupdate data prodi dengan parameter array $dataProdi
    $update = $master->updateProdi($dataProgram);
    if($update){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status editsuccess
        header("Location: ../master-prodi-list.php?status=editsuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-edit.php dengan status failed dan membawa id prodi
        header("Location: ../master-prodi-edit.php?id=".$dataProgram['id']."&status=failed");
    }
} elseif($_GET['aksi'] == 'deleteprodi'){
    // Mengambil id prodi dari parameter GET
    $id = $_GET['id'];
    // Memanggil method deleteProdi untuk menghapus data prodi berdasarkan id
    $delete = $master->deleteProdi($id);
    if($delete){
        // Jika berhasil, redirect ke halaman master-prodi-list.php dengan status deletesuccess
        header("Location: ../master-prodi-list.php?status=deletesuccess");
    } else {
        // Jika gagal, redirect ke halaman master-prodi-list.php dengan status deletefailed
        header("Location: ../master-prodi-list.php?status=deletefailed");
    }
}

?>