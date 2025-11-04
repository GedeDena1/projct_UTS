<?php

// Memasukkan file class-mahasiswa.php untuk mengakses class Mahasiswa
include '../config/class-mahasiswa.php';
// Membuat objek dari class Mahasiswa
$Member = new Member();
// Mengambil data mahasiswa dari form input menggunakan metode POST dan menyimpannya dalam array
$dataMember = [
    'nama' => $_POST['nama'],
    'program' => $_POST['program'],
    'alamat' => $_POST['alamat'],
    'provinsi' => $_POST['provinsi'],
    'email' => $_POST['email'],
    'telp' => $_POST['telp'],
    'status' => $_POST['status']
];
// Memanggil method inputMahasiswa untuk memasukkan data mahasiswa dengan parameter array $dataMahasiswa
$input = $Member->inputMember($dataMember);
// Mengecek apakah proses input berhasil atau tidak - true/false
if($input){
    // Jika berhasil, redirect ke halaman data-list.php dengan status inputsuccess
    header("Location: ../data-list.php?status=inputsuccess");
} else {
    // Jika gagal, redirect ke halaman data-input.php dengan status failed
    header("Location: ../data-input.php?status=failed");
}

?> 