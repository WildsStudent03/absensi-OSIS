<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Anggota - Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen">
    <!-- Header -->
    <header class="bg-slate-800 border-b border-slate-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-white">Kelola Anggota OSIS</h1>
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
                    <li><a href="kelola-anggota.php" class="nav-link active">Kelola Anggota</a></li>
                    <li><a href="absensi.php" class="nav-link">Absensi</a></li>
                    <li><a href="laporan.php" class="nav-link">Laporan</a></li>
                    <li><a href="profile.php" class="nav-link">Profile</a></li>
                </ul>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Controls -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
                <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
                    <input type="text" id="searchInput" placeholder="Cari anggota..." class="px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400">
                    <select id="filterJurusan" class="px-4 py-2 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400">
                        <option value="">Semua Jurusan</option>
                        <option value="RPL">RPL</option>
                        <option value="TBSM">TBSM</option>
                        <option value="ATPH">ATPH</option>
                    </select>
                </div>
                <button onclick="openAddModal()" class="btn-primary">Tambah Anggota</button>
            </div>
            
            <!-- Members Table -->
            <div class="bg-slate-800 rounded-xl border border-slate-700 overflow-hidden glow-card">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-700">
                            <tr>
                                <th class="text-left text-slate-300 py-4 px-6">Nama</th>
                                <th class="text-left text-slate-300 py-4 px-6">NIS</th>
                                <th class="text-left text-slate-300 py-4 px-6">Jurusan</th>
                                <th class="text-left text-slate-300 py-4 px-6">Jabatan</th>
                                <th class="text-left text-slate-300 py-4 px-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="membersTable">
                            <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition-colors">
                                <td class="py-4 px-6 text-white">Ahmad Rizki</td>
                                <td class="py-4 px-6 text-slate-400">12345</td>
                                <td class="py-4 px-6"><span class="jurusan-badge jurusan-rpl">RPL</span></td>
                                <td class="py-4 px-6 text-slate-400">Ketua</td>
                                <td class="py-4 px-6">
                                    <button onclick="editMember(1)" class="text-cyan-400 hover:text-cyan-300 mr-3">Edit</button>
                                    <button onclick="deleteMember(1)" class="text-red-400 hover:text-red-300">Hapus</button>
                                </td>
                            </tr>
                            <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition-colors">
                                <td class="py-4 px-6 text-white">Siti Nurhaliza</td>
                                <td class="py-4 px-6 text-slate-400">12346</td>
                                <td class="py-4 px-6"><span class="jurusan-badge jurusan-tbsm">TBSM</span></td>
                                <td class="py-4 px-6 text-slate-400">Wakil Ketua</td>
                                <td class="py-4 px-6">
                                    <button onclick="editMember(2)" class="text-cyan-400 hover:text-cyan-300 mr-3">Edit</button>
                                    <button onclick="deleteMember(2)" class="text-red-400 hover:text-red-300">Hapus</button>
                                </td>
                            </tr>
                            <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition-colors">
                                <td class="py-4 px-6 text-white">Budi Santoso</td>
                                <td class="py-4 px-6 text-slate-400">12347</td>
                                <td class="py-4 px-6"><span class="jurusan-badge jurusan-atph">ATPH</span></td>
                                <td class="py-4 px-6 text-slate-400">Sekretaris</td>
                                <td class="py-4 px-6">
                                    <button onclick="editMember(3)" class="text-cyan-400 hover:text-cyan-300 mr-3">Edit</button>
                                    <button onclick="deleteMember(3)" class="text-red-400 hover:text-red-300">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    
    <!-- Add/Edit Modal -->
    <div id="memberModal" class="modal hidden">
        <div class="modal-content">
            <div class="flex justify-between items-center mb-6">
                <h2 id="modalTitle" class="text-xl font-bold text-white">Tambah Anggota</h2>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white text-2xl">&times;</button>
            </div>
            
            <form id="memberForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" id="modalNama" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">NIS</label>
                        <input type="text" id="modalNis" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jurusan</label>
                        <select id="modalJurusan" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="RPL">RPL</option>
                            <option value="TBSM">TBSM</option>
                            <option value="ATPH">ATPH</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jabatan</label>
                        <input type="text" id="modalJabatan" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400" required>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="button" onclick="closeModal()" class="px-6 py-3 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition-colors">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="assets/common.js"></script>
    <script>
        // Check admin access
        checkAuth('admin');
        
        let editingId = null;
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('input', filterMembers);
        document.getElementById('filterJurusan').addEventListener('change', filterMembers);
        
        function filterMembers() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const jurusan = document.getElementById('filterJurusan').value;
            const rows = document.querySelectorAll('#membersTable tr');
            
            rows.forEach(row => {
                const nama = row.cells[0]?.textContent.toLowerCase() || '';
                const memberJurusan = row.cells[2]?.textContent || '';
                
                const matchSearch = nama.includes(search);
                const matchJurusan = !jurusan || memberJurusan.includes(jurusan);
                
                row.style.display = matchSearch && matchJurusan ? '' : 'none';
            });
        }
        
        function openAddModal() {
            editingId = null;
            document.getElementById('modalTitle').textContent = 'Tambah Anggota';
            document.getElementById('memberForm').reset();
            document.getElementById('memberModal').classList.remove('hidden');
        }
        
        function editMember(id) {
            editingId = id;
            document.getElementById('modalTitle').textContent = 'Edit Anggota';
            
            // Simulate loading member data
            document.getElementById('modalNama').value = 'Ahmad Rizki';
            document.getElementById('modalNis').value = '12345';
            document.getElementById('modalJurusan').value = 'RPL';
            document.getElementById('modalJabatan').value = 'Ketua';
            
            document.getElementById('memberModal').classList.remove('hidden');
        }
        
        function deleteMember(id) {
            if (confirm('Yakin ingin menghapus anggota ini?')) {
                showNotification('Anggota berhasil dihapus', 'success');
                // Remove row logic here
            }
        }
        
        function closeModal() {
            document.getElementById('memberModal').classList.add('hidden');
        }
        
        document.getElementById('memberForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const action = editingId ? 'diperbarui' : 'ditambahkan';
            showNotification(`Anggota berhasil ${action}`, 'success');
            closeModal();
        });
    </script>
</body>
</html>
