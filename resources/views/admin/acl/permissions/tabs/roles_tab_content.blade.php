<fieldset>
    <div class="row">
        <section class="col col-lg-12">
            <div class="form-group">
                <div class="col-md-11">
                 {!! Form::hidden('selected_roles', null, [ 'id' => 'selected_roles']) !!}
                  {!! Form::select('role_search', [], null, ['class' => 'form-control', 'id' => 'role_search',  'style' => "width: 100%"]) !!}
                    
                </div>
                <label class="control-label col-md-1">
                    <span class="input-group-btn" >
                    <button class="btn btn-primary btn-circle" id="btn-add-role" type="button">
                        <span class="fa fa-fw fa-plus-square">
                        </span>
                    </button>
                </span>
                </label>
            </div>
            <div class="col-md-12 box-body table-responsive no-padding">
                <table class="table table-striped table-bordered table-hover table-condensed" id="tbl-roles">
        <tbody>
            <tr>
                <th class="hidden" rowname="id">
                    {!! trans($admin_trans_path.'general.columns.id')  !!}
                </th>
                <th>
                    {!! trans($admin_trans_path.'general.columns.name')  !!}
                </th>
                <th>
                    {!! trans($admin_trans_path.'general.columns.description')  !!}
                </th>
                <th>
                    {!! trans($admin_trans_path.'general.columns.enabled')  !!}
                </th>
                <th style="text-align: right">
                    {!! trans($admin_trans_path.'general.columns.actions')  !!}
                </th>
            </tr>
            @foreach($perm->roles as $role)
            <tr>
                <td class="hidden" rowname="id">
                    {!! $role->id !!}
                </td>
                <td>
                    {!! link_to_route('admin.roles.show', $role->name, [$role->id], []) !!}
                </td>
                <td>
                    {!! link_to_route('admin.roles.show', $role->description, [$role->id], []) !!}
                </td>
                <td>
                    @if($role->enabled)
                    <i class="fa fa-fw fa-lg fa-check txt-color-green">
                    </i>
                    @else
                    <i class="fa fa-fw fa-lg fa-close txt-color-red">
                    </i>
                    @endif
                </td>
                <td style="text-align: right">
                    <a class="btn-remove-role" href="#" title="{{ trans($admin_trans_path.'general.button.remove-role') }}">
                        <i class="fa  fa-fw fa-lg fa-trash-o txt-color-red deletable">
                        </i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
            </div>
        </section>
    </div>
</fieldset>