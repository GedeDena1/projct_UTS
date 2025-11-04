<?php 

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class Member extends Database {

    // Method untuk input data mahasiswa
    public function inputMember($data){
        // Mengambil data dari parameter $data
        
        $nama     = $data['nama'];
        $program  = $data['program'];
        $alamat   = $data['alamat'];
        $provinsi = $data['provinsi'];
        $email    = $data['email'];
        $telp     = $data['telp'];
        $status   = $data['status'];
        // Menyiapkan query SQL untuk insert data menggunakan prepared statement
        $query = "INSERT INTO tb_member (nama, program, alamat, provinsi, email, telp, status) VALUES ( ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        // Mengecek apakah statement berhasil disiapkan
        if(!$stmt){
            return false;
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("sssissi", $nama, $program, $alamat, $provinsi, $email, $telp, $status);
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk mengambil semua data mahasiswa
    public function getAllMember(){
        // Menyiapkan query SQL untuk mengambil data mahasiswa beserta prodi dan provinsi
        // CATATAN: Perlu dicek apakah nama tabel 'tb_member' sudah benar sesuai skema 'tb_mahasiswa'
        $query = "SELECT t.id, t.nama, t.alamat, d.nama_provinsi , t.email, t.telp, t.status, c.nama_program, t.program
                    FROM tb_member t
                    LEFT JOIN tb_program_latihan c ON t.`program`=c.`kode_program`
                    LEFT JOIN tb_provinsi d ON t.`provinsi`=d.`id_provinsi`
                    ORDER BY t.`nama` DESC";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return[];
        }
        $stmt->execute();
        $result = $stmt->get_result();
        // Menyiapkan array kosong untuk menyimpan data mahasiswa
        $Member = [];
        // Mengecek apakah ada data yang ditemukan
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                $Member[] = [
                    'id' => $row['id'], 
                    'nama' => $row['nama'],
                    'program' => $row['nama_program'],
                    'provinsi' => $row['nama_provinsi'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp'],
                    'status' => $row['status']
                ];
            }
        }
        $stmt->close();
        // Mengembalikan array data mahasiswa
        return $Member;
    }

    // Method untuk mengambil data mahasiswa berdasarkan ID
    public function getUpdateMember($id){
        // Menyiapkan query SQL untuk mengambil data mahasiswa berdasarkan ID menggunakan prepared statement
        // CATATAN: Perlu dicek apakah nama kolom 'id' sudah benar sesuai skema 'id_mhs'
        $query = "SELECT * FROM tb_member WHERE id = ?"; 
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = false;
        if($result->num_rows > 0){
            // Mengambil data mahasiswa  
            $row = $result->fetch_assoc();
            // Menyimpan data dalam array
            $data = [
                'id' => $row['id'],          
                'nama' => $row['nama'],
                'program' => $row['program'],
                'provinsi' => $row['provinsi'],
                'alamat' => $row['alamat'],
                'email' => $row['email'],
                'telp' => $row['telp'],
                'status' => $row['status']
            ];
        }
        $stmt->close();
        // Mengembalikan data mahasiswa
        return $data;
    }

    // Method untuk mengedit data mahasiswa (DIPERBAIKI)
    public function editMember($data){
        // Mengambil data dari parameter $data
        $id       = $data['id'];     
        $nama     = $data['nama'];
        $program  = $data['program'];
        $alamat   = $data['alamat'];
        $provinsi = $data['provinsi'];
        $email    = $data['email'];
        $telp     = $data['telp'];
        $status   = $data['status'];
        
        // Menyiapkan query SQL untuk update data menggunakan prepared statement
        // CATATAN: Query UPDATE sudah benar
        $query = "UPDATE tb_member SET nama = ?, program = ?, alamat = ?, provinsi = ?, email = ?, telp = ?, status = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        if(!$stmt){
            // Cek jika statement gagal disiapkan
            return false;
        }
        
        // Memasukkan parameter ke statement (TIPE DATA DIPERBAIKI)
        // Format string harus 8 karakter: s s s i s s i i 
        // 1. nama(s), 2. program(s), 3. alamat(s), 4. provinsi(i), 5. email(s), 6. telp(s), 7. status(i), 8. id(i)
        $stmt->bind_param("sssissii", $nama, $program, $alamat, $provinsi, $email, $telp, $status, $id);
        
        $result = $stmt->execute();
        
        // Tambahkan cek error eksekusi (optional, tapi sangat disarankan saat debugging)
        if (!$result) {
            // Echo atau log error SQL untuk debugging
            // echo "Error executing query: " . $stmt->error; 
        }
        
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk menghapus data mahasiswa
    public function deleteMember($id){
        // Menyiapkan query SQL untuk delete data menggunakan prepared statement
        $query = "DELETE FROM tb_member WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        // Mengembalikan hasil eksekusi query
        return $result;
    }

    // Method untuk mencari data mahasiswa berdasarkan kata kunci
    public function searchMember($kataKunci){
        // Menyiapkan LIKE query untuk pencarian
        $likeQuery = "%".$kataKunci."%";
        // Menyiapkan query SQL untuk pencarian data mahasiswa menggunakan prepared statement
        $query = "SELECT t.id, t.nama, t.alamat, d.nama_provinsi , t.email, t.telp, t.status, c.nama_program, t.program
                    FROM tb_member t
                    LEFT JOIN tb_program_latihan c ON t.`program`=c.`kode_program`
                    LEFT JOIN tb_provinsi d ON t.`provinsi`=d.`id_provinsi`
                    WHERE t.`nama`= ?";
       
       $stmt = $this->conn->prepare($query);
        if(!$stmt){
            // Mengembalikan array kosong jika statement gagal disiapkan
            return [];
        }
        // Memasukkan parameter ke statement
        $stmt->bind_param("s", $kataKunci);
        $stmt->execute();
        $result = $stmt->get_result();
        // Menyiapkan array kosong untuk menyimpan data mahasiswa
        $Member = [];
        if($result->num_rows > 0){
            // Mengambil setiap baris data dan memasukkannya ke dalam array
            while($row = $result->fetch_assoc()) {
                // Menyimpan data mahasiswa dalam array
                $Member[] = [
                    'id' => $row['id'],
                    'nama' => $row['nama'],
                    'program' => $row['nama_program'],
                    'provinsi' => $row['nama_provinsi'],
                    'alamat' => $row['alamat'],
                    'email' => $row['email'],
                    'telp' => $row['telp'],
                    'status' => $row['status']
                ];
            }
        }
        $stmt->close();
        // Mengembalikan array data mahasiswa yang ditemukan
        return $Member;
    }

}

?>
