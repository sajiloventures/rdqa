<table id="pageDatatable" class="table table-bordered table-striped table-hover">
    <thead>
    <tr>
        <th class="col-actions center">
            <div class="form-check m-b-0">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" name="checkAll" />
                </label>
            </div>
        </th>
        <th>{{ trans($trans_path . 'general.columns.name') }}</th>
        <th>{{ trans($trans_path . 'general.columns.slug') }}</th>
        <th>{{ trans($trans_path . 'general.columns.description') }}</th>
        <th>{{ trans($trans_path . 'general.columns.status') }}</th>
    </tr>
    </thead>
    @if($menus->count() > 0)
        <tbody>
        @foreach($menus as $menu)
            <tr>
                <td>
                    <div class="form-inline">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <label class="form-check-label">
                                        <input name="checkbox[]" type="checkbox" class="form-check-input" value="{{$menu->id}}">
                                    </label>
                                </div>
                                <div class="input-group-btn">
                                    <div class="dropdown">
                                        <a href="#" class="btn btn-default" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="material-icons" style="top: 0">keyboard_arrow_down</i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-left">
                                            <a class="dropdown-item" href="{!! route($base_route.'.edit', $menu->id) !!}"
                                               title="{{trans($trans_path . 'general.action.edit')}}">
                                                <i class="material-icons">edit</i> {{trans('general.button.edit')}}
                                            </a>

                                            <a class="dropdown-item enableDisable" href="{{route('admin.menu.' . ($menu->status == 1?'disable':'enable'), $menu->id)}}"
                                               title="{{trans($trans_path.'general.action.enable_disable')}}">
                                                <i class="material-icons">{{($menu->status == 1 ? 'block': 'check_circle')}}</i>
                                                {{($menu->status == 1? trans('general.button.disable'):trans('general.button.enable'))}}
                                            </a>

                                            <a class="dropdown-item" onclick="confirmDelete('{!! route('admin.menu.confirm-delete', $menu->id) !!}')" title="{{trans('general.button.delete')}}">
                                                <i class="material-icons text-danger">delete</i> {{trans('general.button.delete')}}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
                <td ng-click="init({{$menu->id}})"><a href="#"> {{ $menu->title }}</a></td>
                <td ng-click="init({{$menu->id}})"><a href="#">{{ $menu->slug }}</a></td>
                <td>{{ $menu->description }}</td>
                <td>
                    @if ($menu->status === 1)
                        <span class='text-success'>
                            <i class="fa fa-check-circle-o text-info"></i>
                        </span>
                    @else
                        <span class='text-danger'>
                            <i class="fa fa-ban text-danger"></i>
                        </span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    @endif

    @if ($menus->render())
        <tfoot>
        <tr>
            <td align="right" colspan="5">{!! $menus->render() !!}</td>
        </tr>
        </tfoot>
    @endif
</table>