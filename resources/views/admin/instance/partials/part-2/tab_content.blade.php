<!-- NEW WIDGET START -->
<article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 50px;">

    <!-- Widget ID (each widget will need unique ID)-->
    <div class="jarviswidget" id="wid-id-0" data-widget-colorbutton="false"
         data-widget-editbutton="false"
         data-widget-togglebutton="false"
         data-widget-deletebutton="false"
         data-widget-collapsed="false"
         data-widget-fullscreenbutton="false"
    >
        <header>
            <h2>{{ strtoupper($data['questions']['part-2']['key']) }}: {{ $data['questions']['part-2']['name'] }}</h2>
        </header>

        <!-- widget div-->
        <div>

            <!-- widget content -->
            <div class="widget-body">

                <div class="tab-content">

                    @php $count=0; @endphp
                    @foreach($data['questions']['part-2']['type'] as $key => $questionType)
                        @if(count($questionType['question']->questionList) > 0)
                            <div class="tab-pane {{ ++$count == 1 ? 'active': '' }}" id="tab{{$count}}">
                                @include($view_path . '.partials.part-2._question_list')
                            </div>
                        @endif
                    @endforeach

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="pager wizard no-margin">
                                    <!--<li class="previous first disabled">
                                    <a href="javascript:void(0);" class="btn btn-lg btn-default"> First </a>
                                    </li>-->
                                    <li class="previous disabled">
                                        <a href="javascript:void(0);" class="btn btn-default" style="border-radius: 0;"> Previous </a>
                                    </li>
                                    <li class="next">
                                        <a href="javascript:void(0);" class="btn txt-color-darken"  style="border-radius: 0;"> Next </a>
                                    </li>
                                    <li class="pull-right save" style="display: none;">
                                        <button type="submit" class="btn btn-primary"> Save </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
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