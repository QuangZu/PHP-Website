// Toggle dropdown menu visibility for each post
document.querySelectorAll('[id^="optionsButton-"]').forEach(button => {
    button.addEventListener('click', function () {
        const menu = document.getElementById(`optionsMenu-${button.id.split('-')[1]}`);
        menu.classList.toggle('hidden');
    });
});

// Close dropdowns when clicking outside
document.addEventListener('click', (event) => {
    document.querySelectorAll('[id^="optionsMenu-"]').forEach(menu => {
        const buttonId = `optionsButton-${menu.id.split('-')[1]}`;
        if (!menu.classList.contains('hidden') && !event.target.closest(`#${buttonId}`)) {
            menu.classList.add('hidden');
        }
    });
});

// Edit and delete functions for posts
function editPost(questionId) {
    window.location.href = `edit_post.php?id=${questionId}`;
}

function deletePost(questionId) {
    if (confirm('Are you sure you want to delete this post?')) {
        window.location.href = `delete_post.php?id=${questionId}`;
    }
}
