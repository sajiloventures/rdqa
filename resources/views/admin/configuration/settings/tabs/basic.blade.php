<div class="smart-form">
    <fieldset>
            <section >
                <div class="box box-primary">
                    {!! Form::open( ['route' => 'admin.settings.basic', 'id' => 'form_edit_permission','class' => 'smart-form'] ) !!}

                    <div class="form-group" data-priority="3">
                        <label class="control-label block">Main menu</label>
                        <p class="mb5">
                            <small>
                                <code>get_setting('main_menu')</code>
                            </small>
                        </p>
                        <select class="form-control" name="main_menu"></select>
                        <span class="help-block">Main menu of our website. We will get this menu by default</span>
                    </div>
                    <div class="form-group" data-priority="5">
                        <label class="control-label block">Site title</label>
                        <p class="mb5">
                            <small>
                                <code>get_setting('site_title')</code>
                            </small>
                        </p>
                        <input class="form-control" name="site_title" type="text" value="{{ AppHelper::getsetting('site_title') }}">
                        <span class="help-block">Our site title</span>
                    </div>
                    <div class="form-group" data-priority="6">
                        <label class="control-label block">Application name</label>
                        <p class="mb5">
                            <small>
                                <code>get_setting('app_name')</code>
                            </small>
                        </p>
                        <input class="form-control" name="app_name" value="{!! AppHelper::getsetting('name')??Config('app.name') !!}" type="text">
                        <span class="help-block">Name of this application</span>
                    </div>
                    <div class="form-group" data-priority="7">
                        <label class="control-label block">Site logo</label>
                        <p class="mb5">
                            <small>
                                <code>get_setting('site_logo')</code>
                            </small>
                        </p>
                        <div class="select-media-box">
                            <button type="button" class="btn blue show-add-media-popup">
                                Choose image
                            </button>
                            <div class="clearfix"></div>
                            <a title="" class="show-add-media-popup" href="javascript:;">
                                <img src="http://demoapp.dev/admin/images/no-image.png" alt="" class="img-responsive">
                            </a>
                            <input name="site_logo" value="" class="input-file" type="hidden">
                            <a title="" class="remove-image" href="javascript:;">
                                <span>&nbsp;</span>
                            </a>
                        </div>

                        <span class="help-block">Our site logo</span>
                    </div>
                    <div class="form-group" data-priority="8">
                        <label class="control-label block">Favicon</label>
                        <p class="mb5">
                            <small>
                                <code>get_setting('favicon')</code>
                            </small>
                        </p>
                        <div class="select-media-box">
                            <button type="button" class="btn blue show-add-media-popup">
                                Choose image
                            </button>
                            <div class="clearfix"></div>
                            <a title="" class="show-add-media-popup" href="javascript:;">
                                <img src="http://demoapp.dev/admin/images/no-image.png" alt="" class="img-responsive">
                            </a>
                            <input name="favicon" value="" class="input-file" type="hidden">
                            <a title="" class="remove-image" href="javascript:;">
                                <span>&nbsp;</span>
                            </a>
                        </div>

                        <span class="help-block">16x16, support png, gif, ico, jpg</span>
                    </div>
                    <footer>
                        {!! Form::submit( trans($admin_trans_path.'general.button.save'), ['class' => 'btn btn-primary', 'id' => 'btn-submit-edit'] ) !!}
                        <a class="btn btn-default" href="{!! route('admin.settings') !!}"
                           title="{{ trans($admin_trans_path.'general.button.cancel') }}">
                            {{ trans($admin_trans_path.'general.button.cancel') }}
                        </a>

                    </footer>
                    {!! Form::close() !!}
</div>
      </section>
    </fieldset>
</div>