/**
 * Created by michaelzapf on 07.06.17.
 */

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
