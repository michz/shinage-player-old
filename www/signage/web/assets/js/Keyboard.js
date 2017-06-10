/**
 * Created by michaelzapf on 10.06.17.
 */

function Keyboard(presentation, options) {
    options = options || {};

    // example: how to define default value of option
    //this.testVar = options.testVar || 'leer';

    this.presentation = presentation;

    $(document).keydown($.proxy(function(e) {
        if (e.which == 39) {
            this.keyRight();
        } else if (e.which == 37) {
            this.keyLeft();
        }
    }, this));


    this.keyRight = function() {
        this.presentation.nextSlide();
    };
    this.keyLeft = function() {
        this.presentation.prevSlide();
    };
}