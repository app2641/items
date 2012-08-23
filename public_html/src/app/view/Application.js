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
                xtype: 'content-Combo'
            }, '->', {
                xtype: 'tbtext',
                id: 'toalText',
                text: 'Total: 0'
            }]
        });

        me.callParent(arguments);
    }

});
