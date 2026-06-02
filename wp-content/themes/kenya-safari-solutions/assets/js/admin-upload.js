jQuery(document).ready(function($) {
    var mediaUploader;
    
    $('#upload-cta-image').click(function(e) {
        e.preventDefault();
        
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        mediaUploader = wp.media({
            title: 'Select Background Image',
            button: {
                text: 'Use this image'
            },
            multiple: false
        });
        
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#kenya_cta_bg_image').val(attachment.url);
            $('#cta-image-preview').html('<img src="' + attachment.url + '" style="max-width: 300px; height: auto; border: 1px solid #ddd; padding: 5px;" />');
            $('#remove-cta-image').show();
        });
        
        mediaUploader.open();
    });
    
    $('#remove-cta-image').click(function(e) {
        e.preventDefault();
        $('#kenya_cta_bg_image').val('');
        $('#cta-image-preview').html('');
        $(this).hide();
    });
});
