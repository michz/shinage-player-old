/**
 * Created by michaelzapf on 06.06.17.
 */

'use strict';


function ImageSlide() {
    this.type = 'Image';
    this.title = '';
    this.duration = 1000;
    this.transition = '';
    this.src = '';

    this.markup = null;

    this.init = function (container) {
        this.markup = $(this.getMarkup());
        $(container).append(this.markup);
    };

    this.getMarkup = function() {
        return '<div class="slide image"><img src="' + this.src + '"></div>';
    };

    this.show = function() {
        this.markup.css('opacity', 1);
        //this.markup.parent().append(this.markup); // bring to front
    };
    this.hide = function() {
        this.markup.css('opacity', 0);
    };
}
