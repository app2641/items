/**
 * Items.view.Application
 * @app2641
 */
Ext.define('Items.view.Application', {

    extend: 'Ext.panel.Panel',

    requires: [
        'Items.view.content.Grid',
        'Items.view.content.Combo'
    ],

    initComponent: function () {
        var me = this;

        Ext.apply(me, {
            layout: 'fit',
            items: [{
                xtype: 'content-Grid'
            }],
            tbar: [{
                text: '新規作成',
                handler: function () {
                    Ext.create('Items.view.data.CreateWindow', {
                        type: me.down('combo').getValue()
                    }).show();
                }
            }, '-', {
                xtype: 'content-Combo',
                listeners: {
                    select: function (combo, record) {
                        var grid = me.down('grid');

                        if (grid) {
                            grid.fireEvent('selectContent', record[0]);
                        }
                    }
                }
            }, '-', {
                text: '調合関係',
                handler: function () {
                    window.open('/index/relation');
                }
            }, '-', {
                text: 'MateirlCsv',
                handler: function () {
                    Material.generateCsv(function (res) {
                        if (res.success) {
                            me.downloadCsv(res);
                        }
                    });
                }
            }, '-', {
                text: 'ItemCsv',
                handler: function () {
                    Item.generateCsv(function (res) {
                        if (res.success) {
                            me.downloadCsv(res);
                        }
                    });
                }
            }, '-', {
                text: 'Memo',
                handler: function () {
                    window.open('/index/memo');
                }
            }, '->', {
                xtype: 'tbtext',
                id: 'toalText',
                text: 'Total: 0'
            }]
        });

        me.callParent(arguments);
    },

    downloadCsv: function (res) {
        var body = Ext.getBody();

        body.createChild({
            tag: 'iframe',
            src: '/index/downloadcsv?name=' + res.name,
            border: '0',
            frameborder: '0',
            style: 'display:none;'
        });
    }

});
