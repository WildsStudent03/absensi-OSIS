
<?php
include 'database/connect.php';
session_start();

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['role'] === 'admin') {
        header('Location: pages/dashboard-admin.php');
    } else {
        header('Location: pages/dashboard-member.php');
    }
    exit;
}

$errors = $_SESSION['login_errors'] ?? [];
unset($_SESSION['login_errors']);
?>


<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="login-card w-full max-w-md bg-slate-800 rounded-xl shadow-2xl border border-slate-700 p-8 opacity-0 transform translate-y-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2 typing-text">Login Sistem Absensi OSIS</h1>
            <p class="text-slate-400">Masuk ke akun Anda</p>
        </div>
        
        <?php if (!empty($errors)): ?>
            <div class="mb-4 p-4 bg-red-600 text-white rounded-lg">
                <?php foreach ($errors as $err): ?>
                    <div><?= htmlspecialchars($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form id="loginForm" class="space-y-6" method="POST" action="core/proses_login.php">
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Email/NIS</label>
                <input type="text" id="emailNis" name="emailNis" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="Masukkan email atau NIS" required>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="Masukkan password" required>
            </div>
            
            <button type="submit" class="w-full bg-gradient-to-r from-cyan-400 to-purple-500 text-white font-semibold py-3 px-4 rounded-lg hover:shadow-lg hover:shadow-cyan-400/25 transition-all duration-300 transform hover:scale-105">
                Login
            </button>
        </form>
        
        <div class="mt-6 text-center">
            <p class="text-slate-400">Belum punya akun? 
                <a href="pages/register.php" class="text-cyan-400 hover:text-cyan-300 transition-colors">Daftar di sini</a>
            </p>
        </div>
    </div>
    <script src="assets/common.js"></script>
</body>
</html>
