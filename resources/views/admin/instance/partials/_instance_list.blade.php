<table class="table table-bordered table-striped table-hover table-condensed">
    <thead>
    <tr>
        <th class="text-primary">{{ trans($trans_path.'general.columns.id') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.name') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.selected-indicators') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.basic-info.facility-user') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.hf_name') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.date') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.completed_stage') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.action') }}</th>
    </tr>
    </thead>
    <tbody id="instance_list_tbody">
        {{--@php $counter = 0; @endphp--}}
        {{--@foreach($data['instances'] as $instance)--}}
            {{--<tr>--}}
                {{--<td>{{ ++$counter }}</td>--}}
                {{--<td>{{ $instance->name }}</td>--}}
                {{--<td>--}}
                    {{--{!! $instance->indicators !!}--}}
                {{--</td>--}}
                {{--<td>--}}
                    {{--{!! ($instance->siteDelivery && $instance->siteDelivery->user) ? ($instance->siteDelivery->user->first_name . ' ' . $instance->siteDelivery->user->last_name) : null !!}--}}
                {{--</td>--}}
{{--                <td>{{ $instance->user ? $instance->user->first_name . ' ' . $instance->user->last_name : null }}</td>--}}
                {{--<td>{{ date('Y-m-d', strtotime($instance->created_at)) }}</td>--}}
                {{--<td align="center">{!! AppHelper::getBuildStage($instance->built_stage) !!}</td>--}}
                {{--<td align="center">--}}
                    {{--@if($instance->built_stage == 'step-1')--}}
                        {{--@if (AclHelper::isRouteAccessable('admin.instance.edit:GET'))--}}
                            {{--<a href="{{ route('admin.instance.edit', $instance->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-edit"></i></a>--}}
                        {{--@endif --}}
                    {{--@endif --}}
                    {{--@if($instance->built_stage != 'step-4')--}}
                        {{--@if (AclHelper::isRouteAccessable('admin.instance.edit:GET'))--}}
                            {{--<a href="{{ route('admin.instance.edit', $instance->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-edit"></i></a>--}}
                        {{--@endif--}}
                        {{--@if (AclHelper::isRouteAccessable('admin.instance.deliverySite:GET'))--}}
                            {{--<a href="javascript:void(0)" data-url="{{ route('admin.instance.deliverySite', $instance->id) }}" class="btn btn-xs btn-primary addSiteDelivery"><i class="fa fa-fw fa-plus"></i></a>--}}
                        {{--@endif--}}
                    {{--@else--}}
                        {{--@if (AclHelper::isRouteAccessable('admin.instance.deliverySite.view:GET'))--}}
                            {{--<a href="{{ route('admin.instance.deliverySite.view', $instance->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-fw fa-eye"></i></a>--}}
                        {{--@endif--}}
                    {{--@endif--}}
                {{--</td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
    </tbody>
</table>