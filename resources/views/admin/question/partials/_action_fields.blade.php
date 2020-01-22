@if (AclHelper::isRouteAccessable('admin.indicator.edit:GET'))
    <a href="{{route('admin.indicator.edit', $indicator->id)}}"
       title="{{trans($trans_path . 'general.action.edit')}}">
        <i class="fa fa-fw fa-edit"></i>
    </a>
@endif

@if (AclHelper::isRouteAccessable('admin.indicator.enable:GET') &&
    AclHelper::isRouteAccessable('admin.indicator.disable:GET'))
    <a class="enableDisable" href="{{route('admin.indicator.' . ($indicator->status == 1?'disable':'enable'), $indicator->id)}}">
        <i class="fa fa-fw fa-{{($indicator->status == 1 ? 'check-circle-o text-success': 'ban text-warning')}}"></i>
{{--        {{($indicator->status == 1? trans('general.button.disable'):trans('general.button.enable'))}}--}}
    </a>
@endif

@if (AclHelper::isRouteAccessable('admin.indicator.delete:GET'))
    <a class="deleteIndicator" href="javascript:void(0);"
       attr-name="{{ join(' ', [$indicator->first_name, $indicator->last_name]) }}"
       attr-indicator-code="{{ route('admin.indicator.delete', $indicator->id) }}">
        <i class="fa fa-fw fa-trash text-danger"></i>
    </a>
@endif