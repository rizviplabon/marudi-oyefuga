<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <section class="panel">
            <header class="panel-heading">
                <?php
                if (!empty($faq->id))
                    echo lang('edit_faq');
                else
                    echo lang('add_faq');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <?php echo validation_errors(); ?>
                                <?php echo $this->session->flashdata('feedback'); ?>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <form role="form" action="faq/addNew" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('title'); ?> &ast;</label>
                                <input type="text" class="form-control form-control-lg" name="title" value='<?php
                                                                                                            if (!empty($setval)) {
                                                                                                                echo set_value('title');
                                                                                                            }
                                                                                                            if (!empty($faq->title)) {
                                                                                                                echo $faq->title;
                                                                                                            }
                                                                                                            ?>' placeholder="" required="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> <?php echo lang('description'); ?> &ast;</label>
                                <input type="text" class="form-control form-control-lg" name="description" value='<?php
                                                                                                                    if (!empty($setval)) {
                                                                                                                        echo set_value('description');
                                                                                                                    }
                                                                                                                    if (!empty($faq->description)) {
                                                                                                                        echo $faq->description;
                                                                                                                    }
                                                                                                                    ?>' placeholder="" required="">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> Image &ast;</label>
                                <input type="file" name="img_url" required="">
                            </div>
                            <input type="hidden" name="id" value='<?php
                                                                    if (!empty($faq->id)) {
                                                                        echo $faq->id;
                                                                    }
                                                                    ?>'>
                            <button type="submit" name="submit" class="btn btn-info">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->