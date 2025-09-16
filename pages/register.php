<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - Sistem Absensi OSIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../assets/common.css">
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="register-card w-full max-w-2xl bg-slate-800 rounded-xl shadow-2xl border border-slate-700 p-8 opacity-0 transform translate-y-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-white mb-2 typing-text">Pendaftaran Anggota OSIS</h1>
            <p class="text-slate-400">Lengkapi data diri Anda</p>
        </div>
        
        <!-- Step Indicator -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4">
                <div class="step-indicator active" data-step="1">
                    <span class="w-8 h-8 bg-cyan-400 text-slate-900 rounded-full flex items-center justify-center font-semibold">1</span>
                    <span class="text-sm text-cyan-400 mt-1">Data Diri</span>
                </div>
                <div class="w-12 h-0.5 bg-slate-600"></div>
                <div class="step-indicator" data-step="2">
                    <span class="w-8 h-8 bg-slate-600 text-slate-400 rounded-full flex items-center justify-center font-semibold">2</span>
                    <span class="text-sm text-slate-400 mt-1">Detail</span>
                </div>
            </div>
        </div>
        
        <?php
        session_start();
        $errors = $_SESSION['register_errors'] ?? [];
        unset($_SESSION['register_errors']);
        ?>
        <?php if (!empty($errors)): ?>
            <div class="mb-4 p-4 bg-red-600 text-white rounded-lg">
                <?php foreach ($errors as $err): ?>
                    <div><?= htmlspecialchars($err) ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form id="registerForm" method="POST" action="../core/proses_register.php" enctype="multipart/form-data">
            <div id="step1" class="step-content">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">NIS</label>
                        <input type="text" id="nis" name="username" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="Nomor Induk Siswa" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama_lengkap" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="Nama lengkap" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="email@example.com" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                        <input type="password" id="regPassword" name="password" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="Password" required>
                    </div>
                </div>
                
                <div class="flex justify-between mt-8">
                    <a href="../index.php" class="px-6 py-3 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition-colors">Kembali</a>
                    <button type="button" id="nextStep" class="px-6 py-3 bg-gradient-to-r from-cyan-400 to-purple-500 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-cyan-400/25 transition-all duration-300">Selanjutnya</button>
                </div>
            </div>
            
            <!-- Step 2: Detail -->
            <div id="step2" class="step-content hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jurusan</label>
                        <select id="jurusan" name="jurusan" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" required>
                            <option value="">Pilih Jurusan</option>
                            <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                            <option value="TBSM">Teknik Bisnis Sepeda Motor (TBSM)</option>
                            <option value="ATPH">Agribisnis Tanaman Pangan dan Hortikultura (ATPH)</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jabatan</label>
                        <input type="text" id="jabatan" name="jabatan" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="Jabatan di OSIS" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Daftar Sebagai</label>
                        <select id="role" name="role" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" required onchange="toggleAdminCode()">
                            <option value="anggota">Anggota OSIS</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div id="adminCodeDiv" class="hidden">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kode Admin</label>
                        <input type="password" id="adminCode" name="admin_code" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:border-transparent transition-all" placeholder="Masukkan kode admin">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Upload Foto (Opsional)</label>
                        <input type="file" id="foto" name="foto_profil" accept="image/*" class="w-full px-4 py-3 bg-slate-700 border border-slate-600 rounded-lg text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-cyan-400 file:text-slate-900 file:font-semibold hover:file:bg-cyan-300 transition-all">
                    </div>
                </div>
                
                <div class="flex justify-between mt-8">
                    <button type="button" id="prevStep" class="px-6 py-3 bg-slate-700 text-slate-300 rounded-lg hover:bg-slate-600 transition-colors">Sebelumnya</button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-cyan-400 to-purple-500 text-white font-semibold rounded-lg hover:shadow-lg hover:shadow-cyan-400/25 transition-all duration-300">Daftar</button>
                </div>
            </div>
        </form>
    </div>
    
    <script src="../assets/common.js"></link>
    <script src="../assets/interactive-bg.js"></script>
    <script>
        let currentStep = 1;
        
        document.getElementById('nextStep').addEventListener('click', function() {
            if (validateStep1()) {
                showStep(2);
            }
        });
        
        document.getElementById('prevStep').addEventListener('click', function() {
            showStep(1);
        });
        
        // Hilangkan JS submit handler agar submit ke PHP
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!validateStep2()) {
                e.preventDefault();
            }
        });
        
        function showStep(step) {
            document.getElementById('step' + currentStep).classList.add('hidden');
            document.querySelector(`[data-step="${currentStep}"]`).classList.remove('active');
            
            currentStep = step;
            document.getElementById('step' + currentStep).classList.remove('hidden');
            document.querySelector(`[data-step="${currentStep}"]`).classList.add('active');
        }
        
        function validateStep1() {
            const nis = document.getElementById('nis').value;
            const nama = document.getElementById('nama').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('regPassword').value;
            
            if (!nis || !nama || !email || !password) {
                alert('Mohon lengkapi semua field!');
                return false;
            }
            return true;
        }
        
        function validateStep2() {
            const jurusan = document.getElementById('jurusan').value;
            const jabatan = document.getElementById('jabatan').value;
            
            if (!jurusan || !jabatan) {
                alert('Mohon lengkapi semua field!');
                return false;
            }
            return true;
        }
        function toggleAdminCode() {
            const roleSelect = document.getElementById('role');
            const adminCodeDiv = document.getElementById('adminCodeDiv');
            const adminCodeInput = document.getElementById('adminCode');
            
            if (roleSelect.value === 'admin') {
                adminCodeDiv.classList.remove('hidden');
                adminCodeInput.required = true;
            } else {
                adminCodeDiv.classList.add('hidden');
                adminCodeInput.required = false;
                adminCodeInput.value = '';
            }
        }

        function validateStep2() {
            const jurusan = document.getElementById('jurusan').value;
            const jabatan = document.getElementById('jabatan').value;
            const role = document.getElementById('role').value;
            const adminCode = document.getElementById('adminCode');
            
            if (!jurusan || !jabatan) {
                alert('Mohon lengkapi semua field!');
                return false;
            }

            if (role === 'admin' && (!adminCode.value || adminCode.value !== '<?php echo getenv("ADMIN_CODE") ?: "admin123"; ?>')) {
                alert('Kode admin tidak valid!');
                return false;
            }
            
            return true;
        }
    </script>
</body>
</html>
