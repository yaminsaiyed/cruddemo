<link rel="stylesheet" href="{{ asset('public/admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
<script src="{{ asset('public/admin/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script type="text/javascript">
    var DATATABLE_LANGUAGE = {
        "lengthMenu": "_MENU_",
        "zeroRecords": "No Record Found",
        "info": "_START_ to _END_ of _TOTAL_ entries",
        // "infoEmpty": "No records available",
        "infoFiltered": "(filtered from _MAX_ total records)"
    };
    var DATATABLE_PROCESSING = true;
    var DATATABLE_RESPONSIVE = true;
    var DATATABLE_SERVERSIDE = true;
    var DATATABLE_SEARCHING = false;
    var DATATABLE_BSTATESAVE = false;
    var DATATABLE_PAGELENGTH = 10;
    var DATATABLE_DOM = "<'row'<'col-sm-12'tr>>" + "<'row align-items-center'<'col-sm-6'i><'col-sm-6'p>>";
    /*var DATATABLE_DOM="<'row'<'col-sm-12'tr>>"+"<'row'<'col-sm-6'i><'col-sm-6'p>>"+"<'row'<'col-sm-6'l><'col-sm-6'f>>";*/
    var DATATABLE_LENGTHMENU = [
        [10, 20, 50, 100, 150],
        [10, 20, 50, 100, 150]
    ]; // change per page values here



    $(document).ready(function() {
        //================= FILTER BOX ACTION START =================//
        $(".filter-input").keyup(function() {
            table.column($(this).data('column'))
                .search($(this).val())
                .draw();
        });

        $(".filter-select").change(function() {
            table.column($(this).data('column'))
                .search($(this).val())
                .draw();
        });
        $(".filter-date").change(function() {
            table.column($(this).data('column'))
                .search($(this).val())
                .draw();
        });

        $(".reset_filter").click(function() {
            $('.filter-input').val('');
            $(".filter-select").val('');
            $(".filter-date").val('');
            $(".filter-select").select2();
            table_id.dataTable().fnDraw();

        });
        //================= FILTER BOX ACTION END =================//

        //================= MULTIPLE DELETE START=================//
        $(document).on('click', '.delete_records', function() {

            var data_id = [];
            $('.checkboxes').each(function() {
                if ($(this).is(":checked")) {
                    data_id.push($(this).val());
                }
            });

            if (data_id.length > 0) {
                if (confirm("are you sure you want to delete record ?")) {
                    $.ajax({
                        url: delete_url,
                        method: "GET",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            data_id: JSON.stringify(data_id)
                        },
                        success: function(data) {
                            table_id.DataTable().ajax.reload();
                            if (data.status == true) {
                                var success_html = SUCCESS_MESSAGE;
                                $(".flash_messages").html(success_html.replace("FLASH_MESSAGE", data.message));
                                if ($("html, body").animate({
                                        scrollTop: 0
                                    }, "slow")) {
                                    setTimeout(function() {
                                        $('.alert').alert('close');
                                    }, 5000);
                                }
                            } else {
                                var error_html = ERROR_MESSAGE;
                                $(".flash_messages").html(error_html.replace("FLASH_MESSAGE", data.message));
                                if ($("html, body").animate({
                                        scrollTop: 0
                                    }, "slow")) {
                                    setTimeout(function() {
                                        $('.alert').alert('close');
                                    }, 5000);
                                }

                            }
                        }
                    });
                }
            } else {
                var error_html = ERROR_MESSAGE;
                $(".flash_messages").html(error_html.replace("FLASH_MESSAGE", "Please select at least one record"));
                if ($("html, body").animate({
                        scrollTop: 0
                    }, "slow")) {
                    setTimeout(function() {
                        $('.alert').alert('close');
                    }, 5000);
                }
                return false;
            }
        });

        //================= MULTIPLE DELETE END=================//


        //================= SELECT ALL DELETE START =================//
        $('.check_all').on('change', function() {
            table.$('.checkboxes:checkbox').prop('checked', $(this).prop('checked'));
        });

        $(document).on('change', '.checkboxes', function() {
            if ($(this).is(':checked')) {
                if ($('.checkboxes:checked').length == $('.checkboxes').length) {
                    $('.check_all').prop('checked', true);

                } else {
                    $('.check_all').prop('checked', false);

                }
            } else {
                $('.check_all').prop('checked', false);
            }
        });

        //================= SELECT ALL DELETE END =================//


        //================= FILTER BOX HIDE SHOW START=================//
        $(".filter_btn").on('click', function() {
            $(".filter_box").fadeToggle('slow');
        });
        //================= FILTER BOX HIDE SHOW END=================//



        //================= CHANGE STATUS START=================//

        $(document).on("change", ".on_off", function() {

            var status_id = $(this).val();
            var status = 0;
            if ($(this).is(":checked")) {
                status = 1;
            }

            $.ajax({
                url: status_url,
                method: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    status_id: status_id,
                    status: status
                },
                success: function(data) {
                    table_id.DataTable().ajax.reload();
                    if (data.status == true) {
                        var success_html = SUCCESS_MESSAGE;
                        $(".flash_messages").html(success_html.replace("FLASH_MESSAGE", data.message));

                        if ($("html, body").animate({
                                scrollTop: 0
                            }, "slow")) {
                            setTimeout(function() {
                                $('.alert').alert('close');
                            }, 5000);
                        }

                    } else {
                        var error_html = ERROR_MESSAGE;
                        $(".flash_messages").html(error_html.replace("FLASH_MESSAGE", data.message));
                        if ($("html, body").animate({
                                scrollTop: 0
                            }, "slow")) {
                            setTimeout(function() {
                                $('.alert').alert('close');
                            }, 5000);
                        }

                    }
                }
            });



        });
        //================= CHANGE STATUS END=================//

    });
</script>

<?php /*{ // Language details
            "lengthMenu": "_MENU_",
            "zeroRecords": "Nothing found - sorry",
            "info": "_START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "No records available",
            "infoFiltered": "(filtered from _MAX_ total records)"
                    {
              "decimal":        "",
              "emptyTable":     "No data available in table",
              "info":           "Showing _START_ to _END_ of _TOTAL_ entries",
              "infoEmpty":      "Showing 0 to 0 of 0 entries",
              "infoFiltered":   "(filtered from _MAX_ total entries)",
              "infoPostFix":    "",
              "thousands":      ",",
              "lengthMenu":     "Show _MENU_ entries",
              "loadingRecords": "Loading...",
              "processing":     "Processing...",
              "search":         "Search:",
              "zeroRecords":    "No matching records found",
              "paginate": {
                  "first":      "First",
                  "last":       "Last",
                  "next":       "Next",
                  "previous":   "Previous"
              },
              "aria": {
                  "sortAscending":  ": activate to sort column ascending",
                  "sortDescending": ": activate to sort column descending"
              }
          }
 }*/ ?>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: #fff;
        -webkit-transition: .4s;
        transition: .4s
    }

    input:checked+.slider {
        background-color: #3c8dbc
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #3c8dbc
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px)
    }

    .slider.round {
        border-radius: 34px
    }

    .slider.round:before {
        border-radius: 50%
    }
</style>