<fieldset>
    <div class="row">
        <section class="col col-lg-12">
            <div class="form-group">
                <div class="col-md-11">
                 {!! Form::hidden('selected_routes', null, [ 'id' => 'selected_routes']) !!}
                  {!! Form::select('route_search', [], null, ['class' => 'form-control', 'id' => 'route_search',  'style' => "width: 100%"]) !!}
                    
                </div>
                <label class="control-label col-md-1">
                    <span class="input-group-btn" >
                    <button class="btn btn-primary btn-circle" id="btn-add-route" type="button">
                        <span class="fa fa-fw fa-plus-square">
                        </span>
                    </button>
                </span>
                </label>
            </div>
           

              <div class="col-md-12 box-body table-responsive no-padding">
                <table class="table table-striped table-bordered table-hover table-condensed" id="tbl-routes">
                    <tbody>
                        <tr>
                            <th class="hidden" rowname="id">
                                {!! trans($admin_trans_path.'general.columns.id')  !!}
                            </th>
                            <th>
                                {!! trans($admin_trans_path.'general.columns.method')  !!}
                            </th>
                            <th>
                                {!! trans($admin_trans_path.'general.columns.path')  !!}
                            </th>
                            <th>
                                {!! trans($admin_trans_path.'general.columns.enabled')  !!}
                            </th>
                            <th style="text-align: right">
                                {!! trans($admin_trans_path.'general.columns.actions')  !!}
                            </th>
                        </tr>
                        @if($perm->routes) 
                        @foreach($perm->routes as $route)
                        <tr>
                            <td class="hidden" rowname="id">
                                {!! $route->id !!}
                            </td>
                            <td>
                                {!! link_to_route('admin.routes.show', $route->method, [$route->id], []) !!}
                            </td>
                            <td>
                                {!! link_to_route('admin.routes.show', $route->path, [$route->id], []) !!}
                            </td>
                            <td>
                                @if($route->enabled)
                                <i class="fa fa-check text-green">
                                </i>
                                @else
                                <i class="fa fa-close text-red">
                                </i>
                                @endif
                            </td>
                            <td style="text-align: right">
                                <a class="btn-remove-route" href="#" title="{{ trans($admin_trans_path.'general.button.remove-route') }}">
                                    <i class="fa fa-trash-o deletable">
                                    </i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</fieldset>