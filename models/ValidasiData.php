<?php
class ValidasiData {
    private $conn;                // Database connection
    private $table = 'validasi_data'; // Table name

    // Constructor: Receives PDO connection
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create new validation record
     * @param int $id_user
     * @param int $id_biodata
     * @param int $id_orangtua
     * @param string $hasil
     * @param string $keterangan
     * @return bool
     */
    public function create($id_user, $id_biodata, $id_orangtua, $hasil, $keterangan) {
        try {
            $sql = "INSERT INTO {$this->table}
                    (id_user, id_biodata, id_orangtua, hasil, keterangan)
                    VALUES (:id_user, :id_biodata, :id_orangtua, :hasil, :keterangan)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_user', $id_user, PDO::PARAM_INT);
            $stmt->bindValue(':id_biodata', $id_biodata, PDO::PARAM_INT);
            $stmt->bindValue(':id_orangtua', $id_orangtua, PDO::PARAM_INT);
            $stmt->bindValue(':hasil', $hasil, PDO::PARAM_STR);
            $stmt->bindValue(':keterangan', $keterangan, PDO::PARAM_STR);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ValidasiData create error: " . $e->getMessage());
            return false;
        } 
    }

    /**
     * Get all validation records
     * @return array
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY id_validasi DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ValidasiData getAll error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get validation record by ID
     * @param int $id_validasi
     * @return array|null
     */
    public function getById($id_validasi) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE id_validasi = :id_validasi";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_validasi', $id_validasi, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ValidasiData getById error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update validation record
     * @param int $id_validasi
     * @param string $hasil
     * @param string|null $keterangan
     * @return bool
     */
    public function update($id_validasi, $hasil, $keterangan) {
        try {
            $sql = "UPDATE {$this->table}
                    SET hasil = :hasil,
                        keterangan = :keterangan
                    WHERE id_validasi = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':hasil', $hasil, PDO::PARAM_STR);
            $stmt->bindValue(':keterangan', $keterangan, PDO::PARAM_STR);
            $stmt->bindValue(':id', $id_validasi, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ValidasiData update error: " . $e->getMessage());
            return false;
        } 
    }

    /**
     * Delete validation record
     * @param int $id_validasi
     * @return bool
     */
    public function delete($id_validasi) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id_validasi = :id_validasi";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_validasi', $id_validasi, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("ValidasiData delete error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all validation records with related user, student, and parent data
     * @return array
     */
    public function getAllWithRelations() {
        try {
            $sql = "SELECT v.*, 
                           u.nama_user AS nama_user, 
                           b.nama_murid AS nama_murid, 
                           o.nama_ayah
                    FROM {$this->table} v
                    JOIN data_user u ON v.id_user = u.id_user
                    JOIN biodata_murid b ON v.id_biodata = b.id_biodata
                    JOIN biodata_orangtua o ON v.id_orangtua = o.id_orangtua
                    ORDER BY v.id_validasi DESC";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ValidasiData getAllWithRelations error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get single validation record with related user, student, and parent data
     * @param int $id_validasi
     * @return array|null
     */
    public function getByIdWithRelations($id_validasi) {
        try {
            $sql = "SELECT v.*, 
                           u.nama_user AS nama_user, 
                           b.nama_murid AS nama_murid, 
                           o.nama_ayah
                    FROM {$this->table} v
                    JOIN data_user u ON v.id_user = u.id_user
                    JOIN biodata_murid b ON v.id_biodata = b.id_biodata
                    JOIN biodata_orangtua o ON v.id_orangtua = o.id_orangtua
                    WHERE v.id_validasi = :id
                    LIMIT 1";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id', $id_validasi, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("ValidasiData getByIdWithRelations error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Count result based from hasil
     * @param string $hasil
     * @return int|false - Total result or false on error
     */
    public function countByHasil(string $hasil): int {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE hasil = :hasil";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':hasil', $hasil, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? (int) $result['total'] : 0;
        } catch (PDOException $e) {
            error_log("ValidasiData countByHasil error: " . $e->getMessage());
            return false;
        }
    }
}
?>
