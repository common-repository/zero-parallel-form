(function() {
    tinymce.create("tinymce.plugins.zero_parallel_form_plugin", {

        //url argument holds the absolute url of our plugin directory
        init : function(ed, url) {

            //add new button     
            ed.addButton("zero_parallel_form", {
                title : "Zero Parallel Form",
                cmd : "zero_parallel_form_command",
                image : url + "/zp_favicon.png"
            });

            //button functionality.
            ed.addCommand("zero_parallel_form_command", function() {
                var selected_text = ed.selection.getContent();
                var return_text = "[zp_form extra='on' product='1' mobile='1' user='2' tpl='simple']";
                ed.execCommand("mceInsertContent", 0, return_text);
            });

        },

        createControl : function(n, cm) {
            return null;
        },

        getInfo : function() {
            return {
                longname : "Zero Parallel",
                author : "zp Dev Team",
                version : "1"
            };
        }
    });

    tinymce.PluginManager.add("zero_parallel_form_plugin", tinymce.plugins.zero_parallel_form_plugin);
})();