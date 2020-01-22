<script>
    var evaluationTeamData = $('.evaluationTeamData');
    var evaluationForm = $('.evaluationTeamAddForm');

    // addIndex(evaluationTeamData);
    evaluationForm.on('click', '.addEvaluationTeam', function (e) {
        e.preventDefault();
        evaluationForm.find('.errorSpan').hide();
        var data = {
            name: evaluationForm.find('#team-name').val(),
            title: evaluationForm.find('#team-title').val(),
            organization: evaluationForm.find('#team-organization').val(),
            email: evaluationForm.find('#team-email').val(),
            telephone: evaluationForm.find('#team-telephone').val(),
        };
        if (!checkTeamFormValid(data)) {
            addEvaluationTeamRow(data);
            clearForm(evaluationForm);
        }
    });

    function checkTeamFormValid(data) {
        var hasError = false;

        if (data.name === "") {
            evaluationForm.find('.errorSpan').show();
            hasError = true;
        }

        if (data.name !== "" && data.email !== "" && !validateEmail(data.email)){
            evaluationForm.find('#team-email-error').show();
            hasError = true;
        }

        return hasError;
    }

    function validateEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    function addEvaluationTeamRow(data) {
        var actionFields = '<a href="javascript:void(0)" class="text-info edit"><i class="fa fa-fw fa-edit"></i></a>' +
            '<a href="javascript:void(0)" class="text-danger remove"><i class="fa fa-fw fa-remove"></i></a>';
        var html = wrapInTd('') +
            wrapInTd(data.name + createHiddenField('team-name', data.name)) +
            wrapInTd(data.title + createHiddenField('team-title', data.title)) +
            wrapInTd(data.organization + createHiddenField('team-organization', data.organization)) +
            wrapInTd(data.email + createHiddenField('team-email', data.email)) +
            wrapInTd(data.telephone + createHiddenField('team-telephone', data.telephone)) +
            wrapInTd(createHiddenField('team_id', '') + actionFields);
        evaluationTeamData.find('table tbody').append(wrapInTr(html));
        addIndex(evaluationTeamData);
    }

    var $parentTr;
    evaluationTeamData.on('click', 'a.edit', function (e) {
        e.preventDefault();
        $parentTr = $(this).closest('tr');
        showHideDiv($('.showEvaluationFomDiv'), $('.hideEvaluationFomDiv'), evaluationForm, true);
        evaluationForm.find('#team-name').val($parentTr.find('.team-name').val());
        evaluationForm.find('#team-title').val($parentTr.find('.team-title').val());
        evaluationForm.find('#team-organization').val($parentTr.find('.team-organization').val());
        evaluationForm.find('#team-email').val($parentTr.find('.team-email').val());
        evaluationForm.find('#team-telephone').val($parentTr.find('.team-telephone').val());
        evaluationForm.find('.addEvaluationTeam').hide();
        evaluationForm.find('.updateEvaluationTeam').show();
    });

    evaluationForm.on('click', '.cancelEvaluationTeam', function (e) {
        e.preventDefault();
        $parentTr = null;
        evaluationForm.find('.addEvaluationTeam').show();
        evaluationForm.find('.updateEvaluationTeam').hide();
        clearForm(evaluationForm);
    });

    evaluationForm.on('click', '.updateEvaluationTeam', function (e) {
        e.preventDefault();
        evaluationForm.find('.errorSpan').hide();
        var data = {
            name: evaluationForm.find('#team-name').val(),
            title: evaluationForm.find('#team-title').val(),
            organization: evaluationForm.find('#team-organization').val(),
            email: evaluationForm.find('#team-email').val(),
            telephone: evaluationForm.find('#team-telephone').val(),
        };

        if (!checkTeamFormValid(data)) {
            $parentTr.find('.team-name').parent().html(data.name + createHiddenField('team-name', data.name));
            $parentTr.find('.team-title').parent().html(data.title + createHiddenField('team-title', data.title));
            $parentTr.find('.team-organization').parent().html(data.organization + createHiddenField('team-organization', data.organization));
            $parentTr.find('.team-email').parent().html(data.email + createHiddenField('team-email', data.email));
            $parentTr.find('.team-telephone').parent().html(data.telephone + createHiddenField('team-telephone', data.telephone));

            evaluationForm.find('.addEvaluationTeam').show();
            evaluationForm.find('.updateEvaluationTeam').hide();
            $parentTr = null;
            clearForm(evaluationForm);
        }
    });

    evaluationTeamData.on('click', 'a.remove', function (e) {
        e.preventDefault();
        removeAlert('Delete team',
            'Are you sure want to delete selected team? This process is irreversible.',
            $(this).closest('tr'), evaluationTeamData);
        clearForm(evaluationForm);
        evaluationForm.find('.addEvaluationTeam').show();
        evaluationForm.find('.updateEvaluationTeam').hide();
    });

    evaluationTeamData.on('click', '.showEvaluationFomDiv', function (e) {
        e.preventDefault();
        showHideDiv($(this), $('.hideEvaluationFomDiv'), evaluationForm, true);
    });


    evaluationTeamData.on('click', '.hideEvaluationFomDiv', function (e) {
        e.preventDefault();
        showHideDiv($(this), $('.showEvaluationFomDiv'), evaluationForm, false);
        clearForm(evaluationForm);
    });
