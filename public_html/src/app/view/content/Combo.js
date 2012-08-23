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

        me.initListeners();
    },

    initListeners: function () {
        var me = this;

        me.on({
            select: function (combo, record) {
                var grid = me.up('panel').down('grid');

                if (grid) {
                    grid.fireEvent('selectContent', record[0]);
                }
            }
        });
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
