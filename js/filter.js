/**
 * Digital Recipe Book - Filtering Script
 */
document.addEventListener("DOMContentLoaded", function () {
    const filterButtons = document.querySelectorAll(".filter-btn");
    const recipeItems = document.querySelectorAll(".recipe-item");

    if (filterButtons.length > 0 && recipeItems.length > 0) {
        filterButtons.forEach(button => {
            button.addEventListener("click", function () {
                
                filterButtons.forEach(btn => {
                    btn.classList.remove("btn-success", "fw-bold");
                    btn.classList.add("btn-outline-secondary");
                });
                
                this.classList.remove("btn-outline-secondary");
                this.classList.add("btn-success", "fw-bold");

                const selectedFilter = this.getAttribute("data-filter");
                let visibleIndex = 0;

                recipeItems.forEach(item => {
                    const category = item.getAttribute("data-category");

                    if (selectedFilter === "all" || category === selectedFilter) {
                        item.style.display = "block";
                        // Re-trigger staggered animation when filter is applied
                        item.style.animation = "none";
                        item.offsetHeight; // Force reflow
                        item.style.animation = fadeInUp 0.5s ease-out forwards;
                        item.style.animationDelay = ${visibleIndex * 0.08}s;
                        visibleIndex++;
                    } else {
                        item.style.display = "none";
                    }
                });
            });
        });
    }
});