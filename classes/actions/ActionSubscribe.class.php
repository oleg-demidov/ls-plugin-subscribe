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
        
        $oSubscribe = $this->PluginSubscribe_Subscribe_GetSubscribeByFilter([
            'user_id' => $oUserCurrent->getId(),
            'event_id' => $oEvent->getId(),
            'target_id' => getRequest('targetId')
        ]);

        if($oSubscribe){
            
            $oSubscribe->Delete();
            
            $this->Message_AddNotice(
                $this->Lang_Get(
                    'plugin.subscribe.subscribe.notices.remove', 
                    ['event_name' => $oSubscribe->getName()]
                )
            );
            $this->Viewer_AssignAjax('state', 0);

        }else{
        
            $oSubscribe = Engine::GetEntity('PluginSubscribe_Subscribe_Subscribe');
            $oSubscribe->_setValidateScenario('create');
            $oSubscribe->setUserId(getRequest('userId'));
            $oSubscribe->setTargetId(getRequest('targetId'));
            $oSubscribe->setName(getRequest('name'));
            $oSubscribe->setUrl(getRequest('url'));
            $oSubscribe->setEventId($oEvent->getId());

            if(!$oSubscribe->_Validate()){
                $this->Message_AddError($oSubscribe->_getValidateError());
                return;
            }
            
            if(!$oSubscribe->Save()){ 
                $this->Message_AddError($this->Lang_Get('common.error'));
            }else{
                $this->Message_AddNotice($this->Lang_Get(
                        'plugin.subscribe.subscribe.notices.add', 
                        ['event_name' => $oSubscribe->getName()]
                    )
                );
            }
            $this->Viewer_AssignAjax('state', 1);

        }
        
        $this->Viewer_AssignAjax('count', $oEvent->getCountSubscribes(getRequest('targetId')));
    }
    
    
}