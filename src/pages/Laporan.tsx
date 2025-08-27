import { useState } from "react";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from "@/components/ui/table";
import { Badge } from "@/components/ui/badge";
import { BarChart3, Download, FileText, Search, Calendar, Filter } from "lucide-react";
import Navigation from "@/components/Navigation";

const Laporan = () => {
  const [searchTerm, setSearchTerm] = useState("");
  const [filterPeriod, setFilterPeriod] = useState("semua");
  const [filterStatus, setFilterStatus] = useState("semua");

  // Data dummy untuk laporan
  const laporanData = [
    { id: 1, nama: "Ahmad Rizki", nis: "20210001", tanggal: "2024-01-15", waktu: "08:00", status: "Hadir", keterangan: "-" },
    { id: 2, nama: "Siti Nurhaliza", nis: "20210002", tanggal: "2024-01-15", waktu: "08:15", status: "Terlambat", keterangan: "Macet" },
    { id: 3, nama: "Budi Santoso", nis: "20210003", tanggal: "2024-01-15", waktu: "07:45", status: "Hadir", keterangan: "-" },
    { id: 4, nama: "Dewi Sartika", nis: "20210004", tanggal: "2024-01-15", waktu: "-", status: "Izin", keterangan: "Sakit" },
    { id: 5, nama: "Eko Prasetyo", nis: "20210005", tanggal: "2024-01-15", waktu: "-", status: "Alpha", keterangan: "-" },
    { id: 6, nama: "Fitri Handayani", nis: "20210006", tanggal: "2024-01-14", waktu: "08:10", status: "Terlambat", keterangan: "Transport" },
    { id: 7, nama: "Galih Permana", nis: "20210007", tanggal: "2024-01-14", waktu: "07:55", status: "Hadir", keterangan: "-" },
    { id: 8, nama: "Hesti Rahayu", nis: "20210008", tanggal: "2024-01-14", waktu: "-", status: "Izin", keterangan: "Acara keluarga" },
  ];

  const getStatusBadge = (status: string) => {
    const variants = {
      "Hadir": "bg-success/20 text-success border-success/30",
      "Terlambat": "bg-warning/20 text-warning border-warning/30",
      "Izin": "bg-primary/20 text-primary border-primary/30",
      "Alpha": "bg-destructive/20 text-destructive border-destructive/30"
    };
    return variants[status as keyof typeof variants] || "bg-muted/20 text-muted-foreground";
  };

  const filteredData = laporanData.filter(item => {
    const matchesSearch = item.nama.toLowerCase().includes(searchTerm.toLowerCase()) ||
                         item.nis.includes(searchTerm);
    const matchesStatus = filterStatus === "semua" || item.status === filterStatus;
    // Untuk filter periode, kita bisa menambah logic tanggal di sini
    return matchesSearch && matchesStatus;
  });

  const handleExportPDF = () => {
    // Logic untuk export PDF
    console.log("Exporting PDF...");
  };

  const handleExportExcel = () => {
    // Logic untuk export Excel
    console.log("Exporting Excel...");
  };

  const statistik = {
    totalAbsensi: laporanData.length,
    hadir: laporanData.filter(item => item.status === "Hadir").length,
    terlambat: laporanData.filter(item => item.status === "Terlambat").length,
    izin: laporanData.filter(item => item.status === "Izin").length,
    alpha: laporanData.filter(item => item.status === "Alpha").length,
  };

  return (
    <div className="min-h-screen bg-gradient-dark">
      <Navigation />
      
      <div className="container mx-auto p-6 pt-24">
        {/* Header */}
        <div className="mb-8 animate-fade-in">
          <h1 className="text-3xl font-bold text-foreground mb-2">
            Laporan Absensi
          </h1>
          <p className="text-muted-foreground">
            Lihat dan unduh laporan absensi anggota OSIS
          </p>
        </div>

        {/* Statistik Cards */}
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
          <Card className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in">
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">Total</p>
                  <p className="text-2xl font-bold text-foreground">{statistik.totalAbsensi}</p>
                </div>
                <BarChart3 className="w-8 h-8 text-primary" />
              </div>
            </CardContent>
          </Card>
          
          <Card className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in" style={{ animationDelay: "0.1s" }}>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">Hadir</p>
                  <p className="text-2xl font-bold text-success">{statistik.hadir}</p>
                </div>
                <div className="w-8 h-8 rounded-full bg-success/20 flex items-center justify-center">
                  <div className="w-4 h-4 rounded-full bg-success"></div>
                </div>
              </div>
            </CardContent>
          </Card>

          <Card className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in" style={{ animationDelay: "0.2s" }}>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">Terlambat</p>
                  <p className="text-2xl font-bold text-warning">{statistik.terlambat}</p>
                </div>
                <div className="w-8 h-8 rounded-full bg-warning/20 flex items-center justify-center">
                  <div className="w-4 h-4 rounded-full bg-warning"></div>
                </div>
              </div>
            </CardContent>
          </Card>

          <Card className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in" style={{ animationDelay: "0.3s" }}>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">Izin</p>
                  <p className="text-2xl font-bold text-primary">{statistik.izin}</p>
                </div>
                <div className="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center">
                  <div className="w-4 h-4 rounded-full bg-primary"></div>
                </div>
              </div>
            </CardContent>
          </Card>

          <Card className="glass-card transition-all duration-300 hover:scale-105 animate-fade-in" style={{ animationDelay: "0.4s" }}>
            <CardContent className="p-6">
              <div className="flex items-center justify-between">
                <div>
                  <p className="text-sm text-muted-foreground mb-1">Alpha</p>
                  <p className="text-2xl font-bold text-destructive">{statistik.alpha}</p>
                </div>
                <div className="w-8 h-8 rounded-full bg-destructive/20 flex items-center justify-center">
                  <div className="w-4 h-4 rounded-full bg-destructive"></div>
                </div>
              </div>
            </CardContent>
          </Card>
        </div>

        {/* Filter dan Export */}
        <Card className="glass-card mb-6 animate-slide-up">
          <CardHeader>
            <CardTitle className="flex items-center space-x-2">
              <Filter className="w-5 h-5 text-primary" />
              <span>Filter & Export Data</span>
            </CardTitle>
          </CardHeader>
          <CardContent>
            <div className="flex flex-col lg:flex-row gap-4 items-end">
              <div className="flex-1 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div className="space-y-2">
                  <label className="text-sm font-medium">Cari Anggota</label>
                  <div className="relative">
                    <Search className="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-muted-foreground" />
                    <Input
                      placeholder="Nama atau NIS..."
                      value={searchTerm}
                      onChange={(e) => setSearchTerm(e.target.value)}
                      className="pl-10 bg-input border-border focus:ring-primary focus:border-primary"
                    />
                  </div>
                </div>
                
                <div className="space-y-2">
                  <label className="text-sm font-medium">Periode</label>
                  <Select value={filterPeriod} onValueChange={setFilterPeriod}>
                    <SelectTrigger className="bg-input border-border">
                      <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="semua">Semua Periode</SelectItem>
                      <SelectItem value="hari-ini">Hari Ini</SelectItem>
                      <SelectItem value="minggu-ini">Minggu Ini</SelectItem>
                      <SelectItem value="bulan-ini">Bulan Ini</SelectItem>
                    </SelectContent>
                  </Select>
                </div>

                <div className="space-y-2">
                  <label className="text-sm font-medium">Status</label>
                  <Select value={filterStatus} onValueChange={setFilterStatus}>
                    <SelectTrigger className="bg-input border-border">
                      <SelectValue />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectItem value="semua">Semua Status</SelectItem>
                      <SelectItem value="Hadir">Hadir</SelectItem>
                      <SelectItem value="Terlambat">Terlambat</SelectItem>
                      <SelectItem value="Izin">Izin</SelectItem>
                      <SelectItem value="Alpha">Alpha</SelectItem>
                    </SelectContent>
                  </Select>
                </div>
              </div>

              <div className="flex gap-2">
                <Button 
                  onClick={handleExportPDF}
                  className="bg-destructive hover:bg-destructive/90 text-destructive-foreground"
                >
                  <FileText className="w-4 h-4 mr-2" />
                  Unduh PDF
                </Button>
                <Button 
                  onClick={handleExportExcel}
                  className="bg-success hover:bg-success/90 text-success-foreground"
                >
                  <Download className="w-4 h-4 mr-2" />
                  Unduh Excel
                </Button>
              </div>
            </div>
          </CardContent>
        </Card>

        {/* Tabel Laporan */}
        <Card className="glass-card animate-slide-up" style={{ animationDelay: "0.2s" }}>
          <CardHeader>
            <CardTitle>Data Absensi</CardTitle>
            <CardDescription>
              Menampilkan {filteredData.length} dari {laporanData.length} data absensi
            </CardDescription>
          </CardHeader>
          <CardContent>
            <div className="overflow-x-auto">
              <Table>
                <TableHeader>
                  <TableRow className="border-border">
                    <TableHead>No</TableHead>
                    <TableHead>Nama</TableHead>
                    <TableHead>NIS</TableHead>
                    <TableHead>Tanggal</TableHead>
                    <TableHead>Waktu</TableHead>
                    <TableHead>Status</TableHead>
                    <TableHead>Keterangan</TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  {filteredData.map((item, index) => (
                    <TableRow 
                      key={item.id} 
                      className="border-border hover:bg-card/30 transition-colors"
                    >
                      <TableCell>{index + 1}</TableCell>
                      <TableCell className="font-medium">{item.nama}</TableCell>
                      <TableCell>{item.nis}</TableCell>
                      <TableCell>{item.tanggal}</TableCell>
                      <TableCell>{item.waktu}</TableCell>
                      <TableCell>
                        <Badge className={getStatusBadge(item.status)}>
                          {item.status}
                        </Badge>
                      </TableCell>
                      <TableCell className="text-muted-foreground">
                        {item.keterangan}
                      </TableCell>
                    </TableRow>
                  ))}
                </TableBody>
              </Table>
            </div>
          </CardContent>
        </Card>
      </div>
    </div>
  );
};

export default Laporan;