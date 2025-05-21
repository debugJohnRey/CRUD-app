document.addEventListener("DOMContentLoaded", function () {
  const commentForm = document.getElementById("commentForm");

  if (commentForm) {
    // Regular form validation
    commentForm.addEventListener("submit", function (e) {
      const content = this.querySelector(
        'textarea[name="content"]'
      ).value.trim();

      if (!content) {
        e.preventDefault();
        alert("Comment cannot be empty.");
        return false;
      }
    });
  }

  // Handle comment delete actions
  document.addEventListener("click", function (e) {
    if (e.target.closest(".comment-delete")) {
      if (!confirm("Are you sure you want to delete this comment?")) {
        e.preventDefault();
      }
    }
  });
});
