<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Profile OSIS</h1>
            <div class="flex items-center space-x-4">
                <span class="text-slate-300" id="userName">User</span>
                <button onclick="logout()" class="text-red-400 hover:text-red-300 transition-colors">Logout</button>
            </div>
        </div>
    </header>
    
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-800 min-h-screen border-r border-slate-700">
            <nav class="p-6">
                <ul class="space-y-4" id="sidebarNav">
                    <!-- Navigation will be populated by JS based on role -->
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Profile Card -->
                <div class="bg-slate-800 rounded-xl border border-slate-700 p-8 mb-6 glow-card profile-fade-in">
                    <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8">
                        <div class="relative">
                            <div class="w-32 h-32 bg-gradient-to-r from-cyan-400 to-purple-500 rounded-full flex items-center justify-center text-white text-4xl font-bold">
                                <span id="profileInitial">A</span>
                            </div>
                            <button class="absolute bottom-0 right-0 w-8 h-8 bg-cyan-400 rounded-full flex items-center justify-center text-slate-900 hover:bg-cyan-300 transition-colors">
                                📷
                            </button>
                        </div>
                        
                        <div class="flex-1 text-center md:text-left">
                            <h2 class="text-2xl font-bold text-white mb-2" id="profileName">Anggota OSIS</h2>
                            <div class="space-y-2 text-slate-400">
                                <p><span class="font-medium">NIS:</span> <span id="profileNis">12345</span></p>
                                <p><span class="font-medium">Email:</span> <span id="profileEmail">user@osis.com</span></p>
                                <p><span class="font-medium">Jurusan:</span> <span id="profileJurusan">RPL</span></p>
                                <p><span class="font-medium">Jabatan:</span> <span id="profileJabatan">Anggota</span></p>
                                <p><span class="font-medium">Bergabung:</span> <span id="profileJoinDate">Januari 2024</span></p>
                            </div>
                        </div>
                        
                        <div class="flex flex-col space-y-3">
                            <button onclick="openEditModal()" class="btn-primary">Edit Profile</button>
                            <button onclick="openPasswordModal()" class="px-4 py-2 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition-colors">Ubah Password</button>
                        </div>
                    </div>
                </div>
                
                <!-- Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="stat-card">
                        <div class="text-center">
                            <p class="text-slate-400 text-sm">Total Kehadiran</p>
                            <p class="text-2xl font-bold text-green-400">18</p>
                            <p class="text-xs text-slate-500">Bulan ini</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="text-center">
                            <p class="text-slate-400 text-sm">Izin</p>
                            <p class="text-2xl font-bold text-yellow-400">2</p>
                            <p class="text-xs text-slate-500">Bulan ini</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="text-center">
                            <p class="text-slate-400 text-sm">Sakit</p>
                            <p class="text-2xl font-bold text-blue-400">1</p>
                            <p class="text-xs text-slate-500">Bulan ini</p>
                        </div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="text-center">
                            <p class="text-slate-400 text-sm">Persentase</p>
                            <p class="text-2xl font-bold text-cyan-400">85.7%</p>
                            <p class="text-xs text-slate-500">Kehadiran</p>
                        </div>
                    </div>
                </div>
                
                <!-- Attendance History -->
                <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 glow-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Riwayat Absensi</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="text-left text-slate-400 py-2">Tanggal</th>
                                    <th class="text-left text-slate-400 py-2">Status</th>
                                    <th class="text-left text-slate-400 py-2">Waktu</th>
                                    <th class="text-left text-slate-400 py-2">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">2024-01-15</td>
                                    <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                                    <td class="py-3 text-slate-400">08:00</td>
                                    <td class="py-3 text-slate-400">-</td>
                                </tr>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">2024-01-14</td>
                                    <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                                    <td class="py-3 text-slate-400">07:55</td>
                                    <td class="py-3 text-slate-400">-</td>
                                </tr>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">2024-01-13</td>
                                    <td class="py-3"><span class="status-badge status-izin">Izin</span></td>
                                    <td class="py-3 text-slate-400">-</td>
                                    <td class="py-3 text-slate-400">Keperluan keluarga</td>
                                </tr>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">2024-01-12</td>
                                    <td class="py-3"><span class="status-badge status-sakit">Sakit</span></td>
                                    <td class="py-3 text-slate-400">-</td>
                                    <td class="py-3 text-slate-400">Demam</td>
                                </tr>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">2024-01-11</td>
                                    <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                                    <td class="py-3 text-slate-400">08:10</td>
                                    <td class="py-3 text-slate-400">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Edit Profile Modal -->
    <div id="editModal" class="modal hidden">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white">Edit Profile</h2>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form id="editForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" id="editNama" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input type="email" id="editEmail" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jurusan</label>
                        <select id="editJurusan" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                            <option value="RPL">RPL</option>
                            <option value="TBSM">TBSM</option>
                            <option value="ATPH">ATPH</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jabatan</label>
                        <input type="text" id="editJabatan" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" onclick="closeEditModal()" class="px-6 py-3 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition-colors">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Change Password Modal -->
    <div id="passwordModal" class="modal hidden">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-white">Ubah Password</h2>
                <button onclick="closePasswordModal()" class="text-slate-400 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form id="passwordForm">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Password Lama</label>
                        <input type="password" id="oldPassword" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Password Baru</label>
                        <input type="password" id="newPassword" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password Baru</label>
                        <input type="password" id="confirmPassword" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" onclick="closePasswordModal()" class="px-6 py-3 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition-colors">Batal</button>
                    <button type="submit" class="btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="../assets/common.js"></script>
    <script>
        // Initialize page
        const userRole = localStorage.getItem('userRole');
        document.getElementById('userName').textContent = localStorage.getItem('userName') || 'User';
        
        // Setup navigation based on role
        setupNavigation(userRole);
        loadProfileData();
        
        function setupNavigation(role) {
            const nav = document.getElementById('sidebarNav');
            if (role === 'admin') {
                nav.innerHTML = `
                    <li><a href="dashboard-admin.php" class="nav-link">Dashboard</a></li>
                    <li><a href="kelola-anggota.php" class="nav-link">Kelola Anggota</a></li>
                    <li><a href="absensi.php" class="nav-link">Absensi</a></li>
                    <li><a href="laporan.php" class="nav-link">Laporan</a></li>
                    <li><a href="profile.php" class="nav-link active">Profile</a></li>
                `;
            } else {
                nav.innerHTML = `
                    <li><a href="dashboard-member.php" class="nav-link">Dashboard</a></li>
                    <li><a href="absensi.php" class="nav-link">Absensi</a></li>
                    <li><a href="profile.php" class="nav-link active">Profile</a></li>
                `;
            }
        }
        //dummy data load
        function loadProfileData() {
            const userName = localStorage.getItem('userName') || 'Anggota';
            const userNis = localStorage.getItem('userNis') || '12';
            
            document.getElementById('profileName').textContent = userName;
            document.getElementById('profileNis').textContent = userNis;
            document.getElementById('profileInitial').textContent = userName.charAt(0).toUpperCase();
            
            // Load form data
            document.getElementById('editNama').value = userName;
            document.getElementById('editEmail').value = 'user@osis.com';
            document.getElementById('editJurusan').value = 'RPL';
            document.getElementById('editJabatan').value = 'Anggota';
        }
        
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }
        
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
        
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
        }
        
        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }
        
        document.getElementById('editForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const nama = document.getElementById('editNama').value;
            localStorage.setItem('userName', nama);
            
            showNotification('Profile berhasil diperbarui', 'success');
            loadProfileData();
            closeEditModal();
        });
        
        document.getElementById('passwordForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (newPassword !== confirmPassword) {
                showNotification('Konfirmasi password tidak cocok', 'error');
                return;
            }
            
            showNotification('Password berhasil diubah', 'success');
            closePasswordModal();
            this.reset();
        });
    </script>
</body>
</html>
