$(document).ready(function() {
    //edit
    $('#btnEditUsername').click(function(e) {
        e.preventDefault();
        $('#username').hide();
        $('#editUsername').show();
    });

    $('#btnEditPassword').click(function(e) {
        e.preventDefault();
        $('#btnEditPassword').hide();
        $('#editPassword').show();
    });

    $('#fileImage').on('input', function() {
        let formData = new FormData();
        formData.append('file', $('#fileImage')[0].files[0]);
        ajaxCallbackFile('models/users/upload-image.php', 'POST', function() {
            location.reload();
        }, formData);
    });

    // add friend
    $('#tbAddFriend').on('input', loadUsers);

    function loadUsers() {
        let keyword = $('#tbAddFriend').val();
        if(keyword != '') {
            ajaxCallback('models/friends/search.php', 'GET', function(data) {
                printUsers(data);
            }, {
                keyword: keyword
            });
        } else {
            $('#searchList').html('');
        }
    }

    function printUsers(data) {
        let html = "";

        if(data.length > 0) {
            for(let el of data) {
                html += `<li class='mb-1 font-small rounded p-2 user-listing d-flex justify-content-between align-items-center'><span class="d-flex align-items-center"><span id="userImage" class="d-block me-2"><img src="assets/img/${el.image}" alt="${el.username}" class="img-fluid d-block"/></span><label>${el.username}</label></span>`;
                if(el.friends) {
                    html += "<label>(Friends)</label>";
                } else if(el.alreadySent) {
                    html += "<label>(Request sent)</label>";
                } else {
                    html += `<a href="#" data-id="${el.user_id}" class="btnSendRequest redLink font-medium d-flex align-items-center"><i class="fas fa-plus"></i></a>`;
                }
                html += "</li>";
            }
        } else {
            html = "<label class='font-medium text-center'>We couldn't find anyone.</label>";
        }

        $('#searchList').html(html);
        addSendRequestEvent();
    }


    function addSendRequestEvent() {
        $('.btnSendRequest').click(function(e) {
            e.preventDefault();
            let id = $(this).data('id');

            ajaxCallback('models/requests/send-request.php', 'POST', loadUsers, {
                id: id
            });
        });
    }

    // requests

    function ifLoggedIn(func) {
        $.get('models/users/is-logged-in.php', func);
    }

    ifLoggedIn(loadRequests);
    function loadRequests() {
        ajaxCallback('models/requests/get-requests.php', 'POST', function(data) {
            printRequests(data);
        });
    }

    function printRequests(data) {
        let html = "";
        if(data.length > 0) {
            for(let el of data) {
                html += `<li class='mb-1 font-small rounded p-2 user-listing d-flex justify-content-between align-items-center'><span class="d-flex align-items-center"><span id="userImage" class="d-block me-2"><img src="assets/img/${el.image}" alt="${el.username}" class="img-fluid d-block"/></span><label>${el.username}</label></span><span class="requestLinks d-flex"><a href="#" data-id="${el.friends_id}" class="btnAccept redLink font-medium d-flex align-items-center"><i class="fas fa-check"></i></a><a href="#" data-id="${el.friends_id}" class="btnDecline redLink font-medium ms-3 d-flex align-items-center"><i class="fas fa-times"></i></a></span></li>`;
            }
        } else {
            html = "<label class='font-medium text-center'>You don't have any requests.</label>";
        }

        $('#requestsList').html(html);
        addRespondEvent();
    }

    function addRespondEvent() {
        $('.btnAccept').click(function() {
            let id = $(this).data('id');
            ajaxCallback('models/requests/accept.php', 'POST', loadRequests, { id: id });
        });

        $('.btnDecline').click(function() {
            let id = $(this).data('id');
            ajaxCallback('models/requests/decline.php', 'POST', loadRequests, { id: id });
        });
    }

    // still alive
    function stillAlive() {
        $.get('models/users/still-alive.php');
    }

    setInterval(stillAlive, 2000);

    // friends
    ifLoggedIn(function() {
        loadFriends();
        setInterval(loadFriends, 2000);
    });

    let oldFriendsList = null;
    function checkForFriendsListChanges(data) {
        if(oldFriendsList != null) {
            let result = false;
            if(data.length != oldFriendsList.length) {
                result = true;
            } else {
                for(let i in data) {
                    if(data[i].user_id != oldFriendsList[i].user_id || data[i].username != oldFriendsList[i].username || data[i].online != oldFriendsList[i].online || data[i].unreadMessages != oldFriendsList[i].unreadMessages) {
                        result = true;
                        break;
                    }
                }
            }
            if(result) oldFriendsList = data;
            return result;
        } else {
            oldFriendsList = data;
            return true;
        }
    }

    function loadFriends() {
        ajaxCallback('models/friends/get-friends.php', 'GET', function(data) {
            if(checkForFriendsListChanges(data)) {
                printFriends(data);
            }
        });
    }

    function printFriends(data) {
        let html = "";
        if(data.length > 0) {
            data.sort(function(a, b) {
                return b.online - a.online;
            });
            for(let el of data) {
                html += `<li class='friendDiv mb-1 font-small rounded p-2 user-listing d-flex justify-content-between align-items-center' data-user="${el.user_id}"><span class="d-flex align-items-center"><span id="userImage" class="overflowVisible d-block me-2 position-relative"><img src="assets/img/${el.image}" alt="${el.username}" class="img-fluid d-block"/><span class="position-absolute onlineStatus `;

                if(el.online) {
                    html += "online";
                } else {
                    html += 'offline';
                }

                html += `"></span></span>${el.username}`
                if(el.unreadMessages) {
                    html += '<span class="hasUnread ms-2"></span>';
                }
                html += `</span><a href="#" data-id="${el.user_id}" class="btnRemoveFriend redLink font-small">Remove friend</a></li>`;
            }
        } else {
            html = "<label class='font-small text-center'>You don't have any friends :(</label>";
        }
        $('#friendsList').html(html);
        addFriendsEvents();
    }

    function addFriendsEvents() {
        $('.friendDiv').click(function() {
            let userId = $(this).data('user');
            location.href = `index.php?page=messages&user=${userId}`;
        });

        $('.btnRemoveFriend').click(function(e) {
            e.stopPropagation();
            e.preventDefault();
            let userId = $(this).data('id');
            ajaxCallback('models/friends/remove-friend.php', 'POST', function() {
                loadFriends();
            }, { userId: userId });
        });
    }
});

function ajaxCallback(url, method, success, data = {}) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        dataType: 'json',
        success: success,
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}

function ajaxCallbackFile(url, method, success, data = {}) {
    $.ajax({
        url: url,
        method: method,
        processData: false,
        contentType: false,
        data: data,
        dataType: 'json',
        success: success,
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}