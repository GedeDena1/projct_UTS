<?php

// Memasukkan file konfigurasi database
include_once 'db-config.php';

class MasterData extends Database {

    // Method untuk mendapatkan daftar program studi
    public function getProdi(){
        $query = "SELECT * FROM tb_program_latihan";
        $result = $this->conn->query($query);
        $program = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $program[] = [
                    'id' => $row['kode_program'],
                    'nama' => $row['nama_program']
                ];
            }
        }
        return $program;
    }

    // Method untuk mendapatkan daftar provinsi
    public function getProvinsi(){
        $query = "SELECT * FROM tb_provinsi";
        $result = $this->conn->query($query);
        $provinsi = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $provinsi[] = [
                    'id' => $row['id_provinsi'],
                    'nama' => $row['nama_provinsi']
                ];
            }
        }
        return $provinsi;
    }

    // Method untuk mendapatkan daftar status mahasiswa menggunakan array statis
    public function getStatus(){
        return [
            ['id' => 1, 'nama' => 'Aktif'],
            ['id' => 2, 'nama' => 'Tidak Aktif']
        ];
    }

    // Method untuk input data program studi
    public function inputProdi($data){
        $kodeProgram = $data['kode'];
        $namaProgram = $data['nama'];
        $query = "INSERT INTO tb_program_latihan (kode_program, nama_program) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("ss", $kodeProgram, $namaProgram);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk mendapatkan data program studi berdasarkan kode
    public function getUpdateProdi($id){
        $query = "SELECT * FROM tb_program_latihan WHERE kode_program = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $program = null;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $program = [
                'id' => $row['kode_program'],
                'nama' => $row['nama_program']
            ];
        }
        $stmt->close();
        return $program;
    }

    // Method untuk mengedit data program studi
    public function updateProdi($data){
        $kodeProgram = $data['kode'];
        $namaProgram = $data['nama'];
        $query = "UPDATE tb_program_latihan SET nama_program = ? WHERE kode_program = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("ss", $namaProgram, $kodeProgram);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk menghapus data program studi
    public function deleteProdi($id){
        $query = "DELETE FROM tb_program_latihan WHERE kode_program = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk input data provinsi
    public function inputProvinsi($data){
        $namaProvinsi = $data['nama'];
        $query = "INSERT INTO tb_provinsi (nama_provinsi) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("s", $namaProvinsi);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk mendapatkan data provinsi berdasarkan id
    public function getUpdateProvinsi($id){
        $query = "SELECT * FROM tb_provinsi WHERE id_provinsi = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $provinsi = null;
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $provinsi = [
                'id' => $row['id_provinsi'],
                'nama' => $row['nama_provinsi']
            ];
        }
        $stmt->close();
        return $provinsi;
    }

    // Method untuk mengedit data provinsi
    public function updateProvinsi($data){
        $idProvinsi = $data['id'];
        $namaProvinsi = $data['nama'];
        $query = "UPDATE tb_provinsi SET nama_provinsi = ? WHERE id_provinsi = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("si", $namaProvinsi, $idProvinsi);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    // Method untuk menghapus data provinsi
    public function deleteProvinsi($id){
        $query = "DELETE FROM tb_provinsi WHERE id_provinsi = ?";
        $stmt = $this->conn->prepare($query);
        if(!$stmt){
            return false;
        }
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

}

?>