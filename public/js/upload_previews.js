function bytes_to_readable(bytes) {
    if(bytes<1024)
      return `${bytes} Bytes`
    if(bytes < 1048576)
      return `${(bytes/1024).toFixed(1)} KB`
    return `${(bytes/(1048576)).toFixed(1)} MB`
  }

// For all divs with class  file-upload
document.querySelectorAll(".file-upload").forEach((upload_div) => {
  // Select upload input
  const upload_button = upload_div.querySelector("input[type=file]");
  // Select pre-made previews div
  const previews = upload_div.querySelector(".previews");

  upload_button.addEventListener("change", (e) => {
    // console.log(e);
    if (e.target.files.length > 10) {
      // Prevent too many files being uploaded
      e.target.files = new DataTransfer().files;
      alert("Cannot upload more than 10 files");
      return;
    }
    // console.log(e.target.files);
    // Declare an array to store the file previews
    let new_previews = [];
    for (let i = 0; i < e.target.files.length; ++i) {
      // console.log(e.target.files[i]);
      // Make divs
      new_previews[i] = document.createElement("div");
      const file_name = document.createElement("div");
      // Insert file details
      file_name.textContent = e.target.files[i].name + " : " + bytes_to_readable(e.target.files[i].size);
      const remove_button = document.createElement("button");
      remove_button.textContent ="X"
      file_name.prepend(remove_button);
      new_previews[i].appendChild(file_name);

      // Add preview image for image types
      if (e.target.files[i].type.startsWith("image")) {
        const preview_image = document.createElement("img");
        preview_image.setAttribute("width", "100");
        preview_image.src = URL.createObjectURL(e.target.files[i]);
        new_previews[i].appendChild(preview_image);
      }

    }
    previews.replaceChildren(...new_previews);
  });
});
