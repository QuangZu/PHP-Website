function toggleModal(modalID) {
    document.getElementById(modalID).classList.toggle('hidden');
}

document.getElementById("profileOptionsButton").addEventListener("click", function () {
    const menu = document.getElementById("profileOptionsMenu");
    menu.classList.toggle("hidden");
});

document.addEventListener("click", (event) => {
    const profileOptionsMenu = document.getElementById("profileOptionsMenu");
    if (!profileOptionsMenu.classList.contains("hidden") && !event.target.closest("#profileOptionsButton")) {
        profileOptionsMenu.classList.add("hidden");
    }
});
