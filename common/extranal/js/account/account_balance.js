$(document).ready(function () {
    "use strict";
    $(".table").on("click", ".editbutton", function () {
      //  e.preventDefault(e);
      // Get the record's ID via attribute
      var iid = $(this).attr("data-id");
      $("#editAccountForm").trigger("reset");
      $.ajax({
        url: "account/editAccountByJason?id=" + iid,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          // Populate the form fields with the data returned from server
          $("#editAccountForm")
            .find('[name="id"]')
            .val(response.account.id)
            .end();
          $("#editAccountForm")
            .find('[name="date"]')
            .val(response.account.date)
            .end();
          $("#editAccountForm")
            .find('[name="deposit_amount"]')
            .val(response.account.deposit_amount)
            .end();
          $("#editAccountForm")
            .find('[name="balance_amount"]')
            .val(response.account.balance_amount)
            .end();
          $("#editAccountForm")
            .find('[name="deposit_type"]')
            .val(response.account.deposit_type)
            .trigger("change");
          $("#editAccountForm")
            .find('[name="account_no"]')
            .val(response.account.account_no)
            .end();
          $("#editAccountForm")
            .find('[name="transaction_id"]')
            .val(response.account.transaction_id)
            .end();
          var option1 = new Option(
            response.patient.name + "-" + response.patient.id,
            response.patient.id,
            true,
            true
          );
          $("#editAccountForm")
            .find('[name="patient"]')
            .append(option1)
            .trigger("change");
          $("#myModal2").modal("show");
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
        url: "account/getAccountList",
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
        { extend: "copyHtml5", exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
        { extend: "excelHtml5", exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
        { extend: "csvHtml5", exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
        { extend: "pdfHtml5", exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
        { extend: "print", exportOptions: { columns: [0, 1, 2, 3, 4, 5, 6] } },
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
    $(".flashmessage").delay(3000).fadeOut(100);
    $("#apatients").select2({
      placeholder: select_patient,
      allowClear: true,
      ajax: {
        url: "patient/getPatientInfo",
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
  });
  
  $(document).ready(function () {
  "use strict";
  $(".default-date-picker").datepicker({
    format: "dd-mm-yyyy",
    autoclose: true,
    todayHighlight: true,
    startDate: "01-01-1900",
    clearBtn: true,
    language: language,
  });
});

// Function to toggle account_no and transaction_id fields based on deposit_type
$(document).ready(function () {
  "use strict";
  
  // Function to handle visibility of account_no and transaction_id fields
  function toggleAccountFields(depositType) {
    if (depositType === "Card") {
      $('input[name="account_no"]').closest('.form-group').show();
      $('input[name="transaction_id"]').closest('.form-group').show();
    } else {
      $('input[name="account_no"]').closest('.form-group').hide();
      $('input[name="transaction_id"]').closest('.form-group').hide();
    }
  }
  
  // Initial state - hide fields on page load
  toggleAccountFields($('select[name="deposit_type"]').val());
  
  // Add event listener for deposit_type change in Add Account modal
  $(document).on('change', '#myModal select[name="deposit_type"]', function() {
    toggleAccountFields($(this).val());
  });
  
  // Add event listener for deposit_type change in Edit Account modal
  $(document).on('change', '#myModal2 select[name="deposit_type"]', function() {
    toggleAccountFields($(this).val());
  });
  
  // When edit modal is shown, update fields visibility based on selected deposit type
  $('#myModal2').on('shown.bs.modal', function() {
    toggleAccountFields($('#myModal2 select[name="deposit_type"]').val());
  });
  
  // When add modal is shown, update fields visibility based on default deposit type
  $('#myModal').on('shown.bs.modal', function() {
    toggleAccountFields($('#myModal select[name="deposit_type"]').val());
  });
});