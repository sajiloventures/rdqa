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
            <h2>{{ strtoupper($data['questions']['part-1']['key']) }}: {{ $data['questions']['part-1']['name'] }}</h2>
        </header>

        <!-- widget div-->
        <div>

            <!-- widget content -->
            <div class="widget-body">

                <div class="tab-content">
                    <div class="tab-pane active" id="tab1">
                        @include($view_path . '.partials.part-1._recounting_report_result')
                    </div>

                    <div class="tab-pane" id="tab2">
                        @include($view_path . '.partials.part-1._report_performance')
                    </div>
                    <div class="tab-pane" id="tab3">
                        @include($view_path . '.partials.part-1._cross_check')
                    </div>
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