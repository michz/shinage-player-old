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
        } else if (e.which == 27) {
            this.keyEsc();
        }
    }, this));


    this.keyRight = function() {
        if (this.presentation) {
            this.presentation.nextSlide();
        }
    };
    this.keyLeft = function() {
        if (this.presentation) {
            this.presentation.prevSlide();
        }
    };
    this.keyEsc = function() {
        if (this.presentation) {
            this.presentation.pause();
        }
    };
}