/*
    This file is should be placed in "property_details.php". The main functionality it serves is to provide 
    drag-drop abillity for the user uploaded images in the photos section in the mentioned page.
    
    A change was made in line 570 in file (property_details.php). Added id(#images-input-${i}) and 
    class(.tb3-images-input) for each files input. Also (#images-input-${i}-cell) id was created for the container
    <td> </td> tags to allow user to move images to them when hovering on drop.

    It starts by hiding the default files input element (using a styles/CSS file "image-input.css"). It creates 
    photos for the uploaded images and places them in boxes. On drag event, the box position becomes absolute and
    it follows the user cursor. on drop it will transfer to another input field if user was hovering over it.

*/

var draggedImage = null; // this is the thumbnail
var draggedFile = null; // this is the uploaded file to the server
var draggedFileIndex = null;
var PHOTOSFILESARRAY = []; // this is used in "js/validate-uploaded-images.js"

let rooms_no_input = document.getElementById("no_rooms");
var imagesInputElementsCount = 0;


// uploads all inputed photos to PHOTOSFILESARRAY
function uploadAllPhotosToArray(){
    var arr = [];
    var allInputs = document.getElementsByClassName("tb3-images-input");
    var inputFiles = null;
    for(var index=0; index < allInputs.length; index++){
        inputFiles = allInputs[index].files;
        for(var index2=0; index2 < inputFiles.length; index2++){
            arr.push(inputFiles[index2]);
        }
    }
    PHOTOSFILESARRAY = arr;
}


// get the number of rooms/inputs on change
rooms_no_input.addEventListener('change', function() {
    
    imagesInputElementsCount = rooms_no_input.value;
    
    // add event listener for files change
    for (let i = 1; i <= imagesInputElementsCount; i++){
        document.getElementById("images-input-"+i).onchange = function(){
            // update available files
            uploadAllPhotosToArray();
            // delete previous thumbnails
            old_thumbnails = this.parentNode.getElementsByClassName("tb3-image");
            //console.log(old_thumbnails);
            while(old_thumbnails.length > 0){
                // check URL.revokeObjectURL()
                old_thumbnails[0].parentNode.removeChild(old_thumbnails[0]);
            }
            // get uploaded files list
            var filesList = this.files;
            //console.log(filesList);
            
            // display images in blocks
            for(let upload = 0; upload < filesList.length; upload++){
                //console.log(i);
                var img = document.createElement('img');
                // make thumbnail draggable
                img.setAttribute("draggable","true");
                img.className = "tb3-image user-photo";
                img.src = URL.createObjectURL(filesList[upload]); // create object URLs from the uploaded files
                // add dragging event listeners
                img.ondragstart = function(event){
                    // assign thumbail
                    draggedImage = this;
                    this.style.opacity = 0.75;

                    // assign dragged file
                    //draggedFile = this.parentNode.getElementsByClassName("tb3-images-input")[0].files
                };

                img.ondragend = function(event){
                    this.style.opacity = "";
                };

                // add mobile event listners
                img.addEventListener("touchstart", function(event){
                    // assign thumbail
                    draggedImage = event.targetTouches[0].target;
                    event.targetTouches[0].target.style.opacity = 0.75;
                    draggedImage.style.position = 'fixed';
                }, false);
                img.addEventListener("touchend", function(event){
                    draggedImage.style.opacity = "";
                    draggedImage.style.position = '';
                    draggedImage.style.top = "";
                    draggedImage.style.left = "";
                    var changedTouch = event.changedTouches[0];
                    var drop_element = document.elementFromPoint(changedTouch.clientX, changedTouch.clientY);
                    if(drop_element.className == "images-input-cell"){
                        draggedImage.parentNode.removeChild( draggedImage );
                        drop_element.appendChild( draggedImage );
                        draggedImage = null;
                    }
                }, false);
                img.addEventListener("touchcancel", function(event){
                    draggedImage.style.opacity = "";
                    draggedImage.style.position = '';
                    draggedImage.style.top = "";
                    draggedImage.style.left = "";
                    draggedImage = null;
                }, false);
                img.addEventListener("touchmove", function(event){
                    event.preventDefault();
                    draggedImage.style.top = ((event.targetTouches[event.targetTouches.length - 1].screenY)-0.6*draggedImage.offsetHeight)+"px";
                    draggedImage.style.left = ((event.targetTouches[event.targetTouches.length - 1].screenX)-0.4*draggedImage.offsetWidth)+"px";
                }, false);
                // append thumbnail
                document.getElementById("images-input-"+i+"-cell").appendChild(img);
            }
        };
    }
});


/* events fired on the drop targets */
document.addEventListener("dragover", function( event ) {
    // prevent default to allow drop
    event.preventDefault();
}, false);

document.addEventListener("dragenter", function( event ) {
    // highlight potential drop target when the draggable element enters it
    if ( event.target.className == "images-input-cell" ) {
        event.target.style.background = "#5cb85c40";
    }

}, false);

document.addEventListener("dragleave", function( event ) {
    // highlight potential drop target when the draggable element enters it
    if ( event.target.className == "images-input-cell" ) {
        event.target.style.background = "";
    }

}, false);


document.addEventListener("drop", function( event ) {
    // prevent default action (open as link for some elements)
    event.preventDefault();
    // move dragged elem to the selected drop target
    if ( event.target.className == "images-input-cell" ) {
        event.target.style.background = "";
        draggedImage.parentNode.removeChild( draggedImage );
        event.target.appendChild( draggedImage );
        
        draggedImage = null;

        //console.log(...event.target.getElementsByClassName("tb3-images-input")[0].files);
    }
  
}, false);