// Add event listener for password toggle
document.addEventListener('DOMContentLoaded', function() {
  const editProfileBtn = document.getElementById('editProfileBtn');
  const deleteAccountBtn = document.getElementById('deleteAccountBtn');
  const inputFields = document.querySelectorAll('.profile-info-details');
  const profilePictureOverlay = document.getElementById('profilePictureOverlay');
  const profilePictureInput = document.getElementById('profilePictureInput');
  const profileImage = document.getElementById('profileImage');
  let isEditing = false;
  let selectedFile = null;
  
  // Add event listener for delete account button
  deleteAccountBtn.addEventListener('click', function() {
    openDeleteConfirmModal();
  });
  
  editProfileBtn.addEventListener('click', function() {
    isEditing = !isEditing;
    
    if (isEditing) {
      // Enable editing
      inputFields.forEach(input => {
        input.removeAttribute('readonly');
      });
      editProfileBtn.textContent = 'Save Profile';
      
      // Show profile picture overlay when in edit mode
      profilePictureOverlay.classList.add('active');
    } else {
      // Get updated values
      const username = inputFields[0].value;
      const email = inputFields[1].value;
      
      // Create FormData object for file upload
      const formData = new FormData();
      formData.append('action', 'update_profile');
      formData.append('username', username);
      formData.append('email', email);
      
      // Add profile picture if one was selected
      if (selectedFile) {
        formData.append('profile_picture', selectedFile);
      }
      
      // Show loading state or disable button while saving
      editProfileBtn.textContent = 'Saving...';
      editProfileBtn.disabled = true;
      
      fetch('conn/update-profile.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Profile updated successfully!');
          // Refresh the page to show updated data
          location.reload();
        } else {
          // If there's an error, keep fields editable
          alert('Error: ' + data.message);
          editProfileBtn.textContent = 'Save Profile';
          editProfileBtn.disabled = false;
          isEditing = true; // Keep in edit mode
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating your profile.');
        // If there's an error, keep fields editable
        editProfileBtn.textContent = 'Save Profile';
        editProfileBtn.disabled = false;
        isEditing = true; // Keep in edit mode
      });
      
      // Only disable editing if the save is successful
      
      // Hide profile picture overlay
      profilePictureOverlay.classList.remove('active');
    }
  });
  
  // Handle profile picture selection
  profilePictureInput.addEventListener('change', function(event) {
    if (event.target.files && event.target.files[0]) {
      selectedFile = event.target.files[0];
      
      // Display the selected image preview
      const reader = new FileReader();
      reader.onload = function(e) {
        profileImage.src = e.target.result;
      };
      reader.readAsDataURL(selectedFile);
    }
  });
});

function openModal() {
  document.getElementById("myModal").style.display = "block";
}

function closeModal() {
  const passwordInput = document.querySelector('.change-password-input');
  if (passwordInput) {
    passwordInput.value = '';
  }
  document.getElementById("myModal").style.display = "none";
}

function openDeleteConfirmModal() {
  document.getElementById("deleteConfirmModal").style.display = "block";
}

function closeDeleteConfirmModal() {
  document.getElementById("deleteConfirmModal").style.display = "none";
}

function confirmDeleteAccount() {
  // Send delete request to server
  const formData = new FormData();
  formData.append('action', 'delete_account');
  
  fetch('conn/update-profile.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Your account has been deleted successfully.');
      // Redirect to login page
      window.location.href = 'index.php';
    } else {
      alert('Error: ' + data.message);
      closeDeleteConfirmModal();
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while deleting your account.');
    closeDeleteConfirmModal();
  });
}

// Add function to save password
function savePassword() {
  const passwordInput = document.querySelector('.change-password-input');
  const newPassword = passwordInput.value.trim();
  
  if (!newPassword) {
    alert('Please enter a new password');
    return;
  }
  
  // Send password to server
  const formData = new FormData();
  formData.append('action', 'update_password');
  formData.append('password', newPassword);
  
  fetch('conn/update-profile.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Password updated successfully!');
      closeModal();
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred while updating your password.');
  });
}

// Password visibility toggle
const passwordToggle = document.getElementById('passwordToggle');
if (passwordToggle) {
  passwordToggle.addEventListener('click', function() {
    const passwordInput = document.querySelector('.change-password-input');
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