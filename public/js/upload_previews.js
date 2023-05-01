function bytes_to_readable(bytes) {
  if (bytes < 1024) return `${bytes} Bytes`;
  if (bytes < 1048576) return `${(bytes / 1024).toFixed(1)} KB`;
  return `${(bytes / 1048576).toFixed(1)} MB`;
}

// For all divs with class  file-upload
document.querySelectorAll(".file-upload").forEach((upload_div) => {
  // Select upload input
  const upload_button = upload_div.querySelector("input[type=file]");
  // Select pre-made previews div
  const previews = upload_div.querySelector(".previews");

  const setup_previews = () => {
    // Declare an array to store the file previews
    let new_previews = [];
    console.log(upload_button.files.length);
    for (let i = 0; i < upload_button.files.length; ++i) {
      // console.log(e.target.files[i]);
      // Make divs
      new_previews[i] = document.createElement("div");
      const file_name = document.createElement("div");
      // Insert file details
      file_name.textContent =
        upload_button.files[i].name +
        " : " +
        bytes_to_readable(upload_button.files[i].size);
      const remove_button = document.createElement("button");
      remove_button.textContent = "remove";
      file_name.prepend(remove_button);
      new_previews[i].appendChild(file_name);

      // Add preview image for image types
      if (upload_button.files[i].type.startsWith("image")) {
        const preview_image = document.createElement("img");
        preview_image.setAttribute("width", "100");
        preview_image.src = URL.createObjectURL(upload_button.files[i]);
        new_previews[i].appendChild(preview_image);
      }

      // Add function to remove button
      remove_button.onclick = () => {
        const dt = new DataTransfer();
        for (let j = 0; j < upload_button.files.length; ++j)
          if (j != i) dt.items.add(upload_button.files[j]);

        // Removing the clicked file from the input list
        upload_button.files = dt.files;

        // Clearing previous previews
        while (previews.firstChild) previews.removeChild(previews.lastChild);

        // Resetting previews
        setup_previews();
      };

      previews.replaceChildren(...new_previews);
    }
  };

  upload_button.addEventListener("change", (e) => {
    // console.log(e);
    if (e.target.files.length > 10) {
      // Prevent too many files being uploaded
      e.target.files = new DataTransfer().files;
      alert("Cannot upload more than 10 files");
    }
    const dt = new DataTransfer();
    for (let i=0; i<e.target.files.length; ++i) {
      if(e.target.files[i].size > 5000000) {
        alert(e.target.files[i].name + " is too large");
      } else {
        dt.items.add(e.target.files[i]);
      }
    }
    e.target.files = dt.files
    setup_previews();
  });
});
