<div class="jarviswidget jarviswidget-color-darken" id="wid-id-1"
     data-widget-colorbutton="false"
     data-widget-editbutton="false"
     data-widget-deletebutton="false"
     data-widget-fullscreenbutton="false"
     data-widget-custombutton="false"
     data-widget-collapsed="false"
     data-widget-sortable="false">
    <header>

        <h2>Evaluation team</h2>
    </header>

    <!-- widget div-->
    <div>
        <!-- widget content -->
        <div class="widget-body" style="overflow: scroll; padding: 0;">

            <table class="table table-condensed table-striped" style="margin-top: 15px;">
                <thead>
                <tr>
                    <th>{{ trans($trans_path.'general.columns.sn') }}</th>
                    <th>{{ trans($trans_path.'general.basic-info.team-name') }}</th>
                    <th>{{ trans($trans_path.'general.basic-info.team-title') }}</th>
                    <th>{{ trans($trans_path.'general.basic-info.organization') }}</th>
                    <th>{{ trans($trans_path.'general.basic-info.team-email') }}</th>
                    <th>{{ trans($trans_path.'general.basic-info.team-telephone') }}</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($data['instance']) && $data['instance'] && $data['instance']->evaluation_team)
                    @php
                        $evaluationTeam = unserialize($data['instance']->evaluation_team);
                        $evaluationCounter = 0;
                    @endphp
                    @foreach($evaluationTeam as $evaluation)
                        <tr>
                            <td>{{++$evaluationCounter}}</td>
                            <td>{{ isset($evaluation['name']) ? $evaluation['name'] : null }}</td>
                            <td>{{ isset($evaluation['title']) ? $evaluation['title'] : null }}</td>
                            <td>{{ isset($evaluation['organization']) ? $evaluation['organization'] : null }}</td>
                            <td>{{ isset($evaluation['email']) ? $evaluation['email'] : null }}</td>
                            <td>{{ isset($evaluation['telephone']) ? $evaluation['telephone'] : null }}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>

        </div>
        <!-- end widget content -->

    </div>
    <!-- end widget div -->

</div>