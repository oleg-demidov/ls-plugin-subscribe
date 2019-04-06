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
        
        $this->RegisterEventExternal('Subscribe', 'PluginSubscribe_ActionSubscribe_EventSubscribe');
        $this->AddEventPreg('/^[\w]+$/i', '/^([\w]+)?$/i', '/^(page([\d]+))?$/i', ['Subscribe::EventList' , 'subscribes']);
    }
    
    public function EventAjaxSubscribe() {
        $this->Viewer_SetResponseAjax('json'); 
        
        if(!$oUserCurrent = $this->User_GetUserCurrent()){
            $this->MessageAddError('no auth');
        }
        
        if(!$oEvent = $this->PluginSubscribe_Subscribe_GetEventByCode( getRequest('event'))){
            return 'no event';
        }

        if(getRequest('state') == 1 ){
            
            $sResult = $this->PluginSubscribe_Subscribe_RemoveEventUser( 
                $oEvent,
                getRequest('userId')
            );
            
            $this->Message_AddNotice(
                $this->Lang_Get(
                    'plugin.subscribe.subscribe.notices.remove', 
                    ['event_name' => $oEvent->getTitle()]
                )
            );
            $this->Viewer_AssignAjax('state', 0);

        }else{
        
            $sResult = $this->PluginSubscribe_Subscribe_SubscribeEventUser( 
                $oEvent,
                getRequest('userId'),
                getRequest('targetTitle')
            );

            if(is_string($sResult)){ 
                $this->Message_AddError($sResult);
            }else{
                $this->Message_AddNotice($this->Lang_Get(
                        'plugin.subscribe.subscribe.notices.add', 
                        ['event_name' => $oEvent->getTitle()]
                    )
                );
            }
            $this->Viewer_AssignAjax('state', 1);
        
        }
        
        $this->Viewer_AssignAjax('count', $oEvent->getCountSubscribes());
    }
    
    
}