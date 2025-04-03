document.addEventListener('DOMContentLoaded', function() {
  const closeBtn = document.querySelector('.close-btn');
  const errorMessage = document.querySelector('.error-message');

  closeBtn.addEventListener('click', function() {
      errorMessage.style.display = 'none';
  });
});