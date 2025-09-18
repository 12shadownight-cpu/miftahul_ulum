document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    const nama = document.querySelector("#nama");
    const username = document.querySelector("#username");
    const password = document.querySelector("#password");
    const email = document.querySelector("#email");
    const noHp = document.querySelector("#no_hp");

    form.addEventListener("submit", function (e) {
        let isValid = true;
        let message = "";

        // Nama: only letters and spaces
        const namaRegex = /^[A-Za-z\s]+$/;
        if (!nama.value.trim()) {
            isValid = false;
            message += "- Nama tidak boleh kosong\n";
        } else if (!namaRegex.test(nama.value)) {
            isValid = false;
            message += "- Nama hanya boleh berisi huruf dan spasi\n";
        }

        // Username: no spaces, between 4-20 chars
        if (!username.value.trim()) {
            isValid = false;
            message += "- Username tidak boleh kosong\n";
        } else if (username.value.length < 4 || username.value.length < 20) {
            isValid = false;
            message += "- Username minimal 4 hingga 20 karakter\n";
        } else if (/\s/.test(username.value)) {
            isValid = false;
            message += "- Username tidak boleh mengandung spasi\n";
        }

        // Password: min 6 chars
        if (!password.value.trim()) {
            isValid = false;
            message += "- Password tidak boleh kosong\n";
        } else if (password.value.length < 6) {
            isValid = false;
            message += "- Password minimal 6 karakter\n";
        }

        // Email: basic pattern
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!email.value.trim()) {
            isValid = false;
            message += "- Email tidak boleh kosong\n";
        } else if (!emailRegex.test(email.value)) {
            isValid = false;
            message += "- Format email tidak valid\n";
        }

        // No HP: only digits, at least 10 digits
        const phoneRegex = /^[0-9]{10,}$/;
        if (!noHp.value.trim()) {
            isValid = false;
            message += "- Nomor HP tidak boleh kosong\n";
        } else if (!phoneRegex.test(noHp.value)) {
            isValid = false;
            message += "- Nomor HP harus berupa angka minimal 10 digit\n";
        }

        // Show error and prevent submission
        if (!isValid) {
            e.preventDefault();
            alert("Terjadi kesalahan:\n\n" + message);
        }
    });
});
