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

  const autoResize = (textarea) => {
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
  };

  if (titleTextarea) {
    titleTextarea.addEventListener("input", function () {
      autoResize(this);
    });
  }

  if (contentTextarea) {
    contentTextarea.addEventListener("input", function () {
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

    removeThumbnailButton.addEventListener("click", () => {
      thumbnail.src = "";
      thumbnail.style.display = "none";
      removeThumbnailButton.style.display = "none";
      fileInput.value = "";
      addThumbnailButton.textContent = "Add Thumbnail";
    });
  }
});
