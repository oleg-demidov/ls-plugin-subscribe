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
    
}