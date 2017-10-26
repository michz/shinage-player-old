/**
 * Created by michaelzapf on 07.06.17.
 */

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
