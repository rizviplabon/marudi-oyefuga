"use strict";
$(document).ready(function (e) {
  "use strict";
  $("#save_as_draft").click(function () {
    $("input[name='type']").removeAttr("required");
    $("#pos_select").removeAttr("required");
    $("#add_doctor").removeAttr("required");
    $(".multi-select").removeAttr("required");
    $("#d_name").prop("required", false);
    $("#d_email").prop("required", false);
    $("#d_phone").prop("required", false);
    $("#p_birth").prop("required", false);
    $("#p_name").prop("required", false);
    $("#p_email").prop("required", false);
    $("#p_phone").prop("required", false);

    e.preventDefault;
  });
  var tot = 0;
  $(".ms-list").on("click", ".ms-selected", function () {
    "use strict";
    var idd = $(this).data("idd");
    $("#id-div" + idd).remove();
    $("#idinput-" + idd).remove();
    $("#categoryinput-" + idd).remove();
  });
  $.each($("select.multi-select option:selected"), function () {
    "use strict";
    var idd = $(this).data("idd");
    var qtity = $(this).data("qtity");
    if ($("#idinput-" + idd).length) {
    } else {
      if ($("#id-div" + idd).length) {
      } else {
        $("#editPaymentForm .qfloww").append(
          '<div class="remove1" id="id-div' +
            idd +
            '">  ' +
            '<i class="remove_attr fa fa-times" id="id-remove-' +
            idd +
            '" style="font-size:16px;color:red"></i> ' +
            $(this).data("cat_name") +
            "-" +
            currency +
            $(this).data("id") +
            "</div>"
        );
      }
      var input2 = $("<input>")
        .attr({
          type: "text",
          class: "remove",
          id: "idinput-" + idd,
          name: "quantity[]",
          value: qtity,
        })
        .appendTo("#editPaymentForm .qfloww");

      $("<input>")
        .attr({
          type: "hidden",
          class: "remove",
          id: "categoryinput-" + idd,
          name: "category_id[]",
          value: idd,
        })
        .appendTo("#editPaymentForm .qfloww");
    }
    $(document).ready(function () {
      "use strict";

      $("#idinput-" + idd).keyup(function () {
        "use strict";
        var qty = 0;
        var total = 0;
        $.each($("select.multi-select option:selected"), function () {
          var id1 = $(this).data("idd");
          qty = $("#idinput-" + id1).val();
          var ekokk = $(this).data("id");
          total = total + qty * ekokk;
        });
        tot = total;
        var discount = ($("#dis_id_percent").val() * tot) / 100;
        var vat_amount = $("#vat").val();
        var vat = (vat_amount * tot) / 100;
        var gross = tot - discount + vat;
        $("#editPaymentForm").find('[name="subtotal"]').val(tot).end();
        $("#editPaymentForm")
          .find('[name="discount"]')
          .val(discount.toFixed(2))
          .end();
        $("#editPaymentForm").find('[name="grsss"]').val(gross);
        $("#editPaymentForm").find('[name="vat_amount"]').val(vat).end();
        var amount_received = $("#amount_received").val();
        var change = amount_received - gross;
        $("#editPaymentForm").find('[name="change"]').val(change).end();
        var id = $("#id_pay").val() ? $("#id_pay").val() : null;
        if (id !== null) {
          $.ajax({
            url: "finance/getDepositByInvoiceId?id=" + id,
            method: "GET",
            data: "",
            dataType: "json",
            success: function (response) {
              var due = $("#gross").val() - response.response;
              $("#due").val(due);
            },
          });
        } else {
          $("#due").val($("#gross").val() - amount_received);
        }
      });
    });
    ("use strict");
    var sub_total = $(this).data("id") * $("#idinput-" + idd).val();
    tot = tot + sub_total;
  });
  ("use strict");
  var discount = ($("#dis_id_percent").val() * tot) / 100;
  // if (discount_type === "flat") {
  var vat_amount = $("#vat").val();
  var vat = (vat_amount * tot) / 100;
  var gross = tot - discount + vat;
  // } else {
  //   var vat = (vat_amount * tot) / 100;

  //   var gross = tot - (tot * discount) / 100 + vat;
  // }

  $("#editPaymentForm").find('[name="subtotal"]').val(tot).end();
  $("#editPaymentForm")
    .find('[name="discount"]')
    .val(discount.toFixed(2))
    .end();
  $("#editPaymentForm").find('[name="vat_amount"]').val(vat.toFixed(2)).end();
  $("#editPaymentForm").find('[name="grsss"]').val(gross);
  var amount_received = $("#amount_received").val();
  var change = gross - amount_received;
  $("#editPaymentForm").find('[name="change"]').val(change).end();
  var id = $("#id_pay").val() ? $("#id_pay").val() : null;

  if (id !== null) {
    $.ajax({
      url: "finance/getDepositByInvoiceId?id=" + id,
      method: "GET",
      data: "",
      dataType: "json",
      success: function (response) {
        var due = $("#gross").val() - response.response;
        $("#due").val(due);
      },
    });
  } else {
    $("#due").val($("#gross").val() - amount_received);
  }
});

