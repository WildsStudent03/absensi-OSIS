<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'anggota') {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Anggota - Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Dashboard Anggota OSIS</h1>
            <div class="flex items-center space-x-4">
                <span class="text-slate-300" id="memberName">Anggota OSIS</span>
                <a href="../core/logout.php" class="text-red-400 hover:text-red-300 transition-colors">Logout</a>
            </div>
        </div>
    </header>
    
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 min-h-screen border-r border-slate-700">
            <nav class="p-6">
                <ul class="space-y-4">
                    <li><a href="dashboard-member.php" class="nav-link active">Dashboard</a></li>
                    <li><a href="absensi.php" class="nav-link">Absensi</a></li>
                    <li><a href="profile.php" class="nav-link">Profile</a></li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Profile Card -->
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 mb-8 glow-card">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 bg-gradient-to-r from-cyan-400 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        A
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-white" id="profileName">Anggota OSIS</h2>
                        <p class="text-slate-400" id="profileDetails">NIS: 12345 | Jurusan: RPL | Jabatan: Anggota</p>
                    </div>
                </div>
            </div>
            
            <!-- Quick Action -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="action-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Absen Hari Ini</h3>
                    <p class="text-slate-400 mb-4">Lakukan absensi untuk hari ini</p>
                    <button onclick="quickAttendance()" class="btn-primary w-full">Absen Sekarang</button>
                </div>
                
                <div class="stat-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Status Absensi Bulan Ini</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Hadir</span>
                            <span class="text-green-400 font-semibold">18 hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Izin</span>
                            <span class="text-yellow-400 font-semibold">2 hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Sakit</span>
                            <span class="text-blue-400 font-semibold">1 hari</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Alpha</span>
                            <span class="text-red-400 font-semibold">0 hari</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Riwayat Absensi -->
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 glow-card">
                <h3 class="text-lg font-semibold text-white mb-4">Riwayat Absensi Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="text-left text-slate-400 py-2">Tanggal</th>
                                <th class="text-left text-slate-400 py-2">Status</th>
                                <th class="text-left text-slate-400 py-2">Waktu</th>
                            </tr>
                        </thead>
                        <tbody id="attendanceHistory">
                            <tr class="border-b border-slate-700/50">
                                <td class="py-3 text-white">2024-01-15</td>
                                <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                                <td class="py-3 text-slate-400">08:00</td>
                            </tr>
                            <tr class="border-b border-slate-700/50">
                                <td class="py-3 text-white">2024-01-14</td>
                                <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                                <td class="py-3 text-slate-400">07:55</td>
                            </tr>
                            <tr class="border-b border-slate-700/50">
                                <td class="py-3 text-white">2024-01-13</td>
                                <td class="py-3"><span class="status-badge status-izin">Izin</span></td>
                                <td class="py-3 text-slate-400">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../assets/common.js"></script>
    <script>
       
        checkAuth('member');
        
        // Load member data
        document.getElementById('memberName').textContent = localStorage.getItem('userName') || 'Anggota OSIS';
        document.getElementById('profileName').textContent = localStorage.getItem('userName') || 'Anggota OSIS';
        
        function quickAttendance() {
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            
            if (confirm('Konfirmasi absensi untuk hari ini?')) {
                showNotification('Absensi berhasil dicatat pada ' + time, 'success');
                
                // Add to history
                const tbody = document.getElementById('attendanceHistory');
                const newRow = document.createElement('tr');
                newRow.className = 'border-b border-slate-700/50';
                newRow.innerHTML = `
                    <td class="py-3 text-white">${now.toLocaleDateString('id-ID')}</td>
                    <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                    <td class="py-3 text-slate-400">${time}</td>
                `;
                tbody.insertBefore(newRow, tbody.firstChild);
            }
        }
    </script>
</body>
</html>
