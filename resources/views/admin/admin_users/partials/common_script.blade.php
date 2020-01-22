{!! Html::script('smartadmin/js/bootstrap-tags/bootstrap-tagsinput.min.js') !!}
{{--<script>--}}

    {{--$(document).on('change', 'select[name="province"]', function () {--}}
        {{--$('select[name="municipality"]').html('<option value=""></option>');--}}
        {{--$('select[name="district"]').html('<option value=""></option>');--}}
        {{--getData($('select[name="district"]'), 'district', $(this).val());--}}
    {{--});--}}
    {{--$(document).on('change', 'select[name="district"]', function () {--}}
        {{--$('select[name="municipality"]').html('<option value=""></option>');--}}
        {{--getData($('select[name="municipality"]'), 'municipality', $(this).val());--}}
    {{--});--}}

    {{--getData($('select[name="district"]'), 'district', "{{ isset($user) ? $user->province : null }}", "{{ isset($user) ? $user->district : null }}");--}}

    {{--function getData($this, type, id, selected) {--}}
        {{--if (!selected)--}}
            {{--selected = "";--}}

        {{--$.get('{{ route('admin.admin_users.address') }}?type=' + type + '&id=' + id, function (response) {--}}
            {{--var options = '<option value=""></option>';--}}
            {{--if (response) {--}}
                {{--$.each(response, function (key, value) {--}}
                    {{--if(value === selected)--}}
                        {{--options += '<option value="' + value + '" selected="selected">' + value + '</option>';--}}
                    {{--else--}}
                        {{--options += '<option value="' + value + '">' + value + '</option>';--}}

                {{--});--}}
                {{--$this.html(options);--}}
            {{--}--}}
        {{--}).fail(function (response) {--}}
            {{--alert('error while getting data');--}}
        {{--});--}}
    {{--}--}}

    {{--$(document).ready(function () {--}}
        {{--getData($('select[name="municipality"]'), 'municipality', "{{ isset($user) ? $user->district : null }}", "{{ isset($user) ? $user->municipality : null }}");--}}
    {{--});--}}

{{--</script>--}}
<script>
    var displayFacilityUser = '{{ $data['palika_user_display'] }}';

    $('form').on('change', '[name="user_role"]', function () {
        var role = $(this).val();
        displayOrShowPalika($(this).val());

        displayOrProvince($(this).val());
        console.log(role);
        if(role == 'palika-user'){
            $('.data-post').hide();
            $('.data-palika').show();
            $('.data-district').show();
            $('.data-province').show();

        }
        else if (role == 'district-user'){
            $('.data-post').hide();
            $('.data-palika').hide();

            $('.data-district').show();
            $('.data-province').show();

        }
        else if (role == 'province-user'){
            $('.data-post').hide();
            $('.data-palika').hide();
            $('.data-district').hide();
            $('.data-province').show();

        }
        else {
            $('.data-post').show();
            $('.data-palika').show();
            $('.data-district').show();
            $('.data-province').show();
        }
    });

    displayOrShowPalika($('[name="user_role"]').val());

    function displayOrShowPalika(show) {
        if (displayFacilityUser === 'block') {
            if (show === 'facility-user') {
                $('[name="province_user_id"], [name="district_user_id"], [name="palika_user_id"]')
                    .attr('required', 'required').closest('section').slideDown();
            } else if (show === 'palika-user') {
                $('[name="province_user_id"], [name="district_user_id"]')
                    .attr('required', 'required').closest('section').slideDown();
                $('[name="palika_user_id"]')
                    .removeAttr('required').closest('section').slideUp();
            } else if (show === 'district-user') {
                $('[name="province_user_id"]')
                    .attr('required', 'required').closest('section').slideDown();
                $('[name="district_user_id"], [name="palika_user_id"]')
                    .removeAttr('required').closest('section').slideUp();
            } else
                hideAllRoleUsers();
        } else
            hideAllRoleUsers();
    }

    function hideAllRoleUsers() {
        $('[name="province_user_id"], [name="district_user_id"], [name="palika_user_id"]').removeAttr('required').closest('section').slideUp();
    }

    displayOrProvince($('[name="user_role"]').val());
    function displayOrProvince(val)
    {
        if (val === 'rdqa-admin') {
            if ($('.showHideDistrict').is(':visible'))
                $('.showHideDistrict').slideUp();
        } else
            $('.showHideDistrict').slideDown();
    }

</script>



<script>
    //script for user role select
    $(document).on('change', 'select[name="province_user_id"]', function () {
        $('select[name="district_user_id"]').html('<option value=""></option>');
        $('select[name="palika_user_id"]').html('<option value=""></option>');
        getUserSelectRoleData($('select[name="district_user_id"]'), 'district', $(this).val());
    });
    $(document).on('change', 'select[name="district_user_id"]', function () {
        $('select[name="palika_user_id"]').html('<option value=""></option>');
        getUserSelectRoleData($('select[name="palika_user_id"]'), 'palika', $(this).val());
    });


    function getUserSelectRoleData($this, type, id, selected) {
        if (!selected)
            selected = "";

        $.get('{{ route('admin.admin_users.roles') }}?type=' + type + '&id=' + id, function (response) {
            var options = '<option value=""></option>';
            if (response) {
                $.each(response, function (key, value) {

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
        @if (isset($user))
            @if ($user->user_role == 'palika-user')
                getUserSelectRoleData($('select[name="district_user_id"]'), 'district', "{{ $user->province_user_id }}", "{{ $user->district_user_id }}");
            @endif
            @if ($user->user_role == 'facility-user')
                getUserSelectRoleData($('select[name="district_user_id"]'), 'district', "{{ $user->province_user_id }}", "{{ $user->district_user_id }}");
                getUserSelectRoleData($('select[name="palika_user_id"]'), 'palika', "{{ $user->district_user_id }}", "{{ $user->palika_user_id }}");
            @endif
        @endif
    });

</script>
<script>
    // script for user address change
    $(document).on('change', 'select[name="province"]', function () {
        $('select[name="municipality"]').html('<option value=""></option>');
        $('select[name="district"]').html('<option value=""></option>');
        $('select[name="health_post_name"]').html('<option value=""></option>');
        getProvinceDistrictData($('select[name="district"]'), 'district', $(this).val());
    });
    $(document).on('change', 'select[name="district"]', function () {
        $('select[name="municipality"]').html('<option value=""></option>');
        $('select[name="health_post_name"]').html('<option value=""></option>');
        getProvinceDistrictData($('select[name="municipality"]'), 'municipality', $(this).val());
    });
    $(document).on('change', 'select[name="municipality"]', function () {
        $('select[name="health_post_name"]').html('<option value=""></option>');
        getProvinceDistrictData($('select[name="health_post_name"]'), 'health_post_name', $(this).val());
    });


    function getProvinceDistrictData($this, type, id, selected) {
        if (!selected)
            selected = "";

        $.get('{{ route('admin.admin_users.address') }}?type=' + type + '&id=' + id, function (response) {
            var options = '<option value=""></option>';
            if (response) {
                $.each(response, function (key, value) {

                    if (type !== 'health_post_name')
                        key = value;

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
        @if (isset($user))
            getProvinceDistrictData($('select[name="district"]'), 'district', "{{ $user->province }}", "{{ $user->district }}");
            getProvinceDistrictData($('select[name="municipality"]'), 'municipality', "{{ $user->district }}", "{{ $user->municipality }}");
            getProvinceDistrictData($('select[name="health_post_name"]'), 'health_post_name', "{{ $user->municipality }}", "{{ $user->health_post_name }}");
        @endif
    });

</script>