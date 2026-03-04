<?php
require '../config/database.php';
require '../app/Services/ProtocolEngine.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$engine = new ProtocolEngine($pdo);

$engine->recordResponse($data['callId'], $data['questionId'], $data['answer']);

$question = $engine->getQuestion($data['questionId']);
$nextId = $engine->getNextQuestionId($question, $data['answer']);

if($nextId) {
    $nextQuestion = $engine->getQuestion($nextId);
    echo json_encode(['nextQuestion'=>$nextQuestion]);
} else {
    $engine->endCall($data['callId'], 'Media'); // esempio gravità
    echo json_encode(['finalSeverity'=>'Media']);
}