/*
    This file is should be placed in "general-page.php". The main functionality it serves is to provide 
    drag-drop abillity for the already available images and to replace the moved image room number in 
    the database.
*/

var draggedImage = null; // this is the photo

document.addEventListener("dragstart", function( event ) {
    if ( event.target.classList.contains("drag-drop-img" ) ) {
        draggedImage = event.target;
        event.target.style.opacity = 0.5;
    }
}, false);


document.addEventListener("dragend", function( event ) {
    if ( event.target.classList.contains("drag-drop-img" )){
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
    if ( event.target.classList.contains("drag-drop-target") ) {
        event.target.style.background = "#007BFF";
        event.target.style.color = "#FFFFFF";
    }
    
}, false);

document.addEventListener("dragleave", function( event ) {
    // highlight potential drop target when the draggable element enters it
    if ( event.target.classList.contains("drag-drop-target") ) {
        event.target.style.background = "";
        event.target.style.color = "";
    }
    
}, false);


document.addEventListener("drop", function( event ) {
    // prevent default action (open as link for some elements)
    event.preventDefault();
    // move dragged elem to the selected drop target
    if ( event.target.classList.contains("drag-drop-target") ) {
        event.target.style.background = "";
        event.target.style.color = "";
        if(event.target.dataset.roomnum != draggedImage.dataset.roomnum){
            // different room so change room num and move
            draggedImage.dataset.roomnum = event.target.dataset.roomnum;
            document.getElementById("photo"+event.target.dataset.roomnum).getElementsByTagName("div")[0].appendChild( draggedImage.parentNode );

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
        
        draggedImage = null;

        //console.log(...event.target.getElementsByClassName("tb3-images-input")[0].files);
    }
  
}, false);

// add mobile event listners
document.addEventListener("touchstart", function(event){
    if(event.target.classList.contains("drag-drop-img")){
        // assign thumbail
        draggedImage = event.targetTouches[0].target;
        event.targetTouches[0].target.style.opacity = 0.75;
        draggedImage.style.position = 'fixed';
    }
}, false);
document.addEventListener("touchend", function(event){
    if(event.target.classList.contains("drag-drop-img")){

        draggedImage.style.opacity = "";
        draggedImage.style.position = '';
        draggedImage.style.top = "";
        draggedImage.style.left = "";
        var changedTouch = event.changedTouches[0];
        var drop_element = document.elementFromPoint(changedTouch.clientX, changedTouch.clientY);
        if(drop_element.classList.contains("drag-drop-target")){
            if(drop_element.dataset.roomnum != draggedImage.dataset.roomnum){
                // different room so change room num and move
                draggedImage.dataset.roomnum = drop_element.dataset.roomnum;
                document.getElementById("photo"+drop_element.dataset.roomnum).getElementsByTagName("div")[0].appendChild( draggedImage.parentNode );
    
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
            
            draggedImage = null;
        }
    }
}, false);
document.addEventListener("touchcancel", function(event){
    if(event.target.classList.contains("drag-drop-img")){

        
        draggedImage.style.opacity = "";
        draggedImage.style.position = '';
        draggedImage.style.top = "";
        draggedImage.style.left = "";
        draggedImage = null;
    }
}, false);
document.addEventListener("touchmove", function(event){
    if(event.target.classList.contains("drag-drop-img")){

        
        event.preventDefault();
        draggedImage.style.top = ((event.targetTouches[event.targetTouches.length - 1].screenY)-0.6*draggedImage.offsetHeight)+"px";
        draggedImage.style.left = ((event.targetTouches[event.targetTouches.length - 1].screenX)-0.4*draggedImage.offsetWidth)+"px";
    }
}, {passive: false});