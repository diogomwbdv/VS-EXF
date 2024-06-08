<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

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
                    <td colspan="6" class="text-right">
                        <?= Html::a('Criar Tarefa', 'javascript:void(0);', ['class' => 'btn btn-success', 'id' => 'createTask']) ?>
                        <?= Html::a('Editar Selecionadas', 'javascript:void(0);', ['class' => 'btn btn-primary', 'id' => 'edit-selected']) ?>
                        <?= Html::a('Eliminar Selecionadas', 'javascript:void(0);', ['class' => 'btn btn-danger', 'id' => 'delete-selected']) ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php Pjax::end(); ?>
    </div>
</div>
