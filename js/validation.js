// Validation Search and Contact Forms

document.addEventListener("DOMContentLoaded", function () {

    //Search Bar Input
    const searchInput = document.getElementById("searchInput");
    const searchForm = document.getElementById("searchForm");

    if (searchInput && searchForm) {
        
        
        const isValidSearchQuery = function (value) {
            const trimmed = value.trim();
        
            const validPattern = /[a-zA-Z0-9]/;
            return trimmed !== "" && validPattern.test(trimmed);
        };

    
        searchForm.addEventListener("submit", function (e) {
            const query = searchInput.value;

            if (!isValidSearchQuery(query)) {
                e.preventDefault();
                e.stopImmediatePropagation();

                
                searchInput.classList.add("is-invalid");
                searchInput.value = "";
                searchInput.placeholder = "Please enter valid search terms!";
            } else {
                searchInput.classList.remove("is-invalid");
            }
        }, true);

    
        searchInput.addEventListener("input", function () {
            if (isValidSearchQuery(searchInput.value)) {
                searchInput.classList.remove("is-invalid");
            }
        });
    }


    //Contact Form Handling
    const contactForm = document.querySelector("div.col-md-6 form");

    if (contactForm) {
        contactForm.setAttribute("novalidate", "true");

        contactForm.addEventListener("submit", function (e) {
            let isValid = true;

            const nameInput = contactForm.querySelector('input[type="text"]');
            const emailInput = contactForm.querySelector('input[type="email"]');
            const messageInput = contactForm.querySelector('textarea');

            // Name check
            if (nameInput) {
                if (nameInput.value.trim() === "") {
                    showError(nameInput);
                    isValid = false;
                } else {
                    showSuccess(nameInput);
                }
            }

            // Email check
            if (emailInput) {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(emailInput.value.trim())) {
                    showError(emailInput);
                    isValid = false;
                } else {
                    showSuccess(emailInput);
                }
            }

            // Message check
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