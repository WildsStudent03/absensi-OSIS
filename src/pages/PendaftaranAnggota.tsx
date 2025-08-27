import { useState } from "react";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { UserPlus, Upload, Image as ImageIcon, User } from "lucide-react";
import Navigation from "@/components/Navigation";
import { useToast } from "@/hooks/use-toast";

const PendaftaranAnggota = () => {
  const [formData, setFormData] = useState({
    namaLengkap: "",
    nis: "",
    kelas: "",
    jabatan: "",
    foto: null as File | null
  });
  const { toast } = useToast();

  const handleInputChange = (field: string, value: string) => {
    setFormData(prev => ({ ...prev, [field]: value }));
  };

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    const file = e.target.files?.[0];
    if (file) {
      setFormData(prev => ({ ...prev, foto: file }));
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    if (!formData.namaLengkap || !formData.nis || !formData.kelas || !formData.jabatan) {
      toast({
        title: "Error",
        description: "Mohon lengkapi semua field yang diperlukan",
        variant: "destructive"
      });
      return;
    }

    toast({
      title: "Pendaftaran Berhasil!",
      description: `${formData.namaLengkap} berhasil didaftarkan sebagai ${formData.jabatan}`,
    });

    // Reset form
    setFormData({
      namaLengkap: "",
      nis: "",
      kelas: "",
      jabatan: "",
      foto: null
    });
  };

  const kelasOptions = [
    "X IPA 1", "X IPA 2", "X IPA 3", "X IPS 1", "X IPS 2",
    "XI IPA 1", "XI IPA 2", "XI IPA 3", "XI IPS 1", "XI IPS 2",
    "XII IPA 1", "XII IPA 2", "XII IPA 3", "XII IPS 1", "XII IPS 2"
  ];

  const jabatanOptions = [
    "Ketua OSIS", "Wakil Ketua OSIS", "Sekretaris", "Bendahara",
    "Koordinator Bidang Keagamaan", "Koordinator Bidang Kesiswaan",
    "Koordinator Bidang Kebersihan", "Koordinator Bidang Keamanan",
    "Koordinator Bidang Koperasi", "Koordinator Bidang Olahraga",
    "Koordinator Bidang Kesenian", "Anggota"
  ];

  return (
    <div className="min-h-screen bg-gradient-dark">
      <Navigation />
      
      <div className="container mx-auto p-6 pt-24">
        {/* Header */}
        <div className="mb-8 animate-fade-in">
          <h1 className="text-3xl font-bold text-foreground mb-2">
            Pendaftaran Anggota OSIS
          </h1>
          <p className="text-muted-foreground">
            Daftarkan anggota baru untuk organisasi siswa
          </p>
        </div>

        <div className="max-w-4xl mx-auto">
          <Card className="glass-card animate-slide-up">
            <CardHeader>
              <CardTitle className="flex items-center space-x-2">
                <UserPlus className="w-6 h-6 text-primary" />
                <span>Form Pendaftaran Anggota</span>
              </CardTitle>
              <CardDescription>
                Lengkapi informasi anggota OSIS yang akan didaftarkan
              </CardDescription>
            </CardHeader>
            <CardContent>
              <form onSubmit={handleSubmit} className="space-y-6">
                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                  {/* Form Fields */}
                  <div className="lg:col-span-2 space-y-4">
                    <div className="space-y-2">
                      <Label htmlFor="namaLengkap">Nama Lengkap</Label>
                      <Input
                        id="namaLengkap"
                        type="text"
                        placeholder="Masukkan nama lengkap"
                        value={formData.namaLengkap}
                        onChange={(e) => handleInputChange("namaLengkap", e.target.value)}
                        className="bg-input border-border focus:ring-primary focus:border-primary"
                        required
                      />
                    </div>

                    <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                      <div className="space-y-2">
                        <Label htmlFor="nis">NIS</Label>
                        <Input
                          id="nis"
                          type="text"
                          placeholder="Masukkan NIS"
                          value={formData.nis}
                          onChange={(e) => handleInputChange("nis", e.target.value)}
                          className="bg-input border-border focus:ring-primary focus:border-primary"
                          required
                        />
                      </div>
                      <div className="space-y-2">
                        <Label htmlFor="kelas">Kelas</Label>
                        <Select value={formData.kelas} onValueChange={(value) => handleInputChange("kelas", value)}>
                          <SelectTrigger className="bg-input border-border focus:ring-primary focus:border-primary">
                            <SelectValue placeholder="Pilih kelas" />
                          </SelectTrigger>
                          <SelectContent>
                            {kelasOptions.map((kelas) => (
                              <SelectItem key={kelas} value={kelas}>
                                {kelas}
                              </SelectItem>
                            ))}
                          </SelectContent>
                        </Select>
                      </div>
                    </div>

                    <div className="space-y-2">
                      <Label htmlFor="jabatan">Jabatan</Label>
                      <Select value={formData.jabatan} onValueChange={(value) => handleInputChange("jabatan", value)}>
                        <SelectTrigger className="bg-input border-border focus:ring-primary focus:border-primary">
                          <SelectValue placeholder="Pilih jabatan" />
                        </SelectTrigger>
                        <SelectContent>
                          {jabatanOptions.map((jabatan) => (
                            <SelectItem key={jabatan} value={jabatan}>
                              {jabatan}
                            </SelectItem>
                          ))}
                        </SelectContent>
                      </Select>
                    </div>
                  </div>

                  {/* Photo Upload */}
                  <div className="lg:col-span-1">
                    <div className="space-y-2">
                      <Label>Foto Anggota</Label>
                      <div className="border-2 border-dashed border-border rounded-lg p-6 text-center hover:border-primary/50 transition-colors">
                        {formData.foto ? (
                          <div className="space-y-2">
                            <div className="w-20 h-20 mx-auto bg-primary/20 rounded-full flex items-center justify-center">
                              <User className="w-10 h-10 text-primary" />
                            </div>
                            <p className="text-sm font-medium">{formData.foto.name}</p>
                            <Button
                              type="button"
                              variant="outline"
                              size="sm"
                              onClick={() => setFormData(prev => ({ ...prev, foto: null }))}
                            >
                              Hapus
                            </Button>
                          </div>
                        ) : (
                          <div className="space-y-2">
                            <ImageIcon className="w-12 h-12 mx-auto text-muted-foreground" />
                            <div className="space-y-1">
                              <p className="text-sm font-medium">Upload Foto</p>
                              <p className="text-xs text-muted-foreground">
                                PNG, JPG hingga 5MB
                              </p>
                            </div>
                          </div>
                        )}
                        <input
                          type="file"
                          accept="image/*"
                          onChange={handleFileChange}
                          className="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                        />
                      </div>
                    </div>

                    <Button
                      type="button"
                      variant="outline"
                      className="w-full mt-4 border-secondary/50 text-secondary hover:bg-secondary hover:text-secondary-foreground"
                    >
                      <Upload className="w-4 h-4 mr-2" />
                      Pilih File
                    </Button>
                  </div>
                </div>

                {/* Preview Card */}
                {formData.namaLengkap && (
                  <Card className="bg-card/30 border border-white/10 animate-fade-in">
                    <CardHeader>
                      <CardTitle className="text-lg">Preview Data Anggota</CardTitle>
                    </CardHeader>
                    <CardContent>
                      <div className="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                          <span className="text-muted-foreground">Nama:</span>
                          <span className="ml-2 font-medium">{formData.namaLengkap}</span>
                        </div>
                        <div>
                          <span className="text-muted-foreground">NIS:</span>
                          <span className="ml-2 font-medium">{formData.nis}</span>
                        </div>
                        <div>
                          <span className="text-muted-foreground">Kelas:</span>
                          <span className="ml-2 font-medium">{formData.kelas}</span>
                        </div>
                        <div>
                          <span className="text-muted-foreground">Jabatan:</span>
                          <span className="ml-2 font-medium">{formData.jabatan}</span>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                )}

                <Button 
                  type="submit" 
                  className="w-full bg-gradient-primary hover:shadow-neon transition-all duration-300 font-medium text-lg py-6"
                >
                  <UserPlus className="w-5 h-5 mr-2" />
                  Daftarkan Anggota
                </Button>
              </form>
            </CardContent>
          </Card>
        </div>
      </div>
    </div>
  );
};

export default PendaftaranAnggota;