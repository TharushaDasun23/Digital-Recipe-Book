/**
 * Digital Recipe Book - Theme Switcher & Page Entrance
 * Refactored & Optimized by Contributor
 */
document.addEventListener("DOMContentLoaded", function () {
    // 1. Page Fade-In Transition
    document.body.classList.add("page-loaded");

    // Smooth Page Exit Transition 
    const links = document.querySelectorAll('a[href$=".html"]');
    links.forEach(link => {
        link.addEventListener("click", function (e) {
            const targetUrl = this.getAttribute("href");

            if (this.target === "_blank" || targetUrl.startsWith("#")) {
                return;
            }

            e.preventDefault();
            document.body.classList.remove("page-loaded");
            document.body.classList.add("page-exiting");

            setTimeout(function () {
                window.location.href = targetUrl;
            }, 300);
        });
    });

    // 2. Dark/Light Mode Engine
    const themeToggleBtn = document.getElementById("themeToggle") || document.getElementById("themeToggleBtn");
    const savedTheme = localStorage.getItem("theme");

    if (savedTheme) {
        document.documentElement.setAttribute("data-bs-theme", savedTheme);
        updateButtonState(themeToggleBtn, savedTheme);
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", function () {
            const currentTheme = document.documentElement.getAttribute("data-bs-theme");
            const newTheme = currentTheme === "dark" ? "light" : "dark";

            document.documentElement.setAttribute("data-bs-theme", newTheme);
            localStorage.setItem("theme", newTheme);
            updateButtonState(themeToggleBtn, newTheme);
        });
    }

    function updateButtonState(button, theme) {
        if (!button) return;

        if (theme === "dark") {
            button.textContent = "☀️ Light Mode";
            button.classList.remove("btn-outline-dark");
            button.classList.add("btn-outline-light");
        } else {
            button.textContent = "🌙 Dark Mode";
            button.classList.remove("btn-outline-light");
            button.classList.add("btn-outline-dark");
        }
    }
});