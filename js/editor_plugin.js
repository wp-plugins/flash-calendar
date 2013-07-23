(function() {
    tinymce.create('tinymce.plugins.SpiderFC_mce', {
 
        init : function(ed, url){
			
			ed.addCommand('mceSpiderFC_mce', function() {
				ed.windowManager.open({
					file : location.origin+ajaxurl+'?action=spiderfcwindow',
					width : 350 + ed.getLang('SpiderFC_mce.delta_width', 0),
					height : 200 + ed.getLang('SpiderFC_mce.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url // Plugin absolute URL
				});
			});
            ed.addButton('SpirderFC_mce', {
            title : 'Insert SpiderFC',
			cmd : 'mceSpiderFC_mce',
            });
        }
    });
 
    tinymce.PluginManager.add('SpiderFC_mce', tinymce.plugins.SpiderFC_mce);
 
})();