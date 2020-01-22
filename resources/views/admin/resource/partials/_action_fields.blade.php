@if (AclHelper::isRouteAccessable($base_route . '.edit:GET'))
    <a href="{{route($base_route . '.edit', $resource->id)}}"
       title="{{trans($trans_path . 'general.action.edit')}}">
        <i class="fa fa-fw fa-edit"></i>
    </a>
@endif

@if (AclHelper::isRouteAccessable($base_route . '.enable:GET') &&
    AclHelper::isRouteAccessable($base_route . '.disable:GET'))
    <a class="enableDisable" href="{{route($base_route . '.' . ($resource->status == 1?'disable':'enable'), $resource->id)}}">
        <i class="fa fa-fw fa-{{($resource->status == 1 ? 'check-circle-o text-success': 'ban text-warning')}}"></i>
    </a>
@endif

@if (AclHelper::isRouteAccessable($base_route . '.delete:GET'))
    <a class="deleteResource" href="javascript:void(0);"
       attr-name="{{ $resource->name }}"
       attr-resource-code="{{ route($base_route . '.delete', $resource->id) }}">
        <i class="fa fa-fw fa-trash text-danger"></i>
    </a>
@endif