</script>
<script>

    $('#instanceSetup').on('change', 'select[name="province_name"]', function () {
        $('input[name="province"]').val($(this).val());

        $('select[name="palika_name"]').html('<option value=""></option>');
        $('select[name="district_name"]').html('<option value=""></option>');
        $('select[name="hf_name"]').html('<option value=""></option>');
        getProvinceDistrictData($('select[name="district_name"]'), 'district_name', $(this).val());
    });
    $('#instanceSetup').on('change', 'select[name="district_name"]', function () {
        $('input[name="district"]').val($(this).val());

        $('select[name="palika_name"]').html('<option value=""></option>');
        $('select[name="hf_name"]').html('<option value=""></option>');
        getProvinceDistrictData($('select[name="palika_name"]'), 'palika_name', $(this).val());
    });
    $('#instanceSetup').on('change', 'select[name="palika_name"]', function () {
        $('input[name="palika"]').val($(this).val());

        $('select[name="hf_name"]').html('<option value=""></option>');
        $('select[name="hf_name"]').html('<option value=""></option>');
        getProvinceDistrictData($('select[name="hf_name"]'), 'health_post_name', $(this).val());
    });
    $('#instanceSetup').on('change', 'select[name="hf_name"]', function () {
        $('input[name="hf_name_new"]').val($(this).val());
    });

    function getProvinceDistrictData($this, type, id, selected) {
        if (!selected)
            selected = "";

        if (type === 'district_name')
            $('input[name="province"]').val(id);
        if (type === 'palika_name')
            $('input[name="district"]').val(id);
        if (type === 'health_post_name')
            $('input[name="palika"]').val(id);


        $.get('{{ route('admin.instance.facility') }}?type=' + type + '&id=' + id, function (response) {
            var options = '<option value=""></option>';
            if (response) {
                $.each(response, function (key, value) {

                    if (type !== 'health_post_name')
                        key = value;
                    else
                        $('input[name="hf_name_new"]').val(value);


                    if(key === selected)
                        options += '<option value="' + key + '" selected="selected">' + value + '</option>';
                    else
                        options += '<option value="' + key + '">' + value + '</option>';

                });
                $this.html(options);
            }
        }).fail(function (response) {
            alert('error while getting data');
        });
    }

    $(document).ready(function () {
        @if (isset($data['instance']) && $data['instance']->siteDelivery)
            getProvinceDistrictData($('select[name="district_name"]'), 'district_name', "{{ $data['instance']->siteDelivery->province_name }}", "{{ $data['instance']->siteDelivery->district_name }}");
            getProvinceDistrictData($('select[name="palika_name"]'), 'palika_name', "{{ $data['instance']->siteDelivery->district_name }}", "{{ $data['instance']->siteDelivery->palika_name }}");
            getProvinceDistrictData($('select[name="hf_name"]'), 'health_post_name', "{{ $data['instance']->siteDelivery->palika_name }}", "{{ $data['instance']->siteDelivery->facility_id }}");
        @else
            getProvinceDistrictData($('select[name="district_name"]'), 'district_name', "{{ $data['user']->province }}", "{{ $data['user']->district }}");
            getProvinceDistrictData($('select[name="palika_name"]'), 'palika_name', "{{ $data['user']->district }}", "{{ $data['user']->municipality }}");
            getProvinceDistrictData($('select[name="hf_name"]'), 'health_post_name', "{{ $data['user']->municipality }}", "{{ $data['user']->health_post_name }}");
        @endif


         @if (isset($data['enable_pr_change']) && $data['enable_pr_change'] == 'yes')
            $('.selectEditablePR').show();
            $(' .inputEditablePR').hide();
            //  $('.selectEditable').closest('.row').show();
            //$('.selectEditable').closest('.row').show();
        @else 
            $('.selectEditablePR').hide();
            $(' .inputEditablePR').show();
            //  $('.selectEditable').closest('.row').show();
              @endif

        @if (isset($data['enable_dd_change']) && $data['enable_dd_change'] == 'yes')
            $('.selectEditableDD').show();
            $(' .inputEditableDD').hide();
            //$('.selectEditable').closest('.row').show();
            //$('.selectEditable').closest('.row').show();
        @else 
            $('.selectEditableDD').hide();
            $(' .inputEditableDD').show();
            //$('.selectEditable').closest('.row').show();
              @endif


        @if (isset($data['enable_pa_change']) && $data['enable_pa_change'] == 'yes')
            $('.selectEditablePA').show();
            $('.inputEditablePA').hide();
            //  $('.selectEditable').closest('.row').show();
            //$('.selectEditable').closest('.row').show();
        @else 
            $('.selectEditablePA').hide();
            $('.inputEditablePA').show();
            //  $('.selectEditable').closest('.row').show();
              @endif

              @if (isset($data['enable_hf_change']) && $data['enable_hf_change'] == 'yes')
            $('.selectEditableHF').show();
            $('.inputEditableHF').hide();
            //  $('.selectEditable').closest('.row').show();
            //$('.selectEditable').closest('.row').show();
        @else 
            $('.selectEditablePA').hide();
            $('.inputEditablePA').show();
            //  $('.selectEditable').closest('.row').show();
              @endif
        {{--
        @if (isset($data['enable_hf_change']) && $data['enable_hf_change'] == 'yes')
            $('.selectEditable, .selectEditableHF').show();
            $('.inputEditable, .inputEditableHF').hide();
            $('.selectEditable').closest('.row').show();
        @elseif (isset($data['enable_hf_change']) && $data['enable_hf_change'] == 'hf')
            $('.selectEditable').hide();
            $('.selectEditableHF').show();
            $('.inputEditable').show();
            $('.inputEditableHF').hide();
            $('.selectEditable').closest('.row').show();
        @else
            $('.selectEditable, .selectEditableHF').hide();
            $('.inputEditable, .inputEditableHF').show();
            $('.selectEditable').closest('.row').show();
        @endif
            --}}
    });

</script>