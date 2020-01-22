<div class="smart-form">
    <fieldset>
            <section >
                <div class="box box-primary">
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Facebook</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('facebook')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" placeholder="https://" autocomplete="off" name="facebook" type="text" value="{{ AppHelper::getsetting('facebook') }}">
                                        <span class="help-block"></span>
                                       </div>
                                       <div class="form-group" data-priority="1">
                                        <label class="control-label block">Youtube</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('youtube')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" placeholder="https://" autocomplete="off" name="youtube" type="text" value="{{ AppHelper::getsetting('youtube') }}">
                                        <span class="help-block"></span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Twitter</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('twitter')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" placeholder="https://" autocomplete="off" name="twitter" type="text" value="{{ AppHelper::getsetting('twitter') }}">
                                        <span class="help-block"></span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Google+</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('google_plus')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" placeholder="https://" autocomplete="off" name="google_plus" type="text" value="{{ AppHelper::getsetting('google_plus') }}">
                                        <span class="help-block"></span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Instagram</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('instagram')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" placeholder="https://" autocomplete="off" name="instagram" type="text" value="{{ AppHelper::getsetting('instagram') }}">
                                        <span class="help-block"></span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Linkedin</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('linkedin')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" placeholder="https://" autocomplete="off" name="linkedin" type="text" {{ AppHelper::getsetting('linkedin') }}>
                                        <span class="help-block"></span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Flickr</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('flickr')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" placeholder="https://" autocomplete="off" name="flickr" type="text" {{ AppHelper::getsetting('flickr') }}>
                                        <span class="help-block"></span>
                                    </div>
</div>
      </section>
    </fieldset>
</div>