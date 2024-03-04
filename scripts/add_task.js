function validateForm() {
    var title = document.getElementById('title').value;
    var dueDate = document.getElementById('due_date').value;

    if (title.trim() === '') {
        alert('Title cannot be empty');
        return false;
    }

    return true;
}