<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */

namespace yuncms\system\jobs;

use Yii;
use yii\base\Object;
use yii\queue\Queue;
use yii\queue\RetryableJob;
use yuncms\system\ScanInterface;

/**
 * Class GreenJob.
 */
class ScanTextJob extends Object implements RetryableJob
{
    /**
     * @var int 要检查的ID
     */
    public $modelId;

    /**
     * @var string 要检查的模型
     */
    public $modelClass;

    /**
     * 审查场景
     * @var string 场景e.g  [“new”, “edit”, “share”, “others”]
     */
    public $scenario;

    /**
     * 审查类别
     * @var string 审核类别 e.g [“post”, “reply”, “comment”, “title”, “others”]
     */
    public $category;

    /**
     * @inheritdoc
     */
    public function execute($queue)
    {
        if ($this->modelClass instanceof ScanInterface) {
            /** @var \yii\db\ActiveRecord $modelClass */
            $modelClass = $this->modelClass;
            if (($content = $modelClass::findReview($this->modelId)) != null) {
                $suggestion = $this->green([
                    'action' => $this->scenario,
                    'category' => $this->category,
                    'content' => $content,
                ]);
                $modelClass::review($this->modelId, $suggestion);
            }
        }
    }

    /**
     * 文本反垃圾
     * @param array $tasks
     * @return string 建议用户处理，取值范围：[“pass”, “review”, “block”], pass:文本正常，review：需要人工审核，block：文本违规，可以直接删除或者做限制处理
     */
    protected function green($tasks)
    {
        $results = Yii::$app->green->textScan([$tasks]);
        $result = array_pop($results);
        if ($result['code'] == 200) {
            $suggestion = 'pass';
            foreach ($result['results'] as $res) {
                if ($res['suggestion'] == 'block') {//直接删除
                    $suggestion = 'block';
                    break;
                } else if ($res['suggestion'] == 'review') {//人工审核
                    $suggestion = 'review';
                    break;
                }
            }
        } else {
            $suggestion = 'review';
        }
        return $suggestion;
    }

    /**
     * @inheritdoc
     */
    public function getTtr()
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    public function canRetry($attempt, $error)
    {
        return $attempt < 3;
    }
}
