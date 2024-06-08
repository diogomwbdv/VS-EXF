<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string $task_description
 * @property string $created_at
 * @property string|null $completed_at
 * @property string $task_status
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'task_description', ], 'required'],
            [['created_at', 'completed_at'], 'safe'],
            [['task_status'], 'string'],
            [['title'], 'string', 'max' => 25],
            [['task_description'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'task_description' => 'Task Description',
            'created_at' => 'Created At',
            'completed_at' => 'Completed At',
            'task_status' => 'Task Status',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = date('Y-m-d H:i:s');
        }
        return parent::beforeSave($insert);
    }
}
