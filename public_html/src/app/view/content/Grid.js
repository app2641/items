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
            id: 'data-container-grid',
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
                text: 'rarity',
                dataIndex: 'rarity',
                sortable: true,
                flex: 1
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
                flex: 1
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
                case 'im':
                    Important.getData({
                        id: id
                    }, function (res) {
                        Ext.create('Items.view.data.Window', {
                            data: res,
                            type: type
                        }).show();
                    });
                    break;

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
            },
            itemcontextmenu: function (grid, row, item, index, e) {
                var menu = Ext.create('Ext.menu.Menu', {
                    items: [{
                        text: 'item delete',
                        handler: function () {
                            me.itemDelete(row);
                        }
                    }]
                });
                e.stopEvent();
                menu.showAt(e.getXY());
            }
        });
    },

    buildStore: function () {
        var me = this;

        return Ext.create('Ext.data.Store', {
            fields: ['id', 'name', 'rarity', 'price', 'exp', 'is_active'],
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
    },

    itemDelete: function (row) {
        var me = this,
            type = me.up('panel').down('combo').getValue(),
            mask = new Ext.LoadMask(Ext.getBody(), {
                msg: 'waiting....'
            });

        Ext.Msg.confirm('Confirm', 'sure delete?', function (b) {
            if (b == 'yes') {
                mask.show();

                switch (type) {
                    case 'is':
                    case 'ia':
                    case 'ib':
                    case 'ic':
                    case 'id':
                        Item.dataDelete({
                            id: row.raw.id
                        }, function (res) {
                            mask.hide();

                            if (res.success) {
                                me.getStore.load({
                                    params: {
                                        value: type
                                    }
                                });
                    
                            } else {
                                Ext.Msg.show({
                                    title: 'Caution!',
                                    msg: res.msg,
                                    icon: Ext.Msg.ERROR,
                                    buttons: Ext.Msg.OK
                                });
                            }
                        });
                        break;

                    case 'ms':
                    case 'ma':
                    case 'mc':
                    case 'md':
                        Material.dataDelete({
                            id: row.raw.id
                        }, function (res) {
                            mask.hide();

                            if (res.success) {
                                me.getStore.load({
                                    params: {
                                        value: type
                                    }
                                });
                    
                            } else {
                                Ext.Msg.show({
                                    title: 'Caution!',
                                    msg: res.msg,
                                    icon: Ext.Msg.ERROR,
                                    buttons: Ext.Msg.OK
                                });
                            }
                        });
                        break;
                }
            }
        });
    }

});
