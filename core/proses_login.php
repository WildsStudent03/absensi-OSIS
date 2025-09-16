<?php
include '../database/connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['emailNis'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];
    if (empty($user) || empty($password)) {
        $errors[] = 'Email/NIS dan password wajib diisi!';
    } else {
        // Cek user by username (NIS) atau email
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? OR email = ? LIMIT 1');
        $stmt->bind_param('ss', $user, $user);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        if ($data && password_verify($password, $data['password'])) {
            $_SESSION['user'] = [
                'id_user' => $data['id_user'],
                'username' => $data['username'],
                'nama_lengkap' => $data['nama_lengkap'],
                'role' => $data['role']
            ];
            if ($data['role'] === 'admin') {
                header('Location: ../pages/dashboard-admin.php');
            } else {
                header('Location: ../pages/dashboard-member.php');
            }
            exit;
        } else {
            $errors[] = 'Email/NIS atau password salah!';
        }
        $stmt->close();
    }
    $_SESSION['login_errors'] = $errors;
    header('Location: ../index.php');
    exit;
} else {
    header('Location: ../index.php');
    exit;
}