$(document).ready(function () {
  "use strict";
  $("#dis_id").keyup(function () {
    "use strict";
    var val_dis = 0;
    var amount = 0;
    var ggggg = 0;

    amount = $("#subtotal").val();
    val_dis = this.value;
    var vat_amount = $("#vat").val();
    var vat = (vat_amount * amount) / 100;
    var discount = (val_dis * 100) / amount;
    ggggg = amount - val_dis + vat;

    $("#editPaymentForm").find('[name="grsss"]').val(ggggg);
    $("#editPaymentForm")
      .find('[name="percent_discount"]')
      .val(discount.toFixed(2));

    var amount_received = $("#amount_received").val();
    var change = amount_received - ggggg;
    $("#editPaymentForm").find('[name="change"]').val(change).end();
    var id = $("#id_pay").val() ? $("#id_pay").val() : null;
    if (id !== null) {
      $.ajax({
        url: "finance/getDepositByInvoiceId?id=" + id,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          var due = $("#gross").val() - response.response;
          $("#due").val(due);
        },
      });
    } else {
      $("#due").val($("#gross").val() - amount_received);
    }
  });
  $("#dis_id_percent").keyup(function () {
    "use strict";
    var val_dis = 0;
    var amount = 0;
    var ggggg = 0;
    amount = $("#subtotal").val();
    val_dis = this.value;
    var vat_amount = $("#vat").val();
    var vat = (vat_amount * amount) / 100;

    var discount = (amount * val_dis) / 100;
    ggggg = amount - (amount * val_dis) / 100 + vat;
    $("#editPaymentForm").find('[name="discount"]').val(discount);
    $("#editPaymentForm").find('[name="grsss"]').val(ggggg);
    // $("#editPaymentForm").find('[name="vat"]').val(vat);
    var amount_received = $("#amount_received").val();
    var change = amount_received - ggggg;
    $("#editPaymentForm").find('[name="change"]').val(change).end();
    var id = $("#id_pay").val() ? $("#id_pay").val() : null;
    if (id !== null) {
      $.ajax({
        url: "finance/getDepositByInvoiceId?id=" + id,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          var due = $("#gross").val() - response.response;
          $("#due").val(due);
        },
      });
    } else {
      $("#due").val($("#gross").val() - amount_received);
    }
  });
});

