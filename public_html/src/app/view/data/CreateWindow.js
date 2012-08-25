/**
 * Items.view.data.CreateWindow
 * @app2641
 */
Ext.define('Items.view.data.CreateWindow', {

    extend: 'Ext.window.Window',

    requires: [
        'Items.view.data.Form'
    ],

    initComponent: function () {
        var me = this,
            api = me.buildApi();

        Ext.apply(me, {
            title: 'CreateForm',
            modal: true,
            layout: 'fit',
            border: false,
            autoScroll: true,
            width: 700,
            height: 500,
            items: [{
                xtype: 'data-Form',
                api: api,
                type: me.type
            }]
        });

        me.callParent(arguments);
    },

    buildApi: function () {
        var me = this,
            api;

        switch (me.type) {
        case 'is':
        case 'ia':
        case 'ib':
        case 'ic':
        case 'id':
            api = {
                submit: Item.dataCreate
            };
            break;

        case 'ms':
        case 'ma':
        case 'mb':
        case 'mc':
        case 'md':
            api = {
                submit: Material.dataCreate
            };
            break;
        }

        return api;
    }   

});
