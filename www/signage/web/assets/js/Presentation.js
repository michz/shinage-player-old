/**
 * Created by michaelzapf on 06.06.17.
 */

'use strict';


function Presentation() {
    this.container = null;
    this.slides = [];

    this.loadSlides = function(rawSlides) {
        this.slides = [];
        for (var i = 0; i < rawSlides.length; i++) {
            var rawSlide = rawSlides[i];
            var slide = {};
            if (rawSlide.type == 'Image') {
                slide = new ImageSlide();
            }
            slide.duration = rawSlide.duration;
            slide.src = rawSlide.src;
            slide.title = rawSlide.title;
            slide.transition = rawSlide.transition;
            slide.init(this.container);
            this.slides.push(slide);
        }

        //this.showSlide();
    };

    this.showSlide = function(slide) {

    }

}
