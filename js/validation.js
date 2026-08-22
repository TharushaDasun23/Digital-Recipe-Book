document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('searchInput');

    if (searchForm && searchInput) {
        searchForm.addEventListener('submit', function (e) {
            const value = searchInput.value.trim();
            if (value.length > 100) {
                e.preventDefault();
                searchInput.classList.add('is-invalid');
                searchInput.setCustomValidity('Search must be 100 characters or less.');
                searchInput.reportValidity();
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
