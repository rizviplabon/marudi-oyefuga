$(document).ready(function () {
    "use strict";
    $(".table").on("click", ".editbutton", function () {
        var iid = $(this).attr('data-id');
        $('#myModal2').modal('show');
        $.ajax({
            url: 'country/province/editProvinceByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
            success: function (response) {
                $('#provinceEditForm').find('[name="id"]').val(response.province.id).end();
                $('#provinceEditForm').find('[name="country"]').val(response.province.country).end();
                $('#provinceEditForm').find('[name="province"]').val(response.province.province).end();
            }
        });
    });
});

$(document).ready(function () {
    var table = $('#editable-sample').DataTable({
        responsive: true,
        dom: "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>"
             + "<'row'<'col-sm-12'tr>>"
             + "<'row'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            {
                extend: 'print'
            }
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
            url: "common/assets/DataTables/languages/" + language + ".json"
        }
    });
    table.buttons().container().appendTo('.custom_buttons');
});