window.addEventListener("DOMContentLoaded", function () {
    // initializing file pond js
    FilePond.registerPlugin(
        FilePondPluginImagePreview,
        FilePondPluginImageResize,
        FilePondPluginImageTransform,
        // FilePondPluginImageExifOrientation,
        // FilePondPluginFileValidateSize,
        // FilePondPluginImageEdit,
        // FilePondPluginFileValidateType
    );

    // Select the file input and use
    // create() to turn it into a pond
    var pondInstance = FilePond.create(
        document.querySelector('#imagesFilepond'),
        {
            allowImageResize: true,
            imageResizeTargetWidth: 1920,
            imageResizeTargetHeight: 1920,

            name: 'filepond',
            maxFiles: 100,
            maxParallelUploads: 5,
            allowBrowse: true,
            // acceptedFileTypes: ['image/*'],
            // server
            server: {
                load: (uniqueFileId, load, error, progress, abort, headers) => {
                    console.log('attempting to load', uniqueFileId);
                    // implement logic to load file from server here
                    // https://pqina.nl/filepond/docs/patterns/api/server/#load-1

                    let controller = new AbortController();
                    let signal = controller.signal;

                    fetch(`images/${uniqueFileId}`, {
                        method: "GET",
                        signal,
                    })
                        .then(res => {
                            window.c = res
                            console.log(res)
                            return res.blob()
                        })
                        .then(blob => {
                            console.log(blob)
                            // const imageFileObj = new File([blob], `${uniqueFileId}.${blob.type.split('/')[1]}`, {
                            //   type: blob.type
                            // })
                            // console.log(imageFileObj)
                            // progress(true, size, size);
                            load(blob);
                        })
                        .catch(err => {
                            console.log(err)
                            error(err.message);
                        })

                    return {
                        abort: () => {
                            // User tapped cancel, abort our ongoing actions here
                            controller.abort();
                            // Let FilePond know the request has been cancelled
                            abort();
                        }
                    };
                },
                // remove:
            },
            //files array
            files: window.photo_manager.files,
}
)

    FilePond.setOptions({
        server: {
            // url: "/",
            process: {
                url: photo_manager.process,
                method: 'POST',
                headers: {
                    'x-customheader': 'Processing File'
                },
                onload: (response) => {
                    console.log("raw", response)
                    response = JSON.parse(response);
                    console.log(response);
                    return response.key;
                },
                onerror: (response) => {
                    console.log("raw", response)
                    response = JSON.parse(response);
                    console.log(response);
                    return response.msg
                },
                ondata: (formData) => {
                    window.h = formData;
                    console.log(formData)
                    return formData;
                }
            },
            revert: (uniqueFileId, load, error) => {
                console.log('revert');
                const formData = new FormData();
                formData.append("key", uniqueFileId);

                console.log(uniqueFileId);

                fetch(`${photo_manager.revert}&key=${uniqueFileId}`, {
                    method: "DELETE",
                    body: formData,
                })
                    .then(res => res.json())
                    .then(json => {
                        console.log(json);
                        if (json.status == "success") {
                            // Should call the load method when done, no parameters required
                            load();
                        } else {
                            // Can call the error method if something is wrong, should exit after
                            error(err.msg);
                        }
                    })
                    .catch(err => {
                        console.log(err)
                        // Can call the error method if something is wrong, should exit after
                        error(err.message);
                    })
            },
            remove: (uniqueFileId, load, error) => {
                console.log('remove');
                const formData = new FormData();
                formData.append("key", uniqueFileId);

                console.log(uniqueFileId);

                fetch(`${photo_manager.revert}&key=${uniqueFileId}`, {
                    method: "DELETE",
                    body: formData,
                })
                    .then(res => res.json())
                    .then(json => {
                        console.log(json);
                        if (json.status == "success") {
                            // Should call the load method when done, no parameters required
                            load();
                        } else {
                            // Can call the error method if something is wrong, should exit after
                            error(err.msg);
                        }
                    })
                    .catch(err => {
                        console.log(err)
                        // Can call the error method if something is wrong, should exit after
                        error(err.message);
                    })
            },
            restore: (uniqueFileId, load, error, progress, abort, headers) => {
                console.log('restore');
                let controller = new AbortController();
                let signal = controller.signal;

                fetch(`${photo_manager.revert}&key=${uniqueFileId}`, {
                    method: "GET",
                    signal,
                })
                    .then(res => {
                        window.c = res
                        console.log(res)
                        const headers = res.headers;
                        const contentLength = +headers.get("content-length");
                        const contentDisposition = headers.get("content-disposition");
                        let fileName = contentDisposition.split("filename=")[1];
                        fileName = fileName.slice(1, fileName.length - 1)
                        progress(true, contentLength, contentLength);
                        return {
                            blob: res.blob(),
                            size: contentLength,
                        }
                    })
                    .then(({ blob, size }) => {
                        console.log(blob)
                        // headersString = 'Content-Disposition: inline; filename="my-file.jpg"'
                        // headers(headersString);

                        const imageFileObj = new File([blob], `${uniqueFileId}.${blob.type.split('/')[1]}`, {
                            type: blob.type
                        })
                        console.log(imageFileObj)
                        progress(true, size, size);
                        load(imageFileObj);
                    })
                    .catch(err => {
                        console.log(err)
                        error(err.message);
                    })

                return {
                    abort: () => {
                        // User tapped cancel, abort our ongoing actions here
                        controller.abort();
                        // Let FilePond know the request has been cancelled
                        abort();
                    }
                };
            },
        },
    })

    var pond = document.querySelector('.filepond--root');

    let listener = function (){
        console.log('add');
        $('#smartwizard').css('height', 'auto');
        $('.tab-content').css('height', 'auto');
    };
    pond.addEventListener('FilePond:initfile', listener);
    pond.addEventListener('FilePond:init', listener);

    var form = $('form');
    var filesCount = 0;
    form.submit(function (e){
        console.log('Submit ', filesCount);
        if (filesCount > 0){
            e.preventDefault();
            return false;
        } else {
            var files = [];
            console.log(pondInstance.getFiles());
            for (file of pondInstance.getFiles()){
                // console.log(file);
                files.push(file.file.serverId);
            }
            $('input[name=photo-files]').val(JSON.stringify(files));
            // console.log(files);
            // e.preventDefault();
            // return false;
            return true;
        }
    });
    var changeFiles = function (add){
        filesCount += add;
        var submit = form.find('[type=submit]');
        if (filesCount > 0){
            submit.html('Uploading. '+filesCount+' left');
            submit.attr('disabled' , true);
        } else {
            submit.html('SUBMIT');
            submit.removeAttr('disabled');
        }
    }
    pond.addEventListener('FilePond:processfilestart', () => {changeFiles(1); listener()});
    pond.addEventListener('FilePond:processfile', () => {changeFiles(-1); listener()});

    setInterval(listener, 2000);

    // pond.addEventListener('FilePond:reorderfiles', function (e){
    //     console.log('Reorder', window.photo_manager.move, e.detail);
    //     $.post(window.photo_manager.move, {origin: e.detail.origin, target: e.detail.target});
    // });
})