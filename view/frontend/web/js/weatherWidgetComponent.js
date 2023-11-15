define([
    'ko',
    'jquery',
    'uiComponent',
    'mage/url',
    'mage/translate'
], function (ko, $, Component, url, $t) {
    'use strict';

    return Component.extend({
        conditionIcon: ko.observable(''),
        cityName: ko.observable(''),
        celcius: ko.observable(''),
        farenheith: ko.observable(''),
        windSpeed: ko.observable(''),
        location: ko.observable(''),
        loadingData: ko.observable(true),
        dataError: ko.observable($t('Loading...')),
        initialize: function () {
            this._super();
            this.getCurrentPosition();
        },
        getCurrentPosition: function () {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    this.location(position.coords.latitude + ',' + position.coords.longitude);
                    this.setWeatherData();
                }, (err) => {
                    this.dataError(err.message);
                    this.requestPermission(true);
                });
            } else {
                this.dataError($t('Geolocation is not supported by this browser.'));
            }
        },
        setWeatherData: function () {
            let location = this.location();
            let urlService = url.build('/weatherwidget/service/index');
            $.post(urlService, { location: location })
                .done((function (msg) {
                    if (msg.response != "empty" && msg != "") {
                        this.conditionIcon(msg.response.img_condition);
                        this.cityName(msg.response.location);
                        this.celcius(msg.response.temp_c);
                        this.farenheith(msg.response.temp_f);
                        this.windSpeed(msg.response.wind_s);
                        this.loadingData(false);
                        $('.weather-condition').show();
                        $('.weather-desc-box').show();
                    } else {
                        this.dataError($t('No Data'));
                    }

                }).bind(this))
                .fail((function () {
                    this.dataError($t('Something went wrong'));
                }).bind(this));
        },

    });
});