$(document).ready(function () {
  "use strict";

  $(document.body).on("change", ".multi-select", function () {
    "use strict";
    var tot = 0;

    $(".ms-list").on("click", ".ms-selected", function () {
      "use strict";
      var idd = $(this).data("idd");
      $("#id-div" + idd).remove();
      $("#idinput-" + idd).remove();
      $("#categoryinput-" + idd).remove();
    });
    $.each($("select.multi-select option:selected"), function () {
      "use strict";
      var curr_val = $(this).data("id");
      var idd = $(this).data("idd");

      var cat_name = $(this).data("cat_name");
      if ($("#idinput-" + idd).length) {
      } else {
        if ($("#id-div" + idd).length) {
        } else {
          $("#editPaymentForm .qfloww").append(
            '<div class="remove1" id="id-div' +
              idd +
              '">  ' +
              '<i class="remove_attr fa fa-times" id="id-remove-' +
              idd +
              '" style="font-size:16px;color:red"></i> ' +
              $(this).data("cat_name") +
              "-" +
              currency +
              $(this).data("id") +
              "</div>"
          );
        }

        var input2 = $("<input>")
          .attr({
            type: "text",
            class: "remove",
            id: "idinput-" + idd,
            name: "quantity[]",
            value: "1",
          })
          .appendTo("#editPaymentForm .qfloww");

        $("<input>")
          .attr({
            type: "hidden",
            class: "remove",
            id: "categoryinput-" + idd,
            name: "category_id[]",
            value: idd,
          })
          .appendTo("#editPaymentForm .qfloww");
      }

      $(document).ready(function () {
        "use strict";
        $("#idinput-" + idd).keyup(function () {
          "use strict";

          var qty = 0;
          var total = 0;
          $.each($("select.multi-select option:selected"), function () {
            var id1 = $(this).data("idd");
            qty = $("#idinput-" + id1).val();
            var ekokk = $(this).data("id");
            total = total + qty * ekokk;
          });

          tot = total;

          // var discount = $("#dis_id").val();
          var discount = (tot * $("#dis_id_percent").val()) / 100;
          var vat_amount = $("#vat").val();
          var vat = (vat_amount * tot) / 100;
          var gross = tot - discount + vat;

          $("#editPaymentForm").find('[name="subtotal"]').val(tot).end();
          $("#editPaymentForm").find('[name="discount"]').val(discount).end();
          $("#editPaymentForm").find('[name="vat_amount"]').val(vat).end();
          $("#editPaymentForm").find('[name="grsss"]').val(gross);

          var amount_received = $("#amount_received").val();
          var change = amount_received - gross;
          $("#editPaymentForm").find('[name="change"]').val(change).end();
          var asdid = $("#id_pay").val() ? $("#id_pay").val() : null;
          if (asdid !== null) {
            $.ajax({
              url: "finance/getDepositByInvoiceId?id=" + asdid,
              method: "GET",
              data: "",
              dataType: "json",
              success: function (response) {
                var due = $("#gross").val() - response.response;
                $("#due").val(due);
              },
            });
          } else {
            $("#due").val($("#gross").val() - amount_received);
          }
        });
      });
      ("use strict");
      var sub_total = $(this).data("id") * $("#idinput-" + idd).val();
      tot = tot + sub_total;
    });
    ("use strict");
    var discount = ($("#dis_id_percent").val() * tot) / 100;

    // if (discount_type === "flat") {
    //   var vat = (vat_amount * tot) / 100;
    //   var gross = tot - discount + vat;
    // } else {
    var vat_amount = $("#vat").val();
    var vat = (vat_amount * tot) / 100;

    var gross = tot - discount + vat;
    //}
    $("#editPaymentForm").find('[name="subtotal"]').val(tot).end();
    $("#editPaymentForm").find('[name="discount"]').val(discount).end();
    $("#editPaymentForm").find('[name="vat_amount"]').val(vat);
    $("#editPaymentForm").find('[name="grsss"]').val(gross);

    var amount_received = $("#amount_received").val();
    var change = gross - amount_received;
    $("#editPaymentForm").find('[name="change"]').val(change).end();
    var asdid = $("#id_pay").val() ? $("#id_pay").val() : null;

    if (asdid !== null) {
      $.ajax({
        url: "finance/getDepositByInvoiceId?id=" + asdid,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          var due = $("#gross").val() - response.response;
          $("#due").val(due);
        },
      });
    } else {
      $("#due").val($("#gross").val() - amount_received);
    }
  });
});

