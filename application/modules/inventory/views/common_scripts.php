<!-- Common JavaScript for Inventory Modals -->
<script type="text/javascript">
// Define BASE_URL for AJAX calls
var BASE_URL = '<?php echo base_url(); ?>';

// Common function for AJAX form submission - moved to global scope
function submitFormViaAjax(form, modalId, successMessage) {
    console.log("Submitting form via AJAX", form.attr('action'));
    console.log("Form data:", form.serialize());
    
    $.ajax({
        url: form.attr('action'),
        type: 'POST',
        data: form.serialize(),
        dataType: 'json',
        success: function(response) {
            console.log("AJAX response received:", response);
            if (response.success) {
                $(modalId).modal('hide');
                alert(successMessage);
                if (window.location.href.indexOf(form.attr('action').split('/').pop()) > -1) {
                    location.reload();
                } else {
                    // Reload the DataTable if it exists
                    if ($.fn.DataTable.isDataTable('#inventory-table')) {
                        $('#inventory-table').DataTable().ajax.reload();
                    } else if ($.fn.DataTable.isDataTable('#categories-table')) {
                        $('#categories-table').DataTable().ajax.reload();
                    } else if ($.fn.DataTable.isDataTable('.table')) {
                        $('.table').DataTable().ajax.reload();
                    } else {
                        location.reload();
                    }
                }
            } else {
                // Show validation errors
                var errors = '';
                if (response.errors) {
                    $.each(response.errors, function(key, value) {
                        errors += value + '<br>';
                    });
                } else if (response.message) {
                    errors = response.message;
                } else {
                    errors = 'An error occurred while processing your request';
                }
                
                // Find the correct error container based on form ID
                var errorContainer;
                if (form.attr('id') === 'editItemForm') {
                    errorContainer = $('#editFormErrors');
                } else if (form.attr('id') === 'addItemForm') {
                    errorContainer = $('#formErrors');
                } else {
                    errorContainer = form.find('.alert-danger');
                }
                
                errorContainer.html(errors).show();
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", status, error);
            console.log("Response:", xhr.responseText);
            alert('An error occurred while processing your request');
        }
    });
}

$(document).ready(function() {
    console.log("Common scripts loaded");
    
    // Ensure modal close buttons work properly
    $(document).on('click', '.modal .close, .modal .btn-secondary', function() {
        console.log("Modal close button clicked");
        $(this).closest('.modal').modal('hide');
    });
    
    // Fix for modal backdrop
    $(document).on('show.bs.modal', '.modal', function() {
        var zIndex = 1050 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    }); 
    
    // Initialize Select2 for item selection in modals 
    if ($.fn.select2) {
        $('.select2').not('#item_id, #edit_item_id, #usage_item_id').select2({
            dropdownParent: function() { 
                return $(this).closest('.modal').length ? $(this).closest('.modal') : $('body'); 
            }
        });
    }

    // Remove duplicate event handlers for forms
    $('#addItemForm').off('submit');
    $('#editItemForm').off('submit');
    $('#addCategoryForm').off('submit');
    $('#addPurchaseForm').off('submit');
    $('#addUsageForm').off('submit');

    // Form submission via AJAX for Add Item
    $('#addItemForm').on('submit', function(e) {
        console.log("Add Item form submitted");
        e.preventDefault();
        submitFormViaAjax($(this), '#addItemModal', 'Item added successfully');
    });

    // Form submission via AJAX for Edit Item
    $('#editItemForm').on('submit', function(e) {
        console.log("Edit Item form submitted");
        console.log("Form action:", $(this).attr('action'));
        console.log("Form method:", $(this).attr('method'));
        e.preventDefault();
        submitFormViaAjax($(this), '#editItemModal', 'Item updated successfully');
    });

    // Form submission via AJAX for Add Category
    $('#addCategoryForm').on('submit', function(e) {
        console.log("Add Category form submitted");
        e.preventDefault();
        submitFormViaAjax($(this), '#addCategoryModal', 'Category added successfully');
    });

    // Form submission via AJAX for Add Purchase
    $('#addPurchaseForm').on('submit', function(e) {
        console.log("Add Purchase form submitted");
        e.preventDefault();
        submitFormViaAjax($(this), '#addPurchaseModal', 'Purchase recorded successfully');
    });

    // Form submission via AJAX for Add Usage
    $('#addUsageForm').on('submit', function(e) {
        console.log("Add Usage form submitted");
        e.preventDefault();
        submitFormViaAjax($(this), '#addUsageModal', 'Usage recorded successfully');
    });

    // Calculate total cost automatically for purchases
    $('#quantity, #unit_cost').on('input', function() {
        var quantity = parseFloat($('#quantity').val()) || 0;
        var unitCost = parseFloat($('#unit_cost').val()) || 0;
        var totalCost = quantity * unitCost;
        $('#total_cost').val(totalCost.toFixed(2));
    });
    
    // Make sure Bootstrap modals are properly initialized
    $('.modal').each(function() {
        var $modal = $(this);
        
        // Move modals to body to avoid z-index issues
        if (!$modal.parent().is('body')) {
            $modal.appendTo('body');
        }
    });
});
</script>