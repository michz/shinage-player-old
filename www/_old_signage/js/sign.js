/*
 * sign.js
 * Copyright (C) 2016 Michael Zapf <michi.zapf@mztx.de>
 */


// start initialization process
$(document).ready(function() {
    var id = 0;
    var lastSlide = null;

    slides.forEach(function(s) {
        //alert(s.file);

        var n = document.createElement("div");
        $(n).addClass('slide-img');
        $(n).addClass('slide-'+id);
        $(n).append("<img src='" + s.file + "'>");
        $("body").append(n);
        s.id = 'slide-'+id;
        s.next_slide = 'slide-' + (id+1);
        lastSlide = s;
        id++;
    });

    lastSlide.next_slide = 'slide-0';
    
    //if (slides != undefined) {
    //}
    //
    //TODO: Warten bis Bilder geladen sind?
    // http://stackoverflow.com/a/5623965


    showSlide(getSlide('slide-0'));
    $("#block-loading").hide();
});

var getSlide = function(id) {
    for (var i = 0; i < slides.length; ++i) {
        if (slides[i].id == id) return slides[i];
    }
};

var showSlide = function(s) {
    var div = $('.' + s.id);
    div.css('z-index', 2);
    $('.slide-active').css('z-index', 1);

    // TODO: FadeOut korrekt machen (exakt gleichzeitig mit FadeIn)

    div.animate({opacity:1}, 300, function() {
        $('.slide-active').css('opacity', 0);
        $('.slide-active').removeClass('slide-active');
        div.addClass('slide-active', 500);
    });

    setTimeout(function() { showSlide(getSlide(s.next_slide)); }, s.duration);
};


var available_types = ['img'];

function Slide(type) {
    this.type = type;
    this.file = "";
    this.duration = 10000;

    this.getDuration = function() {
        return this.duration;
    };
}