$(document).ready(function () {
  "use strict";
  $("#dis_id").keyup(function () {
    "use strict";
    var val_dis = 0;
    var amount = 0;
    var ggggg = 0;
    amount = $("#subtotal").val();
    val_dis = this.value;
    var vat_amount = $("#vat").val();
    var vat = (vat_amount * amount) / 100;
    var discount = (val_dis * 100) / amount;
    ggggg = amount - val_dis + vat;

    $("#editPaymentForm").find('[name="grsss"]').val(ggggg);
    $("#editPaymentForm")
      .find('[name="percent_discount"]')
      .val(discount.toFixed(2));

    var amount_received = $("#amount_received").val();
    var change = amount_received - ggggg;
    $("#editPaymentForm").find('[name="change"]').val(change).end();
    var id = $("#id_pay").val() ? $("#id_pay").val() : null;
    if (id !== null) {
      $.ajax({
        url: "finance/getDepositByInvoiceId?id=" + id,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          var due = $("#gross").val() - response.response;
          $("#due").val(due);
        },
      });
    } else {
      $("#due").val($("#gross").val() - amount_received);
    }
  });
  $("#dis_id_percent").keyup(function () {
    "use strict";
    var val_dis = 0;
    var amount = 0;
    var ggggg = 0;
    amount = $("#subtotal").val();
    val_dis = this.value;
    var vat_amount = $("#vat").val();
    var vat = (vat_amount * amount) / 100;

    var discount = (amount * val_dis) / 100;
    ggggg = amount - discount + vat;
    $("#editPaymentForm").find('[name="discount"]').val(discount).toFixed(2);
    $("#editPaymentForm").find('[name="grsss"]').val(ggggg);

    var amount_received = $("#amount_received").val();

    var id = $("#id_pay").val() ? $("#id_pay").val() : null;
    if (id !== null) {
      $.ajax({
        url: "finance/getDepositByInvoiceId?id=" + id,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          var due = $("#gross").val() - response.response;
          $("#due").val(due);
        },
      });
    } else {
      $("#due").val($("#gross").val() - amount_received);
    }
  });
});
$(document).ready(function () {
  "use strict";
  $("#vat_amount").keyup(function () {
    "use strict";
    var val_dis = 0;
    var amount = 0;
    var ggggg = 0;

    amount = $("#subtotal").val();
    val_dis = $(this).val();

    var vat = (100 * val_dis) / amount;
    var discount = $("#dis_id").val();
    ggggg = amount - discount + parseFloat(val_dis);
    $("#vat").val("");
    $("#editPaymentForm").find('[name="grsss"]').val(ggggg);
    $("#editPaymentForm").find('[name="vat"]').val(vat.toFixed(2));

    var amount_received = $("#amount_received").val();
    var change = amount_received - ggggg;
    $("#editPaymentForm").find('[name="change"]').val(change).end();
    var id = $("#id_pay").val() ? $("#id_pay").val() : null;
    if (id !== null) {
      $.ajax({
        url: "finance/getDepositByInvoiceId?id=" + id,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          var due = $("#gross").val() - response.response;
          $("#due").val(due);
        },
      });
    } else {
      $("#due").val($("#gross").val() - amount_received);
    }
  });
  $("#vat").keyup(function () {
    "use strict";
    var val_dis = 0;
    var amount = 0;
    var ggggg = 0;
    amount = $("#subtotal").val();
    val_dis = this.value;
    var discount = $("#dis_id").val();
    var vat = (val_dis * amount) / 100;

    ggggg = amount - discount + vat;
    $("#vat").val("");
    $("#vat_amount").val("");
    $("#editPaymentForm").find('[name="grsss"]').val(ggggg);
    $("#editPaymentForm").find('[name="vat_amount"]').val(vat.toFixed(2));
    $("#editPaymentForm").find('[name="vat"]').val(val_dis);
    var amount_received = $("#amount_received").val();
    var change = amount_received - ggggg;
    $("#editPaymentForm").find('[name="change"]').val(change).end();
    var id = $("#id_pay").val() ? $("#id_pay").val() : null;
    if (id !== null) {
      $.ajax({
        url: "finance/getDepositByInvoiceId?id=" + id,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          var due = $("#gross").val() - response.response;
          $("#due").val(due);
        },
      });
    } else {
      $("#due").val($("#gross").val() - amount_received);
    }
  });
});
$(document).ready(function () {
  "use strict";
  // $("#due").keyup(function () {
  //   var id = $("#id_pay").val();
  //   if (id !== null) {
  //     $.ajax({
  //       url: "finance/getDepositByInvoiceId?id=" + id,
  //       method: "GET",
  //       data: "",
  //       dataType: "json",
  //       success: function (response) {
  //         var due = $("#gross").val() - response.response;
  //         $("#due").val(due);
  //       },
  //     });
  //   } else {
  //     $("#due").val($("#gross").val());
  //   }
  // });
  $("#amount_received").keyup(function () {
    var gross = $("#gross").val();

    var ammount_recived = $(this).val();

    $("#due").val(gross - ammount_recived);
  });
  // if ($.trim($("#id_pay").val()) == "") {
  //   $(".pos_client").hide();
  // }

  $(document.body).on("change", "#pos_select", function () {
    "use strict";
    var v = $("select.pos_select option:selected").val();
    if (v === "add_new") {
      $(".pos_client").show();
      $("#editPaymentForm").find('[name="p_name"]').val(" ").end();
      $("#editPaymentForm").find('[name="p_email"]').val(" ").end();
      $("#editPaymentForm").find('[name="p_phone"]').val(" ").end();
      $("#editPaymentForm").find('[name="p_birth"]').val(" ").end();

      $("#editPaymentForm").find('[name="years"]').val(" ").end();
      $("#editPaymentForm").find('[name="months"]').val(" ").end();
      $("#editPaymentForm").find('[name="days"]').val(" ").end();
      $("#editPaymentForm").find('[name="p_gender"]').val(" ").end();
      $("#editPaymentForm").find('[name="years"]').attr("readonly", false);
      $("#editPaymentForm").find('[name="months"]').attr("readonly", false);
      $("#editPaymentForm").find('[name="days"]').attr("readonly", false);
      $("#editPaymentForm").find('[name="p_birth"]').attr("readonly", false);
      $("#editPaymentForm").find('[name="p_phone"]').attr("readonly", false);
      $("#editPaymentForm").find('[name="p_name"]').attr("readonly", false);
      $("#editPaymentForm").find('[name="p_email"]').attr("readonly", false);
      $("#p_birth").attr("readonly", false);
      $("#p_gender").attr("readonly", false);
      $("#p_birth").prop("required", true);
      $("#p_name").prop("required", true);
      $("#p_email").prop("required", true);
      $("#p_phone").prop("required", true);
    } else {
      $(".pos_client").show();
      $.ajax({
        url: "finance/getPatientById?id=" + v,
        method: "GET",
        data: "",
        dataType: "json",
        success: function (response) {
          "use strict";
          $("#editPaymentForm")
            .find('[name="p_name"]')
            .val(response.patient.name)
            .end();
          $("#editPaymentForm")
            .find('[name="p_email"]')
            .val(response.patient.email)
            .end();
          $("#editPaymentForm")
            .find('[name="p_phone"]')
            .val(response.patient.phone)
            .end();
          $("#editPaymentForm")
            .find('[name="p_birth"]')
            .val(response.patient.birthdate)
            .end();
          var age = response.patient.age.split("-");
          $("#editPaymentForm").find('[name="years"]').val(age[0]).end();
          $("#editPaymentForm").find('[name="months"]').val(age[1]).end();
          $("#editPaymentForm").find('[name="days"]').val(age[2]).end();
          $("#editPaymentForm")
            .find('[name="p_gender"]')
            .val(response.patient.sex)
            .trigger("change");
          $("#editPaymentForm").find('[name="years"]').attr("readonly", true);
          $("#editPaymentForm").find('[name="months"]').attr("readonly", true);
          $("#editPaymentForm").find('[name="days"]').attr("readonly", true);
          $("#editPaymentForm").find('[name="p_birth"]').attr("readonly", true);
          $("#editPaymentForm").find('[name="p_phone"]').attr("readonly", true);
          $("#editPaymentForm").find('[name="p_name"]').attr("readonly", true);
          $("#editPaymentForm").find('[name="p_email"]').attr("readonly", true);
          $("#p_birth").attr("readonly", true);
          $("#p_gender").attr("readonly", true);
          $("#p_birth").prop("required", false);
          $("#p_name").prop("required", false);
          $("#p_email").prop("required", false);
          $("#p_phone").prop("required", false);
        },
      });
      $("#p_birth").prop("required", false);
    }
  });
});

