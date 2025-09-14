<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi - Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Absensi OSIS</h1>
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
                <!-- Date Info -->
                <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 mb-6 glow-card">
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-white mb-2" id="currentDate"></h2>
                        <p class="text-slate-400" id="currentTime"></p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Manual Attendance -->
                    <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 glow-card">
                        <h3 class="text-lg font-semibold text-white mb-4">Absensi Manual</h3>
                        
                        <form id="manualAttendanceForm">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">Nama/NIS</label>
                                    <input type="text" id="memberSearch" placeholder="Cari anggota..." class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-slate-300 mb-2">Status Kehadiran</label>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="attendance-option">
                                            <input type="radio" name="status" value="hadir" class="hidden">
                                            <div class="status-card status-hadir">
                                                <span class="text-xl">✅</span>
                                                <span>Hadir</span>
                                            </div>
                                        </label>
                                        
                                        <label class="attendance-option">
                                            <input type="radio" name="status" value="izin" class="hidden">
                                            <div class="status-card status-izin">
                                                <span class="text-xl">📝</span>
                                                <span>Izin</span>
                                            </div>
                                        </label>
                                        
                                        <label class="attendance-option">
                                            <input type="radio" name="status" value="sakit" class="hidden">
                                            <div class="status-card status-sakit">
                                                <span class="text-xl">🏥</span>
                                                <span>Sakit</span>
                                            </div>
                                        </label>
                                        
                                        <label class="attendance-option">
                                            <input type="radio" name="status" value="alpha" class="hidden">
                                            <div class="status-card status-alpha">
                                                <span class="text-xl">❌</span>
                                                <span>Alpha</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn-primary w-full">
                                    <span id="submitText">Simpan Absensi</span>
                                    <div id="submitSpinner" class="spinner hidden"></div>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- QR Scanner -->
                    <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 glow-card">
                        <h3 class="text-lg font-semibold text-white mb-4">Scan QR Code</h3>
                        
                        <div class="text-center">
                            <div class="w-48 h-48 mx-auto mb-4 bg-slate-700 rounded-lg border-2 border-dashed border-slate-600 flex items-center justify-center">
                                <div class="text-slate-400">
                                    <div class="text-4xl mb-2">📱</div>
                                    <p>Area Scan QR</p>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <input type="text" id="qrInput" placeholder="Atau masukkan kode QR..." class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                                
                                <button onclick="simulateQRScan()" class="btn-primary w-full">
                                    <span id="scanText">Scan QR Code</span>
                                    <div id="scanSpinner" class="spinner hidden"></div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Today's Attendance -->
                <div class="bg-slate-800 rounded-xl border border-slate-700 p-6 mt-6 glow-card">
                    <h3 class="text-lg font-semibold text-white mb-4">Absensi Hari Ini</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-700">
                                    <th class="text-left text-slate-400 py-2">Nama</th>
                                    <th class="text-left text-slate-400 py-2">NIS</th>
                                    <th class="text-left text-slate-400 py-2">Status</th>
                                    <th class="text-left text-slate-400 py-2">Waktu</th>
                                </tr>
                            </thead>
                            <tbody id="todayAttendance">
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">Ahmad Rizki</td>
                                    <td class="py-3 text-slate-400">12345</td>
                                    <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                                    <td class="py-3 text-slate-400">08:00</td>
                                </tr>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">Siti Nurhaliza</td>
                                    <td class="py-3 text-slate-400">12346</td>
                                    <td class="py-3"><span class="status-badge status-hadir">Hadir</span></td>
                                    <td class="py-3 text-slate-400">08:05</td>
                                </tr>
                                <tr class="border-b border-slate-700/50">
                                    <td class="py-3 text-white">Budi Santoso</td>
                                    <td class="py-3 text-slate-400">12347</td>
                                    <td class="py-3"><span class="status-badge status-izin">Izin</span></td>
                                    <td class="py-3 text-slate-400">-</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/common.js"></script>
    <script>
        // Initialize page
        const userRole = localStorage.getItem('userRole');
        document.getElementById('userName').textContent = localStorage.getItem('userName') || 'User';
        
        // Setup navigation based on role
        setupNavigation(userRole);
        
        // Update date and time
        updateDateTime();
        setInterval(updateDateTime, 1000);
        
        function updateDateTime() {
            const now = new Date();
            document.getElementById('currentDate').textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('currentTime').textContent = now.toLocaleTimeString('id-ID');
        }
        
        function setupNavigation(role) {
            const nav = document.getElementById('sidebarNav');
            if (role === 'admin') {
                nav.innerHTML = `
                    <li><a href="dashboard-admin.html" class="nav-link">Dashboard</a></li>
                    <li><a href="kelola-anggota.html" class="nav-link">Kelola Anggota</a></li>
                    <li><a href="absensi.html" class="nav-link active">Absensi</a></li>
                    <li><a href="laporan.html" class="nav-link">Laporan</a></li>
                    <li><a href="profile.html" class="nav-link">Profile</a></li>
                `;
            } else {
                nav.innerHTML = `
                    <li><a href="dashboard-member.html" class="nav-link">Dashboard</a></li>
                    <li><a href="absensi.html" class="nav-link active">Absensi</a></li>
                    <li><a href="profile.html" class="nav-link">Profile</a></li>
                `;
            }
        }
        
        // Manual attendance form
        document.getElementById('manualAttendanceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const member = document.getElementById('memberSearch').value;
            const status = document.querySelector('input[name="status"]:checked')?.value;
            
            if (!member || !status) {
                showNotification('Mohon lengkapi semua field', 'error');
                return;
            }
            
            // Show loading
            showLoading('submitText', 'submitSpinner');
            
            setTimeout(() => {
                hideLoading('submitText', 'submitSpinner');
                showNotification('Absensi berhasil disimpan', 'success');
                
                // Add to today's attendance table
                addToAttendanceTable(member, status);
                
                // Reset form
                this.reset();
                document.querySelectorAll('.status-card').forEach(card => {
                    card.classList.remove('selected');
                });
            }, 1500);
        });
        
        // Status selection
        document.querySelectorAll('.attendance-option').forEach(option => {
            option.addEventListener('click', function() {
                document.querySelectorAll('.status-card').forEach(card => {
                    card.classList.remove('selected');
                });
                this.querySelector('.status-card').classList.add('selected');
                this.querySelector('input').checked = true;
            });
        });
        
        function simulateQRScan() {
            const qrCode = document.getElementById('qrInput').value;
            
            if (!qrCode) {
                // Simulate QR scan
                showLoading('scanText', 'scanSpinner');
                
                setTimeout(() => {
                    hideLoading('scanText', 'scanSpinner');
                    const randomMember = ['Ahmad Rizki', 'Siti Nurhaliza', 'Budi Santoso'][Math.floor(Math.random() * 3)];
                    showNotification(`QR Code berhasil discan untuk ${randomMember}`, 'success');
                    addToAttendanceTable(randomMember, 'hadir');
                }, 2000);
            } else {
                showNotification('QR Code tidak valid', 'error');
            }
        }
        
        function addToAttendanceTable(member, status) {
            const tbody = document.getElementById('todayAttendance');
            const now = new Date();
            const time = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            
            const newRow = document.createElement('tr');
            newRow.className = 'border-b border-slate-700/50';
            newRow.innerHTML = `
                <td class="py-3 text-white">${member}</td>
                <td class="py-3 text-slate-400">-</td>
                <td class="py-3"><span class="status-badge status-${status}">${status.charAt(0).toUpperCase() + status.slice(1)}</span></td>
                <td class="py-3 text-slate-400">${status === 'hadir' ? time : '-'}</td>
            `;
            
            tbody.insertBefore(newRow, tbody.firstChild);
        }
        
        function showLoading(textId, spinnerId) {
            document.getElementById(textId).classList.add('hidden');
            document.getElementById(spinnerId).classList.remove('hidden');
        }
        
        function hideLoading(textId, spinnerId) {
            document.getElementById(textId).classList.remove('hidden');
            document.getElementById(spinnerId).classList.add('hidden');
        }
    </script>
</body>
</html>
