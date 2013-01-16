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
        me.buildFirstMaterialSelector();

        Ext.apply(me, {
            border: false
        });

        me.callParent(arguments);
    },


    buildFirstMaterialSelector: function () {
        var me = this,
            store = me.createBaseStore(Material.getItemSelectorData);

        me.items.push({
            layout: 'hbox',
            border: false,
            items: [{
                xtype: 'multiselect',
                name: 'first_material',
                store: store,
                hideLabel: true,
                displayField: 'name',
                valueField: 'id',
                width: 450,
                height: 230,
                listeners: {
                    select: function (selector, record) {
                        console.log(record);
                    }
                }
            }, {
                xtype: 'panel',
                name: 'first_material_description'
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
            first_material = me.down('multiselect[name="first_material"]'),
            first_store = first_material.getStore();

        first_store.proxy.extraParams.cls = record.data.id;
        first_store.load();
    }

});
