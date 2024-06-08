<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\TasksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>
<?php if (!Yii::$app->user->isGuest): ?>
    <div class="tasks-index">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="table-responsive">
            <?php Pjax::begin(['id' => 'tasks-pjax']); ?>
            <table class="table table-bordered table-hover table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Criado em</th>
                        <th>Concluído em</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider->getModels() as $index => $model): ?>
                        <tr data-id="<?= Html::encode($model->id) ?>">
                            <td><input type="checkbox" class="task-checkbox" value="<?= Html::encode($model->id) ?>"></td>
                            <td><?= Html::encode($model->title) ?></td>
                            <td><?= Html::encode($model->task_description) ?></td>
                            <td><?= Html::encode($model->created_at) ?></td>
                            <td><?= Html::encode($model->completed_at) ?></td>
                            <td><?= Html::encode($model->task_status) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="7" class="text-right">
                            <?= Html::a('Criar Tarefa', ['create'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Editar Selecionadas', 'javascript:void(0);', ['class' => 'btn btn-primary', 'id' => 'edit-selected']) ?>
                            <?= Html::a('Eliminar Selecionadas', 'javascript:void(0);', ['class' => 'btn btn-danger', 'id' => 'delete-selected']) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php Pjax::end(); ?>
        </div>
    </div>
<?php endif; ?>

<script>
document.getElementById('select-all').onclick = function() {
    var checkboxes = document.querySelectorAll('.task-checkbox');
    for (var checkbox of checkboxes) {
        checkbox.checked = this.checked;
    }
};

document.getElementById('edit-selected').onclick = function() {
    var selectedIds = [];
    var checkboxes = document.querySelectorAll('.task-checkbox:checked');
    for (var checkbox of checkboxes) {
        selectedIds.push(checkbox.value);
    }
    if (selectedIds.length === 1) {
        var editUrl = '<?= Url::to(['update']) ?>?id=' + selectedIds[0];
        window.location.href = editUrl;
    } else if (selectedIds.length > 1) {
        alert('Por favor, selecione apenas uma tarefa para editar.');
    } else {
        alert('Por favor, selecione uma tarefa para editar.');
    }
};

document.getElementById('delete-selected').onclick = function() {
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
                    success: function(response) {
                        if (response.success) {
                            $.pjax.reload({container: '#tasks-pjax'});
                        } else {
                            alert('Ocorreu um erro ao tentar eliminar a tarefa.');
                        }
                    },
                    error: function() {
                        alert('Ocorreu um erro ao tentar eliminar a tarefa.');
                    }
                });
            } else {
                var deleteMultipleUrl = '<?= Url::to(['tasks/delete-multiple']) ?>';
                $.ajax({
                    type: 'POST',
                    url: deleteMultipleUrl,
                    data: {taskIds: selectedIds},
                    success: function(response) {
                        if (response.success) {
                            $.pjax.reload({container: '#tasks-pjax'});
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
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
