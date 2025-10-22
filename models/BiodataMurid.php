<?php
class BiodataMurid {
    private $conn;                  // Database connection
    private $table = 'biodata_murid'; // Table name

    // Constructor: Receives PDO connection
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create new student biodata
     * @param int $id_user
     * @param string $nama
     * @param int $umur
     * @param string $jenis_kelamin
     * @param string $tempat_lahir
     * @param string $tanggal_lahir
     * @param string $asal_tk
     * @param string $alamat
     * @param string $nik
     * @param string $no_kk
     * @param string $file_akta
     * @param string $file_kk
     * @param string $file_ijazah
     * @return bool
     */
    public function create($id_user, $nama_murid, $umur_murid, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $asal_tk, $alamat, $nik, $no_kk, $file_akta, $file_kk, $file_ijazah) {
        try {
            // Validate files
            foreach (['file_akta' => $file_akta, 'file_kk' => $file_kk, 'file_ijazah' => $file_ijazah] as $name => $file) {
                if (empty($file)) {
                    throw new InvalidArgumentException("File $name harus diisi!");
                }
            }


            $sql = "INSERT INTO {$this->table} 
                    (id_user, nama_murid, umur_murid, jenis_kelamin, tempat_lahir, tanggal_lahir, asal_tk, alamat, nik, no_kk, file_akta, file_kk, file_ijazah)
                    VALUES 
                    (:id_user, :nama_murid, :umur_murid, :jk, :tempat_lahir, :tanggal_lahir, :asal_tk, :alamat, :nik, :no_kk, :file_akta, :file_kk, :file_ijazah)";
            
            $stmt = $this->conn->prepare($sql);
            
            $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->bindValue(':nama_murid', $nama_murid, PDO::PARAM_STR);
            $stmt->bindValue(':umur_murid', $umur_murid, PDO::PARAM_INT);
            $stmt->bindValue(':jk', $jenis_kelamin, PDO::PARAM_STR);
            $stmt->bindValue(':tempat_lahir', $tempat_lahir, PDO::PARAM_STR);
            $stmt->bindValue(':tanggal_lahir', $tanggal_lahir, PDO::PARAM_STR);
            $stmt->bindValue(':asal_tk', $asal_tk, PDO::PARAM_STR);
            $stmt->bindValue(':alamat', $alamat, PDO::PARAM_STR);
            $stmt->bindValue(':nik', $nik, PDO::PARAM_STR);
            $stmt->bindValue(':no_kk', $no_kk, PDO::PARAM_STR);
            $stmt->bindValue(':file_akta', $file_akta, PDO::PARAM_STR);
            $stmt->bindValue(':file_kk', $file_kk, PDO::PARAM_STR);
            $stmt->bindValue(':file_ijazah', $file_ijazah, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("BiodataMurid create error: " . $e->getMessage());
            return false;
        } catch (InvalidArgumentException $e) {
            error_log("BiodataMurid create validation error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update student biodata
     */
    public function update($id_biodata, $nama_murid, $umur_murid, $jenis_kelamin, $tempat_lahir, $tanggal_lahir, $asal_tk, $alamat, $nik, $no_kk, $file_akta = null, $file_kk = null, $file_ijazah = null) {
        try {
            $sql = "UPDATE {$this->table} SET
                    nama_murid = :nama_murid,
                    umur_murid = :umur_murid,
                    jenis_kelamin = :jk,
                    tempat_lahir = :tempat_lahir,
                    tanggal_lahir = :tanggal_lahir,
                    asal_tk = :asal_tk,
                    alamat = :alamat,
                    nik = :nik,
                    no_kk = :no_kk";
            
            // Add file fields only if provided
            if (!empty($file_akta)) {
                $sql .= ", file_akta = :file_akta";
            }
            if (!empty($file_kk)) {
                $sql .= ", file_kk = :file_kk";
            }
            if (!empty($file_ijazah)) {
                $sql .= ", file_ijazah = :file_ijazah";
            }

            $sql .= " WHERE id_biodata = :id_biodata";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id_biodata', $id_biodata, PDO::PARAM_INT);
            $stmt->bindValue(':nama_murid', $nama_murid, PDO::PARAM_STR);
            $stmt->bindValue(':umur_murid', $umur_murid, PDO::PARAM_INT);
            $stmt->bindValue(':jk', $jenis_kelamin, PDO::PARAM_STR);
            $stmt->bindValue(':tempat_lahir', $tempat_lahir, PDO::PARAM_STR);
            $stmt->bindValue(':tanggal_lahir', $tanggal_lahir, PDO::PARAM_STR);
            $stmt->bindValue(':asal_tk', $asal_tk, PDO::PARAM_STR);
            $stmt->bindValue(':alamat', $alamat, PDO::PARAM_STR);
            $stmt->bindValue(':nik', $nik, PDO::PARAM_STR);
            $stmt->bindValue(':no_kk', $no_kk, PDO::PARAM_STR);
            
            // Bind file fields only if provided
            if (!empty($file_akta)) {
                $stmt->bindValue(':file_akta', $file_akta, PDO::PARAM_STR);
            }
            if (!empty($file_kk)) {
                $stmt->bindValue(':file_kk', $file_kk, PDO::PARAM_STR);
            }
            if (!empty($file_ijazah)) {
                $stmt->bindValue(':file_ijazah', $file_ijazah, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("BiodataMurid update error: " . $e->getMessage());
            return false;
        } 
    }

    /**
     * Delete student biodata and associated files
     * @param int $id_biodata
     * @return bool
     */
    public function delete($id_biodata) {
        try {
            // Get file names first
            $sql = "SELECT file_akta, file_kk, file_ijazah FROM {$this->table} WHERE id_biodata = :id_biodata";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_biodata', $id_biodata, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            // Delete files from folder
            if ($data) {
                $uploadDir = __DIR__ . '/../assets/uploads/';
                foreach (['file_akta', 'file_kk', 'file_ijazah'] as $field) {
                    if (!empty($data[$field])) {
                        $filePath = $uploadDir . $data[$field];
                        // Delete only if file exists
                        if (is_file($filePath)) {
                            if (!unlink($filePath)) {
                                error_log("BiodataMurid delete file error: Could not delete {$filePath}");
                            }
                        }
                    }
                }
            }

            // Delete database record
            $sql = "DELETE FROM {$this->table} WHERE id_biodata = :id_biodata";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_biodata', $id_biodata, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("BiodataMurid delete error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get student biodata by user ID
     * @param int $id_user
     * @return array|null
     */
    public function getByUserId($id_user) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_user = :id_user LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BiodataMurid getByUserId error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all student biodata
     * @return array
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id_biodata DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BiodataMurid getAll error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Count gender based from jenis kelamin
     * @param string $jenis_kelamin
     * @return int|false - Total gender or false on error
     */
    public function countByGender(string $jenis_kelamin): int {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE jenis_kelamin = :jenis_kelamin";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':jenis_kelamin', $jenis_kelamin, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (int) $result['total'] : 0;
        } catch (PDOException $e) {
            error_log("BiodataMurid countByGender error: " . $e->getMessage());
            return false;
        }
    }
}
?>
