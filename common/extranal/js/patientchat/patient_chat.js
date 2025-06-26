$(document).ready(function () {
    // Initialize
    scrollChatToBottom();
    animateUIElements();
    
    // Search function for chat partners
    $('#searchChatPartner').on('keyup', function () {
        var value = $(this).val().toLowerCase();
        $('.contact-item').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    // Chat partner selection with enhanced animations
    $(document).on('click', '.contact-item', function () {
        var partnerId = $(this).data('id');
        var patientId, receptionistId;
        
        // Add loading animation
        showLoadingIndicator();
        
        // Determine if this is a patient or receptionist button
        if ($(this).data('patient-id')) {
            patientId = $(this).data('patient-id');
            receptionistId = partnerId;
        } else {
            patientId = partnerId;
            receptionistId = $(this).data('receptionist-id');
        }
        
        loadChat(patientId, receptionistId);
        
        // UI updates with animation
        $('.contact-item').removeClass('active');
        $(this).addClass('active');
        if ($(this).hasClass('unread')) {
            $(this).removeClass('unread');
            $(this).find('.unread-badge').remove();
        }
    });
    
    // Send button click handler with animation
    $('#sendBtn').on('click', function () {
        $(this).addClass('sending');
        setTimeout(function() {
            $('#sendBtn').removeClass('sending');
        }, 300);
        sendMessage();
    });
    
    // Enter key in chat input
    $('#chatInput').on('keypress', function (e) {
        if (e.which === 13) {
            $('#sendBtn').addClass('sending');
            setTimeout(function() {
                $('#sendBtn').removeClass('sending');
            }, 300);
            sendMessage();
            return false;
        }
    });
    
    // Typing indicator
    $('#chatInput').on('input', function() {
        if ($(this).val().length > 0) {
            sendTypingStatus(true);
        } else {
            sendTypingStatus(false);
        }
    });
    
    // Set up polling for new messages and typing status
    setInterval(checkNewMessages, 3000);
    setInterval(checkTypingStatus, 3000);
    
    // Function to send a message
    function sendMessage() {
        var messageText = $('#chatInput').val().trim();
        if (!messageText) {
            return;
        }
        
        var patientId = $('#patientId').val();
        var receptionistId = $('#receptionistId').val();
        
        if (!patientId || !receptionistId) {
            showToast('Please select a chat partner', 'error');
            return;
        }
        
        // Remove typing indicator when sending a message
        sendTypingStatus(false);
        $('.typing-indicator').remove();
        
        // Show temporary message with sending animation
        var tempMessageId = 'msg_' + new Date().getTime();
        var tempMessageHtml = '<div class="message message-out sending" id="' + tempMessageId + '">' +
            '<div class="message-content">' +
            messageText +
            '<div class="message-time">Sending...</div>' +
            '</div>' +
            '</div>';
            
        $('#chatBox').append(tempMessageHtml);
        scrollChatToBottom();
        $('#chatInput').val('');
        
        $.ajax({
            url: 'patientchat/send_message',
            type: 'POST',
            data: {
                patient_id: patientId,
                receptionist_id: receptionistId,
                message: messageText
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    // Replace temporary message with the real one
                    $('#' + tempMessageId).removeClass('sending');
                    $('#' + tempMessageId).find('.message-time').text(formatTime(response.date_time));
                    
                    // Update last message ID
                    $('#lastMessageId').val(response.message_id);
                } else {
                    // Show error on the temporary message
                    $('#' + tempMessageId).addClass('error');
                    $('#' + tempMessageId).find('.message-time').text('Error: ' + response.message);
                    
                    showToast('Error sending message: ' + response.message, 'error');
                }
            },
            error: function () {
                // Show error on the temporary message
                $('#' + tempMessageId).addClass('error');
                $('#' + tempMessageId).find('.message-time').text('Network error');
                
                showToast('Error connecting to server', 'error');
            }
        });
    }
    
    // Function to load chat with a specific partner
    function loadChat(patientId, receptionistId) {
        console.log("Loading chat for patient: " + patientId + " and receptionist: " + receptionistId);
        
        $.ajax({
            url: 'patientchat/load_chat',
            type: 'GET',
            data: {
                patient_id: patientId,
                receptionist_id: receptionistId
            },
            dataType: 'json',
            success: function (response) {
                // Hide loading indicator
                hideLoadingIndicator();
                
                console.log("Chat load response:", response);
                
                if (response.status === 'success') {
                    // Update chat partner info with animation
                    updateChatPartnerInfo(response.partner_name);
                    
                    // Update hidden fields
                    $('#patientId').val(patientId);
                    $('#receptionistId').val(receptionistId);
                    
                    // Clear chat box with fade effect
                    $('#chatBox').fadeOut(100, function() {
                        $(this).empty();
                        
                        // Add messages or no-messages template
                        if (!response.messages || response.messages.length === 0) {
                            $(this).html(
                                '<div class="no-messages">' +
                                '<div class="placeholder-img">' +
                                '<i class="fa fa-comments-o"></i>' +
                                '</div>' +
                                '<p>No messages yet</p>' +
                                '<small>Start a conversation</small>' +
                                '</div>'
                            );
                        } else {
                            // Add messages with staggered animation
                            var messages = response.messages.reverse();
                            var messageDelay = 0;
                            
                            for (var i = 0; i < messages.length; i++) {
                                var message = messages[i];
                                if (!message) continue; // Skip undefined messages
                                
                                // Check which message class to use
                                var messageClass = '';
                                if (message.is_sender !== undefined) {
                                    messageClass = message.is_sender ? 'message-out' : 'message-in';
                                } else if (message.sender_type !== undefined) {
                                    // Handle if sender_type is provided
                                    var userType = $('#patientId').val() === patientId ? 'patient' : 'receptionist';
                                    messageClass = message.sender_type === userType ? 'message-out' : 'message-in';
                                } else {
                                    console.error("Message missing sender information:", message);
                                    messageClass = 'message-in'; // Default
                                }
                                
                                var delayClass = messageDelay > 0 ? 'delay-' + messageDelay : '';
                                var messageText = message.text || message.chat_text || "Message content unavailable";
                                var messageTime = formatTime(message.date_time);
                                
                                var messageHtml = '<div class="message ' + messageClass + ' ' + delayClass + '">' +
                                    '<div class="message-content">' +
                                    messageText +
                                    '<div class="message-time">' + messageTime + '</div>' +
                                    '</div>' +
                                    '</div>';
                                
                                $(this).append(messageHtml);
                                
                                if (i < 5) { // Only stagger the last 5 messages for performance
                                    messageDelay += 1;
                                }
                            }
                            
                            // Update last message ID
                            if (messages.length > 0) {
                                var lastMessage = messages[messages.length - 1];
                                if (lastMessage && lastMessage.id) {
                                    $('#lastMessageId').val(lastMessage.id);
                                }
                            }
                        }
                        
                        $(this).fadeIn(200, function() {
                            scrollChatToBottom();
                        });
                    });
                } else {
                    showToast('Error loading chat: ' + (response.message || 'Unknown error'), 'error');
                }
            },
            error: function (xhr, status, error) {
                hideLoadingIndicator();
                console.error("AJAX error:", status, error);
                console.error("Response text:", xhr.responseText);
                showToast('Error connecting to server: ' + error, 'error');
            }
        });
    }
    
    // Function to check for new messages
    function checkNewMessages() {
        var patientId = $('#patientId').val();
        var receptionistId = $('#receptionistId').val();
        var lastMessageId = $('#lastMessageId').val();
        
        if (!patientId || !receptionistId) {
            return;
        }
        
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
                    // Remove no-messages div if present
                    $('.no-messages').fadeOut(200, function() {
                        $(this).remove();
                    });
                    
                    // Add new messages to chat box with animation
                    var newLastMessageId = lastMessageId;
                    
                    for (var i = 0; i < response.messages.length; i++) {
                        var message = response.messages[i];
                        
                        var messageHtml = '<div class="message message-in new-message">' +
                            '<div class="message-content">' +
                            message.text +
                            '<div class="message-time">' + formatTime(message.date_time) + '</div>' +
                            '</div>' +
                            '</div>';
                        
                        $('#chatBox').append(messageHtml);
                        
                        // Play notification sound for new messages
                        playNotificationSound();
                        
                        if (parseInt(message.id) > parseInt(newLastMessageId)) {
                            newLastMessageId = message.id;
                        }
                    }
                    
                    $('#lastMessageId').val(newLastMessageId);
                    scrollChatToBottom();
                    
                    // Remove new-message class after animation completes
                    setTimeout(function() {
                        $('.new-message').removeClass('new-message');
                    }, 1000);
                }
            }
        });
    }
    
    // Function to send typing status
    function sendTypingStatus(isTyping) {
        var patientId = $('#patientId').val();
        var receptionistId = $('#receptionistId').val();
        
        if (!patientId || !receptionistId) {
            return;
        }
        
        $.ajax({
            url: 'patientchat/typing_status',
            type: 'POST',
            data: {
                patient_id: patientId,
                receptionist_id: receptionistId,
                is_typing: isTyping
            },
            dataType: 'json'
        });
    }
    
    // Function to check if the other person is typing
    function checkTypingStatus() {
        var patientId = $('#patientId').val();
        var receptionistId = $('#receptionistId').val();
        
        if (!patientId || !receptionistId) {
            return;
        }
        
        $.ajax({
            url: 'patientchat/check_typing',
            type: 'GET',
            data: {
                patient_id: patientId,
                receptionist_id: receptionistId
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    if (response.is_typing) {
                        // Show typing indicator if not already shown
                        if ($('.typing-indicator').length === 0) {
                            $('#chatBox').append(
                                '<div class="typing-indicator">' +
                                '<span></span><span></span><span></span>' +
                                '</div>'
                            );
                            scrollChatToBottom();
                        }
                    } else {
                        // Remove typing indicator
                        $('.typing-indicator').remove();
                    }
                }
            }
        });
    }
    
    // Helper function to scroll chat to bottom
    function scrollChatToBottom() {
        var chatBox = document.getElementById('chatBox');
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    }
    
    // Format time for display
    function formatTime(dateTimeStr) {
        var date = new Date(dateTimeStr);
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0' + minutes : minutes;
        return hours + ':' + minutes + ' ' + ampm;
    }
    
    // Toast notification
    function showToast(message, type) {
        // Use the existing toast system or create a simple alert
        if (typeof toastr !== 'undefined') {
            toastr[type](message);
        } else {
            alert(message);
        }
    }
    
    // Show loading indicator
    function showLoadingIndicator() {
        if ($('#loadingIndicator').length === 0) {
            $('<div id="loadingIndicator" class="chat-loading"><div class="spinner"></div></div>').appendTo('.chat-main');
        }
    }
    
    // Hide loading indicator
    function hideLoadingIndicator() {
        $('#loadingIndicator').fadeOut(200, function() {
            $(this).remove();
        });
    }
    
    // Update chat partner info with animation
    function updateChatPartnerInfo(partnerName) {
        $('.user-name').fadeOut(100, function() {
            $(this).text(partnerName).fadeIn(200);
        });
        
        $('.user-status').fadeOut(100, function() {
            $(this).text('Online').addClass('online').fadeIn(200);
        });
    }
    
    // Animate UI elements on page load
    function animateUIElements() {
        // Stagger animation for contact items
        $('.contact-item').each(function(index) {
            var $this = $(this);
            setTimeout(function() {
                $this.addClass('animate-in');
            }, 100 * index);
        });
        
        // Animate chat header
        $('.chat-header').addClass('animate-in');
        
        // Animate input box
        $('.chat-input').addClass('animate-in');
    }
    
    // Play notification sound
    function playNotificationSound() {
        // Check if notification sound exists
        var notificationSound = document.getElementById('notificationSound');
        if (!notificationSound) {
            // Create audio element if it doesn't exist
            notificationSound = document.createElement('audio');
            notificationSound.id = 'notificationSound';
            notificationSound.src = 'common/assets/sounds/notification.mp3'; // You'll need to add this sound file
            notificationSound.style.display = 'none';
            document.body.appendChild(notificationSound);
        }
        
        // Play the sound
        try {
            notificationSound.play();
        } catch (e) {
            console.log('Could not play notification sound: ' + e.message);
        }
    }
    
    // Add CSS for additional animations
    $('<style>\
        .animate-in { animation: fadeInUp 0.5s ease-out; }\
        .sending { opacity: 0.7; }\
        .error { background-color: rgba(255, 94, 91, 0.1); }\
        .new-message { animation: newMessage 0.5s ease; }\
        .chat-loading { position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,0.7); display: flex; align-items: center; justify-content: center; z-index: 100; }\
        .spinner { width: 40px; height: 40px; border-radius: 50%; border: 3px solid rgba(84, 105, 212, 0.1); border-top-color: var(--primary-color); animation: spin 1s infinite linear; }\
        @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }\
        @keyframes newMessage { 0% { transform: scale(0.8); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }\
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }\
    </style>').appendTo('head');
}); 