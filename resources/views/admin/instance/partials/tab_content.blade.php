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

        </header>

        <!-- widget div-->
        <div>

            <!-- widget content -->
            <div class="widget-body">

                <div class="tab-content">
                    @php $tabCount = 1 @endphp
                    @if($siteFollowUp)
                        <div class="tab-pane active" id="tab{{$tabCount++}}">
                            <table class="table table-striped table-hovered table-bordered actionPlanTable">
                                <thead>
                                <tr>
                                    <th>Type</th>
                                    @foreach($data['questions'] as $type)
                                        <th>{{ $type->type_name }}</th>
                                    @endforeach
                                    <th>Completed</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($siteFollowUp as $aPlan)
                                    <tr>
                                        <td>{{ $aPlan->question ? $aPlan->question->type_name : null  }}</td>
                                        <td>
                                            {{ $aPlan->weakness }}
                                        </td>
                                        <td>
                                            {{ $aPlan->description }}
                                        </td>
                                        <td>
                                            {{ $aPlan->responsible }}
                                        </td>
                                        <td>
                                            {{ $aPlan->time_line }}
                                        </td>
                                        <td align="center">
                                            <div class="form-group">
                                                <label class="checkbox">
                                                    <input type="checkbox" class="form-control" name="plan_id[]" value="{{ $aPlan->id }}" {{$aPlan->completed === 1 ? 'checked' : null}} />
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="tab-pane {{!$siteFollowUp?'active':null}}" id="tab{{$tabCount++}}">
                        @include($view_path . '.partials.forms._basic_info_form')
                    </div>

                    <div class="tab-pane" id="tab{{$tabCount++}}">
                        @include($view_path . '.partials.forms._indicator_form')
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