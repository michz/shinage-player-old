/**
 * Created by michaelzapf on 06.06.17.
 */

'use strict';


function Presentation() {
    this.container = null;
    this.slides = [];
    this.slideCount = 0;
    this.currentSlideId = -1;
    this.currentNextSlideHandler = null;

    this.load = function (data) {
        if (data.slides != undefined) {
            this.loadSlides(data.slides);
        }
        if (data.settings != undefined) {
            this.loadSettings(data.settings);
        }
    };

    this.loadSlides = function(rawSlides) {
        this.slides = [];
        this.slideCount = 0;
        var factory = new SlideFactory();
        for (var i = 0; i < rawSlides.length; i++) {
            var rawSlide = rawSlides[i];
            var slide = factory.createSlide(rawSlide);

            var markup = slide.init();
            this.container.append(markup);
            this.slides.push(slide);
            this.slideCount += 1;
        }

        this.nextSlide();
    };

    this.loadSettings = function(settings) {
        if (settings.backgroundColor != undefined) {
            $('body').css('background-color', settings.backgroundColor);
        }
    };

    this.showSlide = function(id) {
        var slide = this.getSlide(id);
        this.hideSlide();
        slide.show();
        this.currentSlideId = id;
    };

    this.nextSlide = function() {
        var nextId = this.currentSlideId + 1;
        if (nextId >= this.slideCount) {
            nextId = 0;
        }
        this.gotoSlide(nextId);
    };
    this.prevSlide = function() {
        var nextId = this.currentSlideId - 1;
        if (nextId < 0) {
            nextId = this.slideCount - 1;
        }
        this.gotoSlide(nextId);
    };

    this.gotoSlide = function(id) {
        // clear timeout, if set
        if (this.currentNextSlideHandler != null) {
            clearTimeout(this.currentNextSlideHandler);
        }

        this.showSlide(id);
        var slide = this.getSlide(id);
        slide.onComplete = $.proxy(this.nextSlide, this);
        if (slide.duration > 0) {
            this.currentNextSlideHandler = setTimeout($.proxy(this.nextSlide, this), slide.duration);
        }
    };

    this.hideSlide = function() {
        var currentSlide = this.getCurrentSlide();
        if (currentSlide == null) return;
        currentSlide.hide();
    };

    this.pause = function() {
        if (this.currentNextSlideHandler != null) {
            clearTimeout(this.currentNextSlideHandler);
        }
    };

    this.getSlide = function(id) {
        return this.slides[id];
    };

    this.getCurrentSlide = function() {
        if (this.currentSlideId < 0 || this.currentSlideId >= this.slideCount) {
            return null;
        }
        return this.slides[this.currentSlideId];
    };
}
