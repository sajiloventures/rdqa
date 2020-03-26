<table class="table table-bordered table-striped table-hover table-condensed">
    <thead>
    <tr>
        {{--<th class="col-actions center">--}}
            {{--<div class="form-check m-b-0">--}}
                {{--<label class="form-check-label">--}}
                    {{--<input class="form-check-input" type="checkbox" name="checkAll" />--}}
                {{--</label>--}}
            {{--</div>--}}
        {{--</th>--}}
{{--        <th class="text-primary">{{ trans($trans_path.'general.columns.profile_image') }}</th>--}}
        <th class="text-primary">{{ trans($trans_path.'general.columns.id') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.name') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.email') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.user_role') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.assign_for') }}</th>
        <th class="text-primary">{{ trans($trans_path.'general.columns.status') }}</th>
    </tr>
    </thead>
    <tbody id="user_list_tbody">

    </tbody>
</table>