$(document).ready(function () {
  "use strict";
  if (add_doctor === "no") {
    $(".pos_doctor").hide();
  } else {
    $(".pos_doctor").show();
  }

  $(document.body).on("change", "#add_doctor", function () {
    "use strict";

    var v = $("select.add_doctor option:selected").val();
    if (v === "add_new") {
      $(".pos_doctor").show();
      $("#d_name").prop("required", true);
      $("#d_email").prop("required", true);
      $("#d_phone").prop("required", true);
    } else {
      $(".pos_doctor").hide();
      $("#d_name").prop("required", false);
      $("#d_email").prop("required", false);
      $("#d_phone").prop("required", false);
    }
  });
});

$(document).ready(function () {
  "use strict";
  $(".card2").hide();
  $(document.body).on("change", "#selecttype", function () {
    "use strict";
    var v = $("select.selecttype option:selected").val();
    if (v === "Card") {
      $(".cardsubmit").removeClass("hidden");
      $(".cashsubmit").addClass("hidden");
      $(".cardsubmit3").removeClass("hidden");
      $(".cashsubmit2").addClass("hidden");
      $("#amount_received").prop("required", true);

      $(".card2").show();
    } else {
      $(".card2").hide();
      $(".cashsubmit").removeClass("hidden");
      $(".cardsubmit").addClass("hidden");
      $(".cashsubmit2").removeClass("hidden");
      $(".cardsubmit3").addClass("hidden");
      $("#amount_received").prop("required", false);
    }
  });
});

