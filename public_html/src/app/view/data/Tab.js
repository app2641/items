/**
 * Items.view.data.Tab
 * @app2641
 */
Ext.define('Items.view.data.Tab', {

    extend: 'Ext.tab.Panel',

    requires: [
        'Items.view.data.Description',
        'Items.view.data.Form'
    ],

    alias: 'widget.data-Tab',

    initComponent: function () {
        var me = this,
            api = me.buildApi();

        Ext.apply(me, {
            items: [{
                xtype: 'data-Description',
                type: me.type,
                data: me.data
            }, {
                xtype: 'data-Form',
                api: api,
                paramOrder: ['id'],
                dataload: true,
                data: me.data
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
                submit: Item.dataUpdate,
                load: Item.dataLoad
            };
            break;

        case 'ms':
        case 'ma':
        case 'mb':
        case 'mc':
        case 'md':
            api = {
                submit: Material.dataUpdate,
                load: Material.dataLoad
            };
            break;
        }

        return api;
    }

});
