<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('lab_tests'); ?>
                <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a href="lab/addLabView">
                            <div class="btn-group pull-right">
                                <button id="add_new" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_lab_test'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('id'); ?></th>
                                <th><?php echo lang('date'); ?></th>
                                <th><?php echo lang('patient'); ?></th>
                                <th><?php echo lang('doctor'); ?></th>
                                <th><?php echo lang('template'); ?></th>
                                <th><?php echo lang('status'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) { ?>
                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($labs as $lab) { ?>
                            <tr class="">
                                <td><?php echo $lab->id; ?></td>
                                <td><?php echo date('d/m/Y', $lab->date); ?></td>
                                <td><?php echo $this->patient_model->getPatientById($lab->patient)->name; ?></td>
                                <td><?php echo $this->doctor_model->getDoctorById($lab->doctor)->name; ?></td>
                                <td><?php echo $this->lab_model->getTemplateById($lab->template)->name; ?></td>
                                <td><?php echo $lab->status; ?></td>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Laboratorist'))) { ?>
                                    <td class="no-print">
                                        <a class="btn btn-info btn-xs btn_width" href="lab/editLab?id=<?php echo $lab->id; ?>"><i class="fa fa-edit"></i> <?php echo lang('edit'); ?></a>   
                                        <a class="btn btn-info btn-xs btn_width" href="lab/labReport?id=<?php echo $lab->id; ?>" target="_blank"><i class="fa fa-eye"></i> <?php echo lang('report'); ?></a>
                                        <a class="btn btn-info btn-xs btn_width delete_button" href="lab/delete?id=<?php echo $lab->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> <?php echo lang('delete'); ?></a>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->

<!-- Add Lab Modal-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo lang('add_lab_test'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="lab/addLab" class="clearfix" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('patient'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="patient" value=''>
                            <?php foreach ($patients as $patient) { ?>
                                <option value="<?php echo $patient->id; ?>"><?php echo $patient->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('template'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="template" value=''>
                            <?php foreach ($templates as $template) { ?>
                                <option value="<?php echo $template->id; ?>"><?php echo $template->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('doctor'); ?></label>
                        <select class="form-control m-bot15 js-example-basic-single" name="doctor" value=''>
                            <?php foreach ($doctors as $doctor) { ?>
                                <option value="<?php echo $doctor->id; ?>"><?php echo $doctor->name; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"><?php echo lang('date'); ?></label>
                        <input type="text" class="form-control default-date-picker" name="date" value='' placeholder="">
                    </div>
                    <input type="hidden" name="redirect" value='lab'>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-info pull-right"><?php echo lang('submit'); ?></button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- Add Lab Modal-->

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".table").on("click", ".editbutton", function () {
            var iid = $(this).attr('data-id');
            $('#editLabForm').trigger("reset");
            $('#myModal2').modal('show');
            $.ajax({
                url: 'lab/editLabByJason?id=' + iid,
                method: 'GET',
                data: '',
                dataType: 'json',
            }).success(function (response) {
                var data = response.lab;
                $('#editLabForm').find('[name="id"]').val(data.id).end()
                $('#editLabForm').find('[name="patient"]').val(data.patient).end()
                $('#editLabForm').find('[name="template"]').val(data.template).end()
                $('#editLabForm').find('[name="doctor"]').val(data.doctor).end()
                $('#editLabForm').find('[name="date"]').val(data.date).end()
            });
        });
    });
</script>

<script>
    $(document).ready(function () {
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
                        columns: [0, 1, 2, 3, 4, 5],
                    }
                },
            ],
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            iDisplayLength: -1,
            "order": [[0, "desc"]],
            "language": {
                "lengthMenu": "_MENU_",
                search: "_INPUT_",
                "url": "common/assets/DataTables/languages/<?php echo $this->language; ?>.json"
            },
        });
        table.buttons().container()
                .appendTo('.custom_buttons');
    });
</script> 