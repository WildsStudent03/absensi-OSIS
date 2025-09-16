<?php
include '../database/connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $jurusan = $_POST['jurusan'] ?? null;
    $jabatan = $_POST['jabatan'] ?? null;
    $role = trim($_POST['role'] ?? 'anggota');
    $admin_code = $_POST['admin_code'] ?? '';

    $errors = [];
    if (empty($username) || empty($email) || empty($password) || empty($nama_lengkap)) {
        $errors[] = 'Field utama wajib diisi!';
    }

    // Validasi role dan kode admin
    if ($role === 'admin') {
        $valid_admin_code = getenv('ADMIN_CODE') ?: 'admin123';
        if ($admin_code !== $valid_admin_code) {
            $errors[] = 'Kode admin tidak valid!';
        }
    } else {
        // Untuk anggota, jurusan dan jabatan wajib diisi
        if (empty($jurusan) || empty($jabatan)) {
            $errors[] = 'Jurusan dan Jabatan wajib diisi untuk anggota!';
        }
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Format email tidak valid!';
    }
    if (strlen($password) < 6) {
        $errors[] = 'Password minimal 6 karakter!';
    }
    // Cek username/email sudah ada
    $stmt = $conn->prepare('SELECT id_user FROM users WHERE username = ? OR email = ?');
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = 'Username atau email sudah terdaftar!';
    }
    $stmt->close();

    if (count($errors) === 0) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (username, email, password, nama_lengkap, role, jurusan, jabatan) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('sssssss', $username, $email, $hash, $nama_lengkap, $role, $jurusan, $jabatan);
        if ($stmt->execute()) {
            header('Location: ../index.php?register=success');
            exit;
        } else {
            $errors[] = 'Gagal mendaftar. Silakan coba lagi.';
        }
        $stmt->close();
    }
    // Jika error, tampilkan pesan
    session_start();
    $_SESSION['register_errors'] = $errors;
    header('Location: ../pages/register.php');
    exit;
} else {
    header('Location: ../pages/register.php');
    exit;
}
