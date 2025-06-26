<link href="common/extranal/css/patientchat.css" rel="stylesheet">
<div class="main-content content-wrapper">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 content-header">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">
                            <i class="fa fa-comments text-primary mr-2"></i>
                            <?php echo lang('patient_receptionist_chat'); ?>
                        </h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo lang('home'); ?></a></li>
                                <li class="breadcrumb-item active"><?php echo lang('patient_receptionist_chat'); ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card custom-card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <?php if ($is_patient): ?>
                            <i class="fa fa-user-md mr-2"></i> <?php echo lang('chat_with_receptionist'); ?>
                        <?php else: ?>
                            <i class="fa fa-user mr-2"></i> <?php echo lang('chat_with_patient'); ?>
                        <?php endif; ?>
                    </h4>
                </div>
                
                <div class="card-body p-0">
                    <div class="chat-container">
                        <div class="contacts-container">
                            <div class="search-box">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                    <input type="text" id="searchChatPartner" class="form-control" placeholder="<?php echo lang('search'); ?>">
                                </div>
                            </div>
                            
                            <div class="contacts-list" id="chatPartnersBlock">
                                <?php if ($is_patient): ?>
                                    <!-- Patient View -->
                                    <?php if (!empty($chat_receptionists)): ?>
                                        <div class="contact-section">
                                            <h6 class="section-title"><?php echo lang('receptionists_you_have_chatted_with'); ?></h6>
                                            
                                            <div id="chatReceptionistsList">
                                                <?php foreach ($chat_receptionists as $receptionist): ?>
                                                    <div class="contact-item <?php if ($selected_receptionist_id == $receptionist['id']) echo 'active'; ?> <?php if ($receptionist['has_unread']) echo 'unread'; ?>" 
                                                        data-id="<?php echo $receptionist['id']; ?>" 
                                                        data-patient-id="<?php echo $patient_id; ?>">
                                                        
                                                        <div class="contact-avatar">
                                                            <i class="fa fa-user-md"></i>
                                                        </div>
                                                        
                                                        <div class="contact-info">
                                                            <h6 class="contact-name"><?php echo $receptionist['name']; ?></h6>
                                                            <p class="contact-status">Receptionist</p>
                                                        </div>
                                                        
                                                        <?php if ($receptionist['has_unread']): ?>
                                                            <div class="unread-badge">
                                                                <span></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($all_receptionists)): ?>
                                        <div class="contact-section">
                                            <h6 class="section-title"><?php echo lang('all_receptionists'); ?></h6>
                                            
                                            <div id="allReceptionistsList">
                                                <?php foreach ($all_receptionists as $receptionist): ?>
                                                    <?php
                                                    // Skip if already in chat history
                                                    $in_history = false;
                                                    foreach ($chat_receptionists as $cr) {
                                                        if ($cr['id'] == $receptionist['id']) {
                                                            $in_history = true;
                                                            break;
                                                        }
                                                    }
                                                    if ($in_history) continue;
                                                    ?>
                                                    
                                                    <div class="contact-item <?php if ($selected_receptionist_id == $receptionist['id']) echo 'active'; ?>" 
                                                        data-id="<?php echo $receptionist['id']; ?>" 
                                                        data-patient-id="<?php echo $patient_id; ?>">
                                                        
                                                        <div class="contact-avatar">
                                                            <i class="fa fa-user-md"></i>
                                                        </div>
                                                        
                                                        <div class="contact-info">
                                                            <h6 class="contact-name"><?php echo $receptionist['name']; ?></h6>
                                                            <p class="contact-status">Receptionist</p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-contacts"><?php echo lang('no_receptionists_available'); ?></div>
                                    <?php endif; ?>
                                    
                                <?php else: ?>
                                    <!-- Receptionist View -->
                                    <?php if (!empty($chat_patients)): ?>
                                        <div class="contact-section">
                                            <h6 class="section-title"><?php echo lang('patients_you_have_chatted_with'); ?></h6>
                                            
                                            <div id="chatPatientsList">
                                                <?php foreach ($chat_patients as $patient): ?>
                                                    <div class="contact-item <?php if ($selected_patient_id == $patient['id']) echo 'active'; ?> <?php if ($patient['has_unread']) echo 'unread'; ?>" 
                                                        data-id="<?php echo $patient['id']; ?>" 
                                                        data-receptionist-id="<?php echo $receptionist_id; ?>">
                                                        
                                                        <div class="contact-avatar">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        
                                                        <div class="contact-info">
                                                            <h6 class="contact-name"><?php echo $patient['name']; ?> <small class="text-muted">(ID: <?php echo $patient['id']; ?>)</small></h6>
                                                            <p class="contact-status">Patient</p>
                                                        </div>
                                                        
                                                        <?php if ($patient['has_unread']): ?>
                                                            <div class="unread-badge">
                                                                <span></span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($all_patients)): ?>
                                        <div class="contact-section">
                                            <h6 class="section-title"><?php echo lang('all_patients'); ?></h6>
                                            
                                            <div id="allPatientsList">
                                                <?php foreach ($all_patients as $patient): ?>
                                                    <?php
                                                    // Skip if already in chat history
                                                    $in_history = false;
                                                    foreach ($chat_patients as $cp) {
                                                        if ($cp['id'] == $patient['id']) {
                                                            $in_history = true;
                                                            break;
                                                        }
                                                    }
                                                    if ($in_history) continue;
                                                    ?>
                                                    
                                                    <div class="contact-item <?php if ($selected_patient_id == $patient['id']) echo 'active'; ?>" 
                                                        data-id="<?php echo $patient['id']; ?>" 
                                                        data-receptionist-id="<?php echo $receptionist_id; ?>">
                                                        
                                                        <div class="contact-avatar">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        
                                                        <div class="contact-info">
                                                            <h6 class="contact-name"><?php echo $patient['name']; ?> <small class="text-muted">(ID: <?php echo $patient['id']; ?>)</small></h6>
                                                            <p class="contact-status">Patient</p>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="no-contacts"><?php echo lang('no_patients_available'); ?></div>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="chat-main">
                            <div class="chat-header">
                                <div class="chat-user-info">
                                    <div class="user-avatar">
                                        <i class="fa fa-user<?php echo $is_patient ? '-md' : ''; ?>"></i>
                                    </div>
                                    <div class="user-details">
                                        <h6 class="user-name"><?php echo $partner_name; ?></h6>
                                        <p class="user-status <?php echo $partner_name ? 'online' : ''; ?>">
                                            <?php echo $partner_name ? 'Online' : lang('select_chat_partner'); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="chat-messages" id="chatBox">
                                <?php if (!empty($chat_messages)): ?>
                                    <?php foreach (array_reverse($chat_messages) as $message): ?>
                                        <?php 
                                        $is_sender = ($is_patient && $message['sender_type'] == 'patient') || 
                                                    (!$is_patient && $message['sender_type'] == 'receptionist');
                                        $class = $is_sender ? 'message-out' : 'message-in';
                                        ?>
                                        <div class="message <?php echo $class; ?>">
                                            <div class="message-content">
                                                <?php echo $message['chat_text']; ?>
                                                <div class="message-time"><?php echo date('h:i A', strtotime($message['date_time'])); ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="no-messages">
                                        <div class="placeholder-img">
                                            <i class="fa fa-comments-o"></i>
                                        </div>
                                        <p><?php echo lang('no_messages_yet'); ?></p>
                                        <small><?php echo lang('start_conversation'); ?></small>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="chat-input">
                                <div class="input-group">
                                    <input type="text" class="form-control message-input" id="chatInput" placeholder="<?php echo lang('type_message'); ?>">
                                    <button class="btn btn-primary send-btn" id="sendBtn">
                                        <i class="fa fa-paper-plane-o"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <?php if ($is_patient): ?>
                                <input type="hidden" id="patientId" value="<?php echo $patient_id; ?>">
                                <input type="hidden" id="receptionistId" value="<?php echo $selected_receptionist_id ?? ''; ?>">
                            <?php else: ?>
                                <input type="hidden" id="patientId" value="<?php echo $selected_patient_id ?? ''; ?>">
                                <input type="hidden" id="receptionistId" value="<?php echo $receptionist_id; ?>">
                            <?php endif; ?>
                            
                            <input type="hidden" id="lastMessageId" value="<?php echo !empty($chat_messages) ? $chat_messages[0]['id'] : 0; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="common/js/codearistos.min.js"></script>
<script src="common/extranal/js/patientchat/patient_chat.js"></script> 