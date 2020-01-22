<div class="table-responsive no-padding">
<table class="table table-striped table-bordered table-hover table-condensed">
    <thead>
    <tr>
        <th>{!! trans($admin_trans_path.'general.columns.name')  !!}</th>
        <th>{!! trans($admin_trans_path.'general.columns.effective')  !!}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($perms as $perm)
        @if($user->can($perm->name))
        <tr>
            <td>{!! link_to_route('admin.permissions.show', $perm->display_name, [$perm->id], []) !!}</td>
            <td>
            <i class="fa fa-fw fa-lg fa-check txt-color-green"></i>
            </td>
        </tr>
        @endif
    @endforeach
    </tbody>
</table>
</div>