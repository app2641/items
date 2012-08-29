/**
 * Lazuli.History
 * @app2641
 */
Ext.define('Lazuli.History', {

    extend: 'Ext.util.Observable',

    singleton: true,

    flag: false,

    init: function () {
        var me = this;

        // 初回レンダリング時のdirect処理
        me.renderingDirectFunction();

        window.onpopstate = function () {
            // hash移動時のレンダリング処理
            me.renderingDirectFunction();
        }
    },

    // レンダリングダイレクト処理
    renderingDirectFunction: function () {
        var me = this,
            hash = location.hash.replace('#', '');

        if (hash == '') {
            Content.getToppage(function (res) {
                Lazuli.Events.renderingCallback(res);
            });

        } else {
            Content.getEntry({
                url: hash
            }, function (res) {
                Lazuli.Events.renderingCallback(res);
            });
        }
    }

});
