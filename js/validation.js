// Validates search bar
document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.getElementById("searchForm");
    const searchInput = document.getElementById("searchInput");

    if (searchForm && searchInput) {
        searchForm.addEventListener("submit", function (e) {
           
            if (searchInput.value.trim() === "") {
                e.preventDefault();
                searchInput.classList.add("is-invalid");
                searchInput.placeholder = "Please enter a search keyword!";
            } else {
                searchInput.classList.remove("is-invalid");
            }
        });
    }
});