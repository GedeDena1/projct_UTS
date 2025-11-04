<?php

include_once 'config/class-mahasiswa.php';
$Member = new Member();
$kataKunci = '';
// Mengecek apakah parameter GET 'search' ada
if(isset($_GET['search'])){
	// Mengambil kata kunci pencarian dari parameter GET 'search'
	$kataKunci = $_GET['search'];
	// Memanggil method searchMahasiswa untuk mencari data mahasiswa berdasarkan kata kunci dan menyimpan hasil dalam variabel $cariMahasiswa
	$cariMember = $Member->searchMember($kataKunci);
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
								<h3 class="mb-0">Cari Member</h3>
							</div>
							<div class="col-sm-6">
								<ol class="breadcrumb float-sm-end">
									<li class="breadcrumb-item"><a href="index.php">Beranda</a></li>
									<li class="breadcrumb-item active" aria-current="page">Cari Data</li>
								</ol>
							</div>
						</div>
					</div>
				</div>

				<div class="app-content">
					<div class="container-fluid">
						<div class="row">
							<div class="col-12">
								<div class="card mb-3">
									<div class="card-header">
										<h3 class="card-title">Pencarian Member</h3>
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
									<div class="card-body">
										<form action="data-search.php" method="GET">
											<div class="mb-3">
												<label for="search" class="form-label">Masukkan Nama Member</label>
												<input type="text" class="form-control" id="search" name="search" placeholder="Cari berdasarkan Nama Member" value="<?php echo $kataKunci; ?>" required>
											</div>
											<button type="submit" class="btn btn-primary"><i class="bi bi-search-heart-fill"></i> Cari</button>
										</form>
									</div>
								</div>
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Hasil Pencarian</h3>
										<div class="card-tools">
											<button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Collapse">
												<i data-lte-icon="expand" class="bi bi-plus-l g"></i>
												<i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
											</button>
											<button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Remove">
												<i class="bi bi-x-lg"></i>
											</button>
										</div>
									</div>
									<div class="card-body">
										<?php
										// Mengecek apakah parameter GET 'search' ada
										if(isset($_GET['search'])){
											// Mengecek apakah ada data mahasiswa yang ditemukan
											if(count($cariMember) > 0){
												// Menampilkan tabel hasil pencarian
												echo '<table class="table table-striped" role="table">
													<thead>
														<tr>
															<th>No</th>
															<th>Nama</th>
															<th>Program</th>
															<th>Provinsi</th>
															<th>Alamat</th>
															<th>Telp</th>
															<th>Email</th>
															<th class="text-center">Status</th>
															<th class="text-center">Aksi</th>
														</tr>
													</thead>
													<tbody>';
													// Iterasi data mahasiswa yang ditemukan dan menampilkannya dalam tabel
													foreach ($cariMember as $index => $Member){
														// Mengubah status mahasiswa menjadi badge dengan warna yang sesuai
														if($Member['status'] == 1){
															$Member['status'] = '<span class="badge bg-success">Aktif</span>';
														} elseif($Member['status'] == 2){
															$Member['status'] = '<span class="badge bg-danger">Tidak Aktif</span>';
														} elseif($Member['status'] == 3){
															$Member['status'] = '<span class="badge bg-warning text-dark">Cuti</span>';
														} elseif($Member['status'] == 4){
															$Member['status'] = '<span class="badge bg-primary">Lulus</span>';
														} 
														// Menampilkan baris data mahasiswa dalam tabel
														echo '<tr class="align-middle">
															<td>'.($index + 1).'</td>
															<td>'.$Member['nama'].'</td>
															<td>'.$Member['program'].'</td>
															<td>'.$Member['provinsi'].'</td>
															<td>'.$Member['alamat'].'</td>
															<td>'.$Member['telp'].'</td>
															<td>'.$Member['email'].'</td>
															<td class="text-center">'.$Member['status'].'</td>
															<td class="text-center">
																<button type="button" class="btn btn-sm btn-warning me-1" onclick="window.location.href=\'data-edit.php?id='.$Member['id'].'\'"><i class="bi bi-pencil-fill"></i> Edit</button>
																<button type="button" class="btn btn-sm btn-danger" onclick="if(confirm(\'Yakin ingin menghapus data member ini?\')){window.location.href=\'proses/proses-delete.php?id='.$Member['id'].'\'}"><i class="bi bi-trash-fill"></i> Hapus</button>
															</td>
														</tr>';
													}
												echo '</tbody>
												</table>';
											} else {
												// Menampilkan pesan jika tidak ada data mahasiswa yang ditemukan
												echo '<div class="alert alert-warning" role="alert">
														Tidak ditemukan data member yang sesuai dengan kata kunci "<strong>'.htmlspecialchars($_GET['search']).'</strong>".
													  </div>';
											}
										} else {
											// Menampilkan pesan jika form pencarian belum disubmit
											echo '<div class="alert alert-info" role="alert">
													Silakan masukkan kata kunci pencarian di atas untuk mencari data member.
												  </div>';
										}
										?>
									</div>
								</div>
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