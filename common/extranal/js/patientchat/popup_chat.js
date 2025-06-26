$(document).ready(function () {
    // DOM elements
    const $chatPopup = $('#patientChatPopup');
    const $chatTrigger = $('#chatPopupTrigger');
    const $minimizeBtn = $('#minimizeChatBtn');
    const $expandBtn = $('#expandChatBtn');
    const $closeBtn = $('#closeChatBtn');
    const $chatContacts = $('#chatPopupContacts');
    const $chatConversation = $('#chatPopupConversation');
    const $backBtn = $('#backToContactsBtn');
    const $popupChatInput = $('#popupChatInput');
    const $popupSendBtn = $('#popupSendBtn');
    const $conversationMessages = $('#conversationMessages');
    const $searchPopupContact = $('#searchPopupContact');
    
    // State variables
    let isMinimized = false;
    let isExpanded = false;
    let checkMessagesInterval = null;
    let typingTimeout = null;
    let isTyping = false;
    
    // Initialize
    initPopupChat();
    
    // Chat trigger button click - use document.on for dynamic elements
    $(document).on('click', '#chatPopupTrigger', function (e) {
        e.preventDefault();
        toggleChatPopup();
    });
    
    // Minimize button click
    $(document).on('click', '#minimizeChatBtn', function (e) {
        e.stopPropagation();
        console.log('Minimize button clicked');
        minimizeChatPopup();
    });
    
    // Expand button click
    $(document).on('click', '#expandChatBtn', function (e) {
        e.stopPropagation();
        console.log('Expand button clicked');
        toggleExpandChatPopup();
    });
    
    // Close button click
    $(document).on('click', '#closeChatBtn', function (e) {
        e.stopPropagation();
        console.log('Close button clicked');
        closeChatPopup();
    });
    
    // Back to contacts button click
    $(document).on('click', '#backToContactsBtn', function (e) {
        e.preventDefault();
        console.log('Back button clicked, showing contacts list');
        showContactsList();
    });
    
    // Contact click
    $(document).on('click', '.chat-contact', function () {
        const contactId = $(this).data('id');
        let patientId, receptionistId;
        
        // Get the displayed name for the header
        const contactName = $(this).find('.contact-name').text();
        
        console.log('Contact clicked:', contactId, contactName);
        
        // Determine if this is a patient or receptionist contact
        if ($(this).data('patient-id')) {
            patientId = $(this).data('patient-id');
            receptionistId = contactId;
            console.log('Patient chatting with receptionist', patientId, receptionistId);
        } else {
            patientId = contactId;
            receptionistId = $(this).data('receptionist-id');
            console.log('Receptionist chatting with patient', patientId, receptionistId);
        }
        
        // Set hidden fields
        $('#popupPatientId').val(patientId);
        $('#popupReceptionistId').val(receptionistId);
        $('#popupChatPartnerId').val(contactId);
        $('#currentContactName').text(contactName);
        
        // Update contact selection UI
        $('.chat-contact').removeClass('active');
        $(this).addClass('active');
        
        // Load conversation
        loadConversation(patientId, receptionistId, contactId);
        
        // Remove unread indicator
        $(this).removeClass('has-unread');
        $(this).find('.unread-indicator').remove();
    });
    
    // Send button click
    $(document).on('click', '#popupSendBtn', function () {
        sendPopupMessage();
    });
    
    // Enter key in input
    $(document).on('keypress', '#popupChatInput', function (e) {
        if (e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            console.log('Enter key pressed, sending message');
            sendPopupMessage();
        }
    });
    
    // Search contacts
    $(document).on('input', '#searchPopupContact', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        $('.chat-contact').each(function() {
            const contactName = $(this).find('.contact-name').text().toLowerCase();
            if (contactName.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Typing indicator
    $popupChatInput.on('input', function() {
        if (!isTyping) {
            isTyping = true;
            const patientId = $('#popupPatientId').val();
            const receptionistId = $('#popupReceptionistId').val();
            
            // Send typing indicator status to server
            // This would require a server endpoint to be implemented
            /*
            $.ajax({
                url: 'patientchat/typing_status',
                type: 'POST',
                data: {
                    patient_id: patientId,
                    receptionist_id: receptionistId,
                    is_typing: true
                }
            });
            */
        }
        
        // Reset typing timeout
        clearTimeout(typingTimeout);
        typingTimeout = setTimeout(function() {
            isTyping = false;
            const patientId = $('#popupPatientId').val();
            const receptionistId = $('#popupReceptionistId').val();
            
            // Send stopped typing indicator to server
            // This would require a server endpoint to be implemented
            /*
            $.ajax({
                url: 'patientchat/typing_status',
                type: 'POST',
                data: {
                    patient_id: patientId,
                    receptionist_id: receptionistId,
                    is_typing: false
                }
            });
            */
        }, 1000);
    });
    
    // Functions
    
    function initPopupChat() {
        // Check if there are unread messages
        if ($('#chatPopupTrigger').hasClass('has-new-messages')) {
            // Visual notification - pulse animation is handled in CSS
            
            // Automatically open the chat popup after a short delay if user has unread messages
            setTimeout(function () {
                openChatPopup();
            }, 1500);
        }
        
        // Add sound notification for new messages
        // This would be triggered when a new message arrives
        // See checkNewPopupMessages() function
    }
    
    function toggleChatPopup() {
        if ($('#patientChatPopup').is(':visible')) {
            closeChatPopup();
        } else {
            openChatPopup();
        }
    }
    
    function openChatPopup() {
        $('#patientChatPopup').css('display', 'flex').hide().fadeIn(300);
        $('#chatPopupTrigger').removeClass('has-new-messages');
        $('#chatPopupTrigger').find('.new-messages-indicator').remove();
        
        // Start checking for new messages
        startCheckingNewMessages();
    }
    
    function closeChatPopup() {
        console.log('Closing chat popup');
        $('#patientChatPopup').fadeOut(300);
        
        // Reset state
        isMinimized = false;
        isExpanded = false;
        $('#patientChatPopup').removeClass('minimized expanded');
        
        // Show contacts view
        showContactsList();
        
        // Stop checking for new messages
        stopCheckingNewMessages();
    }
    
    function minimizeChatPopup() {
        console.log('Toggling minimize chat popup');
        if (isMinimized) {
            $('#patientChatPopup').removeClass('minimized');
            isMinimized = false;
            console.log('Chat restored from minimized state');
        } else {
            $('#patientChatPopup').addClass('minimized');
            isMinimized = true;
            console.log('Chat minimized');
        }
    }
    
    function toggleExpandChatPopup() {
        console.log('Toggling expand chat popup');
        if (isExpanded) {
            $('#patientChatPopup').removeClass('expanded');
            isExpanded = false;
            console.log('Chat restored from expanded state');
        } else {
            $('#patientChatPopup').addClass('expanded');
            isExpanded = true;
            console.log('Chat expanded');
        }
    }
    
    function showContactsList() {
        console.log('Showing contacts list');
        $('#chatPopupConversation').hide();
        $('#chatPopupContacts').show();
        $('#popupChatPartnerId').val('');
        $('#popupLastMessageId').val(0);
    }
    
    function loadConversation(patientId, receptionistId, partnerId) {
        // Show loading indicator
        console.log('Loading conversation for:', patientId, receptionistId, partnerId);
        
        $('#conversationMessages').html('<div class="text-center p-3"><i class="fa fa-spinner fa-spin"></i> Loading messages...</div>');
        
        // Show conversation view immediately while waiting for data
        $('#chatPopupContacts').hide();
        $('#chatPopupConversation').show();
        
        $.ajax({
            url: 'patientchat/load_chat',
            type: 'GET',
            data: {
                patient_id: patientId,
                receptionist_id: receptionistId
            },
            dataType: 'json',
            success: function (response) {
                console.log('Chat load response:', response);
                
                if (response.status === 'success') {
                    // Update contact name
                    $('#currentContactName').text(response.partner_name);
                    
                    // Clear messages container
                    $('#conversationMessages').empty();
                    
                    // Add messages
                    let lastMessageId = 0;
                    
                    if (response.messages.length === 0) {
                        $('#conversationMessages').html(`
                            <div class="no-messages">
                                <div class="placeholder-img">
                                    <i class="fa fa-comments-o"></i>
                                </div>
                                <p>No messages yet</p>
                                <small>Start a conversation with ${response.partner_name}</small>
                            </div>
                        `);
                    } else {
                        for (let i = response.messages.length - 1; i >= 0; i--) {
                            const message = response.messages[i];
                            const messageClass = message.is_sender ? 'message-out' : 'message-in';
                            
                            const messageHtml = `
                                <div class="message ${messageClass}">
                                    <div class="message-content">
                                        ${message.text}
                                        <div class="message-time">${message.date_time}</div>
                                    </div>
                                </div>
                            `;
                            
                            $('#conversationMessages').append(messageHtml);
                            
                            if (message.id > lastMessageId) {
                                lastMessageId = message.id;
                            }
                        }
                    }
                    
                    // Update last message ID
                    $('#popupLastMessageId').val(lastMessageId);
                    
                    // Focus the input field
                    $('#popupChatInput').focus();
                    
                    // Scroll to bottom
                    scrollConversationToBottom();
                } else {
                    console.error('Error loading conversation:', response.message);
                    showNotification('Error loading conversation: ' + response.message, 'error');
                    $('#conversationMessages').html('<div class="text-center text-danger p-3">Failed to load messages. Please try again.</div>');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error:', status, error);
                showNotification('Error connecting to server', 'error');
                $('#conversationMessages').html('<div class="text-center text-danger p-3">Failed to load messages. Please try again.</div>');
            }
        });
    }
    
    function sendPopupMessage() {
        const messageText = $('#popupChatInput').val().trim();
        if (!messageText) {
            return;
        }
        
        const patientId = $('#popupPatientId').val();
        const receptionistId = $('#popupReceptionistId').val();
        
        console.log('Sending message:', {
            text: messageText,
            patientId: patientId,
            receptionistId: receptionistId
        });
        
        if (!patientId || !receptionistId) {
            showNotification('Please select a chat partner', 'error');
            return;
        }
        
        // Add optimistic message immediately (will be confirmed when server responds)
        const optimisticMessageId = 'temp-' + Date.now();
        const currentTime = new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
        
        const optimisticMessageHtml = `
            <div class="message message-out" id="${optimisticMessageId}">
                <div class="message-content">
                    ${messageText}
                    <div class="message-time">${currentTime} <i class="fa fa-clock-o"></i></div>
                </div>
            </div>
        `;
        
        $('#conversationMessages').append(optimisticMessageHtml);
        scrollConversationToBottom();
        
        // Clear input
        $('#popupChatInput').val('');
        
        $.ajax({
            url: 'patientchat/send_message',
            type: 'POST',
            data: {
                patient_id: patientId,
                receptionist_id: receptionistId,
                message: messageText
            },
            dataType: 'json',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            success: function (response) {
                console.log('Message sent response:', response);
                
                if (response.status === 'success') {
                    // Update optimistic message with real data
                    $(`#${optimisticMessageId} .message-time`).html(response.date_time);
                    
                    // Update message ID
                    $(`#${optimisticMessageId}`).attr('id', 'msg-' + response.message_id);
                    
                    // Update last message ID
                    $('#popupLastMessageId').val(response.message_id);
                } else {
                    // Show error and mark the message as failed
                    $(`#${optimisticMessageId}`).addClass('failed');
                    $(`#${optimisticMessageId} .message-time`).html(`
                        <span class="text-danger">Failed to send <i class="fa fa-exclamation-circle"></i></span>
                    `);
                    console.error('Failed to send message:', response.message);
                    showNotification('Error sending message: ' + response.message, 'error');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX error when sending message:', status, error);
                console.error('Response:', xhr.responseText);
                // Show error and mark the message as failed
                $(`#${optimisticMessageId}`).addClass('failed');
                $(`#${optimisticMessageId} .message-time`).html(`
                    <span class="text-danger">Failed to send <i class="fa fa-exclamation-circle"></i></span>
                `);
                showNotification('Error connecting to server', 'error');
            }
        });
    }
    
    function startCheckingNewMessages() {
        // Clear any existing interval
        stopCheckingNewMessages();
        
        // Start new interval - check every 5 seconds
        checkMessagesInterval = setInterval(checkNewPopupMessages, 5000);
        
        // Also check immediately
        checkNewPopupMessages();
    }
    
    function stopCheckingNewMessages() {
        if (checkMessagesInterval) {
            clearInterval(checkMessagesInterval);
            checkMessagesInterval = null;
        }
    }
    
    function checkNewPopupMessages() {
        const patientId = $('#popupPatientId').val();
        const receptionistId = $('#popupReceptionistId').val();
        const lastMessageId = $('#popupLastMessageId').val();
        const isConversationOpen = $chatConversation.is(':visible');
        
        // If we're in the contacts view or no chat is selected, check for new messages for all contacts
        if (!isConversationOpen || !patientId || !receptionistId) {
            checkAllContactsForNewMessages();
            return;
        }
        
        // Otherwise, check for new messages in current conversation
        $.ajax({
            url: 'patientchat/check_new_messages',
            type: 'GET',
            data: {
                patient_id: patientId,
                receptionist_id: receptionistId,
                last_message_id: lastMessageId
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success' && response.messages.length > 0) {
                    // Add new messages to conversation
                    let newLastMessageId = lastMessageId;
                    
                    for (let i = 0; i < response.messages.length; i++) {
                        const message = response.messages[i];
                        
                        const messageHtml = `
                            <div class="message message-in" id="msg-${message.id}">
                                <div class="message-content">
                                    ${message.text}
                                    <div class="message-time">${message.date_time}</div>
                                </div>
                            </div>
                        `;
                        
                        $conversationMessages.append(messageHtml);
                        
                        if (message.id > newLastMessageId) {
                            newLastMessageId = message.id;
                        }
                    }
                    
                    // Update last message ID
                    $('#popupLastMessageId').val(newLastMessageId);
                    
                    // Play notification sound if window is not focused
                    if (!document.hasFocus()) {
                        playNotificationSound();
                    }
                    
                    // Scroll to bottom
                    scrollConversationToBottom();
                }
            }
        });
    }
    
    function checkAllContactsForNewMessages() {
        $.ajax({
            url: 'patientchat/check_all_contacts',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Update contact list with unread indicators
                    updateContactsWithUnreadStatus(response.contacts);
                    
                    // If there are new messages, show notification on trigger button
                    if (response.has_unread) {
                        if (!$chatPopup.is(':visible') && !$chatTrigger.hasClass('has-new-messages')) {
                            $chatTrigger.addClass('has-new-messages');
                            
                            if (!$chatTrigger.find('.new-messages-indicator').length) {
                                $chatTrigger.append('<div class="new-messages-indicator"></div>');
                            }
                            
                            // Play notification sound if window is not focused
                            if (!document.hasFocus()) {
                                playNotificationSound();
                            }
                        }
                    }
                }
            }
        });
    }
    
    function updateContactsWithUnreadStatus(contacts) {
        // Remove all unread indicators first
        $('.chat-contact').removeClass('has-unread').find('.unread-indicator').remove();
        
        // Add unread indicators to contacts with new messages
        for (let i = 0; i < contacts.length; i++) {
            const contact = contacts[i];
            if (contact.has_unread) {
                const $contact = $(`.chat-contact[data-id="${contact.id}"]`);
                $contact.addClass('has-unread');
                
                if (!$contact.find('.unread-indicator').length) {
                    $contact.append('<div class="unread-indicator"></div>');
                }
            }
        }
    }
    
    function scrollConversationToBottom() {
        try {
            const conversationElement = document.getElementById('conversationMessages');
            if (conversationElement) {
                console.log('Scrolling conversation to bottom');
                conversationElement.scrollTop = conversationElement.scrollHeight;
            }
        } catch (e) {
            console.error('Error scrolling to bottom:', e);
        }
    }
    
    function playNotificationSound() {
        // Create audio element for notification sound
        // This could be moved to the page initialization to avoid creating it every time
        const audio = new Audio('common/audio/notification.mp3');
        audio.volume = 0.5;
        audio.play().catch(function(error) {
            // Autoplay might be blocked by browser policy
            console.log("Notification sound couldn't play:", error);
        });
    }
    
    function showNotification(message, type) {
        console.log('Showing notification:', type, message);
        
        if (type === 'error') {
            // Create a floating notification
            const $notification = $(`
                <div class="chat-notification error">
                    <i class="fa fa-exclamation-circle"></i> ${message}
                </div>
            `);
            
            $('body').append($notification);
            
            // Show and then remove after delay
            $notification.fadeIn(300).delay(3000).fadeOut(300, function() {
                $(this).remove();
            });
        } else {
            // Success notification
            const $notification = $(`
                <div class="chat-notification success">
                    <i class="fa fa-check-circle"></i> ${message}
                </div>
            `);
            
            $('body').append($notification);
            
            // Show and then remove after delay
            $notification.fadeIn(300).delay(2000).fadeOut(300, function() {
                $(this).remove();
            });
        }
    }
    
    // Add popup chat to the dashboard - moved outside document.ready to avoid duplicate event binding issues
    function loadChatPopup() {
        if ($('body').hasClass('dashboard_page') || $('body').hasClass('home_page') || true) {
            // Check if popup already exists to prevent duplicates
            if ($('#patientChatPopup').length === 0) {
                $.ajax({
                    url: 'patientchat/popup',
                    type: 'GET',
                    success: function (response) {
                        if (response && response.trim() !== '') {
                            $('body').append(response);
                            console.log('Chat popup loaded successfully');
                        } else {
                            console.log('Empty response from chat popup');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading chat popup:', error);
                    }
                });
            }
        }
    }
    
    // Load the chat popup when the page is ready
    loadChatPopup();
}); 