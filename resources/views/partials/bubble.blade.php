<!-- AI CHAT BUBBLE -->
<div id="ai-bubble"
     style="position:fixed; bottom:20px; right:20px;
            width:60px; height:60px; background:#0d6efd;
            color:white; border-radius:50%;
            display:flex; align-items:center;
            justify-content:center; font-size:26px;
            cursor:pointer; z-index:9999;">
  🤖
</div>

<!-- AI CHAT POPUP -->
<div id="ai-popup"
     style="position:fixed; bottom:90px; right:20px;
            width:320px; background:white;
            border:1px solid #ddd;
            border-radius:10px;
            display:none; flex-direction:column;
            z-index:9999;">

  <div style="background:#0d6efd; color:white; padding:10px;">
    AI Assistant
    <span id="ai-close" style="float:right; cursor:pointer;">✖</span>
  </div>

  <div id="ai-messages"
       style="height:250px; overflow-y:auto; padding:10px;">
  </div>

  <div style="display:flex; border-top:1px solid #ddd;">
    <input id="ai-input" type="text"
           style="flex:1; border:none; padding:10px;"
           placeholder="Tanya sesuatu...">
    <button id="ai-send"
            style="padding:10px; background:#0d6efd; color:white; border:none;">
      Kirim
    </button>
  </div>
</div>

<script>
const bubble = document.getElementById('ai-bubble');
const popup  = document.getElementById('ai-popup');
const close  = document.getElementById('ai-close');
const send   = document.getElementById('ai-send');
const input  = document.getElementById('ai-input');
const msgBox = document.getElementById('ai-messages');

bubble.onclick = () => popup.style.display = 'flex';
close.onclick  = () => popup.style.display = 'none';

send.onclick = async () => {
  const text = input.value;
  if (!text) return;

  msgBox.innerHTML += `<div><b>Kamu:</b> ${text}</div>`;
  input.value = "";

  const res = await fetch("/ai-chat", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({ message: text })
  });

  const data = await res.json();
  msgBox.innerHTML += `<div><b>AI:</b> ${data.reply}</div>`;
  msgBox.scrollTop = msgBox.scrollHeight;
};
</script>
