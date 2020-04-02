<script src="{{ asset('smartadmin/js/plugin/select2/select2.min.js') }}"></script>
{{--<script src="{{ asset('smartadmin/js/select2_4.min.js') }}"></script>--}}
<script src="{{ asset('smartadmin/js/plugin/bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>

{!! Html::script('nepali_datepicker/nepali.datepicker.v2.2.min.js') !!}
{{--{!! Html::script('js/nepali_datepicker.min.js') !!}--}}
@include($view_path . '.partials.select2_script')
@include($view_path . '.partials.basic_info_script')
@include($view_path . '.partials.indicator_script')



<script>

    //disable wizard click
    $('.bootstrapWizard.form-wizard a').click(function (e) {
        e.preventDefault();
        return false;
    });
//    var d = new Date();
//    var currentDate = calendarFunctions.getBsDateByAdDate(d.getFullYear(), d.getMonth() + 1, d.getDate());
//
//    currentDate = calendarFunctions.bsDateFormat("y-m-d", currentDate.bsYear, currentDate.bsMonth, currentDate.bsDate);
//
//    $('#indicator_from_date').nepaliDatePicker({
//
//        dateFormat: "y-m-d",
//        closeOnDateSelect: true,
//        maxDate : currentDate,
////        maxDate : currentDate.bsYear + '-' + currentDate.bsMonth + '-' + currentDate.bsDate
//    });
//
//    $('#indicator_to_date').nepaliDatePicker({
//        dateFormat: "y-m-d",
//        closeOnDateSelect: true,
//        maxDate : currentDate
//    });


    var todayDateInNepali = getNepaliDate();
    todayDateInNepali = todayDateInNepali.split('-');
    todayDateInNepali = todayDateInNepali[1] + '/' + todayDateInNepali[2] + '/' + todayDateInNepali[0];
    console.log(todayDateInNepali, '12/08/2075');
    $('#indicator_from_date').nepaliDatePicker({
        npdMonth: true,
        npdYear: true,
        npdYearCount: 10,
        disableAfter: todayDateInNepali,
        ndpEnglishInput: 'indicator_from_date_eng',
    });
    $('#indicator_to_date').nepaliDatePicker({
        npdMonth: true,
        npdYear: true,
        npdYearCount: 10,
        disableAfter: todayDateInNepali,
        ndpEnglishInput: 'indicator_to_date_eng',
    });

//    // START AND FINISH DATE
//    $('.startdate').datepicker({
//        dateFormat: 'dd-mm-yy',
//        prevText: '<i class="fa fa-chevron-left"></i>',
//        nextText: '<i class="fa fa-chevron-right"></i>',
//        onSelect: function (selectedDate) {
//            $('.finishdate').datepicker('option', 'minDate', selectedDate);
//        }
//    });
//    $('.finishdate').datepicker({
//        dateFormat: 'dd-mm-yy',
//        prevText: '<i class="fa fa-chevron-left"></i>',
//        nextText: '<i class="fa fa-chevron-right"></i>',
//        onSelect: function (selectedDate) {
//            $('.startdate').datepicker('option', 'maxDate', selectedDate);
//        }
//    });



    function removeAlert(title, content, removeDiv, reIndex) {
        $.SmartMessageBox({
            title : title,
            content : content,
            sound : false,
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {
                removeDiv.remove();
                if (reIndex)
                    addIndex(reIndex);
            }

        });
    }

    function wrapInTr(html) {
        return '<tr>' + html + '</tr>';
    }
    function wrapInTd(html) {
        return '<td>' + html + '</td>';
    }
    function createHiddenField(fieldName, value, className) {
        if (className === undefined || className === null || className === "")
            className = fieldName;

        return '<input type="hidden" name="' + fieldName + '[]" value="' + value +'" class="' + className + '" />';
    }
    function addIndex(parentForm) {
        var count = 1;
        parentForm.find('table tbody tr').each(function () {
            $(this).find('td:first-child').html(count++);
        });
    }

    function clearForm(parentForm) {
        parentForm.find('input, select, textarea').each(function () {
            if ($(this).hasClass('select2') || $(this).hasClass('indicator_indicator'))
                $(this).val('').trigger('change');
            else
                $(this).val('');
        });

        $('.requiredIndicator, .requiredEvaluationTeam, .errorSpan, .error2Span, #team-email-error').hide();
        $('.has-error').removeClass('has-error');

    }

    function showHideDiv($this, showAnchor, div, show) {
        if (show) {
            div.slideDown();
        } else {
            div.slideUp();
        }
        $this.hide();
        showAnchor.show();

    }

    $(document).ready(function() {

        //Bootstrap Wizard Validations

        var $validator = $("#instanceSetup").validate({
            rules: {
                name: {
                    required: true
                },
                province_name: {
                    required: true
                },
                district_name: {
                    required: true
                },
                palika_name: {
                    required: true
                },
                hf_name: {
                    required: true
                }
            },

            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else if (element.parent('.form-group').length) {
                    error.insertAfter(element);
                }else {
                    error.insertAfter(element.parent());
                }
            }
        });

        $('#bootstrap-wizard-1').bootstrapWizard({
            'tabClass': 'form-wizard',
            'onNext': function (tab, navigation, index) {
                var $valid = $("#instanceSetup").valid();
                if (!$valid) {
                    var id = $($validator.currentElements[0]).closest('.tab-pane').attr('id');
                    $('.bootstrapWizard.form-wizard').find('a[href="#' + id + '"]').tab('show');
                    $validator.focusInvalid();
                    return false;
                } else {
                    $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
                        'complete');
                    $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
                        .html('<i class="fa fa-check"></i>');
                }

                if($('.tab-pane.active').find('.evaluationTeamData').length && $('.evaluationTeamData table tbody tr').length < 1) {
                    $('.requiredEvaluationTeam').slideDown();
                    return false;
                }


            },
            'onTabShow': function (tab, navigation, index) {
                if ($('.bootstrapWizard.form-wizard li').length === index + 1) {
                    $('li.next').hide();
                    $('li.save').show();
                } else {
                    $('li.next').show();
                    $('li.save').hide();
                }

            }
        });
        $("#instanceSetup").on('submit', function () {
            if($('.indicatorData .indicator').length < 4) {
                $('.indicatorData .requiredIndicator').slideDown('fast');
                return false;
            }
            if (!$("#instanceSetup").valid()) {
                var id = $($validator.currentElements[0]).closest('.tab-pane').attr('id');
                $('.bootstrapWizard.form-wizard').find('a[href="#' + id + '"]').tab('show');
                $validator.focusInvalid();
                return false;
            }
        });
    });
</script>