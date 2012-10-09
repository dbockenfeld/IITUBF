(function() {
    tinymce.create('tinymce.plugins.youtube', {
        init : function(ed, url) {
            ed.addButton('YouTube', {
                title : 'YouTube Embed',
                onclick : function() {
                    if (ed.selection.getContent()=='') {
                        var yeOut = 'Insert video URL or ID here';
                    } else {
                        var yeOut = ed.selection.getContent();
                    }
                    ed.selection.setContent('[youtube]' + yeOut + '[/youtube]'); 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('YouTube', tinymce.plugins.youtube);
})();