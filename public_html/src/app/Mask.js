/**
 * Lazuli.Mask
 * @app2641
 */
Ext.define('Lazuli.Mask', {

    extend: 'Ext.util.Observable',

    show: function () {
        var el = Ext.get('lazuli-mask');

        if (! el) {
            Ext.getBody().createChild({
                tag: 'div',
                id: 'lazuli-mask'
            });
        }
    },

    hide: function () {
        var el = Ext.get('lazuli-mask');

        if (el) {
            el.remove();
        }
    }

});
