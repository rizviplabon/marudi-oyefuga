<!--sidebar end-->
<!--main content start-->
<div class="main-content content-wrapper">
<div class="page-content">
    <div class="container-fluid">
    <div class="row">
                            <div class="col-12 content-header">
                                <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Expense Categories</h4>&nbsp;&nbsp; &nbsp;&nbsp;
                        &nbsp;&nbsp;
                        <?php if($this->ion_auth->in_group('admin')){                
        if($this->settings->dashboard_theme == 'main'){ ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                        <?php }} ?>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                        <li class="breadcrumb-item">Finance</li>
                                        <li class="breadcrumb-item active"><?php echo lang('expense_categories'); ?></li>
                                    </ol>
                                </div>

                                </div>
                            </div>
                        </div>
        <!-- page start-->
        <section class="card">
        <div class="card-header table_header">
                                        <h4 class="card-title mb-0 col-lg-8"><?php echo lang('expense_categories') ?></h4> 
                                        <div class="col-lg-4 no-print pull-right"> 
                                        <a  href="finance/addExpenseCategoryView" class="btn btn-primary waves-effect waves-light w-xs"><i class="fa fa-plus-circle"></i> <?php echo lang('add_expense_category'); ?></a>
                                           
                                        </div>
                                    </div>
        
            <div class="card-body">
            <div class="table-responsive adv-table">
                                            <table class="table mb-0" id="editable-sample">
                        <thead>
                            <tr>
                                <th><?php echo lang('category'); ?></th>
                                <th><?php echo lang('description'); ?></th>
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <th class="no-print"><?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                       

                        <?php foreach ($categories as $category) { ?>
                            <tr class="">
                                <td><?php echo $category->category; ?></td>
                                <td> <?php echo $category->description; ?></td>
                                <?php if ($this->ion_auth->in_group('admin')) { ?>
                                    <?php                 
        if($this->settings->dashboard_theme == 'main'){ ?>
                                        <td class="no-print">
                                            <div class="btn-group">
                                                <a class="hover-primary dropdown-toggle no-caret"
                                                    data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item"
                                                    href="finance/editExpenseCategory?id=<?php echo $category->id; ?>">Edit
                                                        </a>
                                                   
                                                    <a class="dropdown-item"
                                                        href="finance/deleteExpenseCategory?id=<?php echo $category->id; ?>"
                                                        onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        <?php }else{ ?>
                                    <td class="no-print">
                                        <a class="btn btn-soft-info btn-xs editbutton" title="<?php echo lang('edit'); ?>" href="finance/editExpenseCategory?id=<?php echo $category->id; ?>"><i class="fa fa-edit"></i> </a>
                                        <a class="btn btn-soft-danger btn-xs delete_button" title="<?php echo lang('delete'); ?>" href="finance/deleteExpenseCategory?id=<?php echo $category->id; ?>" onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa fa-trash"></i> </a>
                                    </td>
                                    <?php } ?>
                                <?php } ?>
                            </tr>
                        <?php } ?>


                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </div>
</div>
</div>
<!--main content end-->
<!--footer start-->


<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/finance/expense_category.js"></script>