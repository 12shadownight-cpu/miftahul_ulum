<?php
class BiodataOrangtua {
    private $conn;                 // Database connection
    private $table = 'biodata_orangtua'; // Table name

    // Constructor: Receives PDO connection
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create new biodata orangtua
     * @param int $id_user
     * @param string $nama_ayah
     * @param string $tempat_lahir_ayah
     * @param string $tanggal_lahir_ayah
     * @param string $pekerjaan_ayah
     * @param string $hp_ayah
     * @param string $nik_ayah
     * @param string $kk_ayah
     * @param string|null $file_ktp_ayah
     * @param string $nama_ibu
     * @param string $tempat_lahir_ibu
     * @param string $tanggal_lahir_ibu
     * @param string $pekerjaan_ibu
     * @param string $hp_ibu
     * @param string $nik_ibu
     * @param string $kk_ibu
     * @param string|null $file_ktp_ibu
     * @return bool
     */
    public function create($id_user, $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $pekerjaan_ayah, $hp_ayah, $nik_ayah, $kk_ayah, $file_ktp_ayah, $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $pekerjaan_ibu, $hp_ibu, $nik_ibu, $kk_ibu, $file_ktp_ibu) {
        try {
            // Validate files
            foreach (['file_ktp_ayah' => $file_ktp_ayah, 'file_ktp_ibu' => $file_ktp_ibu] as $name => $file) {
                if (empty($file)) {
                    throw new InvalidArgumentException("File $name harus diisi!");
                }
            }

            $sql = "INSERT INTO {$this->table} 
                    (id_user, nama_ayah, tempat_lahir_ayah, tanggal_lahir_ayah, pekerjaan_ayah, hp_ayah, nik_ayah, kk_ayah, file_ktp_ayah, 
                     nama_ibu, tempat_lahir_ibu, tanggal_lahir_ibu, pekerjaan_ibu, hp_ibu, nik_ibu, kk_ibu, file_ktp_ibu)
                    VALUES 
                    (:id_user, :nama_ayah, :tempat_lahir_ayah, :tanggal_lahir_ayah, :pekerjaan_ayah, :hp_ayah, :nik_ayah, :kk_ayah, :file_ktp_ayah,
                     :nama_ibu, :tempat_lahir_ibu, :tanggal_lahir_ibu, :pekerjaan_ibu, :hp_ibu, :nik_ibu, :kk_ibu, :file_ktp_ibu)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->bindValue(':nama_ayah', $nama_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':tempat_lahir_ayah', $tempat_lahir_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':tanggal_lahir_ayah', $tanggal_lahir_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':pekerjaan_ayah', $pekerjaan_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':hp_ayah', $hp_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':nik_ayah', $nik_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':kk_ayah', $kk_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':file_ktp_ayah', $file_ktp_ayah, PDO::PARAM_STR);

            $stmt->bindValue(':nama_ibu', $nama_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':tempat_lahir_ibu', $tempat_lahir_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':tanggal_lahir_ibu', $tanggal_lahir_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':pekerjaan_ibu', $pekerjaan_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':hp_ibu', $hp_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':nik_ibu', $nik_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':kk_ibu', $kk_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':file_ktp_ibu', $file_ktp_ibu, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("BiodataOrangtua create error: " . $e->getMessage());
            return false;
        } catch (InvalidArgumentException $e) {
            error_log("BiodataOrangtua create validation error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update biodata orangtua
     * @param int $id_orangtua
     * @param string $nama_ayah
     * @param string $tempat_lahir_ayah
     * @param string $tanggal_lahir_ayah
     * @param string $pekerjaan_ayah
     * @param string $hp_ayah
     * @param string $nik_ayah
     * @param string $kk_ayah
     * @param string|null $file_ktp_ayah
     * @param string $nama_ibu
     * @param string $tempat_lahir_ibu
     * @param string $tanggal_lahir_ibu
     * @param string $pekerjaan_ibu
     * @param string $hp_ibu
     * @param string $nik_ibu
     * @param string $kk_ibu
     * @param string|null $file_ktp_ibu
     * @return bool
     */
    public function update($id_orangtua, $nama_ayah, $tempat_lahir_ayah, $tanggal_lahir_ayah, $pekerjaan_ayah, $hp_ayah, $nik_ayah, $kk_ayah, $file_ktp_ayah = null, $nama_ibu, $tempat_lahir_ibu, $tanggal_lahir_ibu, $pekerjaan_ibu, $hp_ibu, $nik_ibu, $kk_ibu, $file_ktp_ibu = null) {
        try {
            $sql = "UPDATE {$this->table} SET
                        nama_ayah = :nama_ayah,
                        tempat_lahir_ayah = :tempat_lahir_ayah,
                        tanggal_lahir_ayah = :tanggal_lahir_ayah,
                        pekerjaan_ayah = :pekerjaan_ayah,
                        hp_ayah = :hp_ayah,
                        nik_ayah = :nik_ayah,
                        kk_ayah = :kk_ayah,
                        nama_ibu = :nama_ibu,
                        tempat_lahir_ibu = :tempat_lahir_ibu,
                        tanggal_lahir_ibu = :tanggal_lahir_ibu,
                        pekerjaan_ibu = :pekerjaan_ibu,
                        hp_ibu = :hp_ibu,
                        nik_ibu = :nik_ibu,
                        kk_ibu = :kk_ibu";
            
            // Add file fields only if provided
            if (!empty($file_ktp_ayah)) {
                $sql .= ", file_ktp_ayah = :file_ktp_ayah";
            }
            if (!empty($file_ktp_ibu)) {
                $sql .= ", file_ktp_ibu = :file_ktp_ibu";
            }

            $sql .= " WHERE id_orangtua = :id_orangtua";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id_orangtua', $id_orangtua, PDO::PARAM_INT);
            $stmt->bindValue(':nama_ayah', $nama_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':tempat_lahir_ayah', $tempat_lahir_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':tanggal_lahir_ayah', $tanggal_lahir_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':pekerjaan_ayah', $pekerjaan_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':hp_ayah', $hp_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':nik_ayah', $nik_ayah, PDO::PARAM_STR);
            $stmt->bindValue(':kk_ayah', $kk_ayah, PDO::PARAM_STR);

            $stmt->bindValue(':nama_ibu', $nama_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':tempat_lahir_ibu', $tempat_lahir_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':tanggal_lahir_ibu', $tanggal_lahir_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':pekerjaan_ibu', $pekerjaan_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':hp_ibu', $hp_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':nik_ibu', $nik_ibu, PDO::PARAM_STR);
            $stmt->bindValue(':kk_ibu', $kk_ibu, PDO::PARAM_STR);
            
            // Bind file values only if present
            if (!empty($file_ktp_ayah)) {
                $stmt->bindValue(':file_ktp_ayah', $file_ktp_ayah, PDO::PARAM_STR);
            }
            if (!empty($file_ktp_ibu)) {
                $stmt->bindValue(':file_ktp_ibu', $file_ktp_ibu, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("BiodataOrangtua update error: " . $e->getMessage());
            return false;
        } 
    }

    /**
     * Delete biodata orangtua
     * @param int $id_orangtua
     * @return bool
     */
    public function delete($id_orangtua) {
        try {
            // Fetch files first
            $sql = "SELECT file_ktp_ayah, file_ktp_ibu FROM {$this->table} WHERE id_orangtua = :id_orangtua";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_orangtua', $id_orangtua, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $uploadDir = __DIR__ . '/../../assets/uploads/';
                foreach (['file_ktp_ayah', 'file_ktp_ibu'] as $field) {
                    if (!empty($data[$field])) {
                        $filePath = $uploadDir . $data[$field];
                        // Delete only if file exists
                        if (is_file($filePath)) {
                            if (!unlink($filePath)) {
                                error_log("BiodataOrangtua delete file error: Could not delete {$filePath}");
                            }
                        }
                    }
                }
            }

            // Delete record
            $sql = "DELETE FROM {$this->table} WHERE id_orangtua = :id_orangtua";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_orangtua', $id_orangtua, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("BiodataOrangtua delete error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get biodata orangtua by user ID
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
            error_log("BiodataOrangtua getByUserId error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get all biodata orangtua
     * @return array
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id_orangtua DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("BiodataOrangtua getAll error: " . $e->getMessage());
            return [];
        }
    }
}
?>
