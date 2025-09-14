// Common JavaScript functions for OSIS Attendance System

// Authentication and role management
function checkAuth(requiredRole = null) {
  const userRole = localStorage.getItem("userRole")
  const userName = localStorage.getItem("userName")

  if (!userRole || !userName) {
    window.location.href = "index.html"
    return false
  }

  if (requiredRole && userRole !== requiredRole) {
    alert("Akses ditolak! Anda tidak memiliki izin untuk halaman ini.")
    if (userRole === "admin") {
      window.location.href = "dashboard-admin.html"
    } else {
      window.location.href = "dashboard-member.html"
    }
    return false
  }

  return true
}

function logout() {
  if (confirm("Yakin ingin logout?")) {
    localStorage.clear()
    window.location.href = "index.html"
  }
}

// Notification system
function showNotification(message, type = "info") {
  // Remove existing notifications
  const existingNotifications = document.querySelectorAll(".notification")
  existingNotifications.forEach((notification) => notification.remove())

  const notification = document.createElement("div")
  notification.className = `notification ${type}`
  notification.textContent = message

  document.body.appendChild(notification)

  // Auto remove after 3 seconds
  setTimeout(() => {
    notification.style.animation = "slideOutRight 0.3s ease-out forwards"
    setTimeout(() => notification.remove(), 300)
  }, 3000)
}

// Page transition effects
document.addEventListener("DOMContentLoaded", () => {
  // Fade in animation for cards
  const cards = document.querySelectorAll(".login-card, .register-card, .glow-card")
  cards.forEach((card, index) => {
    setTimeout(() => {
      card.style.opacity = "1"
      card.style.transform = "translateY(0)"
    }, index * 100)
  })

  // Initialize typing animation
  const typingElements = document.querySelectorAll(".typing-text")
  typingElements.forEach((element) => {
    element.style.animation = "typing 2s steps(40, end), blink 1s step-end infinite"
  })
})

// Form validation helpers
function validateEmail(email) {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(email)
}

function validateNIS(nis) {
  return nis && nis.length >= 4 && /^\d+$/.test(nis)
}

function validatePassword(password) {
  return password && password.length >= 6
}

// Local storage helpers
function saveUserData(userData) {
  Object.keys(userData).forEach((key) => {
    localStorage.setItem(key, userData[key])
  })
}

function getUserData() {
  return {
    userRole: localStorage.getItem("userRole"),
    userName: localStorage.getItem("userName"),
    userNis: localStorage.getItem("userNis"),
    userEmail: localStorage.getItem("userEmail"),
  }
}

// Date and time utilities
function formatDate(date) {
  return new Date(date).toLocaleDateString("id-ID", {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  })
}

function formatTime(date) {
  return new Date(date).toLocaleTimeString("id-ID", {
    hour: "2-digit",
    minute: "2-digit",
  })
}

function getCurrentDateTime() {
  const now = new Date()
  return {
    date: formatDate(now),
    time: formatTime(now),
    timestamp: now.toISOString(),
  }
}

// Modal utilities
function openModal(modalId) {
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.remove("hidden")
    document.body.style.overflow = "hidden"
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId)
  if (modal) {
    modal.classList.add("hidden")
    document.body.style.overflow = "auto"
  }
}

// Click outside modal to close
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("modal")) {
    e.target.classList.add("hidden")
    document.body.style.overflow = "auto"
  }
})

// Escape key to close modal
document.addEventListener("keydown", (e) => {
  if (e.key === "Escape") {
    const openModals = document.querySelectorAll(".modal:not(.hidden)")
    openModals.forEach((modal) => {
      modal.classList.add("hidden")
      document.body.style.overflow = "auto"
    })
  }
})

// Search and filter utilities
function filterTable(searchInput, tableBody, columnIndex = 0) {
  const searchTerm = searchInput.toLowerCase()
  const rows = tableBody.querySelectorAll("tr")

  rows.forEach((row) => {
    const cellText = row.cells[columnIndex]?.textContent.toLowerCase() || ""
    row.style.display = cellText.includes(searchTerm) ? "" : "none"
  })
}

