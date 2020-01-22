<div class="smart-form">
    <fieldset>
            <section >
                <div class="box box-primary">
                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">SMTP driver</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_driver')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_driver" value="{!! AppHelper::getsetting('smtp_driver')??Config('mail.driver') !!}" type="text">
                                        <span class="help-block">Laravel supports both SMTP and PHP's "mail" function as drivers for the sending of e-mail. You may specify which one you're using throughout your application here. By default, Laravel is setup for SMTP mail.</span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">SMTP host</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_host')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_host" value="{!! AppHelper::getsetting('smtp_host')??Config('mail.host') !!}" type="text">
                                        <span class="help-block">Here you may provide the host address of the SMTP server used by your applications. A default option is provided that is compatible with the Mailgun mail service which will provide reliable deliveries.</span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">SMTP port</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_port')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_port" value="{!! AppHelper::getsetting('smtp_port')??Config('mail.port') !!}" type="text">
                                        <span class="help-block">This is the SMTP port used by your application to deliver e-mails to users of the application. Like the host we have set this value to stay compatible with the Mailgun e-mail application by default.</span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">E-Mail encryption protocol</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_encryption')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_encryption" type="text" value="{!! AppHelper::getsetting('smtp_encryption')??Config('mail.encryption') !!}">
                                        <span class="help-block">Here you may specify the encryption protocol that should be used when the application send e-mail messages. A sensible default using the transport layer security protocol should provide great security.</span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Global "From" address</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_from_address')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_from_address" value="{!! AppHelper::getsetting('smtp_from_address')??Config('mail.from.address') !!}" type="text">
                                        <span class="help-block">You may wish for all e-mails sent by your application to be sent from the same address. Here, you may specify a name and address that is used globally for all e-mails that are sent by your application.</span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">Global "From" name</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_from_name')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_from_name" value="{!! AppHelper::getsetting('smtp_from_name')??Config('mail.from.name') !!}" type="text">
                                        <span class="help-block">You may wish for all e-mails sent by your application to be sent from the same address. Here, you may specify a name and address that is used globally for all e-mails that are sent by your application.</span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">SMTP server username</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_username')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_username" value="{!! AppHelper::getsetting('smtp_username')??Config('mail.username') !!}" type="text">
                                        <span class="help-block">If your SMTP server requires a username for authentication, you should set it here. This will get used to authenticate with your server on connection. You may also set the "password" value below this one.</span>
                                    </div>
                                                                    <div class="form-group" data-priority="1">
                                        <label class="control-label block">SMTP server password</label>
                                        <p class="mb5">
                                            <small>
                                                <code>get_setting('smtp_password')</code>
                                            </small>
                                        </p>
                                        <input class="form-control" name="smtp_password" type="text" value="{!! AppHelper::getsetting('smtp_password')??Config('mail.password') !!}">
                                        <span class="help-block">If your SMTP server requires a username for authentication, you should set it here. This will get used to authenticate with your server on connection. You may also set the "password" value below this one.</span>
                                
</div>
      </section>
    </fieldset>
</div>