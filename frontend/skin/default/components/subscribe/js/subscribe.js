
(function($) {
    "use strict";

    $.widget( "livestreet.lsSubscribe", $.livestreet.lsComponent, {
        /**
         * Дефолтные опции
         */
        options: {
            // Селекторы
            
            i18n: {
                unsubscribe: "@plugin.subscribe.subscribe.text.unsubscribe",
                subscribe: "@plugin.subscribe.subscribe.text.subscribe"
            },
            urls:{
                load: aRouter.subscribe + 'ajax-subscribe'
            }
        },

        /**
         * Конструктор
         *
         * @constructor
         * @private
         */
        _create: function () {

            this._super();
            
            this._on(this.element, {click: "onClick"})

            
        },
        onClick:function(){
            this.element.bsButton('loading');
            
            if(this.element.hasClass('active')){
                this.option('params.state', 1);
            }
            
            this._load("load", {}, function(response){
                this.option('params.state', response.state);
                this.element.button('toggle');
                this.element.bsButton('setCount', response.count);
                if(response.state == 1){
                    this.element.bsButton('setText', this._i18n('unsubscribe'));
                }
                if(response.state == 0){
                    this.element.bsButton('setText', this._i18n('subscribe'));
                }
            }.bind(this), {
                showProgress:false, 
                onComplete: function(response){
                    this.element.bsButton('loaded');
                }.bind(this)
            });
        }
        
    });
})(jQuery);