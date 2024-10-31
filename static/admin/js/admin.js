(function($) {
    'use sctrict';
    /**
     * Admin-specific JS.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * some backbone code here
     *
     */

    /*window.app = {
        Models: {},
        Collections: {},
        Views: {},
        Router: {}
    };*/



    //
    $('.laqm-create-story').on('click', function(){
        //?page=la_onionbuzz_dashboard&tab=quiz_edit
        $.confirm({
            boxWidth: '555px',
            useBootstrap: false,
            escapeKey: true,
            backgroundDismiss: true,
            animation: 'scale',
            closeAnimation: 'scale',
            title: 'Create story',
            content: '<div class="laqm-create-story-container"><a class="laqm-create-story-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_edit&type=1" data-type="1"><span class="icon-story-trivia"></span><div>Trivia Quiz</div></a><a class="laqm-create-story-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_edit&type=2" data="type=2"><span class="icon-story-personality"></span><div>Personality Quiz</div></a><a class="laqm-create-story-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_edit&type=3" data-type="1"><span class="icon-story-list"></span><div>List/ Ranked List</div></a><a class="laqm-create-story-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_edit&type=4" data-type="4"><span class="icon-story-flip"></span><div>Flip Cards</div></a><a class="laqm-create-story-icon" href="?page=la_onionbuzz_dashboard&tab=quiz_edit&type=5" data-type="5"><span class="icon-story-checklist"></span><div>Checklist</div></a></div>',
            buttons: {

                cancel: function(){
                    //console.log('the user clicked cancel');
                }
            }
        });
    });

    $('.flat-slider').each(function(){
        var el = "div[data-slider-id='"+$(this).data('slider-id')+"']";
        var value = $(this).data('slider-value');
        $(el)
            .slider({
                max: 10,
                min: -10,
                range: "min",
                value: 0,
                orientation: "vertical"
            })
            .slider("pips", {
                first: "pip",
                last: "pip"
            })
            .slider("float");
        $(el).slider("value", value);
    });


    $("#laqm-questions-list").sortable({
        items: ".laqm-item",
        handle: ".laqm-item-drag",
        placeholder: "ui-state-highlight",
        forcePlaceholderSize: true,
        update: function(event, ui) {
            //console.log(ui.item);
            console.log("New position: " + ui.item.index());

            var iii = 0;
            var questions_order = [];
            $('.laqm-item').each(function(i){
                var eltoset = $(this).find('.laqm-item-info').data('id');
                questions_order.push( {'question': eltoset , 'position': iii} );
                iii++;
            });
            console.log(questions_order);

            var data = {
                'action': 'ob_questions_resort',
                'values': questions_order
            };
            $('#onionbuzz_loader').addClass("is-active");
            jQuery.post(ajaxurl, data, function (response) {
                response = jQuery.parseJSON(response);

                $('#onionbuzz_loader').removeClass("is-active");

                if (response.success == 1) {
                }
                else {
                }
            });
        }
    });
    $(".laqm-item-image").disableSelection();

    function UpdateFloatingElements() {
        $(".floating-area").each(function() {

            var el             = $(this),
                offset         = el.offset(),
                scrollTop      = $(window).scrollTop(),
                floatingHeader = $(".floating-element", this)

            if ((scrollTop > offset.top+150) && (scrollTop < offset.top + el.height())) {
                floatingHeader.css({
                    "visibility": "visible"
                });
            } else {
                floatingHeader.css({
                    "visibility": "hidden"
                });
            };
        });
    }

    var clonedFloatingRow;

    $(".floating-area").each(function() {
        clonedFloatingRow = $(".floating-this", this);
        clonedFloatingRow
            .before(clonedFloatingRow.clone())
            .css("width", clonedFloatingRow.width())
            .addClass("floating-element");

    });

    $(window)
        .scroll(UpdateFloatingElements)
        .trigger("scroll");

    function renderMediaUploader(target) {
        'use strict';

        var file_frame, image_data;
        var target = target;

        /**
         * If an instance of file_frame already exists, then we can open it
         * rather than creating a new instance.
         */
        if ( undefined !== file_frame ) {

            file_frame.open();
            return;

        }

        /**
         * If we're this far, then an instance does not exist, so we need to
         * create our own.
         *
         * Here, use the wp.media library to define the settings of the Media
         * Uploader. We're opting to use the 'post' frame which is a template
         * defined in WordPress core and are initializing the file frame
         * with the 'insert' state.
         *
         * We're also not allowing the user to select more than one image.
         */
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: false
        });

        //add items from thickbox to table
        file_frame.on( 'select', function() {
            //var attachment = file_frame.state().get('selection').toJSON();
            var attachment = file_frame.state().get('selection').first().toJSON();

            var imgurl = attachment.url;
            imgurl = imgurl.replace(/^.*\/\/[^\/]+/, '');
            //console.log(imgurl);
            if(target == 'featured-image'){
                $('#image-url').val(attachment.url);
                $("input[name='featured_image']").val(imgurl);
                $("input[name='attachment_id']").val(attachment.id);
                //$('#media_test').html('<img src="'+attachment.url+'">');
                $('#media_test').css("background-image", "url("+attachment.url+")");
                $('.remove-featured-image').show();
            }
            if(target == 'explanation-image'){
                $('#image-url').val(attachment.url);
                $("input[name='explanation_image']").val(imgurl);
                $("input[name='explanation_attachment_id']").val(attachment.id);
                //$('#media_explorer_explanation').html('<img src="'+attachment.url+'">');
                $('#media_explorer_explanation').css("background-image", "url("+attachment.url+")");
                $('.remove-explanation-image').show();
            }
            $('.form-ays').trigger('checkform.areYouSure');
            //console.log(attachment);
            /*jQuery.each(attachment, function(i, val){
             console.log(val.url+'');
             });*/


        });

        // Now display the actual file_frame
        file_frame.open();

    }
    function renderMediaUploader2($media_form, media_url_input, media_attachment_id_input) {

        'use strict';

        var file_frame, image_data;

        var $media_url_input = $media_form.find("input[name='"+media_url_input+"']");
        var $media_attachment_id_input = $media_form.find("input[name='"+media_attachment_id_input+"']");
        /**
         * If an instance of file_frame already exists, then we can open it
         * rather than creating a new instance.
         */
        if ( undefined !== file_frame ) {

            file_frame.open();
            return;

        }

        /**
         * If we're this far, then an instance does not exist, so we need to
         * create our own.
         *
         * Here, use the wp.media library to define the settings of the Media
         * Uploader. We're opting to use the 'post' frame which is a template
         * defined in WordPress core and are initializing the file frame
         * with the 'insert' state.
         *
         * We're also not allowing the user to select more than one image.
         */
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select or Upload Media Of Your Chosen Persuasion',
            button: {
                text: 'Use this media'
            },
            multiple: false
        });

        //add items from thickbox to table
        file_frame.on( 'select', function() {
            //var attachment = file_frame.state().get('selection').toJSON();
            var attachment = file_frame.state().get('selection').first().toJSON();

            var imgurl = attachment.url;
            imgurl = imgurl.replace(/^.*\/\/[^\/]+/, '');
            //console.log(imgurl);

            //$media_form, $media_url_input, $media_attachment_id_input

            $media_form.find('#image-url').val(attachment.url);
            $media_url_input.val(imgurl);
            $media_attachment_id_input.val(attachment.id);

            $media_form.find('.media_selector[data-input-url="'+media_url_input+'"]').css("background-image", "url("+attachment.url+")");
            $media_form.find('.remove-featured-image-ajaxform[data-input-url="'+media_url_input+'"]').show();

            $media_form.find('.form-ays').trigger('checkform.areYouSure');
            //console.log(attachment);
            /*jQuery.each(attachment, function(i, val){
             console.log(val.url+'');
             });*/


        });

        // Now display the actual file_frame
        file_frame.open();

    }

    $( '#media_test' ).on( 'click', function( evt ) {
        // Stop the anchor's default behavior
        evt.preventDefault();
        // Display the media uploader
        renderMediaUploader('featured-image');
    });
    $( '.media_selector' ).on( 'click', function( evt ) {
        // Stop the anchor's default behavior
        evt.preventDefault();
        // Display the media uploader
        var $media_form = $(this).closest('.container-add-form');
        var media_url_input = $(this).data("input-url");
        var media_attachment_id_input = $(this).data("input-attachment");
        renderMediaUploader2($media_form, media_url_input, media_attachment_id_input);
    });
    $( '#media_explorer_explanation' ).on( 'click', function( evt ) {
        // Stop the anchor's default behavior
        evt.preventDefault();
        // Display the media uploader
        renderMediaUploader('explanation-image');
    });
    $('.remove-featured-image-ajaxform').on('click', function(){
        $form_container = $(this).closest('.container-add-form');
        var media_url_input = $(this).data("input-url");
        var media_attachment_id_input = $(this).data("input-attachment");
        $form_container.find('.media_selector[data-input-url="'+media_url_input+'"]').html('');
        $form_container.find('.media_selector[data-input-url="'+media_url_input+'"]').css("background-image", "");
        $form_container.find('input[name="'+media_url_input+'"]').val('');
        $form_container.find('input[name="'+media_attachment_id_input+'"]').val('');
        $form_container.find('.form-ays').trigger('checkform.areYouSure');
        $(this).hide();
    });
    $('.remove-featured-image').on('click', function(){
        $('#media_test').html('');
        $('#media_test').css("background-image", "");
        $('input[name="featured_image"]').val('');
        $('input[name="attachment_id"]').val('');
        $('.form-ays').trigger('checkform.areYouSure');
        $(this).hide();
    });
    $('.remove-explanation-image').on('click', function(){

        $('#media_explorer_explanation').html('');
        $('#media_explorer_explanation').css("background-image", "");
        $('input[name="explanation_image"]').val('');
        $('input[name="explanation_attachment_id"]').val('');
        $('.form-ays').trigger('checkform.areYouSure');
        $(this).hide();
    });
    if($("select[name='answers_type']").length > 0) {
        if ($("select[name='answers_type'] option:selected").val() == 'mediagrid') {
            $('#mediagrid_selector').show();
        }
        else {
            $('#mediagrid_selector').hide();
        }
        if ($("select[name='answers_type'] option:selected").val() == 'match') {
            $('div[data-subtab="quiz_question_answers_match"]').show();
            $('div[data-subtab="quiz_question_answers"]').hide();
        }
        else {
            $('div[data-subtab="quiz_question_answers_match"]').hide();
            $('div[data-subtab="quiz_question_answers"]').show();
        }
    }
    $('.switch-subtab').on('click', function(){
        var group_clicked = $(this).data("tabs-group");
        $('.switch-subtab').removeClass('active');
        $(this).addClass('active');
        $('.laqm-tab-content[data-tabs-group="'+group_clicked+'"]').hide();
        $('div[data-subtab-content="'+$(this).data('subtab')+'"]').show();
    });

    $("select[name='answers_type']").on('change', function(){
        if ($("select[name='answers_type'] option:selected").val() == 'mediagrid') {
            $('#mediagrid_selector').show();
            $('div[data-subtab="quiz_question_answers_match"]').hide();
            $('div[data-subtab="quiz_question_answers"]').show();
        }
        else if ($("select[name='answers_type'] option:selected").val() == 'match') {
            $('div[data-subtab="quiz_question_answers_match"]').show();
            $('div[data-subtab="quiz_question_answers"]').hide();
            $('#mediagrid_selector').hide();
        }
        else{
            $('#mediagrid_selector').hide();
            $('div[data-subtab="quiz_question_answers_match"]').hide();
            $('div[data-subtab="quiz_question_answers"]').show();
        }
    });
    if($("select[id='advertising_type']").length > 0) {
        if ($("select[name='type'] option:selected").val() == 'adsense') {
            $('div[data-type-group="image"]').hide();
            $('div[data-type-group="custom"]').hide();
        }
        if ($("select[name='type'] option:selected").val() == 'image') {
            $('div[data-type-group="adsense"]').hide();
            $('div[data-type-group="custom"]').hide();
        }
        if ($("select[name='type'] option:selected").val() == 'custom') {
            $('div[data-type-group="image"]').hide();
            $('div[data-type-group="adsense"]').hide();
        }

        $("select[name='type']").on('change', function(){
            if ($("select[name='type'] option:selected").val() == 'adsense') {
                $('div[data-type-group="adsense"]').show();
                $('div[data-type-group="image"]').hide();
                $('div[data-type-group="custom"]').hide();
            }
            if ($("select[name='type'] option:selected").val() == 'image') {
                $('div[data-type-group="image"]').show();
                $('div[data-type-group="adsense"]').hide();
                $('div[data-type-group="custom"]').hide();
            }
            if ($("select[name='type'] option:selected").val() == 'custom') {
                $('div[data-type-group="image"]').hide();
                $('div[data-type-group="adsense"]').hide();
                $('div[data-type-group="custom"]').show();
            }

        });
    }

    if($("select[name='settings_resultlock']").length > 0) {
        if ($("select[name='settings_resultlock'] option:selected").val() == 'sharelock') {
            $('#lock_share').show();
            $('#lock_ignore_quizids').show();
        }
        if ($("select[name='settings_resultlock'] option:selected").val() == 'subscribelock') {
            $('#lock_ignore_quizids').show();
        }
    }
    $("select[name='settings_resultlock']").on('change', function(){
        if ($("select[name='settings_resultlock'] option:selected").val() == 'sharelock') {
            $('#lock_share').show();
            $('#lock_ignore_quizids').show();
        }
        else if ($("select[name='settings_resultlock'] option:selected").val() == 'subscribelock') {
            $('#lock_share').hide();
            $('#lock_ignore_quizids').show();
        }
        else{
            $('#lock_share').hide();
            $('#lock_ignore_quizids').hide();
        }
    });



    $('.colorpick').colorpicker({customClass: 'colorpicker-2x',
        sliders: {
            saturation: {
                maxLeft: 200,
                maxTop: 200
            },
            hue: {
                maxTop: 200
            },
            alpha: {
                maxTop: 200
            }
        }
    });
    $('.colorpick').on('changeColor',function(){
        $('.form-ays').trigger('checkform.areYouSure');
    });

    $('.form-ays').areYouSure();

    $('.buy-pro-version').on('click', function () {
        $.alert({
            escapeKey: 'ok',
            backgroundDismiss: 'ok',
            animation: 'right',
            closeAnimation: 'scale',
            title: 'AVAILABLE IN PRO',
            content: 'To get access to this and many other premium features please <a target="_blank" href="https://goo.gl/23mpm6">upgrade to PRO version</a>.',
            type: 'blue',
            buttons: {
                ok: {
                    text: "Ok",
                    btnClass: 'btn-blue',
                    action: function(){

                    }
                }
            }
        });
    });

})(jQuery);
