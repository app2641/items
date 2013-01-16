/**
 * Items.view.content.Relation
 * @app2641
 */
Ext.define('Items.view.content.Relation', {

    extend: 'Ext.panel.Panel',

    requires: [
        'Items.view.content.Combo',
        'Items.view.content.RelationForm'
    ],

    initComponent: function () {
        var me = this;

        me.items = [];
        me.buildCombo();
        me.buildForm();

        Ext.apply(me, {
            border: false,
            layout: 'anchor'
        });

        me.callParent(arguments);
    },


    buildCombo: function () {
        var me = this;

        me.items.push({
            xtype: 'content-Combo',
            listeners: {
                select: function (combo, record) {
                    var form = me.down('form');

                    if (form) {
                        // 素材やアイテムのストアをロードする
                        form.loadStores(record[0]);
                    }
                }
            }
        });
    },


    buildForm: function () {
        var me = this;

        me.items.push({
            xtype: 'content-RelationForm'
        });
    }

});
