import { Chart } from "@/components/ui/chart"
// Chart.js configurations and utilities for OSIS Attendance System
// Chart.js is loaded via CDN in HTML files, so we use the global Chart object

// Chart.js default configuration
Chart.defaults.color = "#94a3b8" // slate-400
Chart.defaults.backgroundColor = "rgba(56, 189, 248, 0.1)" // cyan-400 with opacity
Chart.defaults.borderColor = "#38bdf8" // cyan-400
Chart.defaults.font.family = "system-ui, -apple-system, sans-serif"

// Color palette for charts
const chartColors = {
  primary: "#38bdf8", // cyan-400
  secondary: "#a855f7", // purple-500
  success: "#22c55e", // green-500
  warning: "#eab308", // yellow-500
  danger: "#ef4444", // red-500
  info: "#3b82f6", // blue-500
  dark: "#1e293b", // slate-800
  light: "#f8fafc", // slate-50
}

// Initialize weekly attendance chart
function initializeWeeklyChart() {
  const ctx = document.getElementById("weeklyChart")
  if (!ctx) return

  const weeklyData = {
    labels: ["Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu", "Minggu"],
    datasets: [
      {
        label: "Hadir",
        data: [58, 62, 55, 60, 59, 45, 30],
        backgroundColor: chartColors.success,
        borderColor: chartColors.success,
        borderWidth: 2,
        borderRadius: 4,
        borderSkipped: false,
      },
      {
        label: "Izin",
        data: [5, 3, 7, 4, 5, 8, 12],
        backgroundColor: chartColors.warning,
        borderColor: chartColors.warning,
        borderWidth: 2,
        borderRadius: 4,
        borderSkipped: false,
      },
      {
        label: "Sakit",
        data: [2, 0, 3, 1, 1, 5, 8],
        backgroundColor: chartColors.info,
        borderColor: chartColors.info,
        borderWidth: 2,
        borderRadius: 4,
        borderSkipped: false,
      },
      {
        label: "Alpha",
        data: [0, 0, 0, 0, 0, 2, 15],
        backgroundColor: chartColors.danger,
        borderColor: chartColors.danger,
        borderWidth: 2,
        borderRadius: 4,
        borderSkipped: false,
      },
    ],
  }

  window.weeklyChart = new Chart(ctx, {
    type: "bar",
    data: weeklyData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "top",
          labels: {
            usePointStyle: true,
            padding: 20,
            color: "#e2e8f0",
          },
        },
        tooltip: {
          backgroundColor: "#1e293b",
          titleColor: "#e2e8f0",
          bodyColor: "#e2e8f0",
          borderColor: "#334155",
          borderWidth: 1,
          cornerRadius: 8,
          displayColors: true,
          callbacks: {
            label: (context) => `${context.dataset.label}: ${context.parsed.y} orang`,
          },
        },
      },
      scales: {
        x: {
          grid: {
            color: "#334155",
            drawBorder: false,
          },
          ticks: {
            color: "#94a3b8",
          },
        },
        y: {
          beginAtZero: true,
          grid: {
            color: "#334155",
            drawBorder: false,
          },
          ticks: {
            color: "#94a3b8",
            callback: (value) => value + " orang",
          },
        },
      },
      interaction: {
        intersect: false,
        mode: "index",
      },
      animation: {
        duration: 1000,
        easing: "easeInOutQuart",
      },
    },
  })

  return window.weeklyChart
}

// Initialize monthly attendance chart (pie chart)
function initializeMonthlyChart() {
  const ctx = document.getElementById("monthlyChart")
  if (!ctx) return

  const monthlyData = {
    labels: ["Hadir", "Izin", "Sakit", "Alpha"],
    datasets: [
      {
        data: [89, 7, 3, 1],
        backgroundColor: [chartColors.success, chartColors.warning, chartColors.info, chartColors.danger],
        borderColor: "#1e293b",
        borderWidth: 2,
        hoverOffset: 10,
      },
    ],
  }

  window.monthlyChart = new Chart(ctx, {
    type: "doughnut",
    data: monthlyData,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "bottom",
          labels: {
            usePointStyle: true,
            padding: 20,
            color: "#e2e8f0",
            generateLabels: (chart) => {
              const data = chart.data
              if (data.labels.length && data.datasets.length) {
                return data.labels.map((label, i) => {
                  const dataset = data.datasets[0]
                  const value = dataset.data[i]
                  return {
                    text: `${label}: ${value}%`,
                    fillStyle: dataset.backgroundColor[i],
                    strokeStyle: dataset.borderColor,
                    lineWidth: dataset.borderWidth,
                    pointStyle: "circle",
                    hidden: false,
                    index: i,
                  }
                })
              }
              return []
            },
          },
        },
        tooltip: {
          backgroundColor: "#1e293b",
          titleColor: "#e2e8f0",
          bodyColor: "#e2e8f0",
          borderColor: "#334155",
          borderWidth: 1,
          cornerRadius: 8,
          callbacks: {
            label: (context) => `${context.label}: ${context.parsed}%`,
          },
        },
      },
      animation: {
        animateRotate: true,
        animateScale: true,
        duration: 1000,
        easing: "easeInOutQuart",
      },
      cutout: "60%",
    },
  })

  return window.monthlyChart
}

// Initialize all charts
function initializeCharts() {
  initializeWeeklyChart()
  initializeMonthlyChart()
}

// Update weekly chart with new data
function updateWeeklyChart(newData = null) {
  if (!window.weeklyChart) return

  if (newData) {
    window.weeklyChart.data = newData
  } else {
    // Generate random data for demo
    const datasets = window.weeklyChart.data.datasets
    datasets.forEach((dataset) => {
      dataset.data = dataset.data.map(() => Math.floor(Math.random() * 65))
    })
  }

  window.weeklyChart.update("active")
}

