<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\TasksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Lista de Tarefas';

?>

<?php if (!Yii::$app->user->isGuest): ?>
    <!-- Estrutura da tabela -->
    <?php require 'table.php'; ?>

    <!-- Modal para criar tarefa -->
    <div class="modal fade" id="modal-create-task" tabindex="-1" aria-labelledby="modal-create-task-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-create-task-label">Criar Nova Tarefa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulário para criar tarefa -->
                    <?= $this->render('_form', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para editar tarefa -->
    <div class="modal fade" id="modal-edit-task" tabindex="-1" aria-labelledby="modal-edit-task-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-task-label">Editar Tarefa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo do modal de edição será carregado dinamicamente -->
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<script>

    //Criar Tarefa
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



    //SELECIONAR TAREFA/S
    document.getElementById('select-all').onclick = function () {
        var checkboxes = document.querySelectorAll('.task-checkbox');
        for (var checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };


    //EDITAR TAREFA
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

    //APAGAR TAREFA

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