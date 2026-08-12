//  smooth lift animation 
document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".recipe-card");
    
    cards.forEach(card => {
        card.addEventListener("mouseenter", function () {
            this.style.transform = "translateY(-6px)";
            this.style.transition = "transform 0.3s ease";
        });
        card.addEventListener("mouseleave", function () {
            this.style.transform = "translateY(0)";
        });
    });
});