// Update monthly chart with new data
function updateMonthlyChart(newData = null) {
  if (!window.monthlyChart) return

  if (newData) {
    window.monthlyChart.data = newData
  } else {
    // Generate random data for demo
    const total = 100
    const hadir = Math.floor(Math.random() * 20) + 75 // 75-95%
    const izin = Math.floor(Math.random() * 10) + 3 // 3-13%
    const sakit = Math.floor(Math.random() * 5) + 1 // 1-6%
    const alpha = total - hadir - izin - sakit

    window.monthlyChart.data.datasets[0].data = [hadir, izin, sakit, alpha]
  }

  window.monthlyChart.update("active")
}

// Generate attendance trend chart
function createAttendanceTrendChart(canvasId, data) {
  const ctx = document.getElementById(canvasId)
  if (!ctx) return

  return new Chart(ctx, {
    type: "line",
    data: {
      labels: data.labels,
      datasets: [
        {
          label: "Tingkat Kehadiran (%)",
          data: data.values,
          borderColor: chartColors.primary,
          backgroundColor: `${chartColors.primary}20`,
          borderWidth: 3,
          fill: true,
          tension: 0.4,
          pointBackgroundColor: chartColors.primary,
          pointBorderColor: "#1e293b",
          pointBorderWidth: 2,
          pointRadius: 6,
          pointHoverRadius: 8,
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: "#1e293b",
          titleColor: "#e2e8f0",
          bodyColor: "#e2e8f0",
          borderColor: "#334155",
          borderWidth: 1,
          cornerRadius: 8,
          callbacks: {
            label: (context) => `Kehadiran: ${context.parsed.y}%`,
          },
        },
      },
      scales: {
        x: {
          grid: {
            color: "#334155",
            drawBorder: false,
          },
          ticks: {
            color: "#94a3b8",
          },
        },
        y: {
          beginAtZero: true,
          max: 100,
          grid: {
            color: "#334155",
            drawBorder: false,
          },
          ticks: {
            color: "#94a3b8",
            callback: (value) => value + "%",
          },
        },
      },
      animation: {
        duration: 1500,
        easing: "easeInOutQuart",
      },
    },
  })
}

// Generate comparison chart between departments
function createDepartmentComparisonChart(canvasId) {
  const ctx = document.getElementById(canvasId)
  if (!ctx) return

  const data = {
    labels: ["RPL", "TBSM", "ATPH"],
    datasets: [
      {
        label: "Tingkat Kehadiran (%)",
        data: [92, 88, 85],
        backgroundColor: [chartColors.primary, chartColors.secondary, chartColors.success],
        borderColor: [chartColors.primary, chartColors.secondary, chartColors.success],
        borderWidth: 2,
        borderRadius: 8,
        borderSkipped: false,
      },
    ],
  }

  return new Chart(ctx, {
    type: "bar",
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          backgroundColor: "#1e293b",
          titleColor: "#e2e8f0",
          bodyColor: "#e2e8f0",
          borderColor: "#334155",
          borderWidth: 1,
          cornerRadius: 8,
          callbacks: {
            label: (context) => `${context.label}: ${context.parsed.y}%`,
          },
        },
      },
      scales: {
        x: {
          grid: {
            display: false,
          },
          ticks: {
            color: "#94a3b8",
          },
        },
        y: {
          beginAtZero: true,
          max: 100,
          grid: {
            color: "#334155",
            drawBorder: false,
          },
          ticks: {
            color: "#94a3b8",
            callback: (value) => value + "%",
          },
        },
      },
      animation: {
        duration: 1000,
        easing: "easeInOutQuart",
      },
    },
  })
}

// Utility function to generate random attendance data
function generateRandomAttendanceData(days = 30) {
  const data = {
    labels: [],
    values: [],
  }

  for (let i = days - 1; i >= 0; i--) {
    const date = new Date()
    date.setDate(date.getDate() - i)

    data.labels.push(
      date.toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
      }),
    )

    // Generate realistic attendance percentage (75-95%)
    data.values.push(Math.floor(Math.random() * 20) + 75)
  }

  return data
}

// Export chart as image
function exportChartAsImage(chart, filename) {
  const url = chart.toBase64Image()
  const a = document.createElement("a")
  a.href = url
  a.download = filename
  a.click()
}

// Resize charts on window resize
window.addEventListener("resize", () => {
  if (window.weeklyChart) {
    window.weeklyChart.resize()
  }
  if (window.monthlyChart) {
    window.monthlyChart.resize()
  }
})

// Chart animation utilities
function animateChart(chart, duration = 1000) {
  chart.update("active")

  setTimeout(() => {
    chart.options.animation.duration = 0
    chart.update("none")
    chart.options.animation.duration = duration
  }, duration)
}

// Create mini chart for dashboard cards
function createMiniChart(canvasId, data, type = "line") {
  const ctx = document.getElementById(canvasId)
  if (!ctx) return

  return new Chart(ctx, {
    type: type,
    data: data,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false,
        },
        tooltip: {
          enabled: false,
        },
      },
      scales: {
        x: {
          display: false,
        },
        y: {
          display: false,
        },
      },
      elements: {
        point: {
          radius: 0,
        },
      },
      animation: {
        duration: 800,
        easing: "easeInOutQuart",
      },
    },
  })
}

// Initialize charts when DOM is loaded
document.addEventListener("DOMContentLoaded", () => {
  // Add a small delay to ensure all elements are rendered
  setTimeout(initializeCharts, 100)
})
