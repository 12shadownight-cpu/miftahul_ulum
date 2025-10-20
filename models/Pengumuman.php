<?php
class Pengumuman {
    private $conn;             // Database connection
    private $table = 'pengumuman'; // Table name

    // Constructor: Receives PDO connection
    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Create new announcement
     * @param int $id_pengurus 
     * @param string $judul 
     * @param string $deskripsi 
     * @param string|null $file_pendukung 
     * @return bool - True if success, False if failed
     */
    public function create($id_pengurus, $judul, $deskripsi, $file_pendukung) {
        try {
            // Validation file
            if (empty($file_pendukung)) {
                throw new InvalidArgumentException("File harus diisi!");
            }

            // SQL Insert query
            $sql = "INSERT INTO {$this->table} 
                    (id_pengurus, judul, deskripsi, file_pendukung)
                    VALUES (:id_pengurus, :judul, :deskripsi, :file_pendukung)";

            // Prepare statement
            $stmt = $this->conn->prepare($sql);

            // Bind values safely (bindValue is safer for nullable params)
            $stmt->bindValue(':id_pengurus', $id_pengurus, PDO::PARAM_INT);
            $stmt->bindValue(':judul', $judul, PDO::PARAM_STR);
            $stmt->bindValue(':deskripsi', $deskripsi, PDO::PARAM_STR);
            $stmt->bindValue(':file_pendukung', $file_pendukung, PDO::PARAM_STR);

            // Execute and return success/fail
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error message instead of displaying to user
            error_log("Pengumuman create error: " . $e->getMessage());
            return false;
        } catch (InvalidArgumentException $e) {
            error_log("Pengumuman create validation error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all announcements
     * @param bool $withPengurus - Whether to join with pengurus table
     * @return array - List of announcements
     */
    public function getAll($withPengurus = false) {
        try {
            // If join with pengurus table
            if ($withPengurus) {
                $sql = "SELECT p.*, d.nama_pengurus 
                        FROM {$this->table} p
                        JOIN data_pengurus d ON p.id_pengurus = d.id_pengurus
                        ORDER BY p.waktu_terbit DESC";
            } else {
                // Without join
                $sql = "SELECT * FROM {$this->table} ORDER BY waktu_terbit DESC";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            // Fetch all rows as associative array
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Pengumuman getAll error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get announcement by ID
     * @param int $id_pengurus - Staff ID
     * @param bool $withPengurus - Whether to join with pengurus table
     * @return array|null - Announcement data or null if not found
     */
    public function getById($id_pengurus, $withPengurus = false) {
        try {
            // Query based on whether join is needed
            if ($withPengurus) {
                $sql = "SELECT p.*, d.nama_pengurus
                        FROM {$this->table} p
                        JOIN data_pengurus d ON p.id_pengurus = d.id_pengurus
                        WHERE p.id_pengurus = :id_pengurus
                        LIMIT 1";
            } else {
                $sql = "SELECT * FROM {$this->table} 
                        WHERE id_pengurus = :id_pengurus
                        LIMIT 1";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_pengumuman', $id_pengurus, PDO::PARAM_INT);
            $stmt->execute();

            // Return single row or null
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Pengumuman getById error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Update announcement
     * @param int $id_pengumuman
     * @param string $judul
     * @param string $deskripsi
     * @param string|null $file_pendukung
     * @return bool
     */
    public function update($id_pengumuman, $judul, $deskripsi, $file_pendukung = null) {
        try {
            $sql = "UPDATE {$this->table}
                    SET judul = :judul,
                        deskripsi = :deskripsi";
            
            // Add file field only if provided
            if (!empty($file_pendukung)) {
                $sql .= ", file_pendukung = :file_pendukung";
            }

            $sql .= " WHERE id_pengumuman = :id_pengumuman";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':judul', $judul, PDO::PARAM_STR);
            $stmt->bindValue(':deskripsi', $deskripsi, PDO::PARAM_STR);
            $stmt->bindValue(':id_pengumuman', $id_pengumuman, PDO::PARAM_INT);

            // Bind file field only if provided
            if (!empty($file_pendukung)) {
                $stmt->bindValue(':file_pendukung', $file_pendukung, PDO::PARAM_STR);
            }

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Pengumuman update error: " . $e->getMessage());
            return false;
        } 
    }

    /**
     * Delete announcement
     * @param int $id_pengumuman
     * @return bool
     */
    public function delete($id_pengumuman) {
        try {
            // Fetch files first
            $sql = "SELECT file_pendukung FROM {$this->table} WHERE id_pengumuman = :id_pengumuman";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_pengumuman', $id_pengumuman, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $uploadDir = __DIR__ . '/../assets/uploads/';
                foreach (['file_pendukung'] as $field) {
                    if (!empty($data[$field])) {
                        $filePath = $uploadDir . $data[$field];
                        // Delete only if file exists
                        if (is_file($filePath)) {
                            if (!unlink($filePath)) {
                                error_log("Pengumuman delete file error: Could not delete {$filePath}");
                            }
                        }
                    }
                }
            }

            //Delete Records
            $sql = "DELETE FROM {$this->table} WHERE id_pengumuman = :id_pengumuman";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':id_pengumuman', $id_pengumuman, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Pengumuman delete error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Count all announcements
     * @return int|false - Total announcements or false on error
     */
    public function countAllPengumuman() {
        try {
            $sql = "SELECT COUNT(*) as total FROM {$this->table}";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return (int)$result['total'];
        } catch (PDOException $e) {
            error_log("Pengumuman countAllPengumuman error: " . $e->getMessage());
            return false;
        }
    }
}
?>
