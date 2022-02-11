$(document).ready(function() {
    let params = new URLSearchParams(location.search);
    let receiverId = params.get('user');

    loadMessages(true);
    setInterval(loadMessages, 1000);

    let oldMessages = null;
    function checkForNewMessages(data) {
        if(oldMessages != null) {
            let result = false;
            if(oldMessages.length != data.length) {
                result = true;
            } else {
                for(let i in data) {
                    if(data[i].messageContent != oldMessages[i].messageContent) {
                        result = true;
                        break;
                    }
                }
            }
            if(result) oldMessages = data;
            return result;
        } else {
            oldMessages = data;
            return true;
        }
    }

    function loadMessages(scroll = false) {
        ajaxCallback('models/messages/load-messages.php', 'POST', function(data) {
            if(checkForNewMessages(data)) {
                printMessages(data, scroll);
            }
        }, { receiver: receiverId });
    }

    function printMessages(data, scroll) {
        let distanceScrolled = $("#messagesContainer")[0].scrollHeight - $("#messagesContainer").scrollTop();
        if(distanceScrolled < $("#messagesContainer").innerHeight() + 20 && distanceScrolled > $("#messagesContainer").innerHeight() - 20) {
            scroll = true;
            messagesRead();
        }
        let html = "";
        if(data.length > 0) {
            for(let el of data) {
                html += `<div class="mb-2 message `;
                if(el.sender_id == receiverId) {
                    html += "receiver";
                } else {
                    html += 'sender';
                }
                // handling links
                let messageContent = el.messageContent;
                let linkRegExp = /^http(s)?\:\/\/([a-zA-Z0-9]+\.)+[a-zA-Z0-9]{2,}(\/.*)*$/;
                let newMessage = "";
                let word = "";
                for(let i in messageContent) {
                    word += messageContent[i];
                    if(messageContent[i] == ' ' || messageContent[i] == "\t" || messageContent[i] == "\n" || i == messageContent.length - 1) {
                        if(word.match(linkRegExp)) {
                            word = `<a href='${word}' target='_blank'>${word}</a>`;
                        }
                        newMessage += word;
                        word = "";
                    }
                }

                //
                html += `"><p class="rounded py-1 px-2 m-0 font-small">${newMessage}</p></div>`;
            }
        }  else {
            html = "<label class='red-text font-small'>Be the first to send a message.</label>";
        }
        $('#messagesContainer').html(html);
        if(scroll) $("#messagesContainer").scrollTop($("#messagesContainer")[0].scrollHeight);
    }

    function messagesRead() {
        ajaxCallback('models/messages/messages-read.php', 'POST', function() {}, { receiver: receiverId });
    }

    function sendMessage() {
        let message = $('#tbMessage').val();
        if(message != '') {
            ajaxCallback('models/messages/send-message.php', 'POST', function() {
                $('#tbMessage').val('');
                loadMessages(true);
            }, {
                receiver: receiverId,
                message: message
            });
        }
    }

    $('#btnSendMessage').click(function(e) {
        e.preventDefault();
        sendMessage();
    });

    $('#tbMessage').keydown(function(e) {
        if(e.keyCode == 13) {
            e.preventDefault();
            sendMessage();
        }
    });
});