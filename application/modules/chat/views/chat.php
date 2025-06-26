<link href="common/extranal/css/chat.css" rel="stylesheet">
<div class="main-content content-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 content-header">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0"><?php echo lang('chat'); ?></h4>&nbsp;&nbsp; &nbsp;&nbsp;
                &nbsp;&nbsp;
                <?php if ($this->ion_auth->in_group('admin')) {
                    if ($this->settings->dashboard_theme == 'main') { ?>
                        <i class="mdi mdi-home-outline"></i> &nbsp;&nbsp; - &nbsp;&nbsp;
                <?php }
                } ?>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                <li class="breadcrumb-item active"><?php echo lang('chat'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header table_header">
                    <h4 class="card-title mb-0 col-lg-12"><?php echo lang('chat'); ?></h4>
                </div>
                
                <div class="card-body panel-body_class">
                    <div class="col-md-12 row">
                        <!-- Contact List Section -->
                        <div class="col-md-4 search_chat">
                            <div class="search-container">
                                <input type="text" id="searchChat" class="form-control" placeholder="<?php echo lang('search'); ?>">
                            </div>
                            <div id="chattersBlock">
                                <p class="search_chat_p"><?php echo lang('admin');?></p>
                                <div id="adminChatters">
                                    <?php for($i=0; $i < count($admins); $i++) { 
                                        if($current_user != $admins[$i]['id']) { ?>
                                        <button class="ca-btn ca-chat-btn d-block <?php if($receiver_id == $admins[$i]['id']) { ?>ca-selected-chat<?php } else if($admins[$i]['newChat'] == 'unread') { ?>newChat<?php } ?>" data-id="<?php echo $admins[$i]['id']; ?>">
                                            <div class="d-flex align-items-center">
                                                <span class="status-indicator <?php echo ($admins[$i]['newChat'] == 'unread') ? 'status-online' : 'status-offline'; ?>"></span>
                                                <span class="chat-user-name"><?php echo $admins[$i]['username']; ?></span>
                                            </div>
                                        </button>
                                    <?php } } ?>
                                </div>
                                <p class="search_chat_p"><?php echo lang('employee');?></p>
                                <div id="employeeChatters">
                                    <?php for($i=0; $i < count($employeeChat); $i++) { 
                                        if($current_user != $employeeChat[$i]['ion_user_id']) { ?>
                                        <button class="ca-btn ca-chat-btn d-block <?php if($receiver_id == $employeeChat[$i]['ion_user_id']) { ?>ca-selected-chat<?php }  else if($employeeChat[$i]['newChat'] == 'unread') { ?>newChat<?php } ?>" data-id="<?php echo $employeeChat[$i]['ion_user_id']; ?>">
                                            <div class="d-flex align-items-center">
                                                <span class="status-indicator <?php echo ($employeeChat[$i]['newChat'] == 'unread') ? 'status-online' : 'status-offline'; ?>"></span>
                                                <span class="chat-user-name"><?php echo $employeeChat[$i]['name']; ?></span>
                                            </div>
                                        </button>
                                    <?php } } ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Chat Area Section -->
                        <div class="col-md-8 chat_info">
                            <div class="chat-container h-100 d-flex flex-column">
                                <!-- Chat Header -->
                                <div class="chatInfo">
                                    <?php if(!empty($user)) { ?>
                                        <div class="d-flex align-items-center">
                                            <div class="status-indicator status-online"></div>
                                            <div>
                                                <?php echo $user; ?>
                                                <div class="chat-status small text-muted"><?php echo lang('online'); ?></div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="text-center w-100 text-muted">
                                            <?php echo lang('select_a_user_to_start_chatting'); ?>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr class="chat_hr">
                                
                                <!-- Chat Messages -->
                                <div class="chatBox">
                                    <?php echo $chats; ?>
                                </div>
                                
                                <!-- Chat Input Area -->
                                <div id="sendDiv">
                                    <input type="text" class="form-control chatInput" placeholder="<?php echo lang('type_a_message'); ?>">
                                    <button class="btn btn-soft-primary btn-rounded waves-effect waves-light caSendBtn">
                                        <?php echo lang('send'); ?>
                                    </button>
                                </div>
                                
                                <!-- Hidden Inputs -->
                                <input type="hidden" id="receiverId" value="<?php echo $receiver_id; ?>">
                                <input type="hidden" id="lastMessageId" value="<?php echo $lastMessageId; ?>">
                                <input type="hidden" id="recentMessageId" value="<?php echo $recentMessageId; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="common/js/codearistos.min.js"></script>
<script src="common/extranal/js/chat_module.js"></script>


