import { useState } from "react";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Badge } from "@/components/ui/badge";
import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import { Users, Search, Plus, Edit, Trash2, Eye, UserCheck } from "lucide-react";
import Navigation from "@/components/Navigation";
import { useNavigate } from "react-router-dom";

const DataAnggota = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const navigate = useNavigate();

  // Data dummy anggota
  const anggotaData = [
    {
      id: 1,
      nama: "Ahmad Rizki",
      nis: "20210001",
      kelas: "XII IPA 1",
      jabatan: "Ketua OSIS",
      status: "Aktif",
      totalHadir: 28,
      totalAbsen: 30,
      foto: "/placeholder.svg"
    },
    {
      id: 2,
      nama: "Siti Nurhaliza",
      nis: "20210002",
      kelas: "XI IPA 2",
      jabatan: "Wakil Ketua OSIS",
      status: "Aktif",
      totalHadir: 25,
      totalAbsen: 30,
      foto: "/placeholder.svg"
    },
    {
      id: 3,
      nama: "Budi Santoso",
      nis: "20210003",
      kelas: "XI IPS 1",
      jabatan: "Sekretaris",
      status: "Aktif",
      totalHadir: 30,
      totalAbsen: 30,
      foto: "/placeholder.svg"
    },
    {
      id: 4,
      nama: "Dewi Sartika",
      nis: "20210004",
      kelas: "X IPA 3",
      jabatan: "Bendahara",
      status: "Aktif",
      totalHadir: 27,
      totalAbsen: 30,
      foto: "/placeholder.svg"
    },
    {
      id: 5,
      nama: "Eko Prasetyo",
      nis: "20210005",
      kelas: "XII IPS 2",
      jabatan: "Koordinator Bidang Kesiswaan",
      status: "Tidak Aktif",
      totalHadir: 15,
      totalAbsen: 30,
      foto: "/placeholder.svg"
    },
    {
      id: 6,
      nama: "Fitri Handayani",
      nis: "20210006",
      kelas: "XI IPA 1",
      jabatan: "Koordinator Bidang Keagamaan",
      status: "Aktif",
      totalHadir: 29,
      totalAbsen: 30,
      foto: "/placeholder.svg"
    }
  ];

  const filteredData = anggotaData.filter(anggota => 
    anggota.nama.toLowerCase().includes(searchTerm.toLowerCase()) ||
    anggota.nis.includes(searchTerm) ||
    anggota.kelas.toLowerCase().includes(searchTerm.toLowerCase()) ||
    anggota.jabatan.toLowerCase().includes(searchTerm.toLowerCase())
  );

  const getStatusBadge = (status: string) => {
    return status === "Aktif" 
      ? "bg-success/20 text-success border-success/30"
      : "bg-muted/20 text-muted-foreground border-muted/30";
  };

  const getKehadiranPercentage = (hadir: number, total: number) => {
    return Math.round((hadir / total) * 100);
  };

  const getKehadiranColor = (percentage: number) => {
    if (percentage >= 90) return "text-success";
    if (percentage >= 75) return "text-warning";
    return "text-destructive";
  };

  return (
    <div className="min-h-screen bg-gradient-dark">
      <Navigation />
      
      <div className="container mx-auto p-6 pt-24">
        {/* Header */}
        <div className="flex flex-col lg:flex-row lg:items-center justify-between mb-8 animate-fade-in">
          <div>
            <h1 className="text-3xl font-bold text-foreground mb-2">
              Data Anggota OSIS
            </h1>
            <p className="text-muted-foreground">
              Kelola data anggota organisasi siswa
            </p>
          </div>
          <Button 
            onClick={() => navigate("/pendaftaran-anggota")}
            className="bg-gradient-primary hover:shadow-neon transition-all duration-300 mt-4 lg:mt-0"
          >
            <Plus className="w-4 h-4 mr-2" />
            Tambah Anggota
          </Button>
        </div>

        {/* Search & Stats */}
        <div className="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
          <Card className="glass-card lg:col-span-2 animate-fade-in">
            <CardContent className="p-6">
              <div className="relative">
                <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                <Input
                  placeholder="Cari anggota, NIS, kelas, atau jabatan..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                  className="pl-10 bg-input border-border focus:ring-primary focus:border-primary"
                />
              </div>
            </CardContent>
          </Card>

          <Card className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in" style={{ animationDelay: "0.1s" }}>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">Total Anggota</p>
                  <p className="text-2xl font-bold text-foreground">{anggotaData.length}</p>
                </div>
                <Users className="w-8 h-8 text-primary" />
              </div>
            </CardContent>
          </Card>

          <Card className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in" style={{ animationDelay: "0.2s" }}>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">Anggota Aktif</p>
                  <p className="text-2xl font-bold text-success">
                    {anggotaData.filter(a => a.status === "Aktif").length}
                  </p>
                </div>
                <UserCheck className="w-8 h-8 text-success" />
              </div>
            </CardContent>
          </Card>
        </div>

        {/* Anggota Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {filteredData.map((anggota, index) => {
            const kehadiranPercentage = getKehadiranPercentage(anggota.totalHadir, anggota.totalAbsen);
            
            return (
              <Card 
                key={anggota.id} 
                className="glass-card transition-all duration-300 hover:scale-105 animate-slide-up"
                style={{ animationDelay: `${index * 0.1}s` }}
              >
                <CardHeader className="pb-3">
                  <div className="flex items-start justify-between">
                    <div className="flex items-center space-x-3">
                      <Avatar className="w-12 h-12">
                        <AvatarImage src={anggota.foto} alt={anggota.nama} />
                        <AvatarFallback className="bg-primary/20 text-primary font-semibold">
                          {anggota.nama.split(' ').map(n => n[0]).join('')}
                        </AvatarFallback>
                      </Avatar>
                      <div>
                        <CardTitle className="text-lg font-semibold">{anggota.nama}</CardTitle>
                        <CardDescription className="text-sm">
                          {anggota.nis} • {anggota.kelas}
                        </CardDescription>
                      </div>
                    </div>
                    <Badge className={getStatusBadge(anggota.status)}>
                      {anggota.status}
                    </Badge>
                  </div>
                </CardHeader>

                <CardContent className="space-y-4">
                  <div>
                    <div className="flex items-center justify-between mb-2">
                      <span className="text-sm text-muted-foreground">Jabatan</span>
                    </div>
                    <p className="font-medium text-sm">{anggota.jabatan}</p>
                  </div>

                  <div>
                    <div className="flex items-center justify-between mb-2">
                      <span className="text-sm text-muted-foreground">Tingkat Kehadiran</span>
                      <span className={`text-sm font-bold ${getKehadiranColor(kehadiranPercentage)}`}>
                        {kehadiranPercentage}%
                      </span>
                    </div>
                    <div className="w-full bg-muted rounded-full h-2">
                      <div 
                        className={`h-2 rounded-full transition-all duration-300 ${
                          kehadiranPercentage >= 90 ? 'bg-success' :
                          kehadiranPercentage >= 75 ? 'bg-warning' : 'bg-destructive'
                        }`}
                        style={{ width: `${kehadiranPercentage}%` }}
                      ></div>
                    </div>
                    <p className="text-xs text-muted-foreground mt-1">
                      {anggota.totalHadir} dari {anggota.totalAbsen} kegiatan
                    </p>
                  </div>

                  <div className="flex justify-between pt-2">
                    <Button variant="outline" size="sm" className="flex-1 mr-1">
                      <Eye className="w-4 h-4 mr-1" />
                      Detail
                    </Button>
                    <Button variant="outline" size="sm" className="flex-1 mx-1">
                      <Edit className="w-4 h-4 mr-1" />
                      Edit
                    </Button>
                    <Button variant="outline" size="sm" className="flex-1 ml-1 border-destructive/50 text-destructive hover:bg-destructive hover:text-destructive-foreground">
                      <Trash2 className="w-4 h-4" />
                    </Button>
                  </div>
                </CardContent>
              </Card>
            );
          })}
        </div>

        {/* Empty State */}
        {filteredData.length === 0 && (
          <Card className="glass-card text-center py-12">
            <CardContent>
              <Users className="w-16 h-16 text-muted-foreground mx-auto mb-4" />
              <h3 className="text-lg font-semibold mb-2">Tidak ada anggota ditemukan</h3>
              <p className="text-muted-foreground mb-6">
                Coba ubah kata kunci pencarian atau tambah anggota baru
              </p>
              <Button 
                onClick={() => navigate("/pendaftaran-anggota")}
                className="bg-gradient-primary hover:shadow-neon transition-all duration-300"
              >
                <Plus className="w-4 h-4 mr-2" />
                Tambah Anggota Pertama
              </Button>
            </CardContent>
          </Card>
        )}
      </div>
    </div>
  );
};

export default DataAnggota;