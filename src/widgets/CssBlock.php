<?php
namespace yuncms\system\widgets;

use yii\widgets\Block;
/**
 * <?php \yuncms\system\widgets\CssBlock::begin() ?>
 * <style type="text/css">
 * .fr {
 *      float: right;
 * }
 * </style>
 * <?php \yuncms\system\widgets\CssBlock::end()?>
 * @author unknown
 */
class CssBlock extends Block
{

    /**
     * @var null
     */
    public $key = null;
    /**
     * @var array $options the HTML attributes for the style tag.
     */
    public $options = [];

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
        $cssBlockPattern = '|^<style[^>]*>(?P<blockContent>.+?)</style>$|is';
        if (preg_match($cssBlockPattern, $block, $matches)) {
            $block = $matches['blockContent'];
        }
        $this->view->registerCss($block, $this->options, $this->key);
    }
}