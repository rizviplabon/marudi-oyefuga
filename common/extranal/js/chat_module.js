"use strict";

// Send message function
function sendMessage() {
    let chat = $('.chatInput').val();
    let receiverId = $('#receiverId').val();
    if (chat.trim()) {
        // Get current time for display
        let now = new Date();
        let hours = now.getHours().toString().padStart(2, '0');
        let minutes = now.getMinutes().toString().padStart(2, '0');
        let timeString = hours + ':' + minutes;
        
        $.ajax({
            url: 'chat/sendChat?chat=' + encodeURIComponent(chat) + '&receiverId=' + receiverId,
            method: 'GET',
            data: '',
            dataType: 'json',
            success: function (response) {
                // Append message with timestamp
                $('.chatBox').append(
                    '<div class="message-container"><span class="chat-sender">' + 
                    chat + 
                    '<span class="chat-time">' + timeString + '</span></span></div>'
                );
                $('.chatInput').val('');
                
                // Scroll to bottom of chat
                scrollToBottom();
            }
        });
    }
}

// Scroll chat to bottom
function scrollToBottom() {
    let chatBox = $('.chatBox');
    chatBox.scrollTop(chatBox[0].scrollHeight);
}

// Send button click event
$('.caSendBtn').on('click', function () {
    sendMessage();
});

// Enter key press event
$('.chatInput').on('keypress', function (e) {
    if (e.which == 13) {
        sendMessage();
    }
});

// Chat person click event
$(document).on('click', '.ca-chat-btn', function () {
    if ($(this).hasClass('newChat')) {
        $(this).removeClass('newChat');
    }

    $('.ca-chat-btn').removeClass('ca-selected-chat');
    $(this).addClass('ca-selected-chat');
    
    let id = $(this).data('id');
    
    // Add loading indicator
    $('.chatBox').html('<div class="text-center p-5"><div class="spinner-border text-primary" role="status"></div></div>');
    
    $.ajax({
        url: 'chat/changeChat?id=' + id,
        method: 'GET',
        data: '',
        dataType: 'json',
        success: function (response) {
            $('.chatBox').empty();
            $('.chatBox').append(response.chats);
            $('#receiverId').val(id);
            $('#lastMessageId').val(response.lastMessageId);
            $('#recentMessageId').val(response.recentId);
            $('.chatInfo').empty();
            
            // Enhanced user info display with status
            if (response.user) {
                $('.chatInfo').html(
                    '<div class="d-flex align-items-center">' +
                    '<div class="status-indicator status-online"></div>' +
                    '<div>' + response.user +
                    '<div class="chat-status small text-muted">' + 'online' + '</div>' +
                    '</div></div>'
                );
            }
            
            // Scroll to bottom of chat after loading
            scrollToBottom();
        }
    });
});

// Scroll functionality for loading older messages
var lastScrollTop = 0;
$('.chatBox').scroll(function (event) {
    var st = $(this).scrollTop();
    let receiverId = $('#receiverId').val();
    let lastMessageId = $('#lastMessageId').val();
    
    if (st > lastScrollTop) {
        // Scrolling down
    } else {
        // When scrolled to top and there are older messages
        if (lastMessageId !== 0 && st === 0) {
            // Add loading indicator at top
            $('.chatBox').prepend('<div id="loading-older" class="text-center p-2"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>');
            
            $.ajax({
                url: 'chat/getOldMessage?receiverId=' + receiverId + '&lastMessageId=' + lastMessageId,
                method: 'GET',
                data: '',
                dataType: 'json',
                success: function (response) {
                    // Remove loading indicator
                    $('#loading-older').remove();
                    
                    // Prepend older messages
                    $('.chatBox').prepend(response.chats);
                    $('#lastMessageId').val(response.lastMessageId);
                }
            });
        }
    }
    lastScrollTop = st;
});

// Document ready function
$(document).ready(function () {
    // Hide flash messages after delay
    $(".flashmessage").delay(3000).fadeOut(100);
    
    // Scroll to bottom on load
    scrollToBottom();

    // Regular check for new messages
    setInterval(function () {
        let id = $('#receiverId').val();
        let recentMessageId = $('#recentMessageId').val();
        
        if (id) {
            $.ajax({
                url: 'chat/checkChat?receiverId=' + id + '&recentId=' + recentMessageId,
                method: 'GET',
                data: '',
                dataType: 'json',
                success: function (response) {
                    if ($('#receiverId').val() == id) {
                        $('#recentMessageId').val(response.recentId);
                        
                        // Append new messages
                        if (response.currentChats && response.currentChats.trim() !== '') {
                            $('.chatBox').append(response.currentChats);
                            // Scroll to bottom if new messages received
                            scrollToBottom();
                        }
                        
                        // Update chatters list
                        $('#chattersBlock').empty();
                        $('#chattersBlock').append(response.html);
                    }
                }
            });
        }
    }, 3000);
});

// Search functionality
$(document).on('keyup', '#searchChat', function () {
    let search = $('#searchChat').val();
    
    if (search.length > 0) {
        // Add loading indicator to search results
        $('#adminChatters, #employeeChatters').html('<div class="text-center p-2"><div class="spinner-border spinner-border-sm text-primary" role="status"></div></div>');
    }
    
    $.ajax({
        url: 'chat/findChatPerson?search=' + encodeURIComponent(search),
        method: 'GET',
        data: '',
        dataType: 'json',
        success: function (response) {
            $('#adminChatters').empty();
            $('#employeeChatters').empty();

            // Display search results
            $('#adminChatters').append(response.admin);
            $('#employeeChatters').append(response.employee);
            
            // Show "no results" message if needed
            if (search.length > 0 && response.admin.trim() === '' && response.employee.trim() === '') {
                $('#adminChatters').append('<div class="text-center p-3 text-muted">No results found</div>');
            }
        }
    });
});


