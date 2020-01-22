{{--{!! Html::script('smartadmin/js/bootstrap-tags/bootstrap-tagsinput.min.js') !!}--}}
{!! Html::script('js/tinymce/jquery.tinymce.min.js') !!}
{!! Html::script('js/tinymce/tinymce.min.js') !!}
<script>
    //textEditor
    var editor_config = {
        path_absolute: "/",
        selector: ".answerEditor",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern code"

        ],
        extended_valid_elements : "script[language|type|src]",
        //allow_script_urls: true,
        convert_urls: false,


        toolbar: "insertfile undo redo | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | code",
        relative_urls: false,
        file_browser_callback: function (field_name, url, type, win) {
            var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
            var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

            var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
            if (type == 'image') {
                cmsURL = cmsURL + "&type=Images";
            } else {
                cmsURL = cmsURL + "&type=Files";
            }

            tinyMCE.activeEditor.windowManager.open({
                file: cmsURL,
                title: 'Filemanager',
                width: x * 0.8,
                height: y * 0.8,
                resizable: "yes",
                close_previous: "no"
            });
        },
        setup: function (editor) {
            editor.on('change', function (e) {
                $('.answerEditor-error').hide();
                // Your text from the tinyMce box will now be passed to your  text area ...
                $(".answerEditor").text(editor.getContent());
            });
        }
    };

    tinymce.init(editor_config);

    $('button[type="submit"]').on('click', function () {
        $('.answerEditor-error').hide();
        $('.question-error').hide();
        $('.has-error').removeClass('has-error');
        var error = true;

        if ($('input[name="question"]').val())
            error = false;
        else {
            $('.question-error').show();
            $('.question-error').closest('.form-group').addClass('has-error');
        }

        if ($('.answerEditor').val()) {
            error = error === true;
        } else {
            $('.answerEditor-error').show();
            $('.answerEditor-error').closest('.form-group').addClass('has-error');
            error = true;
        }

        return error === false;
    });

</script>