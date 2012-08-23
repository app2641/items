/**
 * Items.view.content.Grid
 * @app2641
 */
Ext.define('Items.view.content.Grid', {

    extend: 'Ext.grid.Panel',

    alias: 'widget.content-Grid',

    initComponent: function () {
        var me = this,
            store = me.buildStore();

        Ext.apply(me, {
            store: store,
            loadMask: true,
            autoScroll: true,
            border: false,
            columns: [{
                text: 'id',
                dataIndex: 'id',
                sortable: true,
                flex: 1
            }, {
                text: 'name',
                dataIndex: 'name',
                sortable: true,
                flex: 3
            }, {
                text: 'price',
                dataIndex: 'price',
                sortable: true,
                flex: 2
            }, {
                text: 'exp',
                dataIndex: 'exp',
                sortable: true,
                flex: 2
            }, {
                text: 'active',
                dataIndex: 'is_active',
                sortable: true,
                flex: 2
            }],
            height: 570
        });

        me.callParent(arguments);

        me.initListeners();
    },

    initListeners: function () {
        var me = this;

        me.on({
            selectContent: function (record) {
                me.getStore().load({
                    params: {
                        value: record.data.id
                    }
                });
            },
            itemdblclick: function (grid, record) {
                var id = record.get('id'),
                    type = me.up('panel').down('combo').getValue();

                switch (type) {
                case 'is':
                case 'ia':
                case 'ib':
                case 'ic':
                case 'id':
                    Item.getData({
                        id: id
                    }, function (res) {
                        Ext.create('Items.view.data.Window', {
                            data: res,
                            type: type
                        }).show();
                    });
                    break;

                case 'ms':
                case 'ma':
                case 'mb':
                case 'mc':
                case 'md':
                    Material.getData({
                        id: id
                    }, function (res) {
                        Ext.create('Items.view.data.Window', {
                            data: res,
                            type: type
                        }).show();
                    });
                    break;
                }
            }
        });
    },

    buildStore: function () {
        var me = this;

        return Ext.create('Ext.data.Store', {
            fields: ['id', 'name', 'price', 'exp', 'is_active'],
            proxy: {
                type: 'direct',
                directFn: Item.getContents,
                reader: {
                    root: 'data'
                }
            },
            listeners: {
                load: function (store, record) {
                    me.up('panel').down('tbtext').setText('Total: ' + record.length);
                }
            }
        });
    }

});
