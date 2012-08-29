/**
 * Items Bootstrap
 * Copyright (C) San-ai Kikaku All Rights Reserved.
 */

Ext.ns('Items');

Ext.Loader.setConfig({
    enabled: true,
    paths: {
        'Ext': '/ext/src',
        'Ext.ux': '/src/ux',
        'Items': '/src/app'
    }
});

Ext.require([
    'Ext.direct.*',
    'Items.Events'
]);


Ext.onReady(function () {

    // lunchライブラリ初期化
    lunch.core.init();

    // Ext.direct.Providerの設定
    Ext.direct.Manager.addProvider(Items.REMOTING_API);

    // application build
    Ext.create('Items.view.Application', {
        renderTo: 'contents-container'
    });
});

