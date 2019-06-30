<?php
/*
 * LiveStreet CMS
 * Copyright © 2013 OOO "ЛС-СОФТ"
 *
 * ------------------------------------------------------
 *
 * Official site: www.livestreetcms.com
 * Contact e-mail: office@livestreetcms.com
 *
 * GNU General Public License, version 2:
 * http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 * ------------------------------------------------------
 *
 * @link http://www.livestreetcms.com
 * @copyright 2013 OOO "ЛС-СОФТ"
 * @author 
 *
 */

/**
 * 
 *
 * @package application.blocks
 * @since   2.0
 */
class PluginSubscribe_BlockSubscribe extends Block
{
    /**
     * Запуск обработки
     */
    public function Exec()
    {
        $oEvent = $this->PluginSubscribe_Subscribe_GetEventByCode($this->GetParam('event'));
        if(!$oEvent){
            return false;
        }
        
        if($oUserCurrent  = $this->User_GetUserCurrent()){
            $this->Viewer_Assign('user', $oUserCurrent, true);
        }
        
        $this->Viewer_Assign('remove', $this->GetParam('remove'), true);
        $this->Viewer_Assign('classes', $this->GetParam('classes'), true);
        $this->Viewer_Assign('target_id', $this->GetParam('target_id'), true);
        $this->Viewer_Assign('name', $this->GetParam('name'), true);
        $this->Viewer_Assign('link', $this->GetParam('url'), true);
        $this->Viewer_Assign('event', $oEvent, true);
        
        
        $this->SetTemplate('component@subscribe:subscribe');
    }
}