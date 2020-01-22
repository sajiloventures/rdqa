{!! Html::script('smartadmin/js/datatable.js') !!}
{!! Html::script('smartadmin/js/datatable.bootstrap.js') !!}
{{--{!! Html::script('smartadmin/js/datatables/button.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/button.flash.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/jszip.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/pdf.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/vfs_fonts.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/html5.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/print.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/colvis.js') !!}--}}
{{--{!! Html::script('smartadmin/js/datatables/responsive.js') !!}--}}

{{--{!! Html::script(config('neptrox.asset_path.admin.moment') . 'moment.js') !!}--}}
<script>

    function initialCustomDataTables(dataTableConfigVariable) {
        var table = '';
        (function (options) {

            var route_url = options.dataTableConfigVariable.route_url;
            var selectedTable = options.dataTableConfigVariable.selector_table;
            var selectedSearchField = options.dataTableConfigVariable.selector_search_field;
            var additionalParameters = options.dataTableConfigVariable.additional_parameters;
            var columns = options.dataTableConfigVariable.columns;
            var order = options.dataTableConfigVariable.orderColumn;
            var desc = options.dataTableConfigVariable.orderDesc;
            var lengthMenu = options.dataTableConfigVariable.lengthMenu;
            var paginateLength = options.dataTableConfigVariable.pagination;
            var enableButtons = options.dataTableConfigVariable.buttons;
            var columnToDisplayWhileButtonEnable = options.dataTableConfigVariable.columnToDisplayWhileButtonEnable;
            var enableEachColumnSearch = options.dataTableConfigVariable.enableEachColumnSearch;
            var filterByDateRange = options.dataTableConfigVariable.filterByDateRange;
            var filterByDateRangeInputFieldSelector = options.dataTableConfigVariable.filterByDateRangeInputFieldSelector;

            order = setFalseIfUndefined(order);
            enableButtons = setFalseIfUndefined(enableButtons);
            filterByDateRange = setFalseIfUndefined(filterByDateRange);
            filterByDateRangeInputFieldSelector = setFalseIfUndefined(filterByDateRangeInputFieldSelector);
            enableEachColumnSearch = setFalseIfUndefined(enableEachColumnSearch);
            paginateLength = setFalseIfUndefined(paginateLength, 50);
            selectedTable = setFalseIfUndefined(selectedTable, $('table.table'));
            selectedSearchField = setFalseIfUndefined(selectedSearchField, $('#searchField'));

            function setFalseIfUndefined(variable, defaultValue) {
                if (!defaultValue)
                    defaultValue = false;

                if (variable == 'undefined' || variable == null || variable == "")
                    return defaultValue;
                else
                    return variable;
            }

            if (desc == 'undefined' || desc == null || desc == "") {
                desc = 'asc';
            } else {
                if (desc == 'asc')
                    desc = 'asc';
                else
                    desc = 'desc';
            }

            if (additionalParameters == 'undefined' || additionalParameters == null || additionalParameters == "") {
                additionalParameters = {
                    _token: $('meta[name=csrf-token]').attr("content")
                };
            } else {
                additionalParameters = $.extend({}, additionalParameters, {
                    _token: $('meta[name=csrf-token]').attr("content")
                });
            }


            if (lengthMenu == 'undefined' || lengthMenu == null || lengthMenu == "") {
                var paginationArray = [10, 25, 50, 100];
                var paginationArray1 = [10, 25, 50, 100];
                if($.inArray(paginateLength, paginationArray) == -1)
                    paginationArray.push(paginateLength);
                paginationArray = paginationArray.sort(function(a, b){return a-b});
                paginationArray1.push(-1);
                paginationArray.push("All");
                lengthMenu = [paginationArray1, paginationArray];
            }

            var config = {
                "dom": '<t>r' +
                '<"card-footer card-pagination"<"row"<"col-md-12 text-right"><"col-md-8"p><"col-md-4"l>>>',
                "lengthMenu": lengthMenu,
                "pageLength": paginateLength,
                "oLanguage": {
                    "sLengthMenu": " _MENU_ ",
                    "sSearchPlaceholder": "Search",
                    "oPaginate": {
                        "sNext": "<span aria-hidden='true'>»</span><span class='sr-only'>Next</span>",
                        "sPrevious": "<span aria-hidden='true'>«</span><span class='sr-only'>Previous</span>"
                    }
                },
                processing: true,
                serverSide: true,
                ajax: {
                    type: 'POST',
                    url: route_url.dataTable_url,
                    data: additionalParameters
                },
                "initComplete": function(settings, json) {
                    var colspan = selectedTable.find('thead tr th').length;
                    selectedTable.find('.dataTables_empty').attr('colspan', colspan);
                },
                responsive: true,
                columns: columns
            };

            if (order !== false)
                $.extend(config, {'order': [[order, desc]]});


            var thCount = 0;
            if (enableEachColumnSearch)
            {
                $('body').append('<style>' +
                    'tfoot {' +
                    'display: table-header-group;' +
                    '}' +
                    '</style>');
                selectedTable.find('tfoot th').each( function () {
                    if ($(this).attr('data-search') === undefined) {
                        var title = $(this).text();
                        if (enableEachColumnSearch !== true) {
                            var $data = enableEachColumnSearch.filter(function (data) {
                                return data.index === thCount;
                            });
                            if ($data.length) {
                                if ($data[0].values) {
                                    var select = $('<select class="form-control"><option value="">All</option></select>');

                                    $.each($data[0].values.sort(), function (d, j) {
                                        select.append('<option value="' + j + '">' + j + '</option>')
                                    });
                                    $(this).html(select);
                                } else if ($data[0].datepicker) {
                                    addInputField($(this), title, 'datepicker', 'data-dateformat="yy-mm-dd"');
                                } else
                                    addInputField($(this), title);
                            }
                            else
                                addInputField($(this), title);
                        } else
                            addInputField($(this), title);
                    }
                    thCount++;
                });
            }
            
            function addInputField($this, title, extraClass, extraAttribute) {
                $this.html('<input type="text" class="form-control ' + extraClass + '" ' + extraAttribute + ' placeholder="Search ' + title + '" />');
            }

            //initialize dataTables
            table = selectedTable.DataTable(config);


            if (enableEachColumnSearch)
            {
                // Apply the search
                table.columns().every( function () {
                    var that = this;
                    $( 'input, select', this.footer() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                            that.search( this.value ).draw();
                        }
                    } );
                } );
            }

            selectedSearchField.keyup(function(){
                table.search($(this).val()).draw() ;
            });


            //toggle all checkbox checked or unchecked
            $('body').on('click', 'input[name="checkAll"]', function () {
                var checkBoxes = $("input[name=checkbox\\[\\]]");
                checkBoxes.prop("checked", $(this).prop("checked"));
            });

            if (enableButtons === true) {

                var columnsDisplay = columnToDisplayWhileButtonEnable = ':visible :not(:last-child)';

                if (columnToDisplayWhileButtonEnable == 'undefined' || columnToDisplayWhileButtonEnable == null || columnToDisplayWhileButtonEnable == "") {
                    var totalColumns = selectedTable.find('thead th').length;
                    columnsDisplay = [0];
                    for(var i = 0; i < totalColumns; i++)
                        columnsDisplay.push(i);
                }


                // add download script
                var buttons = new $.fn.dataTable.Buttons(table, {
                    buttons: [
                        //{ extend: 'copy', className: 'btn btn-info' },
                        {
                            extend: 'csv',
                            className: 'btn btn-info',
                            exportOptions: {
                                columns: columnsDisplay
                            }
                        },
                        {
                            extend: 'excel',
                            className: 'btn btn-info',
                            exportOptions: {
                                columns: columnsDisplay
                            }
                        },
                        //{ extend: 'pdf', className: 'btn btn-info' },
                        {
                            extend: 'print',
                            className: 'btn btn-info',
                            exportOptions: {
                                columns: columnsDisplay
                            }
                        }
                    ]
                }).container().appendTo($('#buttons'));
            }

            if (filterByDateRange === true && filterByDateRangeInputFieldSelector) {
//                filterByDateRangeInputFieldSelector.datepicker();
                filterByDateRangeInputFieldSelector.on('change keyup', function () {
//                    setValueInInputField($(this));
                    var fromDate = $('#fromDate').val();
                    var toDate = $('#toDate').val();

                    if (fromDate && toDate)
                        table.search(fromDate + '~' + toDate).draw() ;
                    else
                        table.search("").draw()
                });
            }

//            function setValueInInputField(selector) {
//                var date = moment(selector.val(), "MM/DD/YYYY", true).format('YYYY-MM-DD');
//                if (date === 'Invalid date')
//                    return null;
//                selector.val(date);
//                return date;
//            }

        })({dataTableConfigVariable:dataTableConfigVariable});
        return table;
    }

    var table1 = initialCustomDataTables(dataTableConfigVariable);

    function reloadDataTables(table) {
        table.ajax.reload(null, false);
    }



</script>