<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Laporan Absensi OSIS</h1>
            <div class="flex items-center space-x-4">
                <span class="text-slate-300" id="adminName">Admin OSIS</span>
                <button onclick="logout()" class="text-red-400 hover:text-red-300 transition-colors">Logout</button>
            </div>
        </div>
    </header>
    
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 min-h-screen border-r border-slate-700">
            <nav class="p-6">
                <ul class="space-y-4">
                    <li><a href="dashboard-admin.php" class="nav-link">Dashboard</a></li>
                    <li><a href="kelola-anggota.php" class="nav-link">Kelola Anggota</a></li>
                    <li><a href="absensi.php" class="nav-link">Absensi</a></li>
                    <li><a href="laporan.php" class="nav-link active">Laporan</a></li>
                    <li><a href="profile.php" class="nav-link">Profile</a></li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Filters -->
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 mb-6 glow-card">
                <h3 class="text-lg font-semibold text-white mb-4">Filter Laporan</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jurusan</label>
                        <select id="filterJurusan" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                            <option value="">Semua Jurusan</option>
                            <option value="RPL">RPL</option>
                            <option value="TBSM">TBSM</option>
                            <option value="ATPH">ATPH</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Dari Tanggal</label>
                        <input type="date" id="startDate" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Sampai Tanggal</label>
                        <input type="date" id="endDate" class="w-full px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    </div>
                    
                    <div class="flex items-end">
                        <button onclick="updateCharts()" class="btn-primary w-full">Update Laporan</button>
                    </div>
                </div>
            </div>
            
            <!-- Export Actions -->
            <div class="flex justify-end space-x-4 mb-6">
                <button onclick="exportPDF()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    📄 Export PDF
                </button>
                <button onclick="printReport()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    🖨️ Print
                </button>
            </div>
            
            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Weekly Chart -->
                <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 glow-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Rekap Mingguan</h3>
                    <div class="h-80">
                        <canvas id="weeklyChart"></canvas>
                    </div>
                </div>
                
                <!-- Monthly Chart -->
                <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 glow-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Rekap Bulanan</h3>
                    <div class="h-80">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="stat-card">
                    <div class="text-center">
                        <p class="text-slate-400 text-sm">Total Kehadiran</p>
                        <p class="text-2xl font-bold text-green-400">89%</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="text-center">
                        <p class="text-slate-400 text-sm">Total Izin</p>
                        <p class="text-2xl font-bold text-yellow-400">7%</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="text-center">
                        <p class="text-slate-400 text-sm">Total Sakit</p>
                        <p class="text-2xl font-bold text-blue-400">3%</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="text-center">
                        <p class="text-slate-400 text-sm">Total Alpha</p>
                        <p class="text-2xl font-bold text-red-400">1%</p>
                    </div>
                </div>
            </div>
            
            <!-- Detailed Table -->
            <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 glow-card">
                <h3 class="text-lg font-semibold text-white mb-4">Detail Absensi</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="text-left text-slate-400 py-2">Nama</th>
                                <th class="text-left text-slate-400 py-2">Jurusan</th>
                                <th class="text-left text-slate-400 py-2">Hadir</th>
                                <th class="text-left text-slate-400 py-2">Izin</th>
                                <th class="text-left text-slate-400 py-2">Sakit</th>
                                <th class="text-left text-slate-400 py-2">Alpha</th>
                                <th class="text-left text-slate-400 py-2">Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b border-slate-700/50">
                                <td class="py-3 text-white">Ahmad Rizki</td>
                                <td class="py-3"><span class="jurusan-badge jurusan-rpl">RPL</span></td>
                                <td class="py-3 text-green-400">18</td>
                                <td class="py-3 text-yellow-400">2</td>
                                <td class="py-3 text-blue-400">1</td>
                                <td class="py-3 text-red-400">0</td>
                                <td class="py-3 text-white">85.7%</td>
                            </tr>
                            <tr class="border-b border-slate-700/50">
                                <td class="py-3 text-white">Siti Nurhaliza</td>
                                <td class="py-3"><span class="jurusan-badge jurusan-tbsm">TBSM</span></td>
                                <td class="py-3 text-green-400">20</td>
                                <td class="py-3 text-yellow-400">1</td>
                                <td class="py-3 text-blue-400">0</td>
                                <td class="py-3 text-red-400">0</td>
                                <td class="py-3 text-white">95.2%</td>
                            </tr>
                            <tr class="border-b border-slate-700/50">
                                <td class="py-3 text-white">Budi Santoso</td>
                                <td class="py-3"><span class="jurusan-badge jurusan-atph">ATPH</span></td>
                                <td class="py-3 text-green-400">17</td>
                                <td class="py-3 text-yellow-400">3</td>
                                <td class="py-3 text-blue-400">1</td>
                                <td class="py-3 text-red-400">0</td>
                                <td class="py-3 text-white">81.0%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <script src="../assets/common.js"></script>
    <script src="../assets/charts.js"></script>
    <script>
        // Check admin access
        checkAuth('admin');
        
        // Initialize charts
        let weeklyChart, monthlyChart;
        
        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
            setDefaultDates();
        });
        
        function setDefaultDates() {
            const today = new Date();
            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);
            
            document.getElementById('startDate').value = weekAgo.toISOString().split('T')[0];
            document.getElementById('endDate').value = today.toISOString().split('T')[0];
        }
        
        function updateCharts() {
            showNotification('Laporan berhasil diperbarui', 'success');
            // Update chart data based on filters
            updateWeeklyChart();
            updateMonthlyChart();
        }
        
        function exportPDF() {
            showNotification('Memulai export PDF...', 'info');
            setTimeout(() => {
                showNotification('PDF berhasil diexport', 'success');
            }, 2000);
        }
        
        function printReport() {
            window.print();
        }
    </script>
</body>
</html>
