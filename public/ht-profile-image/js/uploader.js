$(function () {
    var options = {
        dataType: 'json',
        beforeSend: function () {
            $("#progress").show();
            $("#progress .bar").width('0%');
            $("#profile-image-message").html("");
            $(".percent").html("0%");
        },
        uploadProgress: function (event, position, total, percentComplete) {
            $("#progress .bar").width(percentComplete + '%');
            $(".percent").html(percentComplete + '%');


        },
        complete: function (response) {
            if (responseText == 1) {
                
            } else {

                $("#message").html("<font color='red'>" + response.responseText + "</font>");
            }


        },
        error: function () {
            $("#message").html("<font color='red'> ERROR: unable to upload files</font>");

        }

    };

    $(".image_upload_form").ajaxForm(options);
});