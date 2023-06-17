// Preview Image
let imagen = document.getElementById("image");
imagen.addEventListener("change", handleFileSelect);

function handleFileSelect(event) {
  var file = event.target.files[0];
  
  if (file) {
    document.getElementById('iconfile').style.display = 'none'; 
    document.getElementById("upimage").style.borderColor="#FFC300";

    var reader = new FileReader();

    reader.onload = function (e) {
      var previewContainer = document.getElementById("imagenPrevisualizacion");
      var previewImage = document.createElement("img");
      previewImage.src = e.target.result;
      previewImage.style.maxWidth = "300px"; 
      previewImage.style.maxheight = "300px"; 
      previewContainer.innerHTML = "";
      previewContainer.appendChild(previewImage);
    };

    reader.readAsDataURL(file);
  }
}