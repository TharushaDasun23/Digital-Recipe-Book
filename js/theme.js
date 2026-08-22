// Dark Mode, smooth page transitions, and staggered recipe card entrance
document.addEventListener("DOMContentLoaded", function () {
    // 1b. Staggered entrance animation for recipe cards (if any are present on this page)
    const cards = document.querySelectorAll(".recipe-card");
    cards.forEach((card, index) => {
        const col = card.closest(".col-md-3, .col-sm-6, .col-lg-4, .col-md-4, .col");
        if (col) {
            col.classList.add("recipe-card-animate");
            col.style.animationDelay = (index * 0.08) + "s";
        }
    });

    // Smooth Page Exit Transition 
    const links = document.querySelectorAll('a[href]');
    links.forEach(link => {
        link.addEventListener("click", function (e) {
            const targetUrl = this.getAttribute("href");

            if (!targetUrl || this.target === "_blank" || e.ctrlKey || e.metaKey || e.shiftKey || e.altKey || targetUrl.startsWith("#") || targetUrl.startsWith("http") || targetUrl.startsWith("mailto:") || targetUrl.startsWith("tel:") || targetUrl.startsWith("javascript:")) {
                return;
            }

            e.preventDefault();
            document.body.classList.add("page-exiting");

            setTimeout(function () {
                window.location.href = targetUrl;
            }, 300);
        });
    });

    // 2. Dark/Light Mode
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