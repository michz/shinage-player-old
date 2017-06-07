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

    this.init = function (container) {
        $(container).append(this.getMarkup());
        console.log(this.getMarkup());
    };

    this.getMarkup = function() {
        return '<div class="slide image"><img src="' + this.src + '"></div>';
    };
}
