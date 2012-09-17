/**
 * Items.view.data.DataWindow
 * @app2641
 */
Ext.define('Items.view.data.Window', {

    extend: 'Ext.window.Window',

    requires: [
        'Items.view.data.Tab'
    ],

    initComponent: function () {
        var me = this;

        Ext.apply(me, {
            title: me.data.name,
            layout: 'fit',
            border: false,
            modal: true,
            width: 700,
            height: 520,
            items: [{
                xtype: 'data-Tab',
                type: me.type,
                data: me.data
            }]
        });

        me.callParent(arguments);
    }

});
