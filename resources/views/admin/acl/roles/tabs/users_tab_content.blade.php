<?php $membershipFixed = ($role->canChangeMembership()) ? '' : 'disabled'; ?>
<fieldset>
    <div class="row">
        <section class="col col-lg-12">
              <div class="form-group">
                <div class="col-md-11">
                 {!! Form::hidden('selected_users', null, [ 'id' => 'selected_users']) !!}
                 {!! Form::select('user_search', [], null, ['class' => 'form-control', 'id' => 'user_search',  'style' => "width: 100%", $membershipFixed]) !!}
                    
                </div>
                <label class="control-label col-md-1">
                    <span class="input-group-btn" >
                    <button class="btn btn-primary btn-circle" id="btn-add-user" type="button" {!! $membershipFixed !!}>
                        <span class="fa fa-fw fa-plus-square">
                        </span>
                    </button>
                </span>
                </label> 
            </div>
            <div class="col-md-12 box-body table-responsive no-padding">
                <table class="table table-striped table-bordered table-hover table-condensed" id="tbl-users">
                    <tbody>
                        <tr>
                         <th class="hidden" rowname="id">{!! trans($trans_path. 'general.columns.id')  !!}</th>          
                            <th>
                                {!! trans($admin_trans_path.'general.columns.email')  !!}
                            </th>
                            <th>
                                {!! trans($admin_trans_path.'general.columns.username')  !!}
                            </th>
                            <th>
                                {!! trans($admin_trans_path.'general.columns.enabled')  !!}
                            </th>
                            <th style="text-align: right">
                                {!! trans($admin_trans_path.'general.columns.actions')  !!}
                            </th>
                        </tr>
                        @foreach($role->users as $user)
                        <tr>
                           <td class="hidden" rowname="id">{!! $user->id !!}</td>
                            <td>
                                {!! link_to_route('admin.users.show', $user->email, [$user->id], []) !!}
                            </td>
                            <td>
                                {!! link_to_route('admin.users.show', $user->username, [$user->id], []) !!}
                            </td>
                            <td>
                                @if($user->status)
                                <i class="fa fa-fw fa-lg fa-check txt-color-green">
                                </i>
                                @else
                                <i class="fa fa-fw fa-lg fa-close txt-color-red">
                                </i>
                                @endif
                            </td>
                            <td style="text-align: right">
                                <i class="fa fa-fw fa-lg fa-trash-o txt-muted txt-color-red btn-remove-user">
                                </i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.table-responsive -->
        </section>
    </div>
</fieldset>



