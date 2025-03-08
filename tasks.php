<?php
include 'function.php';

if (isset($_GET['get_tasks']) && $_GET['get_tasks'] == 'true') {
    $tasks = getTasks();
    echo json_encode($tasks);
}
if (isset($_GET['get_tasks_final']) && $_GET['get_tasks_final'] == 'true') {
    $tasks = getTasksConcluidas();
    echo json_encode($tasks);
}

//UPDATTE COM POST
if (isset($_POST['action']) && $_POST['action'] == 'edit') {
    $taskId = $_POST['id'];
    $tarefa = $_POST['tarefa'];
    updateTask($taskId, $tarefa);
}
