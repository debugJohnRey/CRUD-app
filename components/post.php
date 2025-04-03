<?php 
function renderCreatePost() {
  return '
    <div class="textarea-container">
        <form id="createPostForm" method="POST" enctype="multipart/form-data" action="create-post.php">
            <div id="thumbnail-container">
                <img id="thumbnail" src="" alt="Thumbnail" style="display: none;">
                <button type="button" id="removeThumbnailButton" style="display: none;">X</button>
            </div>
            <button type="button" id="addThumbnailButton">Add Thumbnail</button>
            <textarea id="autoResizeTextareaTitle" class="title-textarea" name="title" placeholder="Title"></textarea>
            <textarea id="autoResizeTextareaContent" class="content-textarea" name="content" placeholder="Tell your story..."></textarea>
            <input type="file" id="fileInput" name="thumbnail" accept="image/*" style="display: none;">
        </form>
    </div>  

<style>
.textarea-container {
  width: 60%;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border: none;
}

#thumbnail-container {
  position: relative;
  margin-bottom: 10px;
}

#thumbnail {
  max-width: 100%;
  height: auto;
}

#removeThumbnailButton {
  position: absolute;
  top: 5px;
  right: 5px;
  background-color: black;
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 50%;
  padding: 10px 12px;
}

#removeThumbnailButton:hover {
  background-color: darkred;
}

#addThumbnailButton {
  margin-bottom: 10px;
  padding: 10px;
  background-color: rgb(76, 147, 175);
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 3px;
  font-family: "Inter", sans-serif;
  font-style: normal;
  transition: background-color 0.3s;
}

#addThumbnailButton:hover {
  background-color: rgb(64, 121, 143);
}

/* Textarea base styles */
textarea {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: none;
  box-sizing: border-box;
  resize: none;        /* Prevents manual resizing */
  overflow: hidden;    /* Hides scrollbars for auto-resize support */
  margin-bottom: 10px;
  border-radius: 5px;
}

/* Remove outline when textarea is active (focused) */
textarea:focus {
  outline: none;
}

/* Specific textarea heights */
#autoResizeTextareaTitle {
  min-height: 50px;
}

#autoResizeTextareaContent {
  min-height: 100px;
}

.title-textarea {
  min-height: 50px;
  font-family: "Libre Baskerville", serif;
  font-weight: 400;
  font-style: normal;
  font-size: 50px;
}

.content-textarea {
  min-height: 100px;
  font-family: "Libre Baskerville", serif;
  font-weight: 500;
  font-style: normal;
  font-size: 30px;
}
</style>
';
}
?>