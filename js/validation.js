// Validation Search,Contact Forms
document.addEventListener("DOMContentLoaded", function () {

    //  SEARCH BAR VALIDATION & CHECKING

    const searchInput = document.getElementById("searchInput");
    const searchForm = document.getElementById("searchForm");

    const availableRecipes = [
        "sri lankan pumpkin curry", "pumpkin curry",
        "sri lankan coconut sambal", "coconut sambal",
        "creamy avocado pasta", "avocado pasta",
        "chickpea & spinach curry", "chickpea curry",
        "vegan mushroom fried rice", "fried rice",
        "raw jackfruit curry (polos)", "jackfruit curry", "polos",
        "vegan vegetable stir fry", "stir fry",
        "tomato basil bruschetta", "bruschetta",
        "red lentil dhal curry", "dhal curry",
        "gotukola pennywort salad", "gotukola sambol",
        "tofu veggie noodle soup", "noodle soup",
        "vegan mushroom risotto", "risotto",
        "sri lankan cashew curry", "cashew curry",
        "fragrant vegetable biryani", "biryani",
        "crispy vegetable spring rolls", "spring rolls",
        "eggplant pickle (batu moju)", "batu moju",
        "sri lankan", "italian", "indian", "asian"
    ];

    if (searchInput && searchForm) {

        function showSearchError(message) {
            searchInput.classList.add("is-invalid");
            searchInput.value = "";
            searchInput.placeholder = message;
        }

        searchForm.addEventListener("submit", function (e) {
            const rawQuery = searchInput.value;
            const query = rawQuery.toLowerCase().trim();

            const validPattern = /[a-zA-Z0-9]/;
            if (query === "" || !validPattern.test(query)) {
                e.preventDefault();
                showSearchError("Please enter valid search terms!");
                return;
            }

            const recipeExists = availableRecipes.some(recipe => recipe.includes(query) || query.includes(recipe));

            if (!recipeExists) {
                e.preventDefault();
                showSearchError(`No recipe found for "${rawQuery}"!`);
            } else {
                searchInput.classList.remove("is-invalid");
                searchInput.classList.add("is-valid");
            }
        });

        searchInput.addEventListener("input", function () {
            if (searchInput.value.trim() !== "") {
                searchInput.classList.remove("is-invalid");
            }
        });
    }

    //  CONTACT FORM VALIDATION 
    const contactForm = document.querySelector("form");

    if (contactForm && window.location.pathname.includes("contact.html")) {
        contactForm.setAttribute("novalidate", "true");

        contactForm.addEventListener("submit", function (e) {
            let isValid = true;

            // Target fields specifically inside contact form
            const nameInput = contactForm.querySelector('input[type="text"]');
            const emailInput = contactForm.querySelector('input[type="email"]');
            const messageInput = contactForm.querySelector('textarea');

            //Name Check
            if (nameInput) {
                if (nameInput.value.trim() === "") {
                    showError(nameInput);
                    isValid = false;
                } else {
                    showSuccess(nameInput);
                }
            }

            //Email Check
            if (emailInput) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailInput.value.trim())) {
                    showError(emailInput);
                    isValid = false;
                } else {
                    showSuccess(emailInput);
                }
            }

            //Message Check
            if (messageInput) {
                if (messageInput.value.trim() === "") {
                    showError(messageInput);
                    isValid = false;
                } else {
                    showSuccess(messageInput);
                }
            }

        
            if (!isValid) {
                e.preventDefault();
                e.stopPropagation();
            }
        });

        function showError(field) {
            field.classList.add("is-invalid");
            field.classList.remove("is-valid");
        }

        function showSuccess(field) {
            field.classList.remove("is-invalid");
            field.classList.add("is-valid");
        }
    }
});