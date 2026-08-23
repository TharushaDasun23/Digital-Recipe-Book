/**
 * Digital Recipe Book - Scroll To Top Control
 * Refactored & Optimized by Contributor
 */
document.addEventListener("DOMContentLoaded", function () {
    const scrollTopBtn = document.getElementById("scrollTopBtn");

    if (scrollTopBtn) {
        window.addEventListener("scroll", function () {
            if (window.scrollY > 200) {
                scrollTopBtn.classList.remove("d-none");
            } else {
                scrollTopBtn.classList.add("d-none");
            }
        });

        scrollTopBtn.addEventListener("click", function () {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });
    }
});