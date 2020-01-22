@extends('layouts.admin')
@section('page_title', trans($trans_path.'general.page.index.title'))
@section('page_description', trans($trans_path.'general.page.index.description'))
@section('page_specific_styles')
    <style>
        [role="content"] {
            min-height: 450px;
        }
    </style>
@endsection
@section('content')
    <!-- MAIN CONTENT -->
    <div id="content">
    @include('admin.partials._status')
    <!-- widget grid -->
        <section class="" id="widget-grid">
            <!-- row -->
            <div class="row">
                <!-- NEW WIDGET START -->
                <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget jarviswidget-color-blueDark"
                         data-widget-editbutton="false"
                         data-widget-colorbutton="false"
                         data-widget-fullscreenbutton="false"
                         data-widget-togglebutton="false"
                         data-widget-deletebutton="false"
                         id="wid-id-0">
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 5px 20px 0 20px;">

                                        {!! Form::open( ['route' => 'admin.userManual.store', 'method' => 'POST' , 'id' => 'faq_list'] ) !!}

                                            <div class="form-group">
                                                <label class="label">User manual</label>
                                                <textarea class="form-control answerEditor" rows="15" name="user_manual" placeholder="User manual">
                                                    {{ $data }}
                                                </textarea>
                                            </div>

                                        @if (AclHelper::isRouteAccessable('admin.userManual.store:POST'))
                                            <div class="smart-form">
                                                <footer>
                                                    {!! Form::button( trans($admin_trans_path.'general.button.update'), ['class' => 'btn btn-primary', 'type' => 'submit'] ) !!}
                                                </footer>
                                            </div>
                                            @endif
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                            <!-- end widget content -->
                        </div>
                        <!-- end widget div -->

                    </div>
                    <!-- end widget -->


                </article>
                <!-- WIDGET END -->

            </div>

            <!-- end row -->

            <!-- end row -->

        </section>
        <!-- end widget grid -->


    </div>
    <!-- END MAIN CONTENT -->
@endsection

@section('page_specific_scripts')
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

    </script>
@endsection