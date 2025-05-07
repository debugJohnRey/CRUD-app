document.addEventListener("DOMContentLoaded", () => {
  const dropImg = document.querySelector(".drop-img");
  const dropdownContent = document.querySelector(".dropdown-content");

  if (dropImg && dropdownContent) {
    dropImg.addEventListener("click", (e) => {
      e.stopPropagation();
      dropdownContent.classList.toggle("show");
    });

    window.addEventListener("click", () => {
      if (dropdownContent.classList.contains("show")) {
        dropdownContent.classList.remove("show");
      }
    });
  }

  const titleTextarea = document.getElementById("autoResizeTextareaTitle");
  const contentTextarea = document.getElementById("autoResizeTextareaContent");

  // Improved auto-resize function with debouncing
  const autoResize = (textarea) => {
    if (!textarea) return;
    
    // Save the current scroll position
    const scrollPos = window.pageYOffset || document.documentElement.scrollTop;
    
    // Reset height to auto before calculating the new height
    textarea.style.height = 'auto';
    
    // Set the height based on scrollHeight with a small buffer
    textarea.style.height = (textarea.scrollHeight + 2) + 'px';
    
    // Restore the scroll position
    window.scrollTo(0, scrollPos);
  };

  // Initialize heights on page load
  if (titleTextarea) {
    // Set initial height
    autoResize(titleTextarea);
    
    // Add event listeners for various events that might change content
    titleTextarea.addEventListener("input", function() {
      autoResize(this);
    });
    
    titleTextarea.addEventListener("focus", function() {
      autoResize(this);
    });
  }

  if (contentTextarea) {
    // Set initial height
    autoResize(contentTextarea);
    
    // Add event listeners for various events that might change content
    contentTextarea.addEventListener("input", function() {
      autoResize(this);
    });
    
    contentTextarea.addEventListener("focus", function() {
      autoResize(this);
    });
  }

  const addThumbnailButton = document.getElementById("addThumbnailButton");
  const fileInput = document.getElementById("fileInput");
  const thumbnail = document.getElementById("thumbnail");
  const removeThumbnailButton = document.getElementById(
    "removeThumbnailButton"
  );

  if (addThumbnailButton && fileInput && thumbnail && removeThumbnailButton) {
    addThumbnailButton.addEventListener("click", () => {
      fileInput.click();
    });

    fileInput.addEventListener("change", (event) => {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          thumbnail.src = e.target.result;
          thumbnail.style.display = "block";
          removeThumbnailButton.style.display = "flex";
          addThumbnailButton.textContent = "Change Thumbnail";
        };
        reader.readAsDataURL(file);
      }
    });

    // Add this code at the end of the DOMContentLoaded event listener
    if (removeThumbnailButton) {
      removeThumbnailButton.addEventListener("click", () => {
        thumbnail.src = "assets/thumbnail.png";
        thumbnail.style.display = "block";
        document.getElementById("useDefaultThumbnail").value = "1";
        addThumbnailButton.textContent = "Change Thumbnail";
      });
    }
    // Replace the existing removeThumbnailButton event listener with this:
    removeThumbnailButton.addEventListener("click", () => {
      thumbnail.src = "";
      thumbnail.style.display = "none";
      removeThumbnailButton.style.display = "none";
      fileInput.value = "";
      document.getElementById("useDefaultThumbnail").value = "0";
      addThumbnailButton.textContent = "Add Thumbnail";
    });
  }
});
