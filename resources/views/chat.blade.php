<!DOCTYPE html>
<html>

<head>
    <title>Chatbot Support</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body class="p-5">
    <h2>💬 Sistem Sokongan AI</h2>
    <div class="mb-3">
        <label class="form-label">Mod Soalan:</label>
        <select class="form-select" id="mode">
            <option value="general">Soalan Umum (Tiada Dokumen)</option>
            <option value="document">Soalan Berdasarkan Dokumen</option>
        </select>
    </div>

    <div class="mb-3" id="documentSelect" style="display: none;">
        <label class="form-label">Pilih Dokumen:</label>
        <select class="form-select" id="document_id">
            <!-- Akan diisi dari server -->
        </select>
    </div>

    <div id="chatbox" class="border p-3 mb-3" style="height: 300px; overflow-y: auto;"></div>

    <div class="input-group">
        <input type="text" id="question" class="form-control" placeholder="Taip soalan..." />
        <button class="btn btn-primary" onclick="send()">Hantar</button>
    </div>

    <script>
        function send() {
            let question = document.getElementById('question').value;
            let mode = document.getElementById('mode').value;
            let document_id = document.getElementById('document_id').value;
            if (!question) return;
            document.getElementById('chatbox').innerHTML += `<div><b>Anda:</b> ${question}</div>`;
            axios.post('/zara/ask', {
                    question,
                    mode,
                    document_id,
                })
                .then(res => {
                    document.getElementById('chatbox').innerHTML += `<div><b>AI:</b> ${res.data.answer}</div>`;
                    speak(res.data.answer);
                });
            document.getElementById('question').value = '';
        }

        function speak(text) {
            const utterance = new SpeechSynthesisUtterance(text);
            speechSynthesis.speak(utterance);
        }
    </script>

    <script>
        document.getElementById('mode').addEventListener('change', function() {
            const show = this.value === 'document';
            document.getElementById('documentSelect').style.display = show ? 'block' : 'none';
        });

        // Auto load dokumen
        window.onload = function() {
            axios.get('/documents/list').then(res => {
                const select = document.getElementById('document_id');
                res.data.forEach(doc => {
                    const option = document.createElement('option');
                    option.value = doc.id;
                    option.text = doc.title;
                    select.appendChild(option);
                });
            });
        }
    </script>

</body>

</html>