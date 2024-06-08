<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

?>

<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="table-responsive">
        <?php Pjax::begin(['id' => 'tasks-pjax']); ?>
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark text-center">
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
                    <tr data-id="<?= Html::encode($model->id) ?>" class="text-center">
                        <td><input type="checkbox" class="task-checkbox" value="<?= Html::encode($model->id) ?>"></td>
                        <td><?= Html::encode($model->title) ?></td>
                        <td><?= Html::encode($model->task_description) ?></td>
                        <td><?= Html::encode($model->created_at) ?></td>
                        <td><?= Html::encode($model->completed_at) ?></td>
                        <td><?= Html::encode($model->task_status) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right">
                        <?= Html::a('<i class="fas fa-plus"></i> Criar', 'javascript:void(0);', ['class' => 'btn btn-outline-success', 'id' => 'createTask']) ?>
                        <?= Html::a('<i class="fas fa-edit"></i> Editar', 'javascript:void(0);', ['class' => 'btn btn-outline-primary', 'id' => 'edit-selected']) ?>
                        <?= Html::a('<i class="fas fa-trash-alt"></i> Eliminar', 'javascript:void(0);', ['class' => 'btn btn-outline-danger', 'id' => 'delete-selected']) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
        <?php Pjax::end(); ?>
    </div>
</div>
