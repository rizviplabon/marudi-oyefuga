$(document).ready(function () {
    "use strict";

    $(document).on("click", ".editbutton", function () {
        var iid = $(this).attr('data-id');
        $('#editCityForm').trigger("reset");
        $.ajax({
            url: 'city/editCityByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $("#editCityForm #id").val(response.city.id);
                    $("#editCityForm #name").val(response.city.name);
                    $("#editCityForm #province").val(response.city.province).trigger('change');
                    $('#myModal2').modal('show');
                }
            }
        });
    });

    $(document).on("click", ".delete", function () {
        var id = $(this).attr('data-id');
        if (confirm("Are you sure you want to delete this city?")) {
            $.ajax({
                url: 'city/delete?id=' + id,
                method: 'GET',
                data: '',
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success('City deleted successfully');
                        window.location.reload();
                    } else {
                        toastr.error('Error deleting city');
                    }
                }
            });
        }
    });

    $('#editCityForm').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: 'city/addNew',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#myModal2').modal('hide');
                    toastr.success('City updated successfully');
                    window.location.reload();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    $('#addCityForm').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: 'city/addNew',
            method: 'POST',
            data: data,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $('#myModal').modal('hide');
                    toastr.success('City added successfully');
                    window.location.reload();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    var table = $('#editable-sample').DataTable({
        responsive: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            {
                extend: 'print',
                exportOptions: {
                    columns: [0, 1],
                }
            },
        ],
        aLengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        iDisplayLength: 100,
        order: [[0, "desc"]],
        language: {
            lengthMenu: "_MENU_",
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        }
    });

    table.buttons().container().appendTo('.custom_buttons');
});