<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\console;

use Yii;
use yii\console\Controller;
use yuncms\admin\models\Banword;
use yuncms\admin\helpers\BanHelper;

/**
 * Class BadwordController
 */
class BadwordController extends Controller
{
    public $defaultAction = 'test';

    /**
     * import badword
     */
    public function actionImport()
    {
        $files = scandir(Yii::getAlias("@console/resources/banword"));
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            $content = file_get_contents(Yii::getAlias("@console/resources/banword/") . $file);
            $words = explode("@", $content);
            $wordsLen = count($words);
            for ($i = 0; $i < $wordsLen; $i++) {
                $words[$i] = trim($words[$i]);
                if ((strlen($words[$i]) > 0 && !empty($words[$i])) && !Banword::find()->where(['word' => $words[$i]])->exists()) {
                    $badword = new Banword([
                        'word' => $words[$i],
                    ]);
                    $badword->save();
                    $this->stdout('import ban word :' . $words[$i] . "\r\n");
                }
            }
            BanHelper::invalidate();
        }
        $this->stdout("import ban word complete!\r\n");
    }

    /**
     * test Badword
     */
    public function actionTest()
    {
        $starttime = explode(' ', microtime());
        for ($i = 1; $i <= 100; $i++) {
            $isBanWord = BanHelper::checkWord('这里介绍一下办证microtime() 这个函数，microtime() 用的不多，但是不能不知道这个函数，它是返回当前 Unix 时间戳和微秒数。例如：echo microtime(); 会返回：0.08845800 1376983061。所以可以用explode函数将它以空格为标识分割成一个数组，那么此时的$starttime[0]=0.08845800（微秒数），$starttime[1]=1376983061（当前秒数，相当于time()所得的结果）。');
        }
        $endtime = explode(' ', microtime());
        $thistime = $endtime[0] + $endtime[1] - ($starttime[0] + $starttime[1]);
        $thistime = round($thistime, 3);
        var_dump($isBanWord);
        $this->stdout("runtime: {$thistime} ms.\r\n");
    }
}