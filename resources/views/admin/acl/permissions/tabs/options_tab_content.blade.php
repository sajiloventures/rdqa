<fieldset>
    <section>
     {!! '
    <input name="enabled" type="hidden" value="0">
        ' !!}
        <label class="checkbox">
         {!! Form::checkbox('enabled', '1', $perm->enabled) !!} {!! trans($admin_trans_path.'general.status.enabled') !!}
           <i></i>
        </label>
       
    </section>
</fieldset>