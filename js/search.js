//real-time search filtering, URL search, and card animations

document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const searchForm = document.getElementById("searchForm");
    const recipeItems = document.querySelectorAll(".recipe-item");

    //card load animation sequence
    recipeItems.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.08}s`;
    });

    //URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const searchQuery = urlParams.get("search");

    if (searchQuery && searchInput) {
        searchInput.value = searchQuery;
        if (recipeItems.length > 0) {
            filterRecipes(searchQuery.toLowerCase().trim());
        }
    }

    // Real-time keyup filtering
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

    // Form submission handling
    if (searchForm) {
        searchForm.addEventListener("submit", function (e) {
            // Stop processing if input is empty
            if (searchInput && searchInput.value.trim() === "") {
                return;
            }

            // Block default page reload if already on recipes page
            if (recipeItems.length > 4) {
                e.preventDefault();
            }
        });
    }
});