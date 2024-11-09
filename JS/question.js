document.addEventListener('DOMContentLoaded', function () {
    const commentTextarea = document.getElementById('commentTextarea');
    const postButton = document.getElementById('postButton');

    // Expand textarea as the user types
    commentTextarea.addEventListener('input', function () {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    // Show the post button when textarea is focused
    commentTextarea.addEventListener('focus', function () {
        postButton.classList.remove('hidden');
    });

    // Hide the post button if textarea is empty
    commentTextarea.addEventListener('blur', function () {
        if (commentTextarea.value.trim() === '') {
            postButton.classList.add('hidden');
        }
    });
});