// Daftar warna gradient
const gradients = [
    ['#ff8a00', '#e52e71'],
    ['#42e695', '#3bb2b8'],
    ['#4776e6', '#8e54e9'],
    ['#ff512f', '#dd2476'],
    ['#24c6dc', '#514a9d']
];

let currentIndex = 0;
const bg = document.querySelector('.interactive-bg');

// Fungsi ganti background
function changeGradient() {
    currentIndex = (currentIndex + 1) % gradients.length;
    const colors = gradients[currentIndex];

    anime({
        targets: '.interactive-bg',
        background: `linear-gradient(270deg, ${colors[0]}, ${colors[1]})`,
        duration: 1200,
        easing: "easeInOutQuad"
    });
}

// Ripple di posisi klik
function createRipple(x, y) {
    const ripple = document.createElement("div");
    ripple.classList.add("ripple");
    document.body.appendChild(ripple);

    const size = Math.max(window.innerWidth, window.innerHeight) * 2;
    ripple.style.width = ripple.style.height = size + "px";
    ripple.style.left = (x - size / 2) + "px";
    ripple.style.top = (y - size / 2) + "px";
    ripple.style.background = "rgba(255,255,255,0.3)";

    anime({
        targets: ripple,
        scale: [0, 1],
        opacity: [0.6, 0],
        easing: "easeOutQuad",
        duration: 1200,
        complete: () => ripple.remove()
    });
}

// Klik / tap manual
document.addEventListener("click", (e) => {
    changeGradient();
    createRipple(e.clientX, e.clientY);
});

document.addEventListener("touchstart", (e) => {
    const touch = e.touches[0];
    changeGradient();
    createRipple(touch.clientX, touch.clientY);
});

// Auto ganti tiap 5 detik
setInterval(changeGradient, 5000);
