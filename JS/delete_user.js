function deleteUser(user_id) {
    if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = `delete_user.php?id=${user_id}`;
    }
}
