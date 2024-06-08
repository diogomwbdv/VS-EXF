<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/** @var yii\web\View $this */
/** @var app\models\TasksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

?>

<?php if (Yii::$app->user->isGuest): ?>

    <p><?php echo 'Faça login para visualizar a tabela.' ?></p>

    <p><?php echo 'Não é possível acessar às ações via URL até estar logado. Clique em Login para continuar.' ?></p>


<?php endif; ?>

<?php if (!Yii::$app->user->isGuest): ?>
    <div style="width: 100px; height: 100px;">
    </div>
    <!-- Estrutura da tabela -->

    <?php require 'table.php'; ?>

    <!-- O objetive seria ter apenas um modal para ambas operações mas não consegui solucionar problema, deixei separado-->
     <!-- O que faz com que tenham dinâmicas diferentes, problema está na forma está implementada a lógica do javascript - script.php-->

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

<?php require 'script.php'; ?>