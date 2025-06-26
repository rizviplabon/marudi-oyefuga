<!--main content-->
<div class="main-content">
    <div class="section">
        <div class="section-header">
            <h1><?php
                if (!empty($country->id))
                    echo lang('edit_country');
                else
                    echo lang('add_country');
                ?></h1>
        </div>
        <?php
        $message = $this->session->flashdata('feedback');
        if (!empty($message)) {
        ?>
            <div class="alert alert-primary alert-has-icon alert-dismissible show fade">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <div class="alert-title">Info!</div>
                    <?= $message ?>
                </div>
            </div>
        <?php } ?>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form role="form" action="country/addNew" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1"><?php echo lang('country'); ?> &#42;</label>
                                    <input type="text" class="form-control" name="country" id="exampleInputEmail1" value='<?php
                                    if (!empty($setval)) {
                                        echo set_value('country');
                                    }
                                    if (!empty($country->country)) {
                                        echo $country->country;
                                    }
                                    ?>' placeholder="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value='<?php
                        if (!empty($country->id)) {
                            echo $country->id;
                        }
                        ?>'>
                        <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/country.js"></script>