function cardValidation() {
  "use strict";
  var valid = true;
  var cardNumber = $("#card").val();
  var expire = $("#expire").val();
  var cvc = $("#cvv").val();

  $("#error-message").html("").hide();

  if (cardNumber.trim() == "") {
    valid = false;
  }

  if (expire.trim() == "") {
    valid = false;
  }
  if (cvc.trim() == "") {
    valid = false;
  }

  if (valid == false) {
    $("#error-message").html("All Fields are required").show();
  }

  return valid;
}
//set your publishable key
Stripe.setPublishableKey(publish);

//callback to handle the response from stripe
function stripeResponseHandler(status, response) {
  "use strict";

  if (response.error) {
    alert(response.error.message);
    $("#submit-btn").show();
    $("#submit-btn2").show();
    $("#loader").css("display", "none");
    $("#submit-btn").attr("disabled", false);
    $("#submit-btn2").show();
    $("#error-message").html(response.error.message).show();
  } else {
    var token = response["id"];
    if (token != null) {
      $("#token").val(token);
      $("#editPaymentForm").append(
        "<input type='hidden' name='token' value='" + token + "' />"
      );
      $("#editPaymentForm").submit();
    } else {
      alert("Please Check Your Card details");
      $("#submit-btn").attr("disabled", false);
      $("#submit-btn2").attr("disabled", false);
    }
  }
}

function stripePay(e) {
  "use strict";
  e.preventDefault();
  var valid = cardValidation();

  if (valid == true) {
    $("#submit-btn").attr("disabled", true);
    $("#loader").css("display", "inline-block");
    var expire = $("#expire").val();
    var arr = expire.split("/");
    Stripe.createToken(
      {
        number: $("#card").val(),
        cvc: $("#cvv").val(),
        exp_month: arr[0],
        exp_year: arr[1],
      },
      stripeResponseHandler
    );

    return false;
  }
}

