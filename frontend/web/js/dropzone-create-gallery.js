Core.onFullLoad(function(){

Dropzone.autoDiscover = false;

myDropzone = new Dropzone('#dZUpload',{
    url: '/new-ads',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 100,
    previewsContainer: '#previewzone',
    addRemoveLinks: true,
    acceptedFiles: 'image/*',
    thumbnailWidth: 100, //I want to change width to 100% instead
    thumbnailHeight: 100,
    dictRemoveFile: 'Удалить',
//    previewTemplate: $('#template-preview').html(),

    // The setting up of the dropzone
    init: function() {
      var myDropzone = this;

      // First change the button to actually tell Dropzone to process the queue.
        $('.fulldata-form').bind('click',function(e){
            if(myDropzone.files.length < 0){

                return;
            }
            console.log('click eventListener')
            e.preventDefault();
            e.stopPropagation();
            myDropzone.processQueue();
        })

//      this.element.querySelector(".s-form").addEventListener("click", function(e) {
//          console.log('click eventListener')
//        // Make sure that the form isn't actually being sent.
//        e.preventDefault();
//        e.stopPropagation();
//        myDropzone.processQueue();
//      });

      // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
      // of the sending event because uploadMultiple is set to true.
        this.on("sendingmultiple", function(data, xhr, formData) {
          // Gets triggered when the form is actually being sent.
          // Hide the success button or the complete form.
          console.log('sendingmultiple');
            var formValues = $('#my-awesome-dropzone').serializeObject()
            $.each(formValues, function(key, value){
                formData.append(key,value);
            });
        });
        this.on("successmultiple", function(files, response) {
            console.log('successmultiple')
            myDropzone.enqueueAllFiles();
          // Gets triggered when the files have successfully been sent.
          // Redirect user or notify of success.
        });
        this.on("errormultiple", function(files, response) {
            console.log('errormultiple')
          // Gets triggered when there was an error sending the files.
          // Maybe show form again, and notify user of error
        });
        this.on("complete", function() {
            console.log('complete');
            myDropzone.enqueueAllFiles();
        });
    }
});

//    $("#dZUpload").dropzone({
//        url: "/new-ads",
//        addRemoveLinks: true,
//        autoProcessQueue: false, //Dropzone should wait for the user to click a button to upload
//        uploadMultiple: true,//Dropzone should upload all files at once (including the form data) not all files individually
//        parallelUploads: 100, //that means that they shouldn't be split up in chunks as well
//        maxFiles: 100, //and this is to make sure that the user doesn't drop more files than allowed in one request.
//        success: function (file, response) {
//            var imgName = response;
//            file.previewElement.classList.add("dz-success");
//            console.log("Successfully uploaded :" + imgName);
//        },
//        error: function (file, response) {
//            file.previewElement.classList.add("dz-error");
//        }
//    });
})