// Loading states
function showLoading(element) {
  if (typeof element === "string") {
    element = document.getElementById(element)
  }

  if (element) {
    element.disabled = true
    element.innerHTML = '<div class="spinner"></div> Loading...'
  }
}

function hideLoading(element, originalText) {
  if (typeof element === "string") {
    element = document.getElementById(element)
  }

  if (element) {
    element.disabled = false
    element.innerHTML = originalText
  }
}

// Attendance utilities
function getAttendanceStatus(status) {
  const statusMap = {
    hadir: { text: "Hadir", class: "status-hadir", icon: "✅" },
    izin: { text: "Izin", class: "status-izin", icon: "📝" },
    sakit: { text: "Sakit", class: "status-sakit", icon: "🏥" },
    alpha: { text: "Alpha", class: "status-alpha", icon: "❌" },
  }

  return statusMap[status] || statusMap["alpha"]
}

function createStatusBadge(status) {
  const statusInfo = getAttendanceStatus(status)
  return `<span class="status-badge ${statusInfo.class}">${statusInfo.text}</span>`
}

// Data simulation helpers
function generateMockAttendanceData(days = 30) {
  const data = []
  const statuses = ["hadir", "izin", "sakit", "alpha"]
  const weights = [0.85, 0.08, 0.05, 0.02] // Probability weights

  for (let i = 0; i < days; i++) {
    const date = new Date()
    date.setDate(date.getDate() - i)

    // Weighted random selection
    let random = Math.random()
    let status = "hadir"

    for (let j = 0; j < weights.length; j++) {
      if (random < weights[j]) {
        status = statuses[j]
        break
      }
      random -= weights[j]
    }

    data.push({
      date: date.toISOString().split("T")[0],
      status: status,
      time:
        status === "hadir"
          ? `0${7 + Math.floor(Math.random() * 2)}:${String(Math.floor(Math.random() * 60)).padStart(2, "0")}`
          : "-",
    })
  }

  return data.reverse()
}

// Export utilities
function exportToCSV(data, filename) {
  const csv = data.map((row) => Object.values(row).join(",")).join("\n")
  const blob = new Blob([csv], { type: "text/csv" })
  const url = window.URL.createObjectURL(blob)

  const a = document.createElement("a")
  a.href = url
  a.download = filename
  a.click()

  window.URL.revokeObjectURL(url)
}

// Print utilities
function printElement(elementId) {
  const element = document.getElementById(elementId)
  if (!element) return

  const printWindow = window.open("", "_blank")
  printWindow.document.write(`
        <html>
            <head>
                <title>Print</title>
                <style>
                    body { font-family: Arial, sans-serif; }
                    table { width: 100%; border-collapse: collapse; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                ${element.innerHTML}
            </body>
        </html>
    `)
  printWindow.document.close()
  printWindow.print()
}

// Initialize common functionality
document.addEventListener("DOMContentLoaded", () => {
  // Add smooth scrolling
  document.documentElement.style.scrollBehavior = "smooth"

  // Add focus management for accessibility
  const focusableElements = 'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'

  document.addEventListener("keydown", (e) => {
    if (e.key === "Tab") {
      const focusable = Array.from(document.querySelectorAll(focusableElements))
      const index = focusable.indexOf(document.activeElement)

      if (e.shiftKey) {
        const prevIndex = index > 0 ? index - 1 : focusable.length - 1
        focusable[prevIndex]?.focus()
      } else {
        const nextIndex = index < focusable.length - 1 ? index + 1 : 0
        focusable[nextIndex]?.focus()
      }
    }
  })
})

// Error handling
window.addEventListener("error", (e) => {
  console.error("Application error:", e.error)
  showNotification("Terjadi kesalahan aplikasi", "error")
})

// Service worker registration (for offline capability)
if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    // Service worker would be registered here in a real application
    console.log("Service Worker support detected")
  })
}
