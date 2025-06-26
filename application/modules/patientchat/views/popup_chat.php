<div class="patient-chat-popup" id="patientChatPopup">
    <div class="chat-header">
        <div class="chat-title">
            <?php if ($is_patient): ?>
                <i class="fa fa-user-md mr-2"></i> <?php echo lang('chat_with_receptionist'); ?>
            <?php else: ?>
                <i class="fa fa-user mr-2"></i> <?php echo lang('chat_with_patient'); ?>
            <?php endif; ?>
        </div>
        <div class="chat-actions">
            <button type="button" class="minimize-btn" id="minimizeChatBtn" title="Minimize"><i class="fa fa-minus"></i></button>
            <button type="button" class="expand-btn" id="expandChatBtn" title="Expand"><i class="fa fa-expand"></i></button>
            <button type="button" class="close-btn" id="closeChatBtn" title="Close"><i class="fa fa-times"></i></button>
        </div>
    </div>
    
    <div class="chat-body" id="chatPopupBody">
        <div class="chat-contacts" id="chatPopupContacts">
            <div class="search-contact">
                <input type="text" placeholder="<?php echo lang('search'); ?>" id="searchPopupContact" class="form-control">
            </div>

            <?php if ($is_patient): ?>
                <!-- Patient View -->
                <?php if (!empty($receptionists)): ?>
                    <?php foreach ($receptionists as $receptionist): ?>
                        <div class="chat-contact <?php if (isset($receptionist['has_unread']) && $receptionist['has_unread']) echo 'has-unread'; ?>" 
                             data-id="<?php echo $receptionist['id']; ?>" 
                             data-patient-id="<?php echo $patient_id; ?>">
                            <div class="contact-avatar">
                                <i class="fa fa-user-md"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-name"><?php echo $receptionist['name']; ?></div>
                                <div class="contact-status">Receptionist</div>
                            </div>
                            <?php if (isset($receptionist['has_unread']) && $receptionist['has_unread']): ?>
                                <div class="unread-indicator"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-contacts"><?php echo lang('no_receptionists_available'); ?></div>
                <?php endif; ?>
            <?php else: ?>
                <!-- Receptionist View -->
                <?php if (!empty($patients)): ?>
                    <?php foreach ($patients as $patient): ?>
                        <div class="chat-contact <?php if (isset($patient['has_unread']) && $patient['has_unread']) echo 'has-unread'; ?>" 
                             data-id="<?php echo $patient['id']; ?>" 
                             data-receptionist-id="<?php echo $receptionist_id; ?>">
                            <div class="contact-avatar">
                                <i class="fa fa-user"></i>
                            </div>
                            <div class="contact-info">
                                <div class="contact-name"><?php echo $patient['name']; ?> <br> (ID: <?php echo isset($patient['id_new']) ? $patient['id_new'] : $patient['id']; ?>)</div>
                                <div class="contact-status">Patient</div>
                            </div>
                            <?php if (isset($patient['has_unread']) && $patient['has_unread']): ?>
                                <div class="unread-indicator"></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-contacts"><?php echo lang('no_patients_available'); ?></div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <div class="chat-conversation" id="chatPopupConversation" style="display: none;">
            <div class="conversation-header">
                <button class="back-btn" id="backToContactsBtn"><i class="fa fa-arrow-left"></i></button>
                <div class="contact-profile">
                    <div class="contact-avatar small">
                        <i class="fa fa-user<?php echo $is_patient ? '-md' : ''; ?>"></i>
                    </div>
                    <div class="contact-name" id="currentContactName"></div>
                </div>
            </div>
            
            <div class="conversation-messages" id="conversationMessages"></div>
            
            <div class="conversation-input">
                <div class="input-group">
                    <input type="text" id="popupChatInput" placeholder="<?php echo lang('type_message'); ?>">
                    <button id="popupSendBtn"><i class="fa fa-paper-plane"></i></button>
                </div>
            </div>
            
            <input type="hidden" id="popupPatientId" value="<?php echo $is_patient ? $patient_id : ''; ?>">
            <input type="hidden" id="popupReceptionistId" value="<?php echo $is_receptionist ? $receptionist_id : ''; ?>">
            <input type="hidden" id="popupChatPartnerId" value="">
            <input type="hidden" id="popupLastMessageId" value="0">
        </div>
    </div>
</div>

<div class="chat-popup-trigger <?php if ($has_unread) echo 'has-new-messages'; ?>" id="chatPopupTrigger">
    <i class="fa fa-comments"></i>
    <?php if ($has_unread): ?>
        <div class="new-messages-indicator"></div>
    <?php endif; ?>
</div>

<link href="common/extranal/css/patientchat/popup_chat.css" rel="stylesheet">
<!-- Script is loaded in the footer to prevent duplicates --> 