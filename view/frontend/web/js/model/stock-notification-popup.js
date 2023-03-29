define([
    'jquery',
    'Magento_Ui/js/modal/modal',
    'mage/url'
], function ($, modal, url) {

    $.widget('stocknotification.popup', {
        options: {
            totalProducts : 0
        },
        _create: function () {
            var self = this;
            var modelOptions = {
                type: 'popup',
                responsive: true,
                clickableOverlay: false,
                modalClass: 'modal-popup regular-stock-notification',
                innerScroll: true,
                buttons: [
                    {
                        text: $.mage.__('Submit'),
                        class: '',
                        click: function () {
                            var formdata = $('.stock-notification').serializeArray();
                            var getUrl = url.build('stocknotification/index/save');
                            $.ajax({
                                url: getUrl,
                                data: formdata,
                                type: 'POST',
                                dataType: 'json',
                                showLoader: true,
                                beforeSend: function() {
                                    $('body').trigger('processStart');
                                },
                                success: function(data, status, xhr) {
                                    console.log(data);
                                    $('body').trigger('processStop');  
                                    $('#stock-notification-popup').modal('closeModal');
                                    location.reload(true);
                                },
                                error: function (xhr, status, errorThrown) {
                                    console.log('Error happens. Try again.');
                                    console.log(errorThrown);
                                }
                            });
                        }
                    }]
            };
            var popup = modal(modelOptions, $('#stock-notification-popup'));
            if(self.options.totalProducts > 0) {
                $('#stock-notification-popup').modal('openModal');    
            }
            
        }
    });
    return $.stocknotification.popup;
});