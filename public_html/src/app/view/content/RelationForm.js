/**
 * Items.view.content.RelationForm
 * @app2641
 */
Ext.define('Items.view.content.RelationForm', {

    extend: 'Ext.form.Panel',

    alias: 'widget.content-RelationForm',

    requires: [
        'Ext.ux.form.ItemSelector'
    ],

    initComponent: function () {
        var me = this;

        me.items = [];
        me.buildSelectorGrid({
            url: Material.getItemSelectorData,
            grid_name: 'first_material',
            panel_name: 'first_material_description',
            item_type: 'material'
        });

        me.buildSelectorGrid({
            url: Material.getItemSelectorData,
            grid_name: 'second_material',
            panel_name: 'second_material_description',
            item_type: 'material'
        });

        me.buildSelectorGrid({
            url: Item.getItemSelectorData,
            grid_name: 'item_grid',
            panel_name: 'item_grid_description',
            item_type: 'item'
        });


        Ext.apply(me, {
            border: false,
            buttons: [{
                text: 'submit',
                handler: function () {
                    me.submit();
                }
            }]
        });

        me.callParent(arguments);
    },


    buildSelectorGrid: function (config) {
        var me = this,
            store = me.createBaseStore(config.url);

        me.items.push({
            layout: 'hbox',
            border: false,
            items: [{
                xtype: 'grid',
                name: config.grid_name,
                store: store,
                hideHeaders: true,
                width: 450,
                height: 200,
                columns: [{
                    dataIndex: 'name',
                    flex: 1
                }],
                listeners: {
                    select: function (grid, record) {
                        var panel = me.down('panel[name="' + config.panel_name + '"]');
                        me.displayDescriptionPanel(config.item_type, panel, record);

                        // materialの場合は調合関係が既に構築されているか確認する
                        if (config.item_type == 'material') {
                            me.selectItemValue();
                        }
                    }
                }
            }, {
                xtype: 'panel',
                name: config.panel_name,
                border: false,
                height: 200,
                bodyStyle: 'padding-left: 40px'
            }],
            bodyStyle: 'padding: 10px'
        });
    },


    // 基本のストアを生成する
    createBaseStore: function (url) {
        return Ext.create('Ext.data.Store', {
            fields: [
                {name: 'id'},
                {name: 'name'}
            ],
            proxy: {
                type: 'direct',
                directFn: url,
                root: 'result'
            }
        });
    },


    loadStores: function (record) {
        var me = this,
            first_material = me.down('grid[name="first_material"]'),
            first_store = first_material.getStore(),
            
            second_material = me.down('grid[name="second_material"]'),
            second_store = second_material.getStore(),
            
            item_grid = me.down('grid[name="item_grid"]'),
            item_store = item_grid.getStore();


        first_store.proxy.extraParams.cls = record.data.id;
        first_store.load();

        second_store.proxy.extraParams.cls = record.data.id;
        second_store.load();

        item_store.proxy.extraParams.cls = record.data.id;
        item_store.load();
    },


    selectItemValue: function () {
        var me = this,
            first_material = me.down('grid[name="first_material"]'),
            second_material = me.down('grid[name="second_material"]'),
            
            first_value = first_material.getSelectionModel().getSelection()[0],
            second_value = second_material.getSelectionModel().getSelection()[0];


        if (first_value !== undefined && second_value !== undefined) {
            // 組み合わせデータの取得
            Mixin.fetchItemData({
                first_value: first_value.data.id,
                second_value: second_value.data.id
            }, function (response) {
                if (response.success && response.data !== false) {
                    var item_grid = me.down('grid[name="item_grid"]'),
                        record = item_grid.getStore().getById(response.data.item_id);

                    item_grid.getSelectionModel().select(record);
                }
            });
        }
    },


    // 選択したアイテムの情報を表示する
    displayDescriptionPanel: function (type, cmp, record) {
        var me = this,
            html;

        switch (type) {
            case 'material':
                Material.getData({
                    id: record.raw.id
                }, function (response) {
                    html = me.buildDetailHtml(response);

                    // 子要素を破棄してhtmlを仕込んだパネルを追加する
                    cmp.removeAll();
                    cmp.add({
                        xtype: 'panel',
                        border: false,
                        autoScroll: true,
                        html: html,
                        width: 600,
                        height: 200
                    });
                });
                break;

            case 'item':
                Item.getData({
                    id: record.raw.id
                }, function (response) {
                    html = me.buildDetailHtml(response);

                    // 子要素を破棄してhtmlを仕込んだパネルを追加する
                    cmp.removeAll();
                    cmp.add({
                        xtype: 'panel',
                        border: false,
                        autoScroll: true,
                        html: html,
                        height: 200
                    });
                });
                break;
        }
    },


    // 詳細表示のhtmlを構築する
    buildDetailHtml: function (response) {
        var html = '<h3>' + response.name + '</h3>' +
            '<p>Class: ' + response.cls + '<br />' +
            'レア度: ' + response.rarity + '<br />' +
            '値段: ' + response.price + '<br /><br /></p>' +
            '<p>' + response.description + '</p>';

        return html;
    },


    submit: function () {
        var me = this,
            first_material = me.down('grid[name="first_material"]'),
            second_material = me.down('grid[name="second_material"]'),
            item_grid = me.down('grid[name="item_grid"]'),
            
            first_value = first_material.getSelectionModel().getSelection()[0],
            second_value = second_material.getSelectionModel().getSelection()[0],
            item_value = item_grid.getSelectionModel().getSelection()[0];


        // 同じ素材を選択していた場合はエラー
        if (first_value.data.id === second_value.data.id) {
            Ext.Msg.show({
                title: 'Caution!',
                msg: '選択が同じ',
                icon: Ext.Msg.ERROR,
                buttons: Ext.Msg.OK
            });

            return false;
        }


        if (first_value !== undefined && second_value !== undefined && item_value !== undefined) {
            me.getForm().submit({
                params: {
                    first_value: first_value.data.id,
                    second_value: second_value.data.id,
                    item_value: item_value.data.id
                },
                success: function (form, response) {
                    Ext.Msg.show({
                        title: 'Success!',
                        msg: 'Updated!',
                        icon: Ext.Msg.INFO,
                        buttons: Ext.Msg.OK
                    });
                },
                failure: function (form, response) {
                    Ext.Msg.show({
                        title: 'Caution!',
                        msg: response.result.msg,
                        icon: Ext.Msg.ERROR,
                        buttons: Ext.Msg.OK
                    });
                }
            });
        }
    }

});
