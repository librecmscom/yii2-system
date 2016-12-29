<?php
namespace yuncms\system\widgets;

use yii\web\View;
use yii\widgets\Block;

/**
 * <?php \yuncms\system\widgets\JsBlock::begin() ?>
 * <script>
 *      $(function(){
 *          jQuery(".company_introduce").slide({mainCell:".bd ul",effect:"left",autoPlay:true,mouseOverStop:true});
 *      });
 * </script>
 * <?php \yuncms\system\widgets\JsBlock::end()?>
 * @author unknown
 */
class JsBlock extends Block
{

    /**
     * @var null
     */
    public $key = null;

    /**
     * @var int
     */
    public $pos = View::POS_READY;

    /**
     * Ends recording a block.
     * This method stops output buffering and saves the rendering result as a named block in the view.
     */
    public function run()
    {
        $block = ob_get_clean();
        if ($this->renderInPlace) {
            throw new \Exception("not implemented yet ! ");
        }
        $block = trim($block);
        $jsBlockPattern = '|^<script[^>]*>(?P<blockContent>.+?)</script>$|is';
        if (preg_match($jsBlockPattern, $block, $matches)) {
            $block = $matches['blockContent'];
        }
        $this->view->registerJs($block, $this->pos, $this->key);
    }
}