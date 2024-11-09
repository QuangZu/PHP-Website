document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', function () {
        const questionId = this.dataset.questionId;
        const likeCountSpan = this.querySelector('.like-count');

        fetch('question.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({like: true, questionid: questionId})
        })
        .then(response => response.json())
        .then(data => {
            if (data.likes) {
                likeCountSpan.textContent = data.likes;
            }
        })
        .catch(error => console.error('Error:', error));
    });
});