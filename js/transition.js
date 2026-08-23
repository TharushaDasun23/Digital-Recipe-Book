/**
 * Digital Recipe Book - Smooth Page Transition & Sequential Animations
 * Refactored & Optimized by Contributor
 */
document.addEventListener("DOMContentLoaded", function () {
    // 1. Trigger page entrance animation
    document.body.classList.add("page-loaded");

    // 2. Sequential card entrance
    const cards = document.querySelectorAll('.recipe-card');
    cards.forEach((card, index) => {
        const col = card.closest('.col-md-3, .col-sm-6, .col-lg-4, .col-md-4, .col');
        if (col) {
            col.classList.add('recipe-card-animate');
            col.style.animationDelay = (index * 0.08) + 's';
        }
    });

    // 3. Handle smooth page exit transitions
    const links = document.querySelectorAll("a[href]");
    
    links.forEach(link => {
        const href = link.getAttribute("href");

        if (
            href && 
            !href.startsWith("#") && 
            !href.startsWith("javascript:") && 
            !href.startsWith("http") && 
            link.getAttribute("target") !== "_blank"
        ) {
            link.addEventListener("click", function (e) {
                e.preventDefault();
                
                document.body.classList.remove("page-loaded");
                document.body.classList.add("page-exiting");

                setTimeout(function () {
                    window.location.href = href;
                }, 400);
            });
        }
    });
});