<?php
/**
 * YiiDebugToolbarPanelAjax class file.
 *
 * @author jellysandwich <jellysandwich2@gmail.com>
 */

class YiiDebugToolbarPanelAjax extends YiiDebugToolbarPanel
{
    /**
     * {@inheritdoc}
     */
    public function getMenuTitle()
    {
        return "<span id='num_ajax'>0</span> " . YiiDebug::t('ajax');
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return YiiDebug::t('Request');
    }

    /**
     * {@inheritdoc}
     */
    public function init()
    {}

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $this->render('ajax');
    }
}
