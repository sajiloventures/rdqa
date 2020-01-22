@if (AclHelper::isRouteAccessable('admin.facility.edit:GET'))
    <a href="{{route('admin.facility.edit', $facility->id)}}"
       title="{{trans($trans_path . 'general.action.edit')}}">
        <i class="fa fa-fw fa-edit"></i>
    </a>
@endif

@if (AclHelper::isRouteAccessable('admin.facility.enable:GET') &&
    AclHelper::isRouteAccessable('admin.facility.disable:GET'))
    <a class="enableDisable" href="{{route('admin.facility.' . ($facility->status == 1?'disable':'enable'), $facility->id)}}">
        <i class="fa fa-fw fa-{{($facility->status == 1 ? 'check-circle-o text-success': 'ban text-warning')}}"></i>
{{--        {{($facility->status == 1? trans('general.button.disable'):trans('general.button.enable'))}}--}}
    </a>
@endif

@if (AclHelper::isRouteAccessable('admin.facility.delete:GET'))
    @if(in_array($facility->id, $selectedFacilityIds))
        <a class="disabled" href="javascript:void(0);">
            <i class="fa fa-fw fa-trash text-muted"></i>
        </a>
    @else
        <a class="deleteFacility" href="javascript:void(0);"
           attr-name="{{ join(' ', [$facility->first_name, $facility->last_name]) }}"
           attr-facility-code="{{ route('admin.facility.delete', $facility->id) }}">
            <i class="fa fa-fw fa-trash text-danger"></i>
        </a>
    @endif
@endif