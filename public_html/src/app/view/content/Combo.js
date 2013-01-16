/**
 * Items.view.content.Combo
 * @app2641
 */
Ext.define('Items.view.content.Combo', {

    extend: 'Ext.form.field.ComboBox',

    alias: 'widget.content-Combo',

    initComponent: function () {
        var me = this,
            store = me.buildStore();

        Ext.apply(me, {
            store: store,
            forceSelection: true,
            displayField: 'value',
            valueField: 'id',
            editable: false,
            queryMode: 'local',
            width: 300
        });

        me.callParent(arguments);
    },


    buildStore: function () {
        var me = this;
        return Ext.create('Ext.data.Store', {
            fields: ['id', 'value'],
            autoLoad: true,
            proxy: {
                type: 'direct',
                directFn: Item.getComboList
            },
            listeners: {
                load: function (store, record) {
                    var data = record[record.length - 1];
                    me.select(record[record.length - 1]);
                    me.fireEvent('select', me, [data]);
                }
            }
        });
    }

});
