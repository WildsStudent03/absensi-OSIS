import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { useNavigate } from "react-router-dom";
import { 
  QrCode, 
  Clock, 
  History, 
  Users, 
  BarChart3, 
  Calendar,
  TrendingUp,
  UserCheck
} from "lucide-react";
import Navigation from "@/components/Navigation";

const Dashboard = () => {
  const navigate = useNavigate();

  const menuItems = [
    {
      title: "Absensi Hari Ini",
      description: "Lakukan absensi untuk hari ini",
      icon: Clock,
      color: "primary",
      onClick: () => navigate("/absensi")
    },
    {
      title: "Scan QR Code",
      description: "Absensi cepat dengan QR Code",
      icon: QrCode,
      color: "secondary",
      onClick: () => navigate("/absensi")
    },
    {
      title: "Data Anggota",
      description: "Kelola data anggota OSIS",
      icon: Users,
      color: "primary",
      onClick: () => navigate("/data-anggota")
    },
    {
      title: "Laporan Absensi",
      description: "Lihat dan unduh laporan",
      icon: BarChart3,
      color: "secondary",
      onClick: () => navigate("/laporan")
    }
  ];

  const stats = [
    { label: "Anggota Hadir", value: "45", icon: UserCheck, color: "success" },
    { label: "Total Anggota", value: "50", icon: Users, color: "primary" },
    { label: "Tingkat Kehadiran", value: "90%", icon: TrendingUp, color: "secondary" },
    { label: "Hari Ini", value: "Senin", icon: Calendar, color: "muted" }
  ];

  return (
    <div className="min-h-screen bg-gradient-dark">
      <Navigation />
      
      <div className="container mx-auto p-6 pt-24">
        {/* Header */}
        <div className="mb-8 animate-fade-in">
          <h1 className="text-3xl font-bold text-foreground mb-2">
            Dashboard Absensi OSIS
          </h1>
          <p className="text-muted-foreground">
            Selamat datang! Kelola absensi anggota OSIS dengan mudah.
          </p>
        </div>

        {/* Stats Grid */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
          {stats.map((stat, index) => (
            <Card 
              key={stat.label} 
              className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              <CardContent className="p-6">
                <div className="flex items-center justify-between">
                  <div>
                    <p className="text-sm text-muted-foreground mb-1">{stat.label}</p>
                    <p className="text-2xl font-bold text-foreground">{stat.value}</p>
                  </div>
                  <div className={`p-3 rounded-lg bg-${stat.color}/20`}>
                    <stat.icon className={`w-6 h-6 text-${stat.color}`} />
                  </div>
                </div>
              </CardContent>
            </Card>
          ))}
        </div>

        {/* Main Menu */}
        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
          {menuItems.map((item, index) => (
            <Card 
              key={item.title}
              className="glass-card transition-all duration-300 hover:scale-105 cursor-pointer group animate-slide-up"
              style={{ animationDelay: `${0.2 + index * 0.1}s` }}
              onClick={item.onClick}
            >
              <CardHeader className="pb-3">
                <div className="flex items-center space-x-4">
                  <div className={`p-3 rounded-lg bg-${item.color}/20 group-hover:shadow-${item.color === 'primary' ? 'neon' : 'toska'} transition-all duration-300`}>
                    <item.icon className={`w-8 h-8 text-${item.color}`} />
                  </div>
                  <div>
                    <CardTitle className="text-xl font-semibold">{item.title}</CardTitle>
                    <CardDescription className="text-muted-foreground">
                      {item.description}
                    </CardDescription>
                  </div>
                </div>
              </CardHeader>
              <CardContent>
                <Button 
                  variant="outline" 
                  className="w-full group-hover:bg-primary/10 group-hover:border-primary transition-all duration-300"
                >
                  Buka Menu
                </Button>
              </CardContent>
            </Card>
          ))}
        </div>

        {/* Quick Actions */}
        <div className="mt-8">
          <Card className="glass-card animate-fade-in" style={{ animationDelay: "0.6s" }}>
            <CardHeader>
              <CardTitle className="flex items-center space-x-2">
                <History className="w-5 h-5 text-primary" />
                <span>Riwayat Absensi Terbaru</span>
              </CardTitle>
            </CardHeader>
            <CardContent>
              <div className="space-y-3">
                {[
                  { nama: "Ahmad Rizki", waktu: "08:00", status: "Hadir" },
                  { nama: "Siti Nurhaliza", waktu: "08:15", status: "Terlambat" },
                  { nama: "Budi Santoso", waktu: "07:45", status: "Hadir" }
                ].map((absen, index) => (
                  <div key={index} className="flex items-center justify-between p-3 rounded-lg bg-card/30 border border-white/5">
                    <div className="flex items-center space-x-3">
                      <div className="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                        <span className="text-sm font-medium text-primary">
                          {absen.nama.charAt(0)}
                        </span>
                      </div>
                      <div>
                        <p className="font-medium text-foreground">{absen.nama}</p>
                        <p className="text-sm text-muted-foreground">{absen.waktu}</p>
                      </div>
                    </div>
                    <span className={`px-3 py-1 rounded-full text-xs font-medium ${
                      absen.status === 'Hadir' 
                        ? 'bg-success/20 text-success' 
                        : 'bg-warning/20 text-warning'
                    }`}>
                      {absen.status}
                    </span>
                  </div>
                ))}
              </div>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  );
};

export default Dashboard;