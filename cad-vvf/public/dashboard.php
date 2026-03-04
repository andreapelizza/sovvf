<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>CAD VVF - Chiamata</title>
<script>
let currentCallId = null;
async function startCall() {
    const caller = document.getElementById('callerNumber').value;
    const res = await fetch('start_call.php', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({callerNumber:caller, protocolId:1})
    });
    const data = await res.json();
    currentCallId = data.callId;
    document.getElementById('callArea').style.display = 'block';
    document.getElementById('question').innerText = data.firstQuestion.text;
    document.getElementById('questionId').value = data.firstQuestion.id;
}

async function answerQuestion(questionId, answer) {
    const res = await fetch('answer.php', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body:JSON.stringify({callId:currentCallId, questionId, answer})
    });
    const data = await res.json();
    if(data.nextQuestion) {
        document.getElementById('question').innerText = data.nextQuestion.text;
        document.getElementById('questionId').value = data.nextQuestion.id;
    } else {
        alert('Chiamata completata! Gravità: ' + data.finalSeverity);
        document.getElementById('callArea').style.display = 'none';
    }
}
</script>
</head>
<body>
<h1>Gestione Chiamata</h1>
<label>Numero chiamante:</label>
<input type="text" id="callerNumber">
<button onclick="startCall()">Avvia Chiamata</button>

<div id="callArea" style="display:none;">
    <p id="question"></p>
    <input type="hidden" id="questionId">
    <button onclick="answerQuestion(document.getElementById('questionId').value, 'yes')">Sì</button>
    <button onclick="answerQuestion(document.getElementById('questionId').value, 'no')">No</button>
</div>
</body>
</html>