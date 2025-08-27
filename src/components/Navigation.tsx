import { useState } from "react";
import { Link, useLocation, useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { 
  Home, 
  Clock, 
  Users, 
  BarChart3, 
  UserPlus, 
  Menu, 
  X, 
  LogOut,
  QrCode 
} from "lucide-react";

const Navigation = () => {
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);
  const location = useLocation();
  const navigate = useNavigate();

  const navItems = [
    { name: "Dashboard", path: "/dashboard", icon: Home },
    { name: "Absensi", path: "/absensi", icon: Clock },
    { name: "Data Anggota", path: "/data-anggota", icon: Users },
    { name: "Pendaftaran", path: "/pendaftaran-anggota", icon: UserPlus },
    { name: "Laporan", path: "/laporan", icon: BarChart3 }
  ];

  const handleLogout = () => {
    navigate("/");
  };

  return (
    <>
      <nav className="fixed top-0 w-full bg-card/80 backdrop-blur-md border-b border-white/10 z-50">
        <div className="container mx-auto px-4">
          <div className="flex items-center justify-between h-16">
            {/* Logo */}
            <Link to="/dashboard" className="flex items-center space-x-2">
              <div className="p-2 rounded-lg bg-primary/20 glow-primary">
                <QrCode className="w-6 h-6 text-primary" />
              </div>
              <span className="font-bold text-lg text-foreground">OSIS Digital</span>
            </Link>

            {/* Desktop Navigation */}
            <div className="hidden md:flex items-center space-x-1">
              {navItems.map((item) => (
                <Link
                  key={item.path}
                  to={item.path}
                  className={`flex items-center space-x-2 px-4 py-2 rounded-lg transition-all duration-300 ${
                    location.pathname === item.path
                      ? "bg-primary/20 text-primary shadow-neon"
                      : "text-muted-foreground hover:text-foreground hover:bg-card/50"
                  }`}
                >
                  <item.icon className="w-4 h-4" />
                  <span className="font-medium">{item.name}</span>
                </Link>
              ))}
            </div>

            {/* Desktop Logout */}
            <div className="hidden md:flex">
              <Button
                variant="outline"
                size="sm"
                onClick={handleLogout}
                className="border-destructive/50 text-destructive hover:bg-destructive hover:text-destructive-foreground"
              >
                <LogOut className="w-4 h-4 mr-2" />
                Keluar
              </Button>
            </div>

            {/* Mobile Menu Button */}
            <button
              className="md:hidden p-2 rounded-lg text-foreground hover:bg-card/50 transition-colors"
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
            >
              {isMobileMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
            </button>
          </div>
        </div>

        {/* Mobile Navigation */}
        {isMobileMenuOpen && (
          <div className="md:hidden bg-card/95 backdrop-blur-md border-t border-white/10">
            <div className="px-4 py-4 space-y-2">
              {navItems.map((item) => (
                <Link
                  key={item.path}
                  to={item.path}
                  className={`flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-300 ${
                    location.pathname === item.path
                      ? "bg-primary/20 text-primary shadow-neon"
                      : "text-muted-foreground hover:text-foreground hover:bg-card/50"
                  }`}
                  onClick={() => setIsMobileMenuOpen(false)}
                >
                  <item.icon className="w-5 h-5" />
                  <span className="font-medium">{item.name}</span>
                </Link>
              ))}
              <Button
                variant="outline"
                size="sm"
                onClick={handleLogout}
                className="w-full mt-4 border-destructive/50 text-destructive hover:bg-destructive hover:text-destructive-foreground"
              >
                <LogOut className="w-4 h-4 mr-2" />
                Keluar
              </Button>
            </div>
          </div>
        )}
      </nav>
    </>
  );
};

export default Navigation;