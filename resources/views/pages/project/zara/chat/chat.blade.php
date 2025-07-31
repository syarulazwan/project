@push('styles')

<style>
  
    .chat-bubble {
        padding: 10px 15px;
        border-radius: 20px;
        margin-bottom: 10px;
        display: inline-block;
        max-width: 80%;
        word-wrap: break-word;
    }

    .chat-user {
        background-color: #d1e7dd;
        align-self: flex-end;
    }

    .chat-assistant {
        background-color: #e2e3e5;
    }

    .typing-indicator {
        display: inline-block;
    }

    .typing-indicator span {
        display: inline-block;
        width: 8px;
        height: 8px;
        margin: 0 2px;
        background-color: #888;
        border-radius: 50%;
        animation: typing 1s infinite ease-in-out;
    }

    .typing-indicator span:nth-child(2) {
        animation-delay: 0.2s;
    }

    .typing-indicator span:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes typing {

        0%,
        80%,
        100% {
            transform: scale(0.6);
            opacity: 0.3;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

</style>

   
@endpush

@extends('main')
@section('pages')

    <div class="container-fluid">
        <div class="d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div class="">
                <nav>
                    <ol class="breadcrumb mb-0" style="--bs-breadcrumb-divider: '/'; color: rgb(0, 0, 0);">
                        <li class="breadcrumb-item d-flex align-items-center">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold d-flex align-items-center">
                                <i class="bi bi-house-door-fill me-1"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">Project</a>
                        </li>
                            <li class="breadcrumb-item">
                            <a href="javascript:void(0);" class="mb-0 fw-semibold">ZARA</a>
                        </li>
                        <li class="breadcrumb-item active mb-0 fw-semibold" aria-current="page">Chat</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-7">
                                <!-- Chat Interface -->
                                <div class="card shadow-sm mb-3">
                                    <div class="card-header bg-primary text-white">
                                        <h4 class="mb-0">Chat with Document</h4>
                                    </div>
                                    <div class="card-body">
                                        <!-- Your existing chat form and chat container go here -->
                                        <!-- KEEP AS IS -->

                                        <form id="chat-form" class="mb-3">
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="chat_type" class="form-label">Chat Type</label>
                                                    <select name="chat_type" id="chat_type" class="form-select">
                                                        <option value="general">General</option>
                                                        <option value="specific">Specific</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-8" id="doc_selector" style="display:none">
                                                    <label for="document_id" class="form-label">Select Document</label>
                                                    <select name="document_id" id="document_id" class="form-select">
                                                        @foreach($documents as $doc)
                                                        <option value="{{ $doc->id }}">{{ $doc->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="input-group mb-3">
                                                <input type="text" name="question" id="question" class="form-control" placeholder="Ask something..." required>
                                                <button type="submit" class="btn btn-primary">Ask</button>
                                                <button type="button" id="clear-chat" class="btn btn-secondary ms-2">Clear</button>
                                            </div>
                                        </form>

                                        <div id="chat-container" class="border rounded p-3" style="height: 400px; overflow-y: auto; background-color: #f8f9fa;">
                                            <!-- Chat messages appear here -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <!-- D-ID Avatar Video -->
                                <div class="card shadow-sm">
                                    <div class="card-header bg-dark text-white">
                                        <h5 class="mb-0">Virtual Assistant</h5>
                                    </div>
                                    <div class="card-body text-center">
                                        <div id="did-video-placeholder">
                                            <p>Waiting for response...</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>

        document.getElementById('chat_type').addEventListener('change', function() {
        document.getElementById('doc_selector').style.display = this.value === 'specific' ? 'block' : 'none';
    });

    document.getElementById('chat-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const chatContainer = document.getElementById('chat-container');
        const question = document.getElementById('question').value;

        // Append user message
        appendMessage('You', question, 'chat-user');

        const form = new FormData(this);

        // Show typing indicator
        const typingId = 'typing-indicator';
        appendTypingIndicator(typingId);

        const res = await fetch('chat/ask', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: form
        });

        const data = await res.json();

        // Remove typing indicator
        removeTypingIndicator(typingId);

        // Show assistant response
        appendMessage('Assistant', data.answer, 'chat-assistant');

        document.getElementById('question').value = '';

        // Poll the D-ID API for the video
        if (data.talk_id) {
        // if (true) {
            // pollDIDVideo('tlk_JZSk_PtLV5A8elC_LkBtK');
            pollDIDVideo(data.talk_id);
        }
    });

    async function pollDIDVideo(talkId, attempt = 0) {
        const maxAttempts = 15;
        const delay = 2000;

        if (attempt >= maxAttempts) {
            document.getElementById('did-video-placeholder').innerHTML = '<p>Failed to load video.</p>';
            return;
        }

        const res = await fetch(`api/did/video/${talkId}`);
        const data = await res.json();

        if (data.url) {
            document.getElementById('did-video-placeholder').innerHTML = `
            <video src="${data.url}" autoplay controls width="100%"></video>
        `;
        } else {
            setTimeout(() => pollDIDVideo(talkId, attempt + 1), delay);
        }
    }


    document.getElementById('clear-chat').addEventListener('click', function() {
        document.getElementById('chat-container').innerHTML = '';
    });

    function appendMessage(sender, message, className) {
        const chatContainer = document.getElementById('chat-container');
        const msgWrapper = document.createElement('div');
        msgWrapper.className = `d-flex ${className === 'chat-user' ? 'justify-content-end' : 'justify-content-start'}`;

        const msgDiv = document.createElement('div');
        msgDiv.className = `chat-bubble ${className}`;
        msgDiv.innerHTML = `<div><strong>${sender}</strong></div><div>${renderMarkdown(message)}</div>`;

        msgWrapper.appendChild(msgDiv);
        chatContainer.appendChild(msgWrapper);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function renderMarkdown(text) {
        return text
            .replace(/\n/g, '<br>')
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>');
    }

    function appendTypingIndicator(id) {
        const chatContainer = document.getElementById('chat-container');
        const typingDiv = document.createElement('div');
        typingDiv.id = id;
        typingDiv.className = 'd-flex justify-content-start';
        typingDiv.innerHTML = `
            <div class="chat-bubble chat-assistant">
                <strong>Assistant:</strong>
                <span class="typing-indicator">
                    <span></span><span></span><span></span>
                </span>
            </div>`;
        chatContainer.appendChild(typingDiv);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function removeTypingIndicator(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    </script>
    
@endpush