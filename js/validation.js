/**
 * Digital Recipe Book - Form Validation System
 * Refactored & Optimized by Contributor
 */
document.addEventListener("DOMContentLoaded", function () {

    // 1. SEARCH BAR VALIDATION & CHECKING
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
                showSearchError(No recipe found for "${rawQuery}"!);
            } else {
                searchInput.classList.remove('is-invalid');
                searchInput.setCustomValidity('');
            }
        });
    }

    const contactForm = document.querySelector('form[action="contact.php"]');
    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            let valid = true;
            const name = contactForm.querySelector('[name="name"]');
            const email = contactForm.querySelector('[name="email"]');
            const subject = contactForm.querySelector('[name="subject"]');
            const message = contactForm.querySelector('[name="message"]');
            [name, email, subject, message].forEach(field => {
                if (field) field.classList.remove('is-invalid');
            });
            if (!name || name.value.trim().length < 2) { if (name) name.classList.add('is-invalid'); valid = false; }
            if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) { if (email) email.classList.add('is-invalid'); valid = false; }
            if (!subject || subject.value.trim().length < 2) { if (subject) subject.classList.add('is-invalid'); valid = false; }
            if (!message || message.value.trim().length < 5) { if (message) message.classList.add('is-invalid'); valid = false; }
            if (!valid) e.preventDefault();
        });
    }
});
