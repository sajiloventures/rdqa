<script src="{{ asset('js/dropzone.js') }}"></script>
<script>
    var dataID = 0;
    var parent = $('#file-upload-list');
    Dropzone.autoDiscover = false;
    var token = $('input[name="_token"]').val();
    var myDropzone = new Dropzone("#fileUpload", {
        url: "{{ route('admin.resource.upload') }}",
        // Setup chunking
        chunking: true,
        method: "POST",
        maxFilesize: 400000000,
        chunkSize: 1000000,
        // If true, the individual chunks of a file are being uploaded simultaneously.
        parallelChunkUploads: true,
        dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
        dictResponseError: 'Error uploading file!'
    });

    // Append token to the request - required for web routes
    myDropzone.on('sending', function (file, xhr, formData) {
        formData.append("_token", token);
        formData.append("dataID", dataID);
    });

    // Append token to the request - required for web routes
    myDropzone.on('addedfile', function (file) {
        $('.showFileError').hide();
        if (dataID === 0 && parent.find('li').length > 0)
            dataID = parent.find('li').length;
        addIndex();
        dataID++;
        var html = '<li data-index="' + dataID +'">\n' +
            '<span class="counterFile">' + dataID + '</span>. ' + file.name + '<span class="pull-right"><a href="javascript:void(0)" class="text-danger removeFile"><i class="fa fa-remove"></i></a> </span>\n' +
            '   <div class="progress progress-xs">\n' +
            '     <div class="progress-bar bg-color-blue" role="progressbar" style="width: 0%;"></div>\n' +
            '   </div>\n' +
            '   <input type="hidden" name="fileName[]" value="' + file.name + '" />\n' +
            '</li>';

        parent.append(html);
    });
    // Append token to the request - required for web routes
    myDropzone.on('success', function (file, xhr) {
        xhr = file.xhr;
        var data = $.parseJSON(xhr.responseText);
        if (data.dataID) {
            parent.find('li[data-index="' + data.dataID + '"] .progress .progress-bar').css('width', '100%');
            parent.find('li[data-index="' + data.dataID + '"] input[type="hidden"]').val(data.name);
        }
        this.removeAllFiles();
    });

    // Append token to the request - required for web routes
    myDropzone.on('uploadprogress', function (file, xhr, formData) {
        if (xhr !== 100) {
            var data = file.xhr;
            if (data.responseText) {
                data = $.parseJSON(data.responseText);
                if (data.dataID)
                    parent.find('li[data-index="' + data.dataID + '"] .progress .progress-bar').css('width', xhr + '%');
            }
        }
    });

    parent.on('click', '.removeFile', function () {
        $(this).closest('li').remove();
        addIndex();
    });

    function addIndex() {
        dataID = 0;
        parent.find('li').each(function () {
            dataID++;
            $(this).attr('data-index', dataID);
            $(this).find('.counterFile').html(dataID);
        });
    }

    $('form#form_edit_resource').on('submit', function () {
        $('.showFileError').hide();
        if (parent.find('li').length > 0)
            return true;
        $('.showFileError').show();
        return false;

    });
</script>