const USER_KEY = "user_session";

// Laravel-compatible functions
function saveUser(user) {
    localStorage.setItem(USER_KEY, JSON.stringify(user));
}

function getUser() {
    return JSON.parse(localStorage.getItem(USER_KEY));
}

function isAuthenticated() {
    return !!getUser();
}

function getInitials(name) {
    return name
        .split(" ")
        .map((word) => word[0])
        .join("")
        .toUpperCase()
        .slice(0, 2);
}

function logout() {
    // For Laravel logout, we'll use form submission
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "/logout";

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");
    const csrfInput = document.createElement("input");
    csrfInput.type = "hidden";
    csrfInput.name = "_token";
    csrfInput.value = csrfToken;

    form.appendChild(csrfInput);
    document.body.appendChild(form);
    form.submit();
}

// Check if user is authenticated on protected pages
document.addEventListener("DOMContentLoaded", function () {
    // This will be handled by Laravel middleware instead
    // keeping the function for compatibility with existing frontend code
});

// User dropdown functionality (compatible with Laravel views)
if (document.getElementById("userMenuBtn")) {
    document.getElementById("userMenuBtn").onclick = function (e) {
        e.stopPropagation();
        const dropdown = document.getElementById("userDropdown");
        dropdown.classList.toggle("hidden");

        if (!dropdown.classList.contains("hidden")) {
            dropdown.style.opacity = "0";
            dropdown.style.transform = "translateY(-10px)";
            setTimeout(() => {
                dropdown.style.transition = "all 0.2s ease-out";
                dropdown.style.opacity = "1";
                dropdown.style.transform = "translateY(0)";
            }, 10);
        }
    };
}
