( function() {
    tinymce.PluginManager.add( 'tinymce_patron_only_button_plugin', function( editor, url ) {

        // Add a button that opens a window
        editor.addButton( 'tinymce_patron_only_button', {

            text: 'Patron Only',
            icon: false,
            onclick: function() {
             
          
			              selected = tinyMCE.activeEditor.selection.getContent();

                    if( selected ){
                        //If text is selected when button is clicked
                        //Wrap shortcode around it.
                        content =  '[ppp_patron_only]'+selected+'[/ppp_patron_only]';
                    }else{
                        content =  '[ppp_patron_only]';
                    }

                    tinymce.execCommand('mceInsertContent', false, content);
            }

        } );

    } );

} )();