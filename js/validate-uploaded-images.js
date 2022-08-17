// extracts room number and image URL in pairs to upload them correctly to the server
function extractImagesData(imgs){
    var returned_arr = [];
    for(var index=0; index < imgs.length; index++){
        //console.log(imgs[index]);
        //console.log(imgs[index].parentNode);
        //console.log(imgs[index].parentNode.dataset);
        //console.log("roomNum = "+imgs[index].parentNode.dataset.roomnum);
        var roomNum = imgs[index].parentNode.dataset.roomnum;
        returned_arr.push(roomNum);
        //console.log("rn: "+roomNum+" URL: "+imgURL);
    }
    return  returned_arr;
}


/* 
    this function uploads the images to validate-photos.php and
    sets a hidden input (name="uploaded-images-data") value to be
    the file response. the response contains an array of paths and
    room numbers for each photo. The images can be stored in the 
    database and required directories afterwards.

    the function is called before submission(event)

*/

// var submitted = false;

function sendImagesToValidation(){
    // if(!submitted){
    //     //event.preventDefault();
    // }
    
    // submitted = true;
    var allImages = document.getElementsByClassName("user-photo");
    var imagesData = extractImagesData(allImages);

    // Upload photos and data using formData object
    var formData = new FormData();

    // format uploaded data
    for (var i = 0; i < imagesData.length; i++) {
        // Add the file to the request.
        formData.append("images[images_"+i+"]", PHOTOSFILESARRAY[i], PHOTOSFILESARRAY[i].name);
    }
    
    // send images data as well
    formData.append("imagesData", JSON.stringify(imagesData));


    // Create an async request to validate-photos.php
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'validate-photos.php', true);

    // Set up a handler for when the response gets back
    xhr.onload = function () {
        if (xhr.status === 200) {
        // check if upload is successfull
            // document.getElementById("uploaded-images-data").value = (xhr.responseText);
            console.log(xhr.responseText)
            // empty input files to reduce loading time (no need to upload and validate twice)
            var allInputs = document.getElementsByClassName("tb3-images-input");
            for(var index=0; index < allInputs.length; index++){
                allInputs[index].value = null;
            }
            //console.log(document.forms[0]);
            // while(document.getElementById("uploaded-images-data").value == ""){
            //     continue;
            // }
            //$("#form").submit();
            return true; // submits the form
        } else {
            alert('An error occurred!');
            return false; // does not submit the form
        }
    };

    // Send the Data.
    xhr.send(formData);
}