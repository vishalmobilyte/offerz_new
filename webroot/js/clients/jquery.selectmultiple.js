/*!
 * jQuery UI Sortable 1.8.20
 *
 * Copyright (c) 2011-2014, 2degrees Limited <egoddard@tech.2degreesnetwork.com>.
 * All Rights Reserved.
 *
 * This file is part of jquery.selectmultiple
 * <https://github.com/2degrees/jquery.selectmultiple>, which is subject to
 * the provisions of the BSD at
 * <http://dev.2degreesnetwork.com/p/2degrees-license.html>. A copy of the
 * license should accompany this distribution. THIS SOFTWARE IS PROVIDED "AS IS"
 * AND ANY AND ALL EXPRESS OR IMPLIED WARRANTIES ARE DISCLAIMED, INCLUDING, BUT
 * NOT LIMITED TO, THE IMPLIED WARRANTIES OF TITLE, MERCHANTABILITY, AGAINST
 * INFRINGEMENT, AND FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Depends:
 *  jquery 1.7.2+
 *  jquery.ui 1.8.20+
 * 
 *  jquery.ui.core.js
 *  jquery.ui.mouse.js
 *  jquery.ui.widget.js
 *  jquery.ui.sortable.js
 */

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD
        define(['jquery', 'jquery.ui'], factory);
    } else {
        // Browser globals
        factory(jQuery);
    }
}(function ($) {
    'use strict';

    var CSS_CLASSES = {
        HIGHLIGHT: 'ui-state-highlight',
        DEFAULT: 'ui-state-default'
    };
    
    var CONNECTED_LISTS_CLASS = 'connected-lists';
    
    var ORIGINAL_ITEM_DATA_KEY = 'original-item';
    
    $.widget('ui.selectmultiple', $.ui.sortable, {
        widgetEventPrefix: 'selectmultiple',
        options: {
            placeholder: CSS_CLASSES.HIGHLIGHT,
            cursor: 'move'
        },
        _create: function () {
            if (!this.element.is('select[multiple]')) {
                $.error('selectmultiple can only be able applied to <select> ' +
                    'elements with the "multiple" attribute set'
                );
            }
            
            var options = this.options;
            var widget = this;
            this.element.hide();
            
            // Add additional UI-components
            this.unselected_items = $('<ol />');
            this.selected_items = $('<ol />');
            
            this.list_wrapper = $('<div />');
            this.list_wrapper.addClass(this.widgetBaseClass);
            this.list_wrapper.append(this.unselected_items, this.selected_items);

            // Populate the new UI components
            this.element.children().each(function () {
                var $option = $(this);
                if ($option.prop('selected')) {
                    var $list = widget.selected_items;
                    var item_class = CSS_CLASSES.HIGHLIGHT;
                } else {
                    var $list = widget.unselected_items;
                    var item_class = CSS_CLASSES.DEFAULT;
                }
                
                var $item = $('<li />', {text: $option.text()});
                $item.data(ORIGINAL_ITEM_DATA_KEY, $option);
                $item.addClass(item_class);
                
                $list.append($item);
            });

            this.element.after(this.list_wrapper);
            
            // Setup the sortable interactions
            var lists = this.list_wrapper.children();
            lists.addClass(CONNECTED_LISTS_CLASS);
            
            lists.sortable($.extend({}, this.options, {
                connectWith: '.' + CONNECTED_LISTS_CLASS
            })).disableSelection();
            
            // Listen for the sort receive events to update the underlying
            // multiple select
            this.selected_items.on(
                'sortreceive.' + this.widgetName, function (evt, ui) {
                    ui.item
                        .removeClass(CSS_CLASSES.DEFAULT)
                        .addClass(CSS_CLASSES.HIGHLIGHT)
                        .data(ORIGINAL_ITEM_DATA_KEY).prop('selected', true);
                }
            );
            this.unselected_items.on(
                'sortreceive.' + this.widgetName, function (evt, ui) {
                    ui.item
                        .removeClass(CSS_CLASSES.HIGHLIGHT)
                        .addClass(CSS_CLASSES.DEFAULT)
                        .data(ORIGINAL_ITEM_DATA_KEY).prop('selected', false);
                } 
            );
            return this;
        },
        
        destroy: function () {
            $.Widget.prototype.destroy.call(this);
            this.selected_items.off('.' + this.widgetName);
            this.unselected_items.off('.' + this.widgetName);
            this.list_wrapper.remove();
            this.element.show();
            return this;
        }
    });
}));
