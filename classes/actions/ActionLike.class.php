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
 * @author Oleg Demidov 
 *
 */

/**
 * Экшен обработки ajax запросов
 * Ответ отдает в JSON фомате
 *
 * @package actions
 * @since 1.0
 */
class PluginSubscribe_ActionSubscribe extends ActionPlugin{
    
    public function Init()
    {
        
    }
    protected function RegisterEvent() {
        $this->AddEventPreg('/^ajax-subscribe$/i','EventAjaxSubscribe');
    }
    
    public function EventAjaxSubscribe() {
        $this->Viewer_SetResponseAjax('json');
        
        if(!$oUserCurrent = $this->User_GetUserCurrent()){
            $this->MessageAddError('no auth');
        }

        if(getRequest('state') == 1 ){
            
            $mResult = $this->PluginLike_Like_RemoveLike( 
                $oUserCurrent->getId(), 
                getRequest('targetType'),
                getRequest('targetId')
            );
            $this->Message_AddNotice($this->Lang_Get('plugin.like.like.notices.remove'));
            $this->Viewer_AssignAjax('state', 0);

        }else{
        
            $sResult = $this->PluginLike_Like_Like( 
                $oUserCurrent->getId(), 
                getRequest('targetType'),
                getRequest('targetId')
            );

            if(is_string($sResult)){ 
                $this->Message_AddError($sResult);
            }else{
                $this->Message_AddNotice($this->Lang_Get('plugin.like.like.notices.add'));
            }
            $this->Viewer_AssignAjax('state', 1);
        
        }
        
        $this->Viewer_AssignAjax('count', 
                $this->PluginLike_Like_GetCountForTarget(getRequest('targetType'), getRequest('targetId')));
    }
}