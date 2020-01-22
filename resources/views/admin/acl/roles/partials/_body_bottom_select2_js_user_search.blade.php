<!-- Select2 4.0.0 -->
<script type="text/javascript">
    $('#user_search').select2({
        theme: "bootstrap",
        placeholder: 'Search users...',
        minimumInputLength: 3,
        ajax: {
            delay: 250,
            url: "{{ route('admin.users.search') }}",
            dataType: 'json',
            data: function (params) {
                var queryParameters = {
                    query: params.term
                };

                return queryParameters;
            },
            processResults: function (data) {
                return {
                    results: data
                };
            }
        },
        tags: true
    });

    $("#btn-add-user").on("click", function () {
        var userName, userFullname, userEnabled, userStatus, idCell, fullnameCel, nameCel, enabledCel, actionCel;
        // Get ID.
        var userID = $('#user_search').val();
        // Build URL based on route and replace "{user}" with ID.
        var urlShowUser = '{!! url("admin/users/{users}") !!}'.replace('{users}', userID);
        // Capture CSRF token from meta header.
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        // Parse table values based on selected text.
        $.ajax({
            url: '{!! route("admin.users.get-info") !!}',
            type: 'POST',
            data: {
                _token: CSRF_TOKEN,
                id: userID
            },
            dataType: 'JSON',
            success: function (data) {
                //console.log(data);
                userName = data['username'];
                userFullname = data['email'];
                userEnabled = data['enabled'];

                if(1 == userEnabled) {
                    userStatus = '<i class="fa fa-fw fa-lg fa-check txt-color-green"></i>';
                }
                else {
                    userStatus = '<i class="fa fa-fw fa-lg fa-check txt-color-red"></i>';
                }

                // Build table cells.
                idCell     = '<td class="hidden" rowname="id">' + userID + '</td>';
                fullnameCel    = '<td>' + '<a href="' + urlShowUser + '">' + userFullname + '</a>' + '</td>';
                nameCel    = '<td>' + '<a href="' + urlShowUser + '">' + userName + '</a>' + '</td>';
                enabledCel = '<td>' + userStatus + '</td>';
                actionCel  = '<td style="text-align: right"><a class="btn-remove-user" href="#" title="{{ trans('admin.general.button.remove-user') }}"><i class="fa fa-fw fa-lg fa-trash-o txt-muted txt-color-red deletable"></i></a></td>';

                // Add selected item only if not already in list.
                if ( $('#tbl-users tr > td[rowname="id"]:contains(' + userID + ')').length == 0 ) {
                    $('#tbl-users > tbody:last-child').append('<tr>' + idCell + fullnameCel + nameCel + enabledCel + actionCel + '</tr>');
                }

            }
        });

    });

    $('body').on('click', '.btn-remove-user', function() {
        $(this).parent().parent().remove();
    });
</script>
