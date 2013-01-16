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


    // アイテムデータ入力画面
    if (Ext.get('contents-container')) {
        Ext.create('Items.view.Application', {
            renderTo: 'contents-container'
        });

    // メモ画面
    } else if (Ext.get('memo-container')) {
        Ext.create('Items.view.content.Memo', {
            renderTo: 'memo-container'
        });

    // 調合関係設定画面
    } else if (Ext.get('relation-container')) {
        Ext.create('Items.view.content.Relation', {
            renderTo: 'relation-container'
        });
    }
});

