<?php

/*
 * LiveStreet CMS
 * Copyright © 2018 OOO "ЛС-СОФТ"
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
 * @author Oleg Demodov <boxmilo@gmail.com>
 *
 */

/**
 * Description of BlockMenuSettings
 *
 * @author oleg
 */
class PluginSubscribe_BlockMenuSubscribe extends BlockMenu {

    public function __construct($aParams) {
        
        if (!($this->oUserProfile = $this->User_GetUserByLogin(Router::GetActionEvent()))) {
            return false;
        } 
        
        $aEvents = $this->PluginSubscribe_Subscribe_GetEventItemsByEnable(1);
        
        $oMenu = $this->Menu_Get('subscribe');
        
        foreach ($aEvents as $oEvent) {
            if(!$oEvent->getCountSubscribes()){
                continue;
            }
            $oMenu->appendChild(Engine::GetEntity("ModuleMenu_EntityItem", [
                'title' => $oEvent->getTitle(), 
                'name' => $oEvent->getCode(), 
                'count' => $oEvent->getCountSubscribes(),
                'url' => 'subscribe/'.$this->oUserProfile->getLogin()."/". $oEvent->getCode()
            ]));
        }
        
        if(!$oMenu->getItems()){
            return null;
        }
        
        $aParams['name'] = 'subscribe';
        parent::__construct($aParams);
    }   
    

}
