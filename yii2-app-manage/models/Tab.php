<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tab".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $tab_name
 * @property string $tab_type
 * @property string|null $content
 * @property int|null $deleted
 * @property int|null $position
 * @property string $created_at
 * @property string $updated_at
 *
 * @property TableTab[] $tableTabs
 * @property User $user
 */
class Tab extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tab';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'tab_type'], 'required'],
            [['user_id', 'deleted', 'position'], 'integer'],
            [['tab_type', 'content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['tab_name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tab_name' => 'Tab Name',
            'tab_type' => 'Tab Type',
            'content' => 'Content',
            'deleted' => 'Deleted',
            'position' => 'Position',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[TableTabs]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTableTabs()
    {
        return $this->hasMany(TableTab::class, ['tab_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
