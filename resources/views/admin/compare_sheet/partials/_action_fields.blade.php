@if (AclHelper::isRouteAccessable('admin.compare_sheet.edit:GET'))
    <a href="{{route('admin.compare_sheet.edit', $compare_sheet->id)}}"
       title="{{trans($trans_path . 'general.action.edit')}}">
        <i class="fa fa-fw fa-edit"></i>
    </a>
@endif

@if (AclHelper::isRouteAccessable('admin.compare_sheet.enable:GET') &&
    AclHelper::isRouteAccessable('admin.compare_sheet.disable:GET'))
    <a class="enableDisable" href="{{route('admin.compare_sheet.' . ($compare_sheet->status == 1?'disable':'enable'), $compare_sheet->id)}}">
        <i class="fa fa-fw fa-{{($compare_sheet->status == 1 ? 'check-circle-o text-success': 'ban text-warning')}}"></i>
{{--        {{($compare_sheet->status == 1? trans('general.button.disable'):trans('general.button.enable'))}}--}}
    </a>
@endif

@if (AclHelper::isRouteAccessable('admin.compare_sheet.delete:GET'))
    <a class="deleteCompareSheet" href="javascript:void(0);"
       attr-name="{{ join(' ', [$compare_sheet->first_name, $compare_sheet->last_name]) }}"
       attr-compare_sheet-code="{{ route('admin.compare_sheet.delete', $compare_sheet->id) }}">
        <i class="fa fa-fw fa-trash text-danger"></i>
    </a>
@endif