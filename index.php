<?php

include 'function.php';

// Adicionar tarefa
if (isset($_POST['add_task'])) {
    $tarafa = $_POST['tarafa'];
    addTask($tarafa);
}

// Marcar como concluída ou excluir
if (isset($_GET['action']) && isset($_GET['id'])) {
    $taskId = $_GET['id'];
    $tarafa = $_GET['tarefa'];
    var_dump($taskId, $tarafa);
    if ($_GET['action'] == 'complete') {
        completeTask($taskId);
    } elseif ($_GET['action'] == 'delete') {
        deleteTask($taskId);
    } 
}

$tasks = getTasks();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste PHP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Todo List</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="index.php">Tarefas Pendentes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tarefaconcluida.php">Tarefas Concluídas</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h3 class="text-center">Adicionar Tarefa</h3>
            <form id="taskForm">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="tarafa" name="tarefa" placeholder="Nova tarefa" required>
                    <button class="btn btn-primary" type="submit" id="add_task">Adicionar</button>
                </div>
            </form>
            <ul class="list-group" id="taskList">
             
            </ul>
        </div>
    </div>
</div>

<!-- Modal Editar Tarefa -->
<div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTaskModalLabel">Editar Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editTaskForm">
                    <div class="mb-3">
                        <label for="editTarafa" class="form-label">Tarefa</label>
                        <input type="text" class="form-control" id="editTarafa" name="tarefa" required>
                    </div>
                    <input type="hidden" id="editTaskId">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    function loadTasks() {
        $.get('tasks.php?get_tasks=true', function(response) {
            var tasks = JSON.parse(response);
            var taskList = $('#taskList');
            taskList.empty();
            tasks.forEach(function(task) {
                var taskItem = $('<li class="list-group-item d-flex justify-content-between align-items-center"></li>');
                taskItem.text(task.tarefa);
                var buttons = $('<div></div>');
                var completeButton = $('<button class="btn btn-success btn-sm complete-task"><i class="fas fa-check"></i> Concluir</button>');
                completeButton.data('id', task.id);
                var deleteButton = $('<button class="btn btn-danger btn-sm delete-task"><i class="fas fa-trash"></i> Excluir </button>');
                deleteButton.data('id', task.id);
                var editButton = $('<button class="btn btn-warning btn-sm edit-task" data-bs-toggle="modal" data-bs-target="#editTaskModal"><i class="fas fa-edit"></i> Editar</button>');
                editButton.data('id', task.id);
                editButton.data('tarefa', task.tarefa);
                buttons.append(completeButton).append(editButton).append(deleteButton);
                taskItem.append(buttons);
                taskList.append(taskItem);
            });
        });
    }

    $(document).on('click', '.edit-task', function() {
        var taskId = $(this).data('id');
        var tarefa = $(this).data('tarefa');
        $('#editTaskId').val(taskId);
        $('#editTarafa').val(tarefa);
    });

    $('#editTaskForm').on('submit', function(e) {
        e.preventDefault();
        var taskId = $('#editTaskId').val();
        var tarefa = $('#editTarafa').val();
        $.post('tasks.php', { action: 'edit', id: taskId, tarefa: tarefa }, function(response) {
            Swal.fire('Sucesso', 'Tarefa editada com sucesso!', 'success').then(() => {
                $('#editTaskModal').modal('hide');
                loadTasks();
            });
        });
    });

    loadTasks();

    $('#taskForm').on('submit', function(e) {
        e.preventDefault();
        var tarafa = $('#tarafa').val();
        $.post('index.php', { add_task: true, tarafa: tarafa }, function(response) {
            Swal.fire('Sucesso', 'Tarefa adicionada com sucesso!', 'success').then(() => {
                $('#taskForm')[0].reset(); 
                loadTasks();
            });
        });
    });

    

    $(document).on('click', '.complete-task', function() {
        var taskId = $(this).data('id');
        $.get('index.php', { action: 'complete', id: taskId }, function(response) {
            Swal.fire('Sucesso', 'Tarefa marcada como concluída!', 'success').then(() => {
                loadTasks();
            });
        });
    });

    $(document).on('click', '.delete-task', function() {
        var taskId = $(this).data('id');
        Swal.fire({
            title: 'Tem certeza?',
            text: "Você não poderá reverter isso!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.get('index.php', { action: 'delete', id: taskId }, function(response) {
                    Swal.fire('Sucesso', 'Tarefa excluída com sucesso!', 'success').then(() => {
                        loadTasks();
                    });
                });
            }
        });
    });
});

</script>
</body>
</html>