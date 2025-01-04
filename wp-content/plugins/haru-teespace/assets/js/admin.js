/**
 * @package    HaruTheme
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

var HARUTEESPACE = HARUTEESPACE || {};

(function ($) {
	// Base functions
    HARUTEESPACE.base = {
    	init: function() {
            HARUTEESPACE.base.widget_select2_process_new();
            HARUTEESPACE.base.elementorAccordion(); // @TODO
        },
        elementorAccordion: function() {
        	var delay = 10; 

        	setTimeout( function() { 
				$('.elementor-tab-title').removeClass( 'elementor-active' );
			 	$('.elementor-tab-content').css( 'display', 'none' ); 
			}, delay );
        },
        widget_select2_new: function(event, widget) {
            var $select = $('.widget-content .widget-select2');

            if ($select.length > 0) {
                var select2Defaults = {
                    width      : '100%',
                    allowClear : true,
                    tags       : true,
                    placeholder: 'Select'
                };

                $select.each(function() {
                    var $select2 = $(this);

                    if ($select2.hasClass('.widget-select2-inited')) {
                        return;
                    }

                    if ($select2.attr('multiple')) {
                        $select2.on('select2:select', function(e) {
                            var $elm = $(e.params.data.element);
                            $select2.append($elm);
                            $select2.trigger('change.select2');
                        });

                        $select2.parent().find('.widget-select2-all').on('click', function(e) {
                            e.preventDefault();

                            $select2.select2('destroy').find('option').prop('selected', 'selected').end().select2(select2Defaults);
                        });

                        $select2.parent().find('.widget-select2-unselect-all').on('click', function(e) {
                            e.preventDefault();

                            $select2.select2('destroy').find('option').prop('selected', false).end().select2(select2Defaults);
                        });
                    }

                    if ($select2.parents('#widget-list').length > 0) {
                        return;
                    }

                    $select2.select2(select2Defaults);

                    $select2.addClass('.widget-select2-inited');
                });
            }
        },
        widget_select2_process_new: function() {
            $(document).on('widget-added', HARUTEESPACE.base.widget_select2_new);
            $(document).on('widget-updated', HARUTEESPACE.base.widget_select2_new);
            HARUTEESPACE.base.widget_select2_new();
        },
    }

    // Document ready
    HARUTEESPACE.onReady = {
        init: function () {
            HARUTEESPACE.base.init();
        }
    };

    $(document).ready( HARUTEESPACE.onReady.init );
})(jQuery);
