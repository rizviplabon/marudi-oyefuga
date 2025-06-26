<!--main content-->
<div class="main-content">
    <div class="section">
        <div class="section-header">
            <h1><?php
                if (!empty($city->id))
                    echo lang('edit_city');
                else
                    echo lang('add_city');
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
                    <div class="alert-title"></div>
                    <?= $message ?>
                </div>
            </div>
        <?php } ?>
        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form role="form" action="addNew" method="post" enctype="multipart/form-data">
                        <div class="row" style="padding-right:30px">
                            <div class="col-md-12 row mb-4">
                                <div class="col-md-4 text-right">
                                    <label class="col-form-label"><?php echo lang('country'); ?></label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="country" id="country_select" value=''>
                                        <option value=""><?php echo lang('select_country'); ?></option>
                                        <?php foreach ($countries as $country) { ?>
                                            <option value="<?php echo $country->id; ?>"><?php echo $country->country; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-right:30px">
                            <div class="col-md-12 row mb-4">
                                <div class="col-md-4 text-right">
                                    <label class="col-form-label"><?php echo lang('province'); ?></label>
                                </div>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="province" id="province_select" value='' disabled>
                                        <option value=""><?php echo lang('select_province'); ?></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-right:30px">
                            <div class="col-md-12 row mb-4">
                                <div class="col-md-4 text-right">
                                    <label class="col-form-label"><?php echo lang('city'); ?></label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="city" id="exampleInputEmail1" value='<?php
                                        if (!empty($city->city)) {
                                            echo $city->city;
                                        }
                                        ?>' placeholder="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="id" value='<?php
                            if (!empty($city->id)) {
                                echo $city->id;
                            }
                            ?>'>
                        <div class="row" style="padding-right:30px">
                            <div class="col-md-12 row mb-4">
                                <div class="col-md-4 text-right"></div>
                                <div class="col-md-8">
                                    <button type="submit" name="submit" class="btn btn-primary"><?php echo lang('submit'); ?></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/country/city.js"></script>