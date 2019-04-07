<?php

class PluginSubscribe_ModuleSubscribe extends ModuleORM
{
    
   
    public function Init() {
        parent::Init(); 
    }
    
    public function CreateEvent($sCode, $sTitle, $sCallback) {
        
        $oEvent = Engine::GetEntity('PluginSubscribe_Subscribe_Event', [
            'code' => $sCode,
            'title' => $sTitle,
            'callback' => $sCallback
        ]);
        
        if(!$oEvent->_Validate()){
            return $oEvent->_getValidateError();
        }
        
        return $oEvent->Save();
    }
    
    public function SubscribeEventUser(PluginSubscribe_ModuleSubscribe_EntityEvent $oEvent, $iUserId, $sTargetId) {
        
        $oSubscribe = Engine::GetEntity('PluginSubscribe_Subscribe_Subscribe', [
            'user_id' => $iUserId,
            'event_id'  => $oEvent->getId(),
            'target_id' => $sTargetId
        ]);
        
        if(!$oSubscribe->_Validate()){
            return $oSubscribe->_getValidateError();
        }
        
        return $oSubscribe->Save();
    }
    
    public function RemoveEventUser(PluginSubscribe_ModuleSubscribe_EntityEvent $oEvent, $iUserId, $sTargetId) {
        
        $oSubscribe = $this->PluginSubscribe_Subscribe_GetSubscribeByFilter( [
            'user_id' => $iUserId,
            'event_id'  => $oEvent->getId(),
            'target_id' => $sTargetId
        ]);
        
        if(!$oSubscribe){
            return true;
        }
                
        return $oSubscribe->Delete();
    }
    
}