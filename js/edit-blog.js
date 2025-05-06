document.getElementById('createPostForm').addEventListener('submit', function(e) {
  const title = document.getElementById('autoResizeTextareaTitle').value.trim();
  const content = document.getElementById('autoResizeTextareaContent').value.trim();
  
  if (!title || !content) {
    e.preventDefault();
    alert('Title and content cannot be empty.');
    return false;
  }
});

// Handle thumbnail removal
document.getElementById('removeThumbnailButton').addEventListener('click', function() {
  document.getElementById('thumbnail').src = '';
  document.getElementById('thumbnail').style.display = 'none';
  this.style.display = 'none';
  document.getElementById('addThumbnailButton').textContent = 'Add Thumbnail';
  
  // Add a hidden input to indicate thumbnail removal
  const hiddenInput = document.createElement('input');
  hiddenInput.type = 'hidden';
  hiddenInput.name = 'remove_thumbnail';
  hiddenInput.value = '1';
  document.getElementById('createPostForm').appendChild(hiddenInput);
});