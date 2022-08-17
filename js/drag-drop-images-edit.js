/*
    This file is should be placed in "edit-general-page.php". The main functionality it serves is to provide 
    drag-drop abillity for the user uploaded images as well as already existing images in the photos section
    in the mentioned page.
    
    A change was made in line 570 in file (edit-general-page.php). Added id(#images-input-${i}) and 
    class(.tb3-images-input) for each files input. Also (#images-input-${i}-cell) id was created for the container
    <td> </td> tags to allow user to move images to them when hovering on drop. 
    
    Identifiers for the images thumbnails will be added in this script to upload new images and move existing ones in
    the database.

*/

var draggedImage = null; // this is the thumbnail
var draggedFile = null; // this is the uploaded file to the server
var draggedFileIndex = null;
var PHOTOSFILESARRAY = []; // this is used in "js/validate-uploaded-images.js"

let rooms_no_input = document.getElementById("no_rooms");
var imagesInputElementsCount = document.getElementsByClassName("tb3-images-input").length;


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



// add event listener for files change

document.addEventListener("change" , function(event){
    console.log(event.target);
    if(event.target.classList.contains("tb3-images-input")){

        // update available files
        uploadAllPhotosToArray();
        // delete previous thumbnails
        // ..........old_thumbnails = event.target.parentNode.getElementsByClassName("tb3-image");
        //console.log(old_thumbnails);
        // ..........while(old_thumbnails.length > 0){
        // check URL.revokeObjectURL()
        // ..........old_thumbnails[0].parentNode.removeChild(old_thumbnails[0]);
    }
    // get uploaded files list
    var filesList = event.target.files;
    console.log(filesList);
    
    // display images in blocks
    for(let upload = 0; upload < filesList.length; upload++){
        //console.log(i);
        var img = document.createElement('img');
        // make thumbnail draggable
        img.setAttribute("draggable","true");
        img.className = "tb3-image user-photo";
        img.setAttribute("data-roomnum",event.target.parentNode.dataset.roomnum);
        img.src = URL.createObjectURL(filesList[upload]); // create object URLs from the uploaded files
        
        // append thumbnail
        document.getElementById("images-input-"+event.target.parentNode.dataset.roomnum+"-cell").appendChild(img);
    }
    });
// add mobile event listners
document.addEventListener("touchstart", function(event){
    if(event.target.classList.contains("tb3-image")){
        // assign thumbail
        draggedImage = event.targetTouches[0].target;
        event.targetTouches[0].target.style.opacity = 0.5;
        draggedImage.style.position = 'fixed';
    }
}, false);
document.addEventListener("touchend", function(event){
    if(event.target.classList.contains("tb3-image")){

        draggedImage.style.opacity = "";
        draggedImage.style.position = '';
        draggedImage.style.top = "";
        draggedImage.style.left = "";
        var changedTouch = event.changedTouches[0];
        var drop_element = document.elementFromPoint(changedTouch.clientX, changedTouch.clientY);
            if ( drop_element.classList.contains("images-input-cell") ) {
                // move dragged elem to the selected drop target
                    drop_element.style.background = "";
                    if(draggedImage.classList.contains("server-photo")){
                        if(drop_element.dataset.roomnum != draggedImage.dataset.roomnum){
                            // different room so change room num and move
                            draggedImage.dataset.roomnum = drop_element.dataset.roomnum;
                
                            // make request with appropriate data
                            var xhr = new XMLHttpRequest();
                            xhr.open('GET', 'change-image-room.php?roomnum='+drop_element.dataset.roomnum+'&imageURL='+draggedImage.getAttribute("src"), true);
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                console.log(xhr.response);
                                }
                            };
                            xhr.send(null);
                        }
                    }else{
                        if(drop_element.dataset.roomnum != draggedImage.dataset.roomnum){
                            draggedImage.dataset.roomnum = drop_element.dataset.roomnum;
                        }
                    }
                    draggedImage.parentNode.removeChild( draggedImage );
                    drop_element.appendChild( draggedImage );
                    
                    draggedImage = null;
            }  
    }
}, false);
document.addEventListener("touchcancel", function(event){
    if(event.target.classList.contains("tb3-image")){

        
        draggedImage.style.opacity = "";
        draggedImage.style.position = '';
        draggedImage.style.top = "";
        draggedImage.style.left = "";
        draggedImage = null;
    }
}, false);
document.addEventListener("touchmove", function(event){
    if(event.target.classList.contains("tb3-image")){

        
        event.preventDefault();
        draggedImage.style.top = ((event.targetTouches[event.targetTouches.length - 1].screenY)-0.6*draggedImage.offsetHeight)+"px";
        draggedImage.style.left = ((event.targetTouches[event.targetTouches.length - 1].screenX)-0.4*draggedImage.offsetWidth)+"px";
    }
}, {passive: false});
// mobile events end

document.addEventListener("dragstart", function( event ) {
    // all images server or user
    if (event.target.classList.contains("tb3-image")) {
        draggedImage = event.target;
        event.target.style.opacity = 0.5;
    }
}, false);


document.addEventListener("dragend", function( event ) {
    if ( event.target.classList.contains("tb3-image" )){
        event.target.style.opacity = "";
    }
}, false);


/* events fired on the drop targets */
document.addEventListener("dragover", function( event ) {
    // prevent default to allow drop
    event.preventDefault();
}, false);

document.addEventListener("dragenter", function( event ) {
    // highlight potential drop target when the draggable element enters it
    if ( event.target.classList.contains("images-input-cell") ) {
        event.target.style.background = "#5cb85c40";
    }
    
}, false);

document.addEventListener("dragleave", function( event ) {
    // highlight potential drop target when the draggable element enters it
    if ( event.target.classList.contains("images-input-cell") ) {
        event.target.style.background = "";
    }
    
}, false);


document.addEventListener("drop", function( event ) {
    // prevent default action (open as link for some elements)
    event.preventDefault();
    // move dragged elem to the selected drop target
    if ( event.target.classList.contains("images-input-cell") ) {
        // move dragged elem to the selected drop target
            event.target.style.background = "";
            if(draggedImage.classList.contains("server-photo")){
                if(event.target.dataset.roomnum != draggedImage.dataset.roomnum){
                    // different room so change room num and move
                    draggedImage.dataset.roomnum = event.target.dataset.roomnum;
        
                    // make request with appropriate data
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', 'change-image-room.php?roomnum='+event.target.dataset.roomnum+'&imageURL='+draggedImage.getAttribute("src"), true);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                        console.log(xhr.response);
                        }
                    };
                    xhr.send(null);
                }
            }else{
                if(event.target.dataset.roomnum != draggedImage.dataset.roomnum){
                    draggedImage.dataset.roomnum = event.target.dataset.roomnum;
                }
            }
            draggedImage.parentNode.removeChild( draggedImage );
            event.target.appendChild( draggedImage );
            
            draggedImage = null;
    }  
}, false);
