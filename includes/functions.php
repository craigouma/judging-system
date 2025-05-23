<?php
require_once 'config.php';

function getUsers() {
    global $conn;
    $sql = "SELECT * FROM users ORDER BY name";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getJudges() {
    global $conn;
    $sql = "SELECT * FROM judges ORDER BY display_name";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getScores() {
    global $conn;
    $sql = "SELECT 
                u.id as user_id, 
                u.name as user_name,
                SUM(s.score) as total_score
            FROM users u
            LEFT JOIN scores s ON u.id = s.user_id
            GROUP BY u.id
            ORDER BY total_score DESC";
    $result = $conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function addJudge($username, $displayName) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $displayName);
    return $stmt->execute();
}

function addScore($judgeId, $userId, $score) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO scores (judge_id, user_id, score) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $judgeId, $userId, $score);
    return $stmt->execute();
}

function getUnscoredUsers($judgeId) {
    global $conn;
    $sql = "SELECT u.* FROM users u
            WHERE NOT EXISTS (
                SELECT 1 FROM scores s 
                WHERE s.judge_id = ? AND s.user_id = u.id
            )";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $judgeId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>