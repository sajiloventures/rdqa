<fieldset>
    <section>
        <div class="inline-group">
            <!-- Trick to force cleared checkbox to being posted in form! It will be posted as zero unless checked then posted again as 1 and since only last one count! -->
            {!! '
            <input name="enabled" type="hidden" value="0">
                ' !!}
                <label class="checkbox">
                    {!! Form::checkbox('enabled', '1', $role->enabled) !!} {!! trans($admin_trans_path.'general.status.enabled') !!}
                    <i>
                    </i>
                </label>
            </input>
        </div>
    </section>
</fieldset>