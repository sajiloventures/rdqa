<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1"
     data-widget-colorbutton="false"
     data-widget-editbutton="false"
     data-widget-deletebutton="false"
     data-widget-fullscreenbutton="false"
     data-widget-custombutton="false"
     data-widget-collapsed="false"
     data-widget-sortable="false">
    <header>

        <h2>Action Plan</h2>
    </header>

    <!-- widget div-->
    <div>
        <!-- widget content -->
        <div class="widget-body" style="overflow: scroll; padding: 0;">

            <table class="table table-condensed table-bordered text-center">
                <thead>
                    <tr>
                        <th class="text-center">Site</th>
                        <th class="text-center">SN</th>
                        <th class="text-center">Type</th>
                        @foreach($data['action-plan-question'] as $ques)
                            <th>{{$ques->type_name}}</th>
                        @endforeach
                        <th>Completed</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data['instances'] as $instance)
                        @php $instanceCount = 0; @endphp
                        @php $showTD = true; @endphp
                        @foreach($instance->siteFollowUp as $followUp)
                            <tr>
                                @if($showTD)
                                    <td rowspan="{{count($instance->siteFollowUp)}}">{{ $instance['name'] }}</td>
                                    @php $showTD=false; @endphp
                                @endif
                                <td>{{ ++$instanceCount }}</td>
                                <td>{{ $followUp->question ? $followUp->question->type_name : null  }}</td>
                                <td>{{$followUp->weakness}}</td>
                                <td>{{$followUp->description}}</td>
                                <td>{{$followUp->responsible}}</td>
                                <td>{{$followUp->time_line}}</td>
                                <td><i class="fa fa-{{$followUp->completed == 1 ? 'check text-success' : 'remove text-danger'}}"></i></td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>

            </table>

        </div>
        <!-- end widget content -->

    </div>
    <!-- end widget div -->

</div>