<?php
class PengumumanController {
    private $pengumumanModel; // Holds the Pengumuman model instance

    // Constructor: Load Pengumuman model
    public function __construct($db) {
        require_once __DIR__ . '/../../models/Pengumuman.php';
        $this->pengumumanModel = new Pengumuman($db);
    }

    /**
     * Create a new announcement
     * @param array $data - Form data (id_pengurus, judul, deskripsi)
     * @param array|null $file - Uploaded file (optional)
     * @return array - Result with success flag & message
     */
    public function create($data, $file) {
        // Basic form validation (required fields)
        if (
            empty($data['id_pengurus']) ||
            empty($data['judul']) ||
            empty($data['deskripsi'])
        ) {
            return ['success' => false, 'message' => 'Semua data harus diisi!'];
        }

        // File must exist
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'message' => 'File pendukung wajib diunggah!'];
        }

        // File upload process
        $originalName = $file['name']; // Original filename
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION)); // File extension
        $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'docx']; // Allowed extensions

        // Validate file type
        if (!in_array($ext, $allowedTypes)) {
        return ['success' => false, 'message' => 'File tipe tidak diizinkan!'];
        }

        // Validate file size (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return ['success' => false, 'message' => 'Ukuran file maksimal 2MB!'];
        }

        // Create safe file name (remove special characters)
        $safeName = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $originalName);
        // Add unique ID to avoid overwriting
        $fileNameToStore = uniqid('file_', true) . '_' . $safeName;
        $targetPath = __DIR__ . '/../../assets/uploads/' . $fileNameToStore;

        // Move uploaded file to uploads folder
        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            return ['success' => false, 'message' => 'Gagal menyimpan file!'];
        }

        // Save to database via model
        $result = $this->pengumumanModel->create(
            $data['id_pengurus'],
            $data['judul'],
            $data['deskripsi'],
            $fileNameToStore
        );

        // Return response
        return $result
            ? ['success' => true, 'message' => 'Pengumuman berhasil ditambahkan!']
            : ['success' => false, 'message' => 'Gagal menambahkan pengumuman.'];
    }

    /**
     * Update an existing announcement
     * @param array $data - Form data
     * @param array|null $file - Uploaded file (optional)
     * @return array
     */
    public function update($data, $file) {
        // Validate required fields
        if (
            empty($data['id_pengumuman']) ||
            empty($data['judul']) ||
            empty($data['deskripsi'])
        ) {
            return ['success' => false, 'message' => 'Semua data harus diisi!'];
        }

        // Fetch existing record to update
        $existing = $this->pengumumanModel->getById($data['id_pengumuman']);
        if (!$existing) {
            return ['success' => false, 'message' => 'Data pengumuman tidak ditemukan!'];
        }

        $fileNameToStore = $existing['file_pendukung']; // Keep old file unless replaced

        // Handle file replacement if new file uploaded
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $originalName = $file['name'];
            $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
            $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png', 'docx'];

            if (!in_array($ext, $allowedTypes)) {
                return ['success' => false, 'message' => 'File tipe tidak diizinkan!'];
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                return ['success' => false, 'message' => 'Ukuran file maksimal 2MB!'];
            }

            $safeName = preg_replace('/[^a-zA-Z0-9\._-]/', '_', $originalName);
            $fileNameToStore = uniqid('file_', true) . '_' . $safeName;
            $targetPath = __DIR__ . '/../../assets/uploads/' . $fileNameToStore;

            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                return ['success' => false, 'message' => 'Gagal menyimpan file baru!'];
            }

            // Delete old file if it exists
            if (!empty($existing['file_pendukung'])) {
                $oldFilePath = __DIR__ . '/../../assets/uploads/' . $existing['file_pendukung'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }
        }

        // Save updated data to database
        $result = $this->pengumumanModel->update(
            $data['id_pengumuman'],
            $data['judul'],
            $data['deskripsi'],
            $fileNameToStore
        );

        return $result
            ? ['success' => true, 'message' => 'Pengumuman berhasil diperbarui!']
            : ['success' => false, 'message' => 'Gagal memperbarui pengumuman.'];
    }

    /**
     * Delete an announcement
     * @param int $id - Announcement ID
     * @return array
     */
    public function delete($id) {
        // Check if record exists
        $existing = $this->pengumumanModel->getById($id);
        if (!$existing) {
            return ['success' => false, 'message' => 'Data pengumuman tidak ditemukan!'];
        }

        // Delete record from database
        $result = $this->pengumumanModel->delete($id);

        return $result
            ? ['success' => true, 'message' => 'Pengumuman berhasil dihapus!']
            : ['success' => false, 'message' => 'Gagal menghapus pengumuman.'];
    }

    /**
     * Get all announcements with pengurus data
     * @return array
     */
    public function getAllWithPengurus() {
        return $this->pengumumanModel->getAll(true); // use model's withPengurus flag
    }

    /**
     * Get one announcement by ID with pengurus data
     * @return array
     */
    public function getByIdWithPengurus($id) {
        return $this->pengumumanModel->getById($id, true); // use model's withPengurus flag
    }

    /**
     * Get total number of announcements
     * @return int|false
     */
    public function countAllPengumuman() {
        return $this->pengumumanModel->countAllPengumuman();
    }
}
?>
