/**
 * Items.view.data.Description
 * @app2641
 */
Ext.define('Items.view.data.Description', {

    extend: 'Ext.panel.Panel',

    alias: 'widget.data-Description',

    initComponent: function () {
        var me = this;

        Ext.apply(me, {
            title: 'Description',
            layout: 'fit',
            autoScroll: true,
            html: me.buildBody(),
            bodyStyle: 'padding: 20px;'
        });

        me.callParent(arguments);
    },

    buildBody: function () {
        var me = this;

        return '<table class="data-description-table">' +
            '<tr><th>Id</th><td>' + me.data.id + '</td></tr>' +
            '<tr><th>Name</th><td>' + me.data.name + '</td></tr>' +
            '<tr><th>Description</th><td>' + me.data.description + '</td></tr>' +
            '<tr><th>Class</th><td>' + me.data.class + '</td></tr>' +
            '<tr><th>Price</th><td>' + me.data.price + '</td></tr>' +
            '<tr><th>Exp</th><td>' + me.data.exp + '</td></tr>' +
            '<tr><th>Active</th><td>' + me.data.is_active + '</td></tr>' +
        '<table>';
    }

});
