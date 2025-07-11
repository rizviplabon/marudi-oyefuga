"use strict";

$(document).ready(function () {
  $('#country_select2').change(function() {
    var countryId = $(this).val();
    if (countryId) {
      $('#province_select2').prop('disabled', false);
      $.ajax({
        url: 'country/city/getProvinceByCountryIdByJason?country=' + countryId,
        method: 'GET',
        data: '',
        dataType: 'json',
        success: function(response) {
          $('#province_select2').html(response.content).val('').trigger('change');
        }
      });
    } else {
      $('#province_select2').prop('disabled', true).html('<option value="">' + select_province + '</option>');
      $('#city_select2').prop('disabled', true).html('<option value="">' + select_city + '</option>');
    }
  });
  
  $('#province_select2').change(function() {
    var provinceId = $(this).val();
    if (provinceId) {
      $('#city_select2').prop('disabled', false);
      $.ajax({
        url: 'country/city/getCityByProvinceIdByJason?province=' + provinceId,
        method: 'GET',
        data: '',
        dataType: 'json',
        success: function(response) {
          $('#city_select2').html(response.content).val('').trigger('change');
        }
      });
    } else {
      $('#city_select2').prop('disabled', true).html('<option value="">' + select_city + '</option>');
    }
  });
  
  });

$(document).ready(function () {
  "use strict";
  $(".table").on("click", ".editbutton", function () {
    "use strict";
    var iid = $(this).attr("data-id");
    $("#img").attr("src", "uploads/cardiology-patient-icon-vector-6244713.jpg");
    $("#editPatientForm").trigger("reset");
    $.ajax({
      url: "patient/editPatientByJason?id=" + iid,
      method: "GET",
      data: "",
      dataType: "json",
      success: function (response) {
        "use strict";
        $("#editPatientForm")
          .find('[name="id"]')
          .val(response.patient.id)
          .end();
        $("#editPatientForm")
          .find('[name="name"]')
          .val(response.patient.name)
          .end();
        $("#editPatientForm")
          .find('[name="password"]')
          .val(response.patient.password)
          .end();
        $("#editPatientForm")
          .find('[name="email"]')
          .val(response.patient.email)
          .end();
        $("#editPatientForm")
          .find('[name="address"]')
          .val(response.patient.address)
          .end();
        $("#editPatientForm")
          .find('[name="phone"]')
          .val(response.patient.phone)
          .end();
        $("#editPatientForm")
          .find('[name="sex"]')
          .val(response.patient.sex)
          .end();
        $("#editPatientForm")
          .find('[name="cross_con"]')
          .val(response.patient.cross_con)
          .trigger('change');
          $("#editPatientForm")
          .find('[name="nagative_balance"]')
                .val(response.patient.nagative_balance)
          .trigger('change');
        $("#editPatientForm")
          .find('[name="birthdate"]')
          .val(response.patient.birthdate)
          .end();
        $("#editPatientForm")
          .find('[name="bloodgroup"]')
          .val(response.patient.bloodgroup)
          .end();
        $("#editPatientForm")
          .find('[name="p_id"]')
          .val(response.patient.patient_id)
          .end();
          if (response.patient.country) {
            $('#country_select2').val(response.patient.country).trigger('change');
            setTimeout(function() {
              if (response.patient.province) {
                $('#province_select2').val(response.patient.province).trigger('change');
                setTimeout(function() {
                  if (response.patient.city) {
                    $('#city_select2').val(response.patient.city).trigger('change');
                  }
                }, 500);
              }
            }, 500);
          }
        if (response.patient.age !== null) {
          var age = response.patient.age.split("-");
          $("#editPatientForm").find('[name="years"]').val(age[0]).end();
          $("#editPatientForm").find('[name="months"]').val(age[1]).end();
          $("#editPatientForm").find('[name="days"]').val(age[2]).end();
        }
        if (
          typeof response.patient.img_url !== "undefined" &&
          response.patient.img_url != ""
        ) {
          $("#img").attr("src", response.patient.img_url);
        }

        if (response.doctor !== null) {
          var option1 = new Option(
            response.doctor.name + "-" + response.doctor.id,
            response.doctor.id,
            true,
            true
          );
        } else {
          var option1 = new Option(" " + "-" + "", "", true, true);
        }
        $("#editPatientForm")
          .find('[name="doctor"]')
          .append(option1)
          .trigger("change");

        $(".js-example-basic-single.doctor")
          .val(response.patient.doctor)
          .trigger("change");

        // Set parent patient if exists
        if (response.patient.parent_patient_id) {
          // Create option for existing parent and set it
          $.ajax({
            url: "patient/getPatientByJason?id=" + response.patient.parent_patient_id,
            method: "GET",
            dataType: "json",
            success: function(parentResponse) {
              var parentOption = new Option(
                parentResponse.patient.name + " (ID: " + parentResponse.patient.id + " - Phone: " + parentResponse.patient.phone + ")",
                parentResponse.patient.id,
                true,
                true
              );
              $("#parent_patient_select_edit").append(parentOption).trigger("change");
            }
          });
        } else {
          // Clear the parent selection
          $("#parent_patient_select_edit").val(null).trigger("change");
        }

        $("#myModal2").modal("show");
      },
    });
  });

  $(".table").on("click", ".inffo", function () {
    "use strict";
    var iid = $(this).attr("data-id");

    $(".patientIdClass").html("").end();
    $(".nameClass").html("").end();
    $(".emailClass").html("").end();
    $(".addressClass").html("").end();
    $(".genderClass").html("").end();
    $(".birthdateClass").html("").end();
    $(".bloodgroupClass").html("").end();
    $(".patientidClass").html("").end();
    $(".doctorClass").html("").end();
    $(".ageClass").html("").end();
    $(".phoneClass").html("").end();
    $.ajax({
      url: "patient/getPatientByJason?id=" + iid,
      method: "GET",
      data: "",
      dataType: "json",
      success: function (response) {
        "use strict";

        $(".patientIdClass").append(response.patient.id).end();
        $(".nameClass").append(response.patient.name).end();
        $(".emailClass").append(response.patient.email).end();
        $(".addressClass").append(response.patient.address + " , " + response.city.city + " , " + response.province.province + " , " + response.country.country).end();
        $(".phoneClass").append(response.patient.phone).end();
        $(".genderClass").append(response.patient.sex).end();
        $(".birthdateClass").append(response.patient.birthdate).end();
        $(".ageClass").append(response.age).end();
        $(".bloodgroupClass").append(response.patient.bloodgroup).end();
        $(".patientidClass").append(response.patient.patient_id).end();

        if (response.doctor !== null) {
          $(".doctorClass").append(response.doctor.name).end();
        } else {
          $(".doctorClass").append("").end();
        }

        $("#img1").attr(
          "src",
          "uploads/cardiology-patient-icon-vector-6244713.jpg"
        );

        if (
          typeof response.patient.img_url !== "undefined" &&
          response.patient.img_url != ""
        ) {
          $("#img1").attr("src", response.patient.img_url);
        }

        $("#infoModal").modal("show");
      },
    });
  });
});