$(document).ready(function () {
  "use strict";
  $("#pos_select").select2({
    placeholder: select_patient,
    allowClear: true,
    ajax: {
      url: "patient/getPatientinfoWithAddNewOption",
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

  $("#add_doctor").select2({
    placeholder: select_doctor,
    allowClear: true,
    ajax: {
      url: "doctor/getDoctorWithAddNewOption",
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

// Account Balance Functionality - Enhanced with Guardian Support
$(document).ready(function () {
  "use strict";
  
  // Handle deposit type change
  $("#selecttype").change(function () {
    var depositType = $(this).val();
    
    if (depositType === "Account Balance") {
      $("#account_balance_display").show();
      
      // Get current patient ID and fetch balance
      var patientId = $("#pos_select").val();
      if (patientId && patientId !== 'add_new') {
        getPatientAccountBalanceEnhanced(patientId);
      } else {
        updateBalanceDisplayEnhanced({ success: false, message: 'Please select a patient to view their account balance', patient_balance: 0 });
      }
    } else {
      $("#account_balance_display").hide();
    }
  });
  
  // Handle patient selection change
  $("#pos_select").change(function () {
    var patientId = $(this).val();
    var depositType = $("#selecttype").val();
    
    // Only fetch balance if Account Balance is selected
    if (depositType === "Account Balance") {
      if (patientId && patientId !== 'add_new') {
        getPatientAccountBalanceEnhanced(patientId);
      } else {
        updateBalanceDisplayEnhanced({ success: false, message: 'Please select a patient to view their account balance', patient_balance: 0 });
      }
    }
  });
  
  // Enhanced function to fetch patient account balance via AJAX
  function getPatientAccountBalanceEnhanced(patientId) {
    $.ajax({
      url: 'finance/getPatientAccountBalance',
      type: 'POST',
      data: { patient_id: patientId },
      dataType: 'json',
      beforeSend: function() {
        updateBalanceDisplayEnhanced({ success: false, message: 'Loading balance...', patient_balance: 0 });
      },
      success: function(response) {
        updateBalanceDisplayEnhanced(response);
      },
      error: function(xhr, status, error) {
        console.error('Error fetching account balance:', error);
        updateBalanceDisplayEnhanced({ 
          success: false, 
          message: 'Error connecting to server', 
          patient_balance: 0,
          has_guardian: false
        });
      }
    });
  }
  
  // Enhanced function to update balance display with guardian support
  function updateBalanceDisplayEnhanced(response) {
    var container = $("#account_balance_display");
    var html = '';
    
    if (response.success) {
      html += '<div class="card border-0 shadow-sm mt-3">';
      html += '<div class="card-header bg-primary text-white">';
      html += '<h6 class="mb-0"><i class="fas fa-wallet me-2"></i>Account Balance Information</h6>';
      html += '</div>';
      html += '<div class="card-body">';
      
      // Patient Balance Section
      html += '<div class="row mb-3">';
      html += '<div class="col-md-6">';
      html += '<div class="d-flex align-items-center justify-content-between p-3 border rounded ' + (response.patient_is_negative ? 'border-danger' : 'border-success') + '">';
      html += '<div>';
      html += '<h6 class="mb-1 fw-bold">' + response.patient_name + '</h6>';
      html += '<small class="text-muted">Patient Account</small>';
      html += '</div>';
      html += '<div class="text-end">';
      html += '<h5 class="mb-0 ' + (response.patient_is_negative ? 'text-danger' : 'text-success') + '">' + response.formatted_patient_balance + '</h5>';
      html += '</div>';
      html += '</div>';
      html += '</div>';
      
      // Guardian Balance Section (if applicable)
      if (response.has_guardian) {
        html += '<div class="col-md-6">';
        html += '<div class="d-flex align-items-center justify-content-between p-3 border rounded ' + (response.guardian_is_negative ? 'border-danger' : 'border-success') + '">';
        html += '<div>';
        html += '<h6 class="mb-1 fw-bold">' + response.guardian_name + '</h6>';
        html += '<small class="text-muted">Guardian Account</small>';
        html += '</div>';
        html += '<div class="text-end">';
        html += '<h5 class="mb-0 ' + (response.guardian_is_negative ? 'text-danger' : 'text-success') + '">' + response.formatted_guardian_balance + '</h5>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
      }
      html += '</div>';
      
      // Account Selection for Payment (if guardian exists)
      if (response.has_guardian) {
        html += '<div class="row">';
        html += '<div class="col-12">';
        html += '<label class="form-label fw-bold">Select Account for Payment:</label>';
        html += '<div class="d-flex gap-3 mb-3">';
        html += '<div class="form-check">';
        html += '<input class="form-check-input" type="radio" name="payment_account_source" id="use_patient_account" value="patient" checked>';
        html += '<label class="form-check-label" for="use_patient_account">';
        html += 'Use Patient Account (' + response.formatted_patient_balance + ')';
        html += '</label>';
        html += '</div>';
        html += '<div class="form-check">';
        html += '<input class="form-check-input" type="radio" name="payment_account_source" id="use_guardian_account" value="guardian">';
        html += '<label class="form-check-label" for="use_guardian_account">';
        html += 'Use Guardian Account (' + response.formatted_guardian_balance + ')';
        html += '</label>';
        html += '</div>';
        html += '</div>';
        // Hidden fields to store guardian info
        html += '<input type="hidden" id="guardian_patient_id" value="' + response.guardian_id + '">';
        html += '<input type="hidden" id="selected_patient_id" value="' + response.patient_id + '">';
        html += '</div>';
        html += '</div>';
      } else {
        // Hidden field to indicate no guardian
        html += '<input type="hidden" name="payment_account_source" value="patient">';
        html += '<input type="hidden" id="selected_patient_id" value="' + response.patient_id + '">';
      }
      
      // Status message
      if (response.message) {
        var messageClass = response.patient_is_negative && (!response.has_guardian || response.guardian_is_negative) ? 'alert-warning' : 'alert-info';
        html += '<div class="alert ' + messageClass + ' mt-3 mb-0">';
        html += '<i class="fas fa-info-circle me-2"></i>' + response.message;
        html += '</div>';
      }
      
      html += '</div>';
      html += '</div>';
    } else {
      // Error or loading state
      html += '<div class="card border-0 shadow-sm mt-3">';
      html += '<div class="card-header bg-warning text-dark">';
      html += '<h6 class="mb-0"><i class="fas fa-exclamation-triangle me-2"></i>Account Balance</h6>';
      html += '</div>';
      html += '<div class="card-body">';
      html += '<div class="alert alert-warning mb-0">';
      html += '<i class="fas fa-info-circle me-2"></i>' + (response.message || 'Unable to load balance information');
      html += '</div>';
      html += '</div>';
      html += '</div>';
    }
    
    container.html(html);
  }
  
  // Initialize balance display if Account Balance is already selected on page load
  if ($("#selecttype").val() === "Account Balance") {
    $("#account_balance_display").show();
    var patientId = $("#pos_select").val();
    if (patientId && patientId !== 'add_new') {
      getPatientAccountBalanceEnhanced(patientId);
    }
  }
});

// Form submission handler to include account source information
$(document).ready(function() {
  "use strict";
  
  // Intercept form submission to add account source data
  $("#editPaymentForm").on('submit', function(e) {
    var depositType = $("#selecttype").val();
    
    if (depositType === "Account Balance") {
      var accountSource = $('input[name="payment_account_source"]:checked').val();
      var selectedPatientId = $("#selected_patient_id").val();
      var guardianPatientId = $("#guardian_patient_id").val();
      
      if (accountSource === 'guardian' && guardianPatientId) {
        // Add hidden field to specify that payment should be deducted from guardian account
        $(this).append('<input type="hidden" name="deduct_from_patient_id" value="' + guardianPatientId + '">');
        $(this).append('<input type="hidden" name="original_patient_id" value="' + selectedPatientId + '">');
        $(this).append('<input type="hidden" name="payment_account_type" value="guardian">');
        $(this).append('<input type="hidden" name="selected_account" value="guardian">');
      } else {
        // Payment from patient's own account
        $(this).append('<input type="hidden" name="deduct_from_patient_id" value="' + selectedPatientId + '">');
        $(this).append('<input type="hidden" name="payment_account_type" value="patient">');
        $(this).append('<input type="hidden" name="selected_account" value="patient">');
      }
    }
  });
});
