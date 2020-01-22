@if(auth()->user()->id != $users->id)

    @if (AclHelper::isRouteAccessable('admin.users.impersonate:GET'))
        <a href="{!! route('admin.users.impersonate', $users->id) !!}"
           title="{{ trans($admin_trans_path.'general.button.impersonate') }}">
            <i class="fa fa-fw fa-lg fa-user-secret">
            </i>
        </a>
    @endif
    @if (AclHelper::isRouteAccessable('admin.admin_users.edit:GET'))
        <a href="{{route('admin.admin_users.edit', $users->id)}}"
           title="{{trans($trans_path . 'general.action.edit')}}">
            <i class="fa fa-fw fa-edit"></i>
        </a>
    @endif
    @if (AclHelper::isRouteAccessable('admin.admin_users.enable:GET') &&
    AclHelper::isRouteAccessable('admin.admin_users.disable:GET'))
        <a class="enableDisable" href="{{route('admin.admin_users.' . ($users->enabled == 1?'disable':'enable'), $users->id)}}">
            <i class="fa fa-fw fa-{{($users->enabled == 1 ? 'check-circle-o text-success': 'ban text-warning')}}"></i>
    {{--        {{($users->enabled == 1? trans('general.button.disable'):trans('general.button.enable'))}}--}}
        </a>
    @endif

    @if (AclHelper::isRouteAccessable('admin.admin_users.delete:GET'))

        @if(in_array($users->id, $usedFacilityUsers))
            <a class="disabled" href="javascript:void(0);">
                <i class="fa fa-fw fa-trash text-muted"></i>
            </a>
        @else
            <a class="deleteUser" href="javascript:void(0);"
               attr-name="{{ join(' ', [$users->first_name, $users->last_name]) }}"
               attr-user-code="{{ route('admin.admin_users.delete', $users->id) }}">
                <i class="fa fa-fw fa-trash text-danger"></i>
            </a>
        @endif
    @endif
@endif