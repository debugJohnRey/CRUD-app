document.addEventListener('DOMContentLoaded', function() {
  const closeBtn = document.querySelector('.close-btn');
  const errorMessage = document.querySelector('.error-message');

  if (closeBtn && errorMessage) {
    closeBtn.addEventListener('click', function() {
        errorMessage.style.display = 'none';
    });
  }
  
  // Password visibility toggle
  const passwordToggle = document.getElementById('passwordToggle');
  if (passwordToggle) {
    passwordToggle.addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordToggle.classList.remove('fa-eye-slash');
        passwordToggle.classList.add('fa-eye');
      } else {
        passwordInput.type = 'password';
        passwordToggle.classList.remove('fa-eye');
        passwordToggle.classList.add('fa-eye-slash');
      }
    });
  }
});