import { useState } from "react";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";
import { QrCode, Clock, Calendar, User, CheckCircle2 } from "lucide-react";
import Navigation from "@/components/Navigation";
import { useToast } from "@/hooks/use-toast";

const Absensi = () => {
  const [nama, setNama] = useState("");
  const [nis, setNis] = useState("");
  const [status, setStatus] = useState("");
  const [keterangan, setKeterangan] = useState("");
  const { toast } = useToast();

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    if (!nama || !nis || !status) {
      toast({
        title: "Error",
        description: "Mohon lengkapi semua field yang diperlukan",
        variant: "destructive"
      });
      return;
    }

    toast({
      title: "Absensi Berhasil!",
      description: `${nama} berhasil diabsen dengan status: ${status}`,
    });

    // Reset form
    setNama("");
    setNis("");
    setStatus("");
    setKeterangan("");
  };

  const statusOptions = [
    { value: "hadir", label: "Hadir", color: "success", description: "Tepat waktu" },
    { value: "terlambat", label: "Terlambat", color: "warning", description: "Datang terlambat" },
    { value: "izin", label: "Izin", color: "primary", description: "Izin dengan keterangan" },
    { value: "alpha", label: "Alpha", color: "destructive", description: "Tanpa keterangan" }
  ];

  const currentDate = new Date().toLocaleDateString('id-ID', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  });

  const currentTime = new Date().toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit'
  });

  return (
    <div className="min-h-screen bg-gradient-dark">
      <Navigation />
      
      <div className="container mx-auto p-6 pt-24">
        {/* Header */}
        <div className="mb-8 fade-in">
          <h1 className="text-3xl font-bold text-foreground mb-2">
            Absensi Anggota OSIS
          </h1>
          <p className="text-muted-foreground">
            Lakukan absensi untuk kegiatan OSIS hari ini
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
          {/* Info Card */}
          <div className="lg:col-span-1">
            <Card className="glass-card mb-6 fade-in">
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <Calendar className="w-5 h-5 text-primary" />
                  <span>Info Hari Ini</span>
                </CardTitle>
              </CardHeader>
              <CardContent className="space-y-4">
                <div className="flex items-center space-x-3">
                  <Calendar className="w-4 h-4 text-muted-foreground" />
                  <span className="text-sm">{currentDate}</span>
                </div>
                <div className="flex items-center space-x-3">
                  <Clock className="w-4 h-4 text-muted-foreground" />
                  <span className="text-sm">{currentTime}</span>
                </div>
                <div className="flex items-center space-x-3">
                  <User className="w-4 h-4 text-muted-foreground" />
                  <span className="text-sm">Absensi Rutin</span>
                </div>
              </CardContent>
            </Card>

            {/* QR Code Scanner */}
            <Card className="glass-card fade-in" style={{ animationDelay: "0.1s" }}>
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <QrCode className="w-5 h-5 text-secondary" />
                  <span>Scan QR Code</span>
                </CardTitle>
                <CardDescription>
                  Absensi cepat dengan QR Code
                </CardDescription>
              </CardHeader>
              <CardContent>
                <div className="aspect-square bg-card/30 border-2 border-dashed border-secondary/50 rounded-lg flex items-center justify-center mb-4">
                  <QrCode className="w-20 h-20 text-secondary/50" />
                </div>
                <Button 
                  variant="outline" 
                  className="w-full border-secondary/50 text-secondary hover:bg-secondary hover:text-secondary-foreground glow-secondary"
                >
                  Buka Kamera
                </Button>
              </CardContent>
            </Card>
          </div>

          {/* Form Absensi */}
          <div className="lg:col-span-2">
            <Card className="glass-card slide-up">
              <CardHeader>
                <CardTitle className="flex items-center space-x-2">
                  <CheckCircle2 className="w-6 h-6 text-primary" />
                  <span>Form Absensi Manual</span>
                </CardTitle>
                <CardDescription>
                  Isi form berikut untuk melakukan absensi
                </CardDescription>
              </CardHeader>
              <CardContent>
                <form onSubmit={handleSubmit} className="space-y-6">
                  <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div className="space-y-2">
                      <Label htmlFor="nama">Nama Lengkap</Label>
                      <Input
                        id="nama"
                        type="text"
                        placeholder="Masukkan nama lengkap"
                        value={nama}
                        onChange={(e) => setNama(e.target.value)}
                        className="bg-input border-border focus:ring-primary focus:border-primary"
                        required
                      />
                    </div>
                    <div className="space-y-2">
                      <Label htmlFor="nis">NIS</Label>
                      <Input
                        id="nis"
                        type="text"
                        placeholder="Masukkan NIS"
                        value={nis}
                        onChange={(e) => setNis(e.target.value)}
                        className="bg-input border-border focus:ring-primary focus:border-primary"
                        required
                      />
                    </div>
                  </div>

                  <div className="space-y-3">
                    <Label>Status Kehadiran</Label>
                    <RadioGroup 
                      value={status} 
                      onValueChange={setStatus}
                      className="grid grid-cols-1 md:grid-cols-2 gap-4"
                    >
                      {statusOptions.map((option) => (
                        <div key={option.value} className="flex items-center space-x-2">
                          <RadioGroupItem 
                            value={option.value} 
                            id={option.value}
                            className={`border-${option.color} text-${option.color}`}
                          />
                          <Label 
                            htmlFor={option.value} 
                            className="flex-1 cursor-pointer p-4 rounded-lg border border-border hover:bg-card/50 transition-all duration-300"
                          >
                            <div className="font-medium">{option.label}</div>
                            <div className="text-sm text-muted-foreground">{option.description}</div>
                          </Label>
                        </div>
                      ))}
                    </RadioGroup>
                  </div>

                  {(status === "izin" || status === "alpha") && (
                    <div className="space-y-2">
                      <Label htmlFor="keterangan">Keterangan</Label>
                      <Input
                        id="keterangan"
                        type="text"
                        placeholder="Masukkan keterangan (opsional)"
                        value={keterangan}
                        onChange={(e) => setKeterangan(e.target.value)}
                        className="bg-input border-border focus:ring-primary focus:border-primary"
                      />
                    </div>
                  )}

                  <Button 
                    type="submit" 
                    className="w-full bg-gradient-primary hover:shadow-neon transition-all duration-300 font-medium text-lg py-6"
                  >
                    Kirim Absensi
                  </Button>
                </form>
              </CardContent>
            </Card>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Absensi;