$(document).ready(function () {
  "use strict";
  var table = $("#editable-sample").DataTable({
    responsive: true,
    //   dom: 'lfrBtip',

    processing: true,
    serverSide: true,
    searchable: true,
    ajax: {
      url: "patient/getPatient",
      type: "POST",
    },
    scroller: {
      loadingIndicator: true,
    },
    dom:
      "<'row'<'col-sm-3'l><'col-sm-5 text-center'B><'col-sm-4'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",

    buttons: [
      { extend: "copyHtml5", exportOptions: { columns: [0, 1, 2] } },
      { extend: "excelHtml5", exportOptions: { columns: [0, 1, 2] } },
      { extend: "csvHtml5", exportOptions: { columns: [0, 1, 2] } },
      { extend: "pdfHtml5", exportOptions: { columns: [0, 1, 2] } },
      { extend: "print", exportOptions: { columns: [0, 1, 2] } },
    ],
    aLengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    iDisplayLength: 100,
    order: [[0, "desc"]],

    language: {
      lengthMenu: "_MENU_",
      search: "_INPUT_",
      url: "common/assets/DataTables/languages/" + language + ".json",
    },
  });
  table.buttons().container().appendTo(".custom_buttons");
});

$(document).ready(function () {
  "use strict";
  $("#doctorchoose").select2({
    placeholder: select_doctor,
    allowClear: true,
    ajax: {
      url: "doctor/getDoctorinfo",
      type: "post",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term, // search term
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });
  $("#doctorchoose1").select2({
    placeholder: select_doctor,
    allowClear: true,
    ajax: {
      url: "doctor/getDoctorInfo",
      type: "post",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term, // search term
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });

  // Guardian/Primary Contact Select2 for Add New Modal
  $("#parent_patient_select").select2({
    placeholder: "Select Guardian/Primary Contact (Optional)",
    allowClear: true,
    ajax: {
      url: "patient/getAvailableParents",
      type: "get",
      dataType: "json",
      delay: 250,
      data: function (params) {
        return {
          term: params.term, // search term
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });

  // Guardian/Primary Contact Select2 for Edit Modal
  $("#parent_patient_select_edit").select2({
    placeholder: "Select Guardian/Primary Contact (Optional)",
    allowClear: true,
    ajax: {
      url: "patient/getAvailableParents",
      type: "get",
      dataType: "json",
      delay: 250,
      data: function (params) {
        var currentPatientId = $("#editPatientForm").find('[name="id"]').val();
        return {
          term: params.term, // search term
          exclude_id: currentPatientId // exclude current patient from list
        };
      },
      processResults: function (response) {
        return {
          results: response,
        };
      },
      cache: true,
    },
  });
});

$(document).ready(function () {
  "use strict";
  $(".flashmessage").delay(3000).fadeOut(100);
});

$(document).ready(function () {
  "use strict";
  // $(".table").on("click", ".negative_balance_switcher", function () {
  $(".table").on('change', '.nagative_balance_switcher', function() {
    var patientId = $(this).data('id');
    var isChecked = $(this).is(':checked');
    var nagativeBalance = isChecked ? 'Yes' : 'No';
    // var nagativeBalance = $(this).prop('checked') ? 'Yes' : 'No';
    
    $.ajax({
      url: 'patient/updateNagativeBalance',
      type: 'POST',
      data: {
        id: patientId,
        nagative_balance: nagativeBalance
      },
      success: function(response) {
        var data = JSON.parse(response);
        if (data.status === 'success') {
          toastr.success(data.message);
        } else {
          toastr.error(data.message);
        }
      },
      error: function() {
        toastr.error('An error occurred while updating negative balance status');
      }
    });
  });
});
