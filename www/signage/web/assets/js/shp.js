'use strict';


function ImageSlide() {
    this.type = 'Image';
    this.title = '';
    this.duration = 1000;
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

function PresentationLoader() {
    this.currentUrl = '';
    this.currentLastModified = 0;
    this.recheckTimeout = 60000;

    this.check = function() {
        $.ajax('/current', {
            method: 'get',
            dataType: 'jsonp',
            success: $.proxy(function(data) {
                if (data.lastModified == undefined || data.url == undefined) {
                    return;
                }

                if (this.currentUrl == data.url && this.currentLastModified == data.lastModified) {
                    return;
                }

                this.currentUrl = data.url;
                this.currentLastModified = data.lastModified;
                this.load(this.currentUrl);
            }, this)
        });
        setTimeout($.proxy(this.check, this), this.recheckTimeout);
    };

    this.load = function(url) {
        $.ajax(url, {
            method: 'get',
            dataType: 'jsonp',
            success: $.proxy(function(data) {
                this.clear();

                var pres = new Presentation();
                keyboardHandler.presentation = pres;
                pres.container = $('#canvas');
                pres.load(data);
                //TODO: Warten bis Bilder geladen sind?
                // http://stackoverflow.com/a/5623965
            }, this)
        });
    };

    this.clear = function () {
        $('#canvas').empty();
    }
}
'use strict';

function SlideFactory() {

    this.createSlide = function(slideData) {
        var className = slideData.type + 'Slide';
        var obj = new window[className];

        obj.duration = slideData.duration;
        obj.title = slideData.title;
        obj.transition = slideData.transition;

        obj.configure(slideData);

        return obj;
    };
}

'use strict';


function VideoSlide() {
    this.type = 'Video';
    this.title = '';
    this.duration = 1000;
    this.transition = '';
    this.src = '';
    this.mime = '';

    this.markup = null;
    this.videoElement = null;

    this.onComplete = null;

    this.configure = function(data) {
        this.src = data.src;
    };

    this.init = function () {
        this.markup = $(this.getMarkup());
        this.videoElement = this.markup.find('video').get(0);
        this.videoElement.addEventListener('ended', $.proxy(this.onCompleteHandler, this), false);
        this.videoElement.width = $(window).width();
        this.videoElement.height = $(window).height();
        return this.markup;
    };

    this.getMarkup = function() {
        return  '<div class="slide video">'+
                '   <video>'+
                '       <source src="' + this.src + '" type="' + this.mime + '">'+
                '   </video>'+
                '</div>';
    };

    this.show = function() {
        this.markup.css('opacity', 1);
        this.videoElement.currentTime = 0;
        this.videoElement.play();
        //this.markup.parent().append(this.markup); // bring to front
    };

    this.hide = function() {
        this.videoElement.pause();
        this.markup.css('opacity', 0);
    };

    this.onCompleteHandler = function() {
        if (this.onComplete != null) {
            this.onComplete();
        }
    };
}

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
