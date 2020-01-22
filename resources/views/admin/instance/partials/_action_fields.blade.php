@if($instance->built_stage != 'step-4')
    @if (AclHelper::isRouteAccessable('admin.instance.edit:GET'))
        <a href="{{ route('admin.instance.edit', $instance->id) }}" class="btn btn-xs btn-primary margin-bottom-5"><i class="fa fa-fw fa-edit"></i></a>
    @endif
    @if (AclHelper::isRouteAccessable('admin.instance.deliverySite:GET'))
        <a href="javascript:void(0)" data-url="{{ route('admin.instance.deliverySite', $instance->id) }}" class="btn btn-xs btn-primary addSiteDelivery margin-bottom-5"><i class="fa fa-fw fa-plus"></i></a>
    @endif
@else
    @if (AclHelper::isRouteAccessable('admin.instance.deliverySite.view:GET'))
        <a href="{{ route('admin.instance.deliverySite.view', $instance->id) }}" class="btn btn-xs btn-primary margin-bottom-5"><i class="fa fa-fw fa-eye"></i></a>
    @endif
@endif
@if (AclHelper::isRouteAccessable('admin.instance.destroy:GET'))
    <a href="#" class="btn btn-xs btn-danger deleteInstance" data-url="{{ route('admin.instance.destroy', $instance->id) }}" data-title="{{ $instance->name }}"><i class="fa fa-fw fa-remove"></i></a>
@endif
