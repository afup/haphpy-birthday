/*
 * =============================================================
 * elaostrap
 *
 * (c) 2015 Jeremy FAGIS <jeremy@fagis.fr>
 * =============================================================
 */

!function t(e,n,r){function i(a,o){if(!n[a]){if(!e[a]){var p="function"==typeof require&&require;if(!o&&p)return p(a,!0);if(s)return s(a,!0);throw new Error("Cannot find module '"+a+"'")}var u=n[a]={exports:{}};e[a][0].call(u.exports,function(t){var n=e[a][1][t];return i(n?n:t)},u,u.exports,t,e,n,r)}return n[a].exports}for(var s="function"==typeof require&&require,a=0;a<r.length;a++)i(r[a]);return i}({1:[function(){!function(t){function e(e,i){this.element=e,this.settings=t.extend({},r,i),this._defaults=r,this._name=n,this.init()}var n="simpleSelector",r={wrapperClass:"selector-wrapper",caretClass:"elaostrap-font-arrow"},i=!1;e.prototype={init:function(){if(!i){var e=t(this.element),n=e.data("default-text")||"---",r=e.find("option:selected").text()||n;e.removeClass("selector"),e.wrap('<div class="'+this.settings.wrapperClass+" "+e.attr("class")+'" />'),e.removeAttr("class"),t("<span/>").text(r).prependTo(e.parent()),t('<i class="'+this.settings.caretClass+'"></i>').appendTo(e.parent()),e.on("change",function(){var e=t(this).find("option:selected").text();e=e?e:n,t(this).prev("span").text(e)})}}},t.fn[n]=function(r){return this.each(function(){t.data(this,"plugin_"+n)||t.data(this,"plugin_"+n,new e(this,r))}),this}}(jQuery,window,document)},{}]},{},[1]);