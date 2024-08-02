@extends('layouts.main')

@section('title', 'Chats')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Chat
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="row g-0">
                    <div class="col-12 col-lg-5 col-xl-3 border-end">
                        <div class="card-header d-none d-md-block">
                            <div class="input-icon">
                                <span class="input-icon-addon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                        <path d="M21 21l-6 -6" />
                                    </svg>
                                </span>
                                <input type="text" value="" class="form-control" placeholder="Search…"
                                    aria-label="Search" />
                            </div>
                        </div>
                        <div class="card-body p-0 scrollable" style="max-height: 35rem">
                            <div class="nav flex-column nav-pills p-2" role="tablist">
                                <!-- Dropdown toggle for Recent Chats -->
                                <button class="btn btn-link d-flex justify-content-between align-items-center w-100"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#recentChats"
                                    aria-expanded="true" aria-controls="recentChats">
                                    <h4 class="mb-0">Recent Chats</h4>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 9l6 6l6 -6" />
                                    </svg>
                                </button>
                                <div id="recentChats" class="collapse show">
                                    @foreach ($chattedUsers as $user)
                                        <a href="javascript:void(0)" class="nav-link text-start mw-100 p-3"
                                            data-recipient-id="{{ $user->id }}" onclick="loadChat({{ $user->id }})">
                                            <div class="row align-items-center flex-fill">
                                                <div class="col-auto">
                                                    <span class="avatar"
                                                        style="background-image: url({{ $user->avatar ? url('avatars/' . e($user->avatar)) : url('avatars/default-avatar.png') }})"></span>
                                                </div>
                                                <div class="col text-body">
                                                    <div>{{ e($user->name) }}</div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                                <!-- Dropdown toggle for All Users -->
                                <button class="btn btn-link d-flex justify-content-between align-items-center w-100 mt-3"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#allUsers" aria-expanded="true"
                                    aria-controls="allUsers">
                                    <h4 class="mb-0">All Users</h4>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-2" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M6 9l6 6l6 -6" />
                                    </svg>
                                </button>
                                <div id="allUsers" class="collapse">
                                    @foreach ($allUsers as $user)
                                        <a href="javascript:void(0)" class="nav-link text-start mw-100 p-3"
                                            data-recipient-id="{{ $user->id }}" onclick="loadChat({{ $user->id }})">
                                            <div class="row align-items-center flex-fill">
                                                <div class="col-auto">
                                                    <span class="avatar"
                                                        style="background-image: url({{ $user->avatar ? url('avatars/' . e($user->avatar)) : url('avatars/default-avatar.png') }})"></span>
                                                </div>
                                                <div class="col text-body">
                                                    <div>{{ e($user->name) }}</div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7 col-xl-9 d-flex flex-column">
                        <div class="card-body scrollable" style="height: 35rem">
                            <div class="chat">
                                <div class="profile-chat">
                                    {{--  menampilkan profile yang sedang di chat setiap user memilih  --}}
                                </div>
                                <div class="chat-bubbles" id="chat-bubbles">
                                    <!-- Chat messages will be loaded here -->
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="input-group input-group-flat">
                                <input type="text" class="form-control" autocomplete="off" placeholder="Type message"
                                    id="chat-message" onkeydown="checkEnter(event)" />
                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" data-bs-toggle="tooltip"
                                        aria-label="Send message" title="Send message" onclick="sendMessage()">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 19l9 2l-9 -18l-9 18l9 -2z" />
                                        </svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentRecipientId = null;

        function loadChat(recipientId) {
            currentRecipientId = recipientId;
            fetch(`/chats/${recipientId}`)
                .then(response => response.json())
                .then(data => {
                    const chatBubbles = document.getElementById('chat-bubbles');
                    chatBubbles.innerHTML = '';
                    data.forEach(chat => {
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('chat-item');

                        const isCurrentUser = chat.user_id === {{ Auth::id() }};
                        const chatBubbleClass = isCurrentUser ? 'chat-bubble-me' : 'chat-bubble';
                        const currentUserAvatar =
                            `{{ Auth::user()->avatar ? url('avatars/' . e(Auth::user()->avatar)) : url('avatars/default-avatar.png') }}`;
                        const chatUserAvatar = chat.user.avatar ? `{{ url('avatars') }}/${chat.user.avatar}` :
                            `{{ url('avatars/default-avatar.png') }}`;

                        messageElement.innerHTML = `
                            <div class="row align-items-end ${isCurrentUser ? 'justify-content-end' : ''}">
                                ${isCurrentUser ? `
                                        <div class="col col-lg-6">
                                            <div class="chat-bubble ${chatBubbleClass}">
                                                <div class="chat-bubble-title">
                                                    <div class="row">
                                                        <div class="col chat-bubble-author">${e(chat.user.name)}</div>
                                                        <div class="col-auto chat-bubble-date">${formatTime(chat.created_at)}</div>
                                                    </div>
                                                </div>
                                                <div class="chat-bubble-body">
                                                    <p>${e(chat.message)}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto"><span class="avatar" style="background-image: url('${currentUserAvatar}')"></span></div>
                                    ` : `
                                        <div class="col-auto"><span class="avatar" style="background-image: url('${chatUserAvatar}')"></span></div>
                                        <div class="col col-lg-6">
                                            <div class="${chatBubbleClass}">
                                                <div class="chat-bubble-title">
                                                    <div class="row">
                                                        <div class="col chat-bubble-author">${e(chat.user.name)}</div>
                                                        <div class="col-auto chat-bubble-date">${formatTime(chat.created_at)}</div>
                                                    </div>
                                                </div>
                                                <div class="chat-bubble-body">
                                                    <p>${e(chat.message)}</p>
                                                </div>
                                            </div>
                                        </div>
                                    `}
                            </div>
                        `;
                        chatBubbles.appendChild(messageElement);
                    });
                });
        }

        function sendMessage() {
            const message = document.getElementById('chat-message').value;
            if (message.trim() === '' || !currentRecipientId) return;

            fetch(`/chats/${currentRecipientId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        message: message.trim()
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'Message sent successfully!') {
                        const chatBubbles = document.getElementById('chat-bubbles');
                        const messageElement = document.createElement('div');
                        messageElement.classList.add('chat-item');
                        const currentUserName = '{{ e(Auth::user()->name) }}';
                        const currentUserAvatar =
                            `{{ Auth::user()->avatar ? url('avatars/' . e(Auth::user()->avatar)) : url('avatars/default-avatar.png') }}`;

                        messageElement.innerHTML = `
                            <div class="row align-items-end justify-content-end">
                                <div class="col col-lg-6">
                                    <div class="chat-bubble chat-bubble-me">
                                        <div class="chat-bubble-title">
                                            <div class="row">
                                                <div class="col chat-bubble-author">${currentUserName}</div>
                                                <div class="col-auto chat-bubble-date">${formatTime(data.chat.created_at)}</div>
                                            </div>
                                        </div>
                                        <div class="chat-bubble-body">
                                            <p>${e(data.chat.message)}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto"><span class="avatar" style="background-image: url('${currentUserAvatar}')"></span></div>
                            </div>
                        `;
                        chatBubbles.appendChild(messageElement);

                        // Clear input field
                        document.getElementById('chat-message').value = '';
                    }
                });
        }

        function formatTime(dateTime) {
            const date = new Date(dateTime);
            const hours = date.getHours().toString().padStart(2, '0');
            const minutes = date.getMinutes().toString().padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        function checkEnter(event) {
            if (event.key === 'Enter') {
                sendMessage();
            }
        }

        function e(str) {
            return str.replace(/[&<>"'\/]/g, function(s) {
                return ({
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;',
                    '/': '&#x2F;'
                })[s];
            });
        }
    </script>
@endsection
