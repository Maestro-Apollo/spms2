document.addEventListener("click", function( event ) {
    // images with this class can be magnified or enlarged
    if ( event.target.classList.contains("drag-drop-img")){
        var img = event.target;
        img.parentNode.classList.add("magnified-img-container");
        img.setAttribute("draggable", false);
    }
    // closing button
    if ( event.target.classList.contains("close-image-icon")){
        event.target.parentNode.classList.remove("magnified-img-container");
        event.target.parentNode.getElementsByClassName("drag-drop-img")[0].setAttribute("draggable", true);
    }
}, false);