const searchbox = document.getElementById("search");
const catfil = document.getElementById("catfil");
var context = false;
const search = () => {
  const text = searchbox.value.toLowerCase();
  const category = catfil.value;
  if (text.length >= 3) {
    document.querySelectorAll("tr:not(.table-head-row)").forEach((element) => {
      found = false;
      element.childNodes.forEach((child) => {
        // console.log(child.textContent);
        if (child.textContent.toLowerCase().includes(text)) {
          found = true;
        }
      });
      if (found) {
        element.style.display = "table-row";
      } else {
        element.style.display = "none";
      }
    });
  } else {
    filter();
  }
};

searchbox.addEventListener("input", search);

const filter = () => {
  const category = catfil.value;
  if (category == "null") {
    document.querySelectorAll("tr:not(.table-head-row)").forEach((element) => {
      element.style.display = "table-row";
    });
  } else {
    document.querySelectorAll("tr:not(.table-head-row)").forEach((element) => {
      if (element.childNodes[6].textContent == category) {
        element.style.display = "table-row";
      } else {
        element.style.display = "none";
      }
    });
  }
  search();
};

catfil.addEventListener("change", filter);
