import {Notification, Message} from 'element-ui';
(function ($) {
    class FluentFormsGlobal {
        constructor() {
            this.fluent_forms_global_var = window.fluent_forms_global_var;
            this.url = fluent_forms_global_var.ajaxurl;
            this.defaultNotificationOption = {
                duration:3000,
                position:'top-right',
                offset: 30
            }
            this.defaultMessageOption = {
                offset: 40,
                duration: 2800,
                center: true
            }

            $.ajaxSetup({
                data:{
                    fluent_forms_admin_nonce: this.fluent_forms_global_var.fluent_forms_admin_nonce
                }
            });
        }

        $get(data, url = '') {
            url = url || this.url;

            return $.get(url, data);
        }

        $post(data, url = '') {
            url = url || this.url;

            return $.post(url, data);
        }

        // method for modify element ui notification and message options
        Notification(options ={},from, type ='', defaults ={}){

            if (typeof options === 'string') {
                options = {
                    message: options
                };
            }

            if (typeof defaults === 'string') {
                defaults = {
                    message: defaults
                }
            }

            let Response;
            if (from === 'message') {
                options = {...this.defaultMessageOption, ...defaults, ...options}
                Response = Message;
            }
            else if (from === 'notification') {
                options = {...this.defaultNotificationOption, ...defaults, ...options}
                Response = Notification;
            }

            if (type) {
                switch (type) {
                    case 'success':
                       return  Response.success(options);
                    case 'info':
                        return Response.info(options);
                    case 'error':
                        return Response.error(options);
                    case 'warning':
                        return Response.warning(options);
                }
            } else {
                return Response(options);
            }
        }

        // method for register element ui notification and message with default option
        RegisterNotificationAndMessage(Vue, defaults={},defaultFor = 'all'){
            if (typeof defaults === 'string') {
                defaults = {
                    message: defaults
                }
            }

            if (defaultFor === 'message') {
                this.defaultMessageOption = {...this.defaultMessageOption, ...defaults}
                defaults = {}
            } else if (defaultFor === 'notification') {
                this.defaultNotificationOption = {...this.defaultNotificationOption, ...defaults}
                defaults = {}
            }

            Vue.prototype.$message = options => this.Notification(options,'message','', defaults);
            Vue.prototype.$notify = options => this.Notification(options,'notification','', defaults);

            ['success','error','info','warning'].forEach(type => {
                switch (type) {
                    case 'success':
                        Vue.prototype.$message.success = (options) => this.Notification(options,'message',type, defaults);
                        Vue.prototype.$notify.success = (options) => this.Notification(options,'notification',type, defaults);
                        break;
                    case 'info':
                        Vue.prototype.$message.info = (options) => this.Notification(options,'message',type, defaults);
                        Vue.prototype.$notify.info = (options) => this.Notification(options,'notification',type, defaults);
                        break;
                    case 'error':
                        Vue.prototype.$message.error = (options) => this.Notification(options,'message',type, defaults);
                        Vue.prototype.$notify.error = (options) => this.Notification(options,'notification',type, defaults);
                        break;
                    case 'warning':
                        Vue.prototype.$message.warning = (options) => this.Notification(options,'message',type, defaults);
                        Vue.prototype.$notify.warning = (options) => this.Notification(options,'notification',type, defaults);
                        break;
                }
            })

        }
    }
    window.FluentFormsGlobal = new FluentFormsGlobal();

    jQuery('.update-nag,.notice, #wpbody-content > .updated, #wpbody-content > .error').remove();

})(jQuery)
