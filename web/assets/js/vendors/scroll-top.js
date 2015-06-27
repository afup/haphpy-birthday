/*
 * =============================================================
 * elaostrap
 *
 * (c) 2015 Jeremy FAGIS <jeremy@fagis.fr>
 * =============================================================
 */

(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({"/Volumes/Elao/workspace/JeremyFagis/ElaoStrap/assets/js/vendors/scroll-top.js":[function(require,module,exports){
function scrollTop(options)
{
    this.limit       = options.limit || 150,
    this.btn         = options.btn || '.scroll-to-top',
    this.toggleClass = options.toggleClass || 'visible',
    this.easing      = options.easing || 'easeInOutExpo',
    this.duration    = options.duration || 800

    this.checkScroll($(window).scrollTop());
    this.initEvents();
}

scrollTop.prototype.constructor = scrollTop;

scrollTop.prototype.initEvents = function()
{
    var _this = this;
    $(window).scroll(function(){
        _this.checkScroll($(window).scrollTop());
    });

    $(this.settings.btn).on('click', function(){
        $('html, body').animate({scrollTop : 0}, _this.settings.duration, _this.settings.easing);
        return false;
    });
};

scrollTop.prototype.checkScroll = function(scroll)
{
    if(scroll > this.settings.limit) {
        $(this.settings.btn).addClass(this.settings.toggleClass);
    } else {
        $(this.settings.btn).removeClass(this.settings.toggleClass);
    }
};

module.exports = scrollTop;

},{}]},{},["/Volumes/Elao/workspace/JeremyFagis/ElaoStrap/assets/js/vendors/scroll-top.js"])