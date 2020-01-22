<div class="smart-form">
    <fieldset>
        <section class="form-group">
            <label class="control-label">{{ trans($trans_path.'general.columns.question') }}</label>
            <label class="input">
                {!! Form::text('question' , null, ['class' => 'form-control', 'placeholder'=>trans($trans_path.'general.columns.question'), 'required']) !!}
                <i></i>
            </label>
            <span class="question-error text-danger" style="display: none;">This field is required.</span>
        </section>
        <section class="form-group">
            <label class="control-label">{{ trans($trans_path.'general.columns.answer') }}</label>
            <label class="input">
                {!! Form::textarea('answer', null, ['class' => 'form-control answerEditor', 'placeholder'=>trans($trans_path.'general.columns.answer'), 'required']) !!}
            </label>
            <span class="answerEditor-error text-danger" style="display: none;">This field is required.</span>
        </section>
        <section>
            <label class="control-label">{{ trans($admin_trans_path.'general.columns.status') }}</label>
            <div class="checkbox">
                <label>
                    <input name="status" type="checkbox" class="checkbox" value="1" {{ isset($faq) && $faq->status == 1 ? 'checked' : null }} />
                    <span>{{ trans($admin_trans_path.'general.columns.status') }} </span>
                </label>
            </div>
        </section>
    </fieldset>
</div>