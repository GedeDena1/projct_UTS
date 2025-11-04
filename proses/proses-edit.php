<?php

// Memasukkan file class-mahasiswa.php untuk mengakses class Mahasiswa
include_once '../config/class-mahasiswa.php';
// Membuat objek dari class Mahasiswa
$Member = new Member();
// Mengambil data mahasiswa dari form edit menggunakan metode POST dan menyimpannya dalam array
$dataMember = [
    'id' => $_POST['id'],
    'nama' => $_POST['nama'],
    'program' => $_POST['program'],
    'alamat' => $_POST['alamat'],
    'provinsi' => $_POST['provinsi'],
    'email' => $_POST['email'],
    'telp' => $_POST['telp'],
    'status' => $_POST['status']
];
// Memanggil method editMahasiswa untuk mengupdate data mahasiswa dengan parameter array $dataMahasiswa
$edit = $Member->editMember($dataMember);
// Mengecek apakah proses edit berhasil atau tidak - true/false
if($edit){
    // Jika berhasil, redirect ke halaman data-list.php dengan status editsuccess
    header("Location: ../data-list.php?status=editsuccess");
} else {
    // Jika gagal, redirect ke halaman data-edit.php dengan status failed dan membawa id mahasiswa
    header("Location: ../data-edit.php?id=".$dataMember['id']."&status=failed");
}

?>