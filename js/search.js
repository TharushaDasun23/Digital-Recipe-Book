// Handles real-time search filtering,URL search,card loading animations
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchForm = document.getElementById("searchForm");
    const recipeItems = document.querySelectorAll(".recipe-item");

    // 1. Staggered card load animation sequence
    recipeItems.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.08}s`;
    });

    // 2. Parse search query
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get("search");

    if (searchQuery && searchInput) {
        searchInput.value = searchQuery;
        if (recipeItems.length > 0) {
            filterRecipes(searchQuery.toLowerCase().trim());
        }
    }

    // 3. Real-time keyup filtering 
    if (searchInput && recipeItems.length > 4) {
        searchInput.addEventListener("keyup", function () {
            const query = searchInput.value.toLowerCase().trim();
            filterRecipes(query);
        });
    }

  
    function filterRecipes(query) {
        recipeItems.forEach(item => {
            const title = item.querySelector(".card-title") ? item.querySelector(".card-title").textContent.toLowerCase() : "";
            const category = item.getAttribute("data-category") ? item.getAttribute("data-category").toLowerCase() : "";

            if (title.includes(query) || category.includes(query)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }

    // 4. Form submission behavior
    if (searchForm) {
        searchForm.addEventListener("submit", function (e) {
            // Block page refresh only if already on the full recipes page
            if (recipeItems.length > 4) {
                e.preventDefault();
            }
        });
    }
});