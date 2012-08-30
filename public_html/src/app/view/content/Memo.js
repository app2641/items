/**
 * Items.view.content.Memo
 * @app2641
 */
Ext.define('Items.view.content.Memo', {

    extend: 'Ext.panel.Panel',

    initComponent: function () {
        var me = this;

        me.items = [];
        me.buildForm();

        Ext.apply(me, {
            border: false,
            bodyStyle: 'padding: 20px;'
        });

        me.callParent(arguments);

        me.initListeners();
    },

    initListeners: function () {
        var me = this,
            form = me.down('form');

        me.on({
            afterrender: function () {
                form.getForm().load();
            }
        });
    },

    buildForm: function () {
        var me = this;

        me.items.push({
            xtype: 'form',
            border: false,
            api: {
                load: Memo.loadData,
                submit: Memo.updateData
            },
            items: [{
                xtype: 'textarea',
                name: 'memo',
                hideLabel: true,
                allowBlank: false,
                rows: 40,
                width: 900
            }],
            buttons: [{
                text: 'submit',
                handler: function () {
                    var form = me.down('form'),
                        mask = new Ext.LoadMask(Ext.getBody(), {
                            msg: 'waiting....'
                        });

                    if (form.getForm().isValid) {
                        mask.show();

                        form.getForm().submit({
                            success: function () {
                                mask.hide();

                                Ext.Msg.show({
                                    title: 'Success!',
                                    msg: 'updated!',
                                    icon: Ext.Msg.INFO,
                                    buttons: Ext.Msg.OK
                                });
                            }
                        });
                    }
                }
            }]
        });
    }

});
