<script>
    var errorElement = null;
    var currentForm = null;
    var $validator = null;
    function validateForm(form)
    {
        currentForm = form;
        $validator = form.validate({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block text-danger',
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    }

    function formWizard(wizard, form) {
        currentForm = form;
        wizard.bootstrapWizard({
            'tabClass': 'form-wizard',
            'onNext': function (tab, navigation, index) {
                var $valid = currentForm.valid();
                if (!$valid) {
                    $validator.focusInvalid();
                    return false;
                } else {
                    $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).addClass(
                        'complete');
                    $('#bootstrap-wizard-1').find('.form-wizard').children('li').eq(index - 1).find('.step')
                        .html('<i class="fa fa-check"></i>');
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
    }

    $('form').submit(function () {
        if ($('button[type="submit"]').is(':hidden')) {
            $('.pager.wizard').find('.next a').trigger('click');
            return false;
        }
        if (!$(this).valid()) {
            var id = $(errorElement).closest('.tab-pane').attr('id');
            $('.bootstrapWizard.form-wizard').find('a[href="#' + id + '"]').tab('show');
            $validator.focusInvalid();
            return false;
        }
    });
</script>