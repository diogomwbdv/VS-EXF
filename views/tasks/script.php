<?php

use yii\helpers\Url;
?>

<script>
    document.getElementById('createTask').onclick = function () {
        var modal = new bootstrap.Modal(document.getElementById('modal-create-task'));
        modal.show();
    };

    // Quando o formulário de criar tarefa for enviado
    document.getElementById('modal-create-task').querySelector('form').addEventListener('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        fetch('<?= Url::to(['create']) ?>', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (response.ok) {
                    $('#modal-create-task').modal('hide');
                    $.pjax.reload({ container: '#tasks-pjax' });
                } else {
                    throw new Error('Erro ao criar tarefa.');
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao criar a tarefa.');
            });
    });

    // Selecionar Tarefa/S
    document.getElementById('select-all').onclick = function () {
        var checkboxes = document.querySelectorAll('.task-checkbox');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };

    // Editar Tarefa
    document.getElementById('edit-selected').onclick = function () {
        var selectedIds = [];
        var checkboxes = document.querySelectorAll('.task-checkbox:checked');
        for (var checkbox of checkboxes) {
            selectedIds.push(checkbox.value);
        }
        if (selectedIds.length === 1) {
            var editUrl = '<?= Url::to(['update']) ?>?id=' + selectedIds[0];
            $('#modal-edit-task .modal-body').load(editUrl, function () {
                $('#modal-edit-task').modal('show');
            });
        } else if (selectedIds.length > 1) {
            alert('Por favor, selecione apenas uma tarefa para editar.');
        } else {
            alert('Por favor, selecione uma tarefa para editar.');
        }
    };

    // Apagar Tarefa
    document.getElementById('delete-selected').onclick = function () {
        var selectedIds = [];
        var checkboxes = document.querySelectorAll('.task-checkbox:checked');
        for (var checkbox of checkboxes) {
            selectedIds.push(checkbox.value);
        }
        if (selectedIds.length > 0) {
            if (confirm('Tem certeza de que deseja eliminar as tarefas selecionadas?')) {
                if (selectedIds.length === 1) {
                    var deleteUrl = '<?= Url::to(['delete']) ?>?id=' + selectedIds[0];
                    $.ajax({
                        type: 'POST',
                        url: deleteUrl,
                        success: function (response) {
                            if (response.success) {
                                $.pjax.reload({ container: '#tasks-pjax' });
                            } else {
                                alert('Ocorreu um erro ao tentar eliminar a tarefa.');
                            }
                        },
                        error: function () {
                            alert('Ocorreu um erro ao tentar eliminar a tarefa.');
                        }
                    });
                } else {
                    var deleteMultipleUrl = '<?= Url::to(['tasks/delete-multiple']) ?>';
                    $.ajax({
                        type: 'POST',
                        url: deleteMultipleUrl,
                        data: { taskIds: selectedIds },
                        success: function (response) {
                            if (response.success) {
                                $.pjax.reload({ container: '#tasks-pjax' });
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function () {
                            alert('Ocorreu um erro ao tentar eliminar as tarefas.');
                        }
                    });
                }
            }
        } else {
            alert('Por favor, selecione pelo menos uma tarefa.');
        }
    };

</script>