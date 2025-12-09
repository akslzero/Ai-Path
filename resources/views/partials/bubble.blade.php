<!-- AI CHAT BUBBLE -->
<!-- AI CHAT BUBBLE -->

<style>
    /* Hover grow */
    #ai-bubble {
        transition: transform 0.2s ease;
    }

    #ai-bubble:hover {
        transform: scale(1.12);
    }

    /* Bounce on click */
    @keyframes bubble-bounce {
        0% {
            transform: scale(1);
        }

        30% {
            transform: scale(0.85);
        }

        60% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }

    .bounce {
        animation: bubble-bounce 0.25s ease;
    }

    /* CHAT STYLES */
    .msg {
        margin-bottom: 10px;
        padding: 10px 14px;
        border-radius: 14px;
        max-width: 85%;
        font-size: 14px;
        animation: fadeIn .25s ease;
        line-height: 1.4;
    }

    /* User = gradient premium */
    .msg-user {
        background: linear-gradient(135deg, #4e8df5, #0d6efd);
        color: white;
        margin-left: auto;
        border-bottom-right-radius: 2px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    /* AI = soft grey */
    .msg-ai {
        background: linear-gradient(135deg, #f7f7f7, #eeeeee);
        color: #333;
        border-bottom-left-radius: 2px;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(6px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Typing bubble */
    .typing {
        display: inline-block;
        padding: 8px 13px;
        background: #eaeaea;
        border-radius: 12px;
        margin-bottom: 10px;
        width: fit-content;
        color: #555;
        font-size: 13px;
        border-bottom-left-radius: 2px;
        animation: fadeIn .2s ease;
    }

    .typing-dot {
        height: 6px;
        width: 6px;
        background: #888;
        border-radius: 50%;
        display: inline-block;
        margin: 0 2px;
        animation: blink 1.4s infinite;
    }

    .typing-dot:nth-child(2) {
        animation-delay: .2s;
    }

    .typing-dot:nth-child(3) {
        animation-delay: .4s;
    }

    #ai-input:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
    }

    #ai-send:hover {
        background: #0b5ed7;
        transform: scale(1.07);
    }

    #ai-send:active {
        transform: scale(0.92);
    }


    @keyframes blink {
        0% {
            opacity: .2;
        }

        20% {
            opacity: 1;
        }

        100% {
            opacity: .2;
        }
    }
</style>



<div id="ai-bubble"
    style="position:fixed; bottom:20px; right:20px;
            width:60px; height:60px; background:#0d6efd;
            color:white; border-radius:50%;
            display:flex; align-items:center;
            justify-content:center; font-size:26px;
            cursor:pointer; z-index:9999;">
    <i class="fa-solid fa-robot"></i>
</div>

<!-- AI CHAT POPUP -->
<div id="ai-popup"
    style="position:fixed; bottom:90px; right:20px;
            width:320px; background:white;
            border:1px solid #ddd;
            border-radius:10px;
            display:none; flex-direction:column;
            z-index:9999; overflow:hidden;">

    <div style="background:#0d6efd; color:white; padding:10px;">
        AI Assistant
    </div>

    <div id="ai-messages" style="height:250px; overflow-y:auto; padding:10px;">
        <div id="typing-indicator"></div>
    </div>


    <div style="display:flex; border-top:1px solid #ddd; padding:8px;">
        <input id="ai-input" type="text"
            style="flex:1; padding:10px 14px; border-radius:8px; border:1px solid #ccc;
               font-size:14px; outline:none; transition:0.2s;"
            placeholder="Tanya sesuatu...">

        <button id="ai-send"
            style="margin-left:8px; background:#0d6efd; border:none; color:white; 
               width:42px; height:42px; border-radius:10px; font-size:16px;
               display:flex; align-items:center; justify-content:center;
               cursor:pointer; transition:0.2s;">
            <i class="fa-solid fa-paper-plane"></i>
        </button>
    </div>

</div>


<script>
    const bubble = document.getElementById('ai-bubble');
    const popup = document.getElementById('ai-popup');
    const send = document.getElementById('ai-send');
    const input = document.getElementById('ai-input');
    const msgBox = document.getElementById('ai-messages');
    const typing = document.getElementById('typing-indicator');

    // Kirim pakai tombol ENTER
    input.addEventListener("keydown", function(e) {
        if (e.key === "Enter") {
            e.preventDefault(); // biar nggak bikin baris baru
            send.click(); // pencet tombol kirim secara otomatis
        }
    });

    async function loadHistory() {
        const res = await fetch("/ai-chat/history");
        const data = await res.json();

        msgBox.innerHTML = ""; // bersihin chat lama

        data.forEach(chat => {
            msgBox.innerHTML += `
            <div class="msg msg-user">
                <b>{{ Auth::user()->name }}</b><br> ${chat.message}
            </div>
        `;

            if (chat.reply) {
                msgBox.innerHTML += `
                <div class="msg msg-ai">
                    <b>AI</b><br> ${chat.reply}
                </div>
            `;
            }
        });

        msgBox.scrollTop = msgBox.scrollHeight;
    }



    bubble.onclick = async () => {
        bubble.classList.add("bounce");
        setTimeout(() => bubble.classList.remove("bounce"), 250);

        // toggle popup
        const show = (popup.style.display !== 'flex');
        popup.style.display = show ? 'flex' : 'none';

        // kalau popup baru dibuka -> load history
        if (show) loadHistory();
    };


    send.onclick = async () => {
        const text = input.value;
        if (!text) return;

        // User message
        msgBox.innerHTML += `
            <div class="msg msg-user">
                <b>{{ Auth::user()->name }}</b><br> ${text}
            </div>
        `;

        msgBox.scrollTop = msgBox.scrollHeight;
        input.value = "";

        // Show "AI sedang mengetik..."
        typing.innerHTML = `
            <div class="typing">
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span class="typing-dot"></span>
                <span style="margin-left:6px;">AI sedang mengetik...</span>
            </div>
        `;

        const res = await fetch("/ai-chat", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                message: text
            })
        });

        const data = await res.json();

        // Remove typing indicator
        typing.innerHTML = "";

        // AI message
        msgBox.innerHTML += `
            <div class="msg msg-ai">
                <b>AI</b><br> ${data.reply}
            </div>
        `;

        msgBox.scrollTop = msgBox.scrollHeight;
    };
</script>
