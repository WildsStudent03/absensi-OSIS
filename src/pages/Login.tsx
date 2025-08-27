import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { QrCode, Users, BarChart3 } from "lucide-react";

const Login = () => {
  const [namaPengguna, setNamaPengguna] = useState("");
  const [kataSandi, setKataSandi] = useState("");
  const navigate = useNavigate();

  const handleLogin = (e: React.FormEvent) => {
    e.preventDefault();
    // Simulasi login sederhana
    if (namaPengguna && kataSandi) {
      navigate("/dashboard");
    }
  };

  return (
    <div className="min-h-screen bg-gradient-dark flex items-center justify-center p-4">
      {/* Background Glow Effect */}
      <div className="absolute inset-0 bg-gradient-glow opacity-30"></div>
      
      <div className="w-full max-w-md relative z-10">
        {/* Header Section */}
        <div className="text-center mb-8 slide-up">
          <div className="flex justify-center mb-4">
            <div className="p-4 rounded-full bg-primary/20 glow-primary">
              <QrCode className="w-12 h-12 text-primary" />
            </div>
          </div>
          <h1 className="text-3xl font-bold text-foreground mb-2">
            Absensi OSIS Digital
          </h1>
          <p className="text-muted-foreground">
            Sistem Absensi Modern untuk Organisasi Siswa
          </p>
        </div>

        {/* Login Card */}
        <Card className="glass-card slide-up" style={{ animationDelay: "0.2s" }}>
          <CardHeader className="space-y-1">
            <CardTitle className="text-2xl font-semibold text-center">
              Masuk ke Akun
            </CardTitle>
            <CardDescription className="text-center">
              Masukkan kredensial Anda untuk mengakses sistem
            </CardDescription>
          </CardHeader>
          <CardContent>
            <form onSubmit={handleLogin} className="space-y-4">
              <div className="space-y-2">
                <Label htmlFor="username">Nama Pengguna</Label>
                <Input
                  id="username"
                  type="text"
                  placeholder="Masukkan nama pengguna"
                  value={namaPengguna}
                  onChange={(e) => setNamaPengguna(e.target.value)}
                  className="bg-input border-border focus:ring-primary focus:border-primary"
                  required
                />
              </div>
              <div className="space-y-2">
                <Label htmlFor="password">Kata Sandi</Label>
                <Input
                  id="password"
                  type="password"
                  placeholder="Masukkan kata sandi"
                  value={kataSandi}
                  onChange={(e) => setKataSandi(e.target.value)}
                  className="bg-input border-border focus:ring-primary focus:border-primary"
                  required
                />
              </div>
              <Button 
                type="submit" 
                className="w-full bg-gradient-primary hover:shadow-neon transition-all duration-300 font-medium"
              >
                Masuk
              </Button>
            </form>
          </CardContent>
        </Card>

        {/* Features Preview */}
        <div className="mt-8 grid grid-cols-3 gap-4 fade-in" style={{ animationDelay: "0.4s" }}>
          <div className="text-center">
            <div className="p-3 rounded-lg bg-card/50 backdrop-blur-sm border border-white/10 mb-2">
              <QrCode className="w-6 h-6 text-primary mx-auto" />
            </div>
            <span className="text-xs text-muted-foreground">QR Code</span>
          </div>
          <div className="text-center">
            <div className="p-3 rounded-lg bg-card/50 backdrop-blur-sm border border-white/10 mb-2">
              <Users className="w-6 h-6 text-secondary mx-auto" />
            </div>
            <span className="text-xs text-muted-foreground">Data Anggota</span>
          </div>
          <div className="text-center">
            <div className="p-3 rounded-lg bg-card/50 backdrop-blur-sm border border-white/10 mb-2">
              <BarChart3 className="w-6 h-6 text-primary mx-auto" />
            </div>
            <span className="text-xs text-muted-foreground">Laporan</span>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Login;