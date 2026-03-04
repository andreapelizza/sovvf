<?php
class ProtocolEngine {
    protected $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getQuestion($id) {
        $stmt = $this->db->prepare("SELECT * FROM questions WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function recordResponse($callId, $questionId, $answer) {
        $stmt = $this->db->prepare("INSERT INTO responses (call_id, question_id, answer) VALUES (?, ?, ?)");
        $stmt->execute([$callId, $questionId, $answer]);
    }

    public function getNextQuestionId($question, $answer) {
        return strtolower($answer) === 'yes' ? $question['next_if_yes'] : $question['next_if_no'];
    }

    public function startCall($callerNumber, $protocolId) {
        $stmt = $this->db->prepare("INSERT INTO call_logs (caller_number, protocol_id) VALUES (?, ?)");
        $stmt->execute([$callerNumber, $protocolId]);
        return $this->db->lastInsertId();
    }

    public function endCall($callId, $finalSeverity, $notes = null) {
        $stmt = $this->db->prepare("UPDATE call_logs SET end_time=NOW(), final_severity=?, notes=? WHERE id=?");
        $stmt->execute([$finalSeverity, $notes, $callId]);
    }
}