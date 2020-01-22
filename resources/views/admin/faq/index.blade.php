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
                        <header>
                            <span class="widget-icon"> <i class="fa fa-user-secret"></i> </span>
                            <h2>{{ trans($trans_path.'general.content.list') }} </h2>
                            <span class="pull-right">
                                @if (AclHelper::isRouteAccessable($base_route . '.create:GET'))
                                    <a class="btn btn-sm txt-color-white" href="{!! route($base_route . '.create') !!}" title="{{ trans($admin_trans_path.'general.button.create') }}">
                                        <i class="fa fa-lg fa-plus-square"></i>
                                    </a>
                                @endif
                            </span>
                        </header>
                        <!-- widget div-->
                        <div>
                            <!-- widget content -->
                            <div class="widget-body">
                                <div class="row">
                                    <div class="col-sm-12" style="padding: 5px 20px 0 20px;">

                                        {!! Form::open( ['method' => 'POST' , 'id' => 'faq_list'] ) !!}

                                            @include($view_path . '.partials.faq_list')

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
    <script src="{{ asset('smartadmin/js/plugin/jquery-nestable/jquery.nestable.min.js') }}"></script>

    <script>
        var sortOrderData = null;
        @if (AclHelper::isRouteAccessable($base_route . '.sortData:POST'))
            // activate Nestable for list 1
            $('#faqNestable').nestable({
                maxDepth : 1
            }).on('change', updateOutput);

            function updateOutput(e) {
                var list = e.length ? e : $(e.target);
                if (window.JSON) {
                    sortOrderData = list.nestable('serialize');
                    var url = '{{ route($base_route . '.sortData') }}';
                    var data = {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        sort_data: sortOrderData
                    };
                    $.post(url, data, function (response) {

                    }).fail(function (xhr) {
                        alert('Error while sorting data');
                    });
                } else {
                    console.log('Browser does not support sorting.');
                }
            }
        @else
            $('#faqNestable').nestable({
                maxDepth : 0
            });
        @endif
    </script>
    @if (AclHelper::isRouteAccessable('admin.faq.delete:GET'))
        <script>
            $('body').on('click', '.deleteFaq', function (e) {
                e.preventDefault();
                var modal = $("#faqModal");
                modal.find('.modal-title span').html($(this).data("name"));
                modal.find('.deleteFaqFinal').attr('href', $(this).data("delete-url"));
                modal.modal('show');
            });
        </script>

        <!-- Faq Delete Confirmation Modal -->
        <div class="modal fade" id="faqModal" tabindex="-1" role="dialog" aria-labelledby="faqModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <input type="hidden" name="id" class="faqId">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title text-danger">{{ trans($trans_path . 'general.delete.title') }} : <span></span></h5>
                    </div>
                    <div class="modal-body">
                        <h5>
                            {{ trans($trans_path . 'general.delete.sure') }}
                            <br />
                            <small>{{ trans($trans_path . 'general.delete.message') }}</small>
                        </h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">
                            {{ trans("general.button.cancel") }}
                        </button>
                        <a href="#" type="button" class="btn btn-danger deleteFaqFinal">
                            {{ trans("general.button.delete") }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    @endif

@endsection