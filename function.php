<?php
include 'conexao.php';

function addTask($tarefa) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO tarefas (tarefa) VALUES (?)");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $tarefa);
    return $stmt->execute();
}

function getTasks() {
    global $conn;
    $result = $conn->query("SELECT * FROM tarefas WHERE concluido = 0 ORDER BY created_at DESC");
    if ($result === false) {
        die('Query failed: ' . htmlspecialchars($conn->error));
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getTasksConcluidas() {
    global $conn;
    $result = $conn->query("SELECT * FROM tarefas WHERE concluido = 1 ORDER BY created_at DESC");
    if ($result === false) {
        die('Query failed: ' . htmlspecialchars($conn->error));
    }
    return $result->fetch_all(MYSQLI_ASSOC);
}

function completeTask($taskId) {
    global $conn;
    $stmt = $conn->prepare("UPDATE tarefas SET concluido = 1 WHERE id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $taskId);
    return $stmt->execute();
}



function reabrirTask($taskId) {
    global $conn;
    $stmt = $conn->prepare("UPDATE tarefas SET concluido = 0 WHERE id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $taskId);
    return $stmt->execute();
}

function updateTask($taskId, $tarefa) {
    global $conn;
    $stmt = $conn->prepare("UPDATE tarefas SET tarefa = ? WHERE id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("si", $tarefa, $taskId);
    return $stmt->execute();
}

function deleteTask($taskId) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM tarefas WHERE id = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("i", $taskId);
    return $stmt->execute();
}


?>