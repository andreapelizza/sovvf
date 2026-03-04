<?php
require '../config/database.php';
require '../app/Services/ProtocolEngine.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$engine = new ProtocolEngine($pdo);

$callId = $engine->startCall($data['callerNumber'], $data['protocolId']);
$firstQuestion = $engine->getQuestion(1); // primo step demo
echo json_encode(['callId'=>$callId, 'firstQuestion'=>$firstQuestion]);