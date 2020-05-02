/*!
 * header.js v0.0.1
 * https://github.com/GetOlympus/olympus-dionysos-field-header
 *
 * This plugin manage a header block.
 *
 * Copyright 2016 Achraf Chouk
 * Achraf Chouk (https://github.com/crewstyle)
 */

(function ($, wp){
    "use strict";

    /**
     * Constructor
     * @param {nodeElement} $el
     * @param {array}       options
     */
    var Header = function ($el,options){
        // vars
        var _this = this;

        // this plugin works ONLY with WordPress wpTemplate functions
        if (!wp || !wp.template) {
            return;
        }

        _this.$el = $el;
        _this.options = options;

        // update elements list
        _this.$elements = _this.$el.find(_this.options.elements);

        // bind click event
        _this.$elements.find(_this.options.addbutton).on('click', $.proxy(_this.add_block, _this));

        // update buttons
        _this.update_buttons();
    };

    /**
     * @type {nodeElement}
     */
    Header.prototype.$el = null;

    /**
     * @type {array}
     */
    Header.prototype.$elements = null;

    /**
     * @type {array}
     */
    Header.prototype.options = null;

    /**
     * Creates a new block element in the items list, based on source template
     * @param {event} e
     */
    Header.prototype.add_block = function (e){
        e.preventDefault();
        var _this = this;

        // vars
        var $self = $(e.target || e.currentTarget),
            $parent = $self.closest(_this.options.elements),
            _count = $parent.find(_this.options.item).length;

        // count elements (max: 3)
        if (_count >= 3) {
            return;
        }

        var _col = 0 == _count ? 'first' : (1 == _count ? 'second' : 'third');

        // create content from template and append to container
        var _template = wp.template(_this.options.sources.block);
        var $html = $(_template({
            header: $parent.attr('data-h'),
        }));
        $parent.append($html);

        // update buttons
        _this.update_buttons();

        // display edit block
        $html.find(_this.options.editbutton).click();
    };

    /**
     * Edits an item block contents
     * @param {event} e
     */
    Header.prototype.edit_block = function (e){
        e.preventDefault();
        var _this = this;

        // vars
        var $self = $(e.target || e.currentTarget),
            $parent = $self.closest(_this.options.item);

        // deleting animation
        $parent.find(_this.options.modes).addClass(_this.options.opened);
    };

    /**
     * Removes an item block contents
     * @param {event} e
     */
    Header.prototype.remove_block = function (e){
        e.preventDefault();
        var _this = this;

        // vars
        var $self = $(e.target || e.currentTarget),
            $parent = $self.closest(_this.options.item);

        // deleting animation
        $parent.css('background', _this.options.color);
        $parent.animate({
            opacity: '0'
        }, 'slow', function (){
            // remove parent and update buttons
            $parent.remove();
            _this.update_buttons();
        });
    };

    /**
     * Updates an item block contents
     * @param {event} e
     */
    Header.prototype.update_block = function (e){
        e.preventDefault();
        var _this = this;

        // vars
        var $self = $(e.target || e.currentTarget),
            $container = $self.closest(_this.options.elements),
            $parent = $self.closest(_this.options.item),
            $content = $parent.find(_this.options.content),
            $modes = $parent.find(_this.options.modes);

        // texts
        var $add = $parent.find('.add'),
            $edit = $parent.find('.edit');

        // new mode
        var _old_mode = $modes.attr('data-m'),
            _new_mode = $modes.find('select option:selected').val();

        // check values
        if (_old_mode != _new_mode) {
            // empty contents
            $content.empty();

            // create content from template and append to content
            if ('' != _new_mode) {
                var _template = wp.template(_this.options.sources[_new_mode]);
                var $html = $(_template({
                    name: $container.attr('data-n')
                }));

                $content.append($html);
                $add.hide();
                $edit.show();
            } else {
                $add.show();
                $edit.hide();
            }
        }

        // update mode
        $modes.attr('data-m', _new_mode);
        $modes.removeClass(_this.options.opened);
    };

    /**
     * Displays or hides interactive buttons
     */
    Header.prototype.update_buttons = function (){
        var _this = this;

        // bind click event
        _this.$elements.find(_this.options.editbutton).off('click');
        _this.$elements.find(_this.options.removebutton).off('click');
        _this.$elements.find(_this.options.updatebutton).off('click');

        // iterate on elements
        $.each(_this.$elements, function (id,el){
            var $self  = $(el),
                $add   = $self.find(_this.options.addbutton),
                _count = $self.find(_this.options.item).length;

            if (0 <= _count && 3 > _count) {
                $add.show();

                var $check = $self.find(_this.options.enable);

                if (0 == _count && $check.is(':checked')) {
                    $self.find(_this.options.enable).click();
                }
            } else {
                $add.hide();
            }
        });

        // bind click event
        _this.$elements.find(_this.options.editbutton).on('click', $.proxy(_this.edit_block, _this));
        _this.$elements.find(_this.options.removebutton).on('click', $.proxy(_this.remove_block, _this));
        _this.$elements.find(_this.options.updatebutton).on('click', $.proxy(_this.update_block, _this));
    };

    var methods = {
        init: function (options){
            if (!this.length) {
                return false;
            }

            var settings = {
                // configurations
                color: '#ffaaaa',               // background color used when deleting a social network
                elements: '.header',            // node list of headers
                enable: '.enable',              // node element which disable/enable header's elements
                item: 'fieldset',               // node element which contains header's content
                content: '.content',            // node element which contains item's content
                modes: '.modes',                // node element which contains item's available modes
                opened: 'opened',               // class used to display modes elements
                // buttons
                addbutton: '.add-button',       // node element which is used to add a new item
                editbutton: '.edit-button',     // node element which is used to edit item
                removebutton: '.remove-button', // node element which is used to remove item
                updatebutton: '.update-button', // node element which is used to update item
                // source
                sources: {                      // node script elements in DOM containing handlebars JS temlpate
                    block: 'template-id',
                    logo: 'template-logo-id',
                    nav: 'template-nav-id',
                    search: 'template-search-id',
                    text: 'template-text-id',
                }
            };

            return this.each(function (){
                if (options) {
                    $.extend(settings, options);
                }

                new Header($(this), settings);
            });
        }
    };

    $.fn.dionysosHeader = function (method){
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        }
        else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        }
        else {
            $.error('Method '+method+' does not exist on dionysosHeader');
            return false;
        }
    };
})(window.jQuery, window.wp);
