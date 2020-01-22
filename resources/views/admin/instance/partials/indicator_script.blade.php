<script>

    var indicatorData = $('.indicatorData');
    var indicatorForm = $('.indicatorForm');
    // addIndex(indicatorData);

    indicatorForm.on('click', '.addIndicator', function (e) {
        e.preventDefault();
        indicatorForm.find('.errorSpan').hide();
        var data = getData();
        if (!checkAndShowErrorOfIndicator(data)) {
            addIndicatorRow(data);
            clearForm(indicatorForm);
        }
    });

    function checkAndShowErrorOfIndicator(data)
    {
        indicatorForm.find('.has-error').removeClass('has-error');
        indicatorForm.find('.errorSpan').hide();
        indicatorForm.find('.error2Span').hide();
        var hasError = false;
        if(!data.indicator_indicator)
        {
            indicatorForm.find('#indicator_indicator').closest('.form-group').addClass('has-error').find('.errorSpan').show();
            hasError = true;
        } else {
            if (checkUsedIndicator(data.indicator_indicator)) {
                if (!$parentTr) {
                    indicatorForm.find('#indicator_indicator').closest('.form-group').addClass('has-error').find('.error2Span').show();
                    hasError = true;
                }
            }
        }

        if(!data.indicator_cross_check_1_a)
        {
            indicatorForm.find('#indicator_cross_check_1_a').closest('.form-group').addClass('has-error').find('.errorSpan').show();
            hasError = true;
        }

//        if(!data.indicator_cross_check_2_a)
//        {
//            indicatorForm.find('#indicator_cross_check_2_a').closest('.form-group').addClass('has-error').find('.errorSpan').show();
//            hasError = true;
//        }

        if(!data.indicator_from_date)
        {
            indicatorForm.find('#indicator_from_date').closest('.form-group').addClass('has-error').find('.errorSpan').show();
            hasError = true;
        }

        if(!data.indicator_to_date)
        {
            indicatorForm.find('#indicator_to_date').closest('.form-group').addClass('has-error').find('.errorSpan').show();
            hasError = true;
        }

        return hasError;
    }

    function getData() {
        var data = {
            indicator_indicator: indicatorForm.find('#indicator_indicator').val(),
            indicator_program: indicatorForm.find('#indicator_program').val(),
            indicator_cross_check_1_a: indicatorForm.find('#indicator_cross_check_1_a').val(),
            indicator_cross_check_2_a: indicatorForm.find('#indicator_cross_check_2_a').val(),
            indicator_cross_check_3_a: indicatorForm.find('#indicator_cross_check_3_a').val(),
            indicator_from_date: indicatorForm.find('#indicator_from_date').val(),
            indicator_to_date: indicatorForm.find('#indicator_to_date').val(),
            indicator_from_date_eng: indicatorForm.find('#indicator_from_date_eng').val(),
            indicator_to_date_eng: indicatorForm.find('#indicator_to_date_eng').val()
        };
        var dataText={
            indicator_indicator_text: data.indicator_indicator > 0 ? indicatorForm.find('#indicator_indicator option[value="' + data.indicator_indicator +'"]').text() : "",
            indicator_cross_check_1_a_text: data.indicator_cross_check_1_a > 0 ? indicatorForm.find('#indicator_cross_check_1_a option[value="' + data.indicator_cross_check_1_a +'"]').text() : "",
            indicator_cross_check_2_a_text: data.indicator_cross_check_2_a > 0 ? indicatorForm.find('#indicator_cross_check_2_a option[value="' + data.indicator_cross_check_2_a +'"]').text() : "",
            indicator_cross_check_3_a_text: data.indicator_cross_check_3_a > 0 ? indicatorForm.find('#indicator_cross_check_3_a option[value="' + data.indicator_cross_check_3_a +'"]').text() : "",
            from_to_date_text: data.indicator_from_date + ' - ' + data.indicator_to_date
        };
        $.extend(data, dataText);
        return data;
    }

    function addIndicatorRow(data) {
        var actionFields = '<a href="javascript:void(0)" class="text-info edit"><i class="fa fa-fw fa-edit"></i></a>' +
            '<a href="javascript:void(0)" class="text-danger remove"><i class="fa fa-fw fa-remove"></i></a>';

        var indicatorText = selectedValueText ? selectedValueText : data.indicator_indicator_text;
        selectedValueText = "";
        var cc1 = getVsText(data.indicator_cross_check_1_a, 0, data.indicator_cross_check_1_a_text, "");
        var cc2 = getVsText(data.indicator_cross_check_2_a, 0, data.indicator_cross_check_2_a_text, "");
        var cc3 = getVsText(data.indicator_cross_check_3_a, 0, data.indicator_cross_check_3_a_text, "");

        var html = wrapInTd('') +
            wrapInTd(indicatorText + createHiddenField('indicator', data.indicator_indicator) + createHiddenField('program', data.indicator_program)) +
            wrapInTd(cc1 + createHiddenField('cross_check_1_a', data.indicator_cross_check_1_a)) +
            wrapInTd(cc2 + createHiddenField('cross_check_2_a', data.indicator_cross_check_2_a)) +
            wrapInTd(cc3 + createHiddenField('cross_check_3_a', data.indicator_cross_check_3_a)) +
            wrapInTd(data.from_to_date_text + createHiddenField('from_date', data.indicator_from_date) + createHiddenField('to_date', data.indicator_to_date) + createHiddenField('from_date_eng', data.indicator_from_date_eng) + createHiddenField('to_date_eng', data.indicator_to_date_eng)) +
            wrapInTd(createHiddenField('instance_indicator_id', '') + actionFields);
        indicatorData.find('table tbody').append(wrapInTr(html));
        addIndex(indicatorData);
    }

    function getVsText(a, b, aText, bText) {
        var vs = ' ' + '{{ trans($trans_path . 'general.indicator.vs') }}' + ' ';
        if (parseInt(b) > 0)
            return aText + vs + bText;
        return aText;
    }

    var $parentTr;
    indicatorData.on('click', 'a.edit', function (e) {
        indicatorValueChange = false;
        e.preventDefault();
        $parentTr = $(this).closest('tr');
        showHideDiv($('.showIndicatorFormDiv'), $('.hideIndicatorFormDiv'), indicatorForm, true);
        if (indicatorForm.find('#indicator_indicator [value="' + $parentTr.find('.indicator').val() + '"]').length < 1)
            indicatorForm.find('#indicator_indicator').append('<option value="' + $parentTr.find('.indicator').val() + '">' + $parentTr.find('.indicator').closest('td').find('span').html() + '</option>');

        indicatorForm.find('#indicator_program').val($parentTr.find('.program').val()).trigger('change');
        indicatorForm.find('#indicator_indicator').val($parentTr.find('.indicator').val()).trigger('change');
        indicatorForm.find('#indicator_cross_check_1_a').val($parentTr.find('.cross_check_1_a').val()).trigger('change');
        indicatorForm.find('#indicator_cross_check_2_a').val($parentTr.find('.cross_check_2_a').val()).trigger('change');
        indicatorForm.find('#indicator_cross_check_3_a').val($parentTr.find('.cross_check_3_a').val()).trigger('change');
        indicatorForm.find('#indicator_from_date').val($parentTr.find('.from_date').val());
        indicatorForm.find('#indicator_to_date').val($parentTr.find('.to_date').val());
        indicatorForm.find('#indicator_from_date_eng').val($parentTr.find('.from_date_eng').val());
        indicatorForm.find('#indicator_to_date_eng').val($parentTr.find('.to_date_eng').val());
        indicatorForm.find('.addIndicator').hide();
        indicatorForm.find('.updateIndicator').show();
    });

    indicatorForm.on('click', '.cancelIndicator', function (e) {
        e.preventDefault();
        $parentTr = null;
        indicatorForm.find('.addIndicator').show();
        indicatorForm.find('.updateIndicator').hide();
        clearForm(indicatorForm);
    });

    indicatorForm.on('click', '.updateIndicator', function (e) {
        e.preventDefault();
        indicatorForm.find('.errorSpan').hide();
        indicatorForm.find('.error2Span').hide();
        var data = getData();

        if (!checkAndShowErrorOfIndicator(data)) {
            var indicatorText = selectedValueText ? selectedValueText : data.indicator_indicator_text;
            selectedValueText = "";
            var cc1 = getVsText(data.indicator_cross_check_1_a, 0, data.indicator_cross_check_1_a_text, "");
            var cc2 = getVsText(data.indicator_cross_check_2_a, 0, data.indicator_cross_check_2_a_text, "");
            var cc3 = getVsText(data.indicator_cross_check_3_a, 0, data.indicator_cross_check_3_a_text, "");

            $parentTr.find('.indicator').parent().html(indicatorText + createHiddenField('indicator', data.indicator_indicator) + createHiddenField('program', data.indicator_program));
            $parentTr.find('.cross_check_1_a').parent().html(cc1 + createHiddenField('cross_check_1_a', data.indicator_cross_check_1_a));
            $parentTr.find('.cross_check_2_a').parent().html(cc2 + createHiddenField('cross_check_2_a', data.indicator_cross_check_2_a));
            $parentTr.find('.cross_check_3_a').parent().html(cc3 + createHiddenField('cross_check_3_a', data.indicator_cross_check_3_a));
            $parentTr.find('.from_date').parent().html(data.from_to_date_text + createHiddenField('from_date', data.indicator_from_date) + createHiddenField('to_date', data.indicator_to_date) + createHiddenField('from_date_eng', data.indicator_from_date_eng) + createHiddenField('to_date_eng', data.indicator_to_date_eng));

            indicatorForm.find('.addIndicator').show();
            indicatorForm.find('.updateIndicator').hide();
            $parentTr = null;
            clearForm(indicatorForm);
        }
    });

    indicatorData.on('click', 'a.remove', function (e) {
        e.preventDefault();
        removeAlert('Delete team',
            'Are you sure want to delete selected indicator? This process is irreversible.',
            $(this).closest('tr'), indicatorData);
        clearForm(indicatorForm);
        indicatorForm.find('.addIndicator').show();
        indicatorForm.find('.updateIndicator').hide();
    });

    indicatorData.on('click', '.showIndicatorFormDiv', function (e) {
        e.preventDefault();
        showHideDiv($(this), $('.hideIndicatorFormDiv'), indicatorForm, true);
    });


    indicatorData.on('click', '.hideIndicatorFormDiv', function (e) {
        e.preventDefault();
        showHideDiv($(this), $('.showIndicatorFormDiv'), indicatorForm, false);
        clearForm(indicatorForm);
    });

    function checkUsedIndicator(value) {

        return value && indicatorData.find('[value="' + value + '"].indicator').length > 0;

    }

    indicatorForm.find('#indicator_cross_check_1_a').on('change', function () {
        makeDisabled();
    });
    indicatorForm.find('#indicator_cross_check_2_a').on('change', function () {
        makeDisabled();
    });
    indicatorForm.find('#indicator_cross_check_3_a').on('change', function () {
        makeDisabled();
    });
    
    function makeDisabled() {
        var selector_1_a = indicatorForm.find('#indicator_cross_check_1_a');
        var selector_2_a = indicatorForm.find('#indicator_cross_check_2_a');
        var selector_3_a = indicatorForm.find('#indicator_cross_check_3_a');

        indicatorForm.find('#indicator_cross_check_1_a option[disabled="disabled"]').removeAttr('disabled');
        indicatorForm.find('#indicator_cross_check_2_a option[disabled="disabled"]').removeAttr('disabled');
        indicatorForm.find('#indicator_cross_check_3_a option[disabled="disabled"]').removeAttr('disabled');

        if (selector_1_a.val()) {
            indicatorForm.find('#indicator_cross_check_2_a').find('option[value="' + selector_1_a.val() + '"]').attr('disabled', true);
            indicatorForm.find('#indicator_cross_check_3_a').find('option[value="' + selector_1_a.val() + '"]').attr('disabled', true);
        }
        if (selector_2_a.val()) {
            indicatorForm.find('#indicator_cross_check_1_a').find('option[value="' + selector_2_a.val() + '"]').attr('disabled', true);
            indicatorForm.find('#indicator_cross_check_3_a').find('option[value="' + selector_2_a.val() + '"]').attr('disabled', true);
        }
        if (selector_3_a.val()) {
            indicatorForm.find('#indicator_cross_check_1_a').find('option[value="' + selector_3_a.val() + '"]').attr('disabled', true);
            indicatorForm.find('#indicator_cross_check_2_a').find('option[value="' + selector_3_a.val() + '"]').attr('disabled', true);
        }

//        selector_1_a.select2();
//        selector_2_a.select2();
//        selector_3_a.select2();
    }

</script>