/**
 * Created by michaelzapf on 27.06.17.
 */

'use strict';


function WebSlide() {
    this.type = 'Web';
    this.title = '';
    this.duration = 0;
    this.transition = '';
    this.src = '';

    this.markup = null;

    this.onComplete = null;

    this.configure = function(data) {
        this.src = data.src;
    };

    this.init = function () {
        this.markup = $(this.getMarkup());
        return this.markup;
    };

    this.getMarkup = function() {
        return '<div class="slide web"><iframe src="' + this.src + '"></iframe></div>';
    };

    this.show = function() {
        this.markup.css('opacity', 1);
        //this.markup.parent().append(this.markup); // bring to front
    };
    this.hide = function() {
        this.markup.css('opacity', 0);
    };
}
