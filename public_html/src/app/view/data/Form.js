/**
 * Items.view.data.Form
 * @app2641
 */
Ext.define('Items.view.data.Form', {

    extend: 'Ext.form.Panel',

    alias: 'widget.data-Form',

    initComponent: function () {
        var me = this;

        me.items = [];
        me.buildId();
        me.buildName();
        me.buildDescription();
        me.buildClass();
        me.buildPrice();
        me.buildExp();
        me.buildActive();

        Ext.apply(me, {
            title: 'Form',
            autoScroll: true,
            buttons: [{
                text: 'submit',
                handler: function () {
                    me.submit();
                }
            }],
            bodyStyle: 'padding: 20px;'
        });

        me.callParent(arguments);

        if (me.dataload) {
            console.log(me.data);
            me.getForm().load({
                params: {
                    id: me.data.id
                },
                success: function (res) {
                    
                }
            });
        }
    },

    buildId: function () {
        this.items.push({
            xtype: 'textfield',
            name: 'id',
            fieldLabel: 'Id',
            readOnly: true
        });
    },

    buildName: function () {
        this.items.push({
            xtype: 'textfield',
            name: 'name',
            fieldLabel: 'Name',
            allowBlank: false,
            width: 500,
            listeners: {
                afterrender: function (field) {
                    field.focus(true, 400);
                }
            }
        });
    },

    buildDescription: function () {
        this.items.push({
            xtype: 'textarea',
            name: 'description',
            fieldLabel: 'Description',
            allowBlank: false,
            rows: 14,
            width: 500
        });
    },

    buildClass: function () {
        this.items.push({
            xtype: 'textfield',
            name: 'class',
            fieldLabel: 'Class',
            allowBlank: false
        });
    },

    buildPrice: function () {
        this.items.push({
            xtype: 'textfield',
            name: 'price',
            fieldLabel: 'Price',
            allowBlank: false,
            width: 500
        });
    },

    buildExp: function () {
        this.items.push({
            xtype: 'textfield',
            name: 'exp',
            fieldLabel: 'Exp',
            allowBlank: false,
            width: 500
        });
    },

    buildActive: function () {
        this.items.push({
            xtype: 'checkbox',
            name: 'is_active',
            fieldLabel: 'is_active'
        });
    }

});
