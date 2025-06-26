<footer class="main-footer">
            
            <?php echo date('Y'); ?> &copy; <?php echo $this->db->get('settings')->row()->footer_message; ?>
        </footer>

        

        <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->


    <!-- Sidebar -->

  

    <!-- Page Content overlay -->


    <!-- Vendor JS -->
    <script src="doclinic/main/js/vendors.min.js"></script>
    <script src="doclinic/main/js/pages/chat-popup.js"></script>
    <script src="doclinic/assets/icons/feather-icons/feather.min.js"></script>

    <script src="doclinic/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
    <script src="https://rawgit.com/nnnick/Chart.js/v1.0.2/Chart.min.js"></script>
    <script src="doclinic/assets/vendor_components/raphael/raphael.min.js"></script>
    <script src="doclinic/assets/vendor_components/morris.js/morris.min.js"></script>
    <script src="doclinic/assets/vendor_components/fullcalendar/lib/moment.min.js"></script>
    <script src="doclinic/assets/vendor_components/fullcalendar/fullcalendar.min.js"></script>
    <!-- <script src="doclinic/assets/vendor_components/datatable/datatables.min.js"></script> -->
    <script src="doclinic/main/js/pages/data-table.js"></script>
    
    <!-- Doclinic App -->
    <script src="doclinic/main/js/template.js"></script>
    <script src="doclinic/main/js/pages/dashboard4.js"></script>
    <script src="doclinic/main/js/pages/calendar.js"></script>

    <script src="common/js/jquery.js"></script>
<script src="common/js/bootstrap.min.js"></script>
<script src="common/js/jquery.scrollTo.min.js"></script>

<script src="common/js/moment.min.js"></script>
<script  type="text/javascript" src="common/assets/DataTables/pdfmake.min.js"></script>
<script  type="text/javascript" src="common/assets/DataTables/vfs_fonts.js"></script>
<script  type="text/javascript" src="common/assets/DataTables/datatables.min.js"></script>


<script src="common/js/respond.min.js" ></script>
<script type="text/javascript" src="common/assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="common/assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="common/assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>


<script type="text/javascript" src="common/assets/jquery-multi-select/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="common/assets/jquery-multi-select/js/jquery.quicksearch.js"></script>
<script type="text/javascript" src="common/assets/ckeditor/build/ckeditor.js"></script>

<script type="text/javascript" src="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>

<script type="text/javascript" src="common/assets/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script src="common/js/advanced-form-components.js"></script>
<script src="common/js/jquery.cookie.js"></script>
<!--common script for all pages--> 
<!-- <script src="common/js/jquery.nicescroll.js" type="text/javascript"></script> -->
<script src="common/js/common-scripts.js"></script>
<script src="common/js/lightbox.js"></script>
<script class="include" type="text/javascript" src="common/js/jquery.dcjqaccordion.2.7.js"></script>
<!--script for this page only-->
<script src="common/js/editable-table.js"></script>

<script src="common/assets/fullcalendar/fullcalendar.js"></script>

<script type="text/javascript" src="common/assets/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="common/assets/select2/js/select2.min.js"></script>
<script src="common/js/bootstrap-select.min.js"></script>
<script src="common/js/bootstrap-select-country.min.js"></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"></script>
    <script>
    var heart_rate = <?php echo $vitals->heart_rate; ?>;

    var temperature = <?php echo $vitals->temperature; ?>;
    var oxygen_saturation = <?php echo $vitals->oxygen_saturation; ?>;
    var respiratory_rate = <?php echo $vitals->respiratory_rate; ?>;
    var bmi_weight = <?php echo $vitals->bmi_weight; ?>;
    var bmi_height = <?php echo $vitals->bmi_height; ?>;
    </script>

    <script>
    Morris.Donut({
        element: 'donut-chart',
        data: [{
            label: "<?php echo lang('heart_rate'); ?> (bpm)",
            value: heart_rate,

        }, {
            label: "<?php echo lang('temp'); ?> (&deg;C)",
            value: temperature,
        }, {
            label: "<?php echo lang('oxygen_saturation'); ?> (%)",
            value: oxygen_saturation,
        }, {
            label: "<?php echo lang('respiratory_rate'); ?> (bpm)",
            value: respiratory_rate,
        }, {
            label: "<?php echo lang('bmi_weight'); ?> (Kg)",
            value: bmi_weight,
        }, {
            label: "<?php echo lang('bmi_height'); ?> (Cm)",
            value: bmi_height,
        }],
        resize: true,
        colors: ['#A3B385', '#FFBD8F', '#B385A6', '#D48FFF', '#DBC761', '#8ABBB2']
    });
    </script>

<?php
// Add the patient chat popup for patients
if ($this->ion_auth->logged_in() && $this->ion_auth->in_group('Patient')) {
    // Add the patient chat CSS
    echo '<link href="common/extranal/css/patientchat/popup_chat.css" rel="stylesheet">';
    
    // Add the patient chat JS with a unique identifier to prevent duplicate loading
    echo '<script src="common/extranal/js/patientchat/popup_chat.js?v=' . time() . '"></script>';
    
    // No need for additional AJAX call as the script will handle loading the popup
}
?>
</body>

</html>