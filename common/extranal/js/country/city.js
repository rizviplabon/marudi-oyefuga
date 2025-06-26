$(document).ready(function () {
    "use strict";

    $('#country_select').change(function() {
        var countryId = $(this).val();
        var provinceSelect = $('#province_select');
        
        if (countryId) {
            // provinceSelect.prop('disabled', true);
            $.ajax({
                url: 'country/province/getProvincesByCountry',
                type: 'GET',
                data: { country_id: countryId },
                dataType: 'json',
                success: function(response) {
                    provinceSelect.empty();
                    provinceSelect.append('<option value="">' + 'Select Province' + '</option>');
                    
                    $.each(response, function(key, value) {
                        provinceSelect.append('<option value="' + value.id + '">' + value.province + '</option>');
                    });
                    
                    provinceSelect.prop('disabled', false);
                },
                error: function() {
                    provinceSelect.prop('disabled', true);
                    toastr.error('Error loading provinces');
                }
            });
        } else {
            provinceSelect.empty();
            provinceSelect.append('<option value="">' + 'Select Province' + '</option>');
            provinceSelect.prop('disabled', true);
        }
    });


    $(document).on("click", ".editbutton", function () {
        var iid = $(this).attr('data-id');
        $('#editCityForm').trigger("reset");
        $.ajax({
            url: 'country/city/editCityByJason?id=' + iid,
            method: 'GET',
            data: '',
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $("#editCityForm #id").val(response.city.id);
                    $("#editCityForm #city").val(response.city.city);
                    // $("#editCityForm #province").val(response.city.province).trigger('change');
                    $("#editCityForm #country").val(response.city.country).trigger('change');
                    $('#myModal2').modal('show');
                }
            }
        });
    });

    $(document).on("click", ".delete", function () {
        var id = $(this).attr('data-id');
        if (confirm("Are you sure you want to delete this city?")) {
            $.ajax({
                url: 'country/city/delete?id=' + id,
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



    $('#addCityForm').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: 'country/city/addNew',
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

$(document).ready(function () {
    "use strict";
    
    $("#edit_country_select").change(function () {
        var country = $(this).val();
        $("#edit_province_select").html("<option value=''>Select Province</option>");
        
        $.ajax({
            url: "country/getProvinceByCountryIdByJason?id=" + country,
            method: "GET",
            data: "",
            dataType: "json",
            success: function (response) {
                $.each(response.provinces, function (key, value) {
                    $("#edit_province_select").append($("<option>").text(value.province).val(value.id));
                });
            }
        });
    });

    $(".editbutton").click(function () {
        var id = $(this).data('id');
        $('#myModal2').modal('show');
        $.ajax({
            url: 'country/city/editCityByJason?id=' + id,
            method: 'GET',
            data: '',
            dataType: 'json',
            success: function (response) {
                $('#editCityForm').find('[name="id"]').val(response.city.id);
                $('#editCityForm').find('[name="city"]').val(response.city.city);
                
                // Set country and trigger change to load provinces
                $('#edit_country_select').val(response.city.country).trigger('change');
                
                // Set province after a small delay to ensure provinces are loaded
                setTimeout(function() {
                    $('#edit_province_select').val(response.city.province);
                }, 500);
            }
        });
    });
});