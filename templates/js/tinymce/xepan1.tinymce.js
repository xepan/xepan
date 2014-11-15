$.each({
    xtinymce: function() {
        tinymce.baseURL = "templates/js/tinymce";
        tinymce.init({
            selector: "textarea.tinymce",
            file_browser_callback: function elFinderBrowser(field_name, url, type, win) {
                $('<div/>').dialogelfinder({
                    url: 'elfinder/php/connector.php',
                    lang: 'en',
                    width: 840,
                    destroyOnClose: true,
                    getFileCallback: function(files, fm) {
                        $('#' + field_name).val(files.url);
                    },
                    commandsOptions: {
                        getfile: {
                            oncomplete: 'close',
                            folders: true
                        }
                    }
                }).dialogelfinder('instance');
            },
            plugins: [
                "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "save table contextmenu directionality emoticons template paste textcolor"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
            // toolbar2: "print preview media | forecolor backcolor emoticons",
            image_advtab: true,

            content_css: 'templates/default/css/epan.css',
            setup: function(ed) {
                ed.on("change", function(ed) {
                    tinyMCE.triggerSave();
                });
            }
        });
    }
}, $.univ._import);

$.widget("ui.dialog", $.ui.dialog, {
    _allowInteraction: function(event) {
        return !!$(event.target).closest(".mce-container").length || this._super(event);
    }
});