<script>

    // this variable is used to get text while adding text
    var selectedValueText = "";
    $('[name="indicator_indicator"]').select2({
        ajax: {
            url: "{{ route('admin.instance.indicator') }}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    search: params.term,
                    page: params.page,
                    program: $('select[name="indicator_program"]').val()
                };
            },
            processResults: function (data, params) {

                return {
                    results: data.items
                };
            },
            cache: true
        },
        placeholder: 'Search indicator',
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 3,
        templateResult: formatIndicator,
        templateSelection: formatIndicatorSelection
    });

    function formatIndicator (data) {
        if (data.loading) {
            return data.name;
        }

        return '<strong>' + data.program + '</strong><br />' + data.name;
    }

    function formatIndicatorSelection (data) {
        if (data.program || data.name) {
            selectedValueText = data.name;
            return data.name;
        }
        return data.text;
    }
    /*
    var $facilitySelect = $('[name="facility"]').select2({
        ajax: {
            url: "{{-- route('admin.instance.facility') --}}",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    search: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {

                return {
                    results: data.items
                };
            },
            cache: true
        },
        placeholder: 'Search facility',
        minimumInputLength: 3,
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        templateResult: function (data) {
            if (data.loading) {
                return data.name;
            }

            return data.name;
        },
        templateSelection: function (data) {
            if (data.name)
                return data.name;
            return data.text;
        }
    });
    */
    var indicatorValueChange = true;
    $('[name="indicator_program"]').on('change', function () {
        if (indicatorValueChange === true) {
            $('[name="indicator_indicator"]').val('').trigger('change');
        }
        indicatorValueChange = true;
    });
</script>