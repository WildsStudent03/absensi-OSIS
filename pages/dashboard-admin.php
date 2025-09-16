<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Dashboard Admin OSIS</h1>
            <div class="flex items-center space-x-4">
                <span class="text-slate-300" id="adminName">Admin OSIS</span>
                <a href="../core/logout.php" class="text-red-400 hover:text-red-300 transition-colors">Logout</a>
            </div>
        </div>
    </header>
    
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 min-h-screen border-r border-slate-700">
            <nav class="p-6">
                <ul class="space-y-4">
                    <li><a href="dashboard-admin.php" class="nav-link active">Dashboard</a></li>
                    <li><a href="kelola-anggota.php" class="nav-link">Kelola Anggota</a></li>
                    <li><a href="absensi.php" class="nav-link">Absensi</a></li>
                    <li><a href="laporan.php" class="nav-link">Laporan</a></li>
                    <li><a href="profile.php" class="nav-link">Profile</a></li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Statistik Cards -->
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm">Total Anggota RPL</p>
                            <p class="text-2xl font-bold text-white">25</p>
                        </div>
                        <div class="w-12 h-12 bg-cyan-400/20 rounded-lg flex items-center justify-center">
                            <span class="text-cyan-400 text-xl">👨‍💻</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm">Total Anggota TBSM</p>
                            <p class="text-2xl font-bold text-white">18</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-400/20 rounded-lg flex items-center justify-center">
                            <span class="text-purple-400 text-xl">🏍️</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm">Total Anggota ATPH</p>
                            <p class="text-2xl font-bold text-white">22</p>
                        </div>
                        <div class="w-12 h-12 bg-green-400/20 rounded-lg flex items-center justify-center">
                            <span class="text-green-400 text-xl">🌱</span>
                        </div>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-slate-400 text-sm">Kehadiran Hari Ini</p>
                            <p class="text-2xl font-bold text-white">58/65</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-400/20 rounded-lg flex items-center justify-center">
                            <span class="text-yellow-400 text-xl">✅</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="action-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Kelola Anggota</h3>
                    <p class="text-slate-400 mb-4">Tambah, edit, atau hapus data anggota OSIS</p>
                    <a href="kelola-anggota.php" class="btn-primary">Kelola Anggota</a>
                </div>
                
                <div class="action-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Absensi</h3>
                    <p class="text-slate-400 mb-4">Kelola absensi harian anggota OSIS</p>
                    <a href="absensi.php" class="btn-primary">Buka Absensi</a>
                </div>
                
                <div class="action-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Laporan Mingguan</h3>
                    <p class="text-slate-400 mb-4">Lihat rekap absensi mingguan dan bulanan</p>
                    <a href="laporan.php" class="btn-primary">Lihat Laporan</a>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../assets/common.js"></script>
    <script>
        // Check admin access
        checkAuth('admin');
        
        // Load admin name
        document.getElementById('adminName').textContent = localStorage.getItem('userName') || 'Admin OSIS';
    </script>
</body>
</html>
