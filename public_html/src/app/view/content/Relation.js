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
            layout: 'hbox',
            border: false,
            items: [{
                xtype: 'content-Combo',
                style: 'margin-right: 20px',
                listeners: {
                    select: function (combo, record) {
                        var form = me.down('form');

                        if (form) {
                            // 素材やアイテムのストアをロードする
                            form.loadStores(record[0]);
                        }
                    }
                }
            }, {
                xtype: 'button',
                text: 'アイテムの再読み込み',
                handler: function () {
                    var combo = me.down('content-Combo'),
                        form = me.down('form'),
                        record = {
                            data: {
                                id: combo.getValue()
                            }
                        };

                    if (form) {
                        form.loadStores(record);
                    }
                }
            }]
        });
    },


    buildForm: function () {
        var me = this;

        me.items.push({
            xtype: 'content-RelationForm',
            api: {
                submit: Mixin.insert
            }
        });
    }

});
