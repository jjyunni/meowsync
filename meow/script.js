document.addEventListener("DOMContentLoaded", function () {

    //dark mode toggle
    const footer = document.querySelector("footer");
    const button = document.getElementById("dark");
    const topnav = document.querySelector(".topnav");
    const sidebar = document.querySelector(".sidebar");

    if (button) {
        button.addEventListener("click", () => {
            document.body.classList.toggle("dark");
            footer.classList.toggle("dark");
            topnav.classList.toggle("dark");
            sidebar.classList.toggle("dark");

        });
    }

    //sidebar toggle

    const menuBtn = document.querySelector(".menu-btn");

    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", () => {
            sidebar.classList.toggle("active");

            menuBtn.innerHTML = sidebar.classList.contains("active") ? "✖" : "☰";
        });
    }

    let favorites = JSON.parse(localStorage.getItem("favorites")) || {};
    const favoriteButtons = document.querySelectorAll(".favorite-btn");

    favoriteButtons.forEach(button => {
        const cardId = button.getAttribute("data-id");

        if (favorites[cardId]) {
            button.classList.add("favorited");
            button.innerHTML = "❤";
        }

        button.addEventListener("click", function () {
            if (favorites[cardId]) {
                delete favorites[cardId];
                button.classList.remove("favorited");
                button.innerHTML = "♡";
            } else {
                favorites[cardId] = true;
                button.classList.add("favorited");
                button.innerHTML = "❤︎";
            }

            localStorage.setItem("favorites", JSON.stringify(favorites));
        });
    });

    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
    const modal = document.getElementById("cardModal");

    openModal.addEventListener("click", function () {
        modal.style.display = "flex";
    });

    closeModal.addEventListener("click", function () {
        modal.style.display = "none";
    });

    // closes modal when u click outside of it 
    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });


    const cuisineButtons = document.querySelectorAll(".cuisine-btn");
    const resetButton = document.getElementById("reset-filter");
    const cards = document.querySelectorAll(".card");
    const fsections = document.querySelectorAll(".fsection");

    cuisineButtons.forEach(button => {
        button.addEventListener("click", function () {
            const selectedCuisine = this.getAttribute("data-cuisine");

            fsections.forEach(section => {
                section.style.display = "none";
            });

            fsections.forEach(section => {
                const card = section.querySelector(".card");
                if (card.getAttribute("data-cuisine") === selectedCuisine) {
                    section.style.display = "flex";
                }
            });

            if (document.body.classList.contains("dark")) {
                document.body.className = `dark ${selectedCuisine}`;
            } else {
                document.body.className = selectedCuisine;
            }
        });
    });

    resetButton.addEventListener("click", function () {
        fsections.forEach(section => {
            section.style.display = "flex";
        });

        if (document.body.classList.contains("dark")) {
            document.body.className = "dark";
        } else {
            document.body.className = "";
        }
    });
});
