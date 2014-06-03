/*!
 * Masonry PACKAGED v3.1.4
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

/*!
 * eventie v1.0.5
 * event binding helper
 *   eventie.bind( elem, 'click', myFn )
 *   eventie.unbind( elem, 'click', myFn )
 * MIT license
 */

/*!
 * docReady
 * Cross browser DOMContentLoaded event emitter
 */

/*!
 * EventEmitter v4.2.7 - git.io/ee
 * Oliver Caldwell
 * MIT license
 * @preserve
 */

/*!
 * getStyleProperty v1.0.3
 * original by kangax
 * http://perfectionkills.com/feature-testing-css-properties/
 */

/*!
 * Outlayer v1.1.10
 * the brains and guts of a layout library
 * MIT license
 */

/*!
 * Masonry v3.1.4
 * Cascading grid layout library
 * http://masonry.desandro.com
 * MIT License
 * by David DeSandro
 */

/*
	 * debouncedresize: special jQuery event that happens once after a window resize
	 *
	 * latest version and complete README available on Github:
	 * https://github.com/louisremi/jquery-smartresize
	 *
	 * Copyright 2012 @louis_remi
	 * Licensed under the MIT license.
	 *
	 * This saved you an hour of work?
	 * Send me music http://www.amazon.co.uk/wishlist/HNTU0468LQON
	 */

(function(e){function n(){}function r(e){function r(t){if(t.prototype.option)return;t.prototype.option=function(t){if(!e.isPlainObject(t))return;this.options=e.extend(!0,this.options,t)}}function s(n,r){e.fn[n]=function(s){if(typeof s=="string"){var o=t.call(arguments,1);for(var u=0,a=this.length;u<a;u++){var f=this[u],l=e.data(f,n);if(!l){i("cannot call methods on "+n+" prior to initialization; "+"attempted to call '"+s+"'");continue}if(!e.isFunction(l[s])||s.charAt(0)==="_"){i("no such method '"+s+"' for "+n+" instance");continue}var c=l[s].apply(l,o);if(c!==undefined)return c}return this}return this.each(function(){var t=e.data(this,n);t?(t.option(s),t._init()):(t=new r(this,s),e.data(this,n,t))})}}if(!e)return;var i=typeof console=="undefined"?n:function(e){console.error(e)};return e.bridget=function(e,t){r(t),s(e,t)},e.bridget}var t=Array.prototype.slice;typeof timely.define=="function"&&timely.define.amd?timely.define("jquery-bridget/jquery.bridget",["jquery"],r):r(e.jQuery)})(window),function(e){function r(t){var n=e.event;return n.target=n.target||n.srcElement||t,n}var t=document.documentElement,n=function(){};t.addEventListener?n=function(e,t,n){e.addEventListener(t,n,!1)}:t.attachEvent&&(n=function(e,t,n){e[t+n]=n.handleEvent?function(){var t=r(e);n.handleEvent.call(n,t)}:function(){var t=r(e);n.call(e,t)},e.attachEvent("on"+t,e[t+n])});var i=function(){};t.removeEventListener?i=function(e,t,n){e.removeEventListener(t,n,!1)}:t.detachEvent&&(i=function(e,t,n){e.detachEvent("on"+t,e[t+n]);try{delete e[t+n]}catch(r){e[t+n]=undefined}});var s={bind:n,unbind:i};typeof timely.define=="function"&&timely.define.amd?timely.define("eventie/eventie",s):typeof exports=="object"?module.exports=s:e.eventie=s}(this),function(e){function r(e){if(typeof e!="function")return;r.isReady?e():n.push(e)}function i(e){var i=e.type==="readystatechange"&&t.readyState!=="complete";if(r.isReady||i)return;r.isReady=!0;for(var s=0,o=n.length;s<o;s++){var u=n[s];u()}}function s(n){return n.bind(t,"DOMContentLoaded",i),n.bind(t,"readystatechange",i),n.bind(e,"load",i),r}var t=e.document,n=[];r.isReady=!1,typeof timely.define=="function"&&timely.define.amd?(r.isReady=typeof requirejs=="function",timely.define("doc-ready/doc-ready",["eventie/eventie"],s)):e.docReady=s(e.eventie)}(this),function(){function e(){}function i(e,t){var n=e.length;while(n--)if(e[n].listener===t)return n;return-1}function s(e){return function(){return this[e].apply(this,arguments)}}var t=e.prototype,n=this,r=n.EventEmitter;t.getListeners=function(t){var n=this._getEvents(),r,i;if(t instanceof RegExp){r={};for(i in n)n.hasOwnProperty(i)&&t.test(i)&&(r[i]=n[i])}else r=n[t]||(n[t]=[]);return r},t.flattenListeners=function(t){var n=[],r;for(r=0;r<t.length;r+=1)n.push(t[r].listener);return n},t.getListenersAsObject=function(t){var n=this.getListeners(t),r;return n instanceof Array&&(r={},r[t]=n),r||n},t.addListener=function(t,n){var r=this.getListenersAsObject(t),s=typeof n=="object",o;for(o in r)r.hasOwnProperty(o)&&i(r[o],n)===-1&&r[o].push(s?n:{listener:n,once:!1});return this},t.on=s("addListener"),t.addOnceListener=function(t,n){return this.addListener(t,{listener:n,once:!0})},t.once=s("addOnceListener"),t.defineEvent=function(t){return this.getListeners(t),this},t.defineEvents=function(t){for(var n=0;n<t.length;n+=1)this.defineEvent(t[n]);return this},t.removeListener=function(t,n){var r=this.getListenersAsObject(t),s,o;for(o in r)r.hasOwnProperty(o)&&(s=i(r[o],n),s!==-1&&r[o].splice(s,1));return this},t.off=s("removeListener"),t.addListeners=function(t,n){return this.manipulateListeners(!1,t,n)},t.removeListeners=function(t,n){return this.manipulateListeners(!0,t,n)},t.manipulateListeners=function(t,n,r){var i,s,o=t?this.removeListener:this.addListener,u=t?this.removeListeners:this.addListeners;if(typeof n!="object"||n instanceof RegExp){i=r.length;while(i--)o.call(this,n,r[i])}else for(i in n)n.hasOwnProperty(i)&&(s=n[i])&&(typeof s=="function"?o.call(this,i,s):u.call(this,i,s));return this},t.removeEvent=function(t){var n=typeof t,r=this._getEvents(),i;if(n==="string")delete r[t];else if(t instanceof RegExp)for(i in r)r.hasOwnProperty(i)&&t.test(i)&&delete r[i];else delete this._events;return this},t.removeAllListeners=s("removeEvent"),t.emitEvent=function(t,n){var r=this.getListenersAsObject(t),i,s,o,u;for(o in r)if(r.hasOwnProperty(o)){s=r[o].length;while(s--)i=r[o][s],i.once===!0&&this.removeListener(t,i.listener),u=i.listener.apply(this,n||[]),u===this._getOnceReturnValue()&&this.removeListener(t,i.listener)}return this},t.trigger=s("emitEvent"),t.emit=function(t){var n=Array.prototype.slice.call(arguments,1);return this.emitEvent(t,n)},t.setOnceReturnValue=function(t){return this._onceReturnValue=t,this},t._getOnceReturnValue=function(){return this.hasOwnProperty("_onceReturnValue")?this._onceReturnValue:!0},t._getEvents=function(){return this._events||(this._events={})},e.noConflict=function(){return n.EventEmitter=r,e},typeof timely.define=="function"&&timely.define.amd?timely.define("eventEmitter/EventEmitter",[],function(){return e}):typeof module=="object"&&module.exports?module.exports=e:this.EventEmitter=e}.call(this),function(e){function r(e){if(!e)return;if(typeof n[e]=="string")return e;e=e.charAt(0).toUpperCase()+e.slice(1);var r;for(var i=0,s=t.length;i<s;i++){r=t[i]+e;if(typeof n[r]=="string")return r}}var t="Webkit Moz ms Ms O".split(" "),n=document.documentElement.style;typeof timely.define=="function"&&timely.define.amd?timely.define("get-style-property/get-style-property",[],function(){return r}):typeof exports=="object"?module.exports=r:e.getStyleProperty=r}(window),function(e,t){function i(e){var t=parseFloat(e),n=e.indexOf("%")===-1&&!isNaN(t);return n&&t}function o(){var e={width:0,height:0,innerWidth:0,innerHeight:0,outerWidth:0,outerHeight:0};for(var t=0,n=s.length;t<n;t++){var r=s[t];e[r]=0}return e}function u(e){function a(e){typeof e=="string"&&(e=document.querySelector(e));if(!e||typeof e!="object"||!e.nodeType)return;var n=r(e);if(n.display==="none")return o();var a={};a.width=e.offsetWidth,a.height=e.offsetHeight;var l=a.isBorderBox=!!t&&!!n[t]&&n[t]==="border-box";for(var c=0,h=s.length;c<h;c++){var p=s[c],d=n[p];d=f(e,d);var v=parseFloat(d);a[p]=isNaN(v)?0:v}var m=a.paddingLeft+a.paddingRight,g=a.paddingTop+a.paddingBottom,y=a.marginLeft+a.marginRight,b=a.marginTop+a.marginBottom,w=a.borderLeftWidth+a.borderRightWidth,E=a.borderTopWidth+a.borderBottomWidth,S=l&&u,x=i(n.width);x!==!1&&(a.width=x+(S?0:m+w));var T=i(n.height);return T!==!1&&(a.height=T+(S?0:g+E)),a.innerWidth=a.width-(m+w),a.innerHeight=a.height-(g+E),a.outerWidth=a.width+y,a.outerHeight=a.height+b,a}function f(e,t){if(n||t.indexOf("%")===-1)return t;var r=e.style,i=r.left,s=e.runtimeStyle,o=s&&s.left;return o&&(s.left=e.currentStyle.left),r.left=t,t=r.pixelLeft,r.left=i,o&&(s.left=o),t}var t=e("boxSizing"),u;return function(){if(!t)return;var e=document.createElement("div");e.style.width="200px",e.style.padding="1px 2px 3px 4px",e.style.borderStyle="solid",e.style.borderWidth="1px 2px 3px 4px",e.style[t]="border-box";var n=document.body||document.documentElement;n.appendChild(e);var s=r(e);u=i(s.width)===200,n.removeChild(e)}(),a}var n=e.getComputedStyle,r=n?function(e){return n(e,null)}:function(e){return e.currentStyle},s=["paddingLeft","paddingRight","paddingTop","paddingBottom","marginLeft","marginRight","marginTop","marginBottom","borderLeftWidth","borderRightWidth","borderTopWidth","borderBottomWidth"];typeof timely.define=="function"&&timely.define.amd?timely.define("get-size/get-size",["get-style-property/get-style-property"],u):typeof exports=="object"?module.exports=u(require("get-style-property")):e.getSize=u(e.getStyleProperty)}(window),function(e,t){function r(e,t){return e[n](t)}function i(e){if(e.parentNode)return;var t=document.createDocumentFragment();t.appendChild(e)}function s(e,t){i(e);var n=e.parentNode.querySelectorAll(t);for(var r=0,s=n.length;r<s;r++)if(n[r]===e)return!0;return!1}function o(e,t){return i(e),r(e,t)}var n=function(){if(t.matchesSelector)return"matchesSelector";var e=["webkit","moz","ms","o"];for(var n=0,r=e.length;n<r;n++){var i=e[n],s=i+"MatchesSelector";if(t[s])return s}}(),u;if(n){var a=document.createElement("div"),f=r(a,"div");u=f?r:o}else u=s;typeof timely.define=="function"&&timely.define.amd?timely.define("matches-selector/matches-selector",[],function(){return u}):window.matchesSelector=u}(this,Element.prototype),function(e){function r(e,t){for(var n in t)e[n]=t[n];return e}function i(e){for(var t in e)return!1;return t=null,!0}function s(e){return e.replace(/([A-Z])/g,function(e){return"-"+e.toLowerCase()})}function o(e,t,o){function d(e,t){if(!e)return;this.element=e,this.layout=t,this.position={x:0,y:0},this._create()}var u=o("transition"),a=o("transform"),f=u&&a,l=!!o("perspective"),c={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"otransitionend",transition:"transitionend"}[u],h=["transform","transition","transitionDuration","transitionProperty"],p=function(){var e={};for(var t=0,n=h.length;t<n;t++){var r=h[t],i=o(r);i&&i!==r&&(e[r]=i)}return e}();r(d.prototype,e.prototype),d.prototype._create=function(){this._transn={ingProperties:{},clean:{},onEnd:{}},this.css({position:"absolute"})},d.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},d.prototype.getSize=function(){this.size=t(this.element)},d.prototype.css=function(e){var t=this.element.style;for(var n in e){var r=p[n]||n;t[r]=e[n]}},d.prototype.getPosition=function(){var e=n(this.element),t=this.layout.options,r=t.isOriginLeft,i=t.isOriginTop,s=parseInt(e[r?"left":"right"],10),o=parseInt(e[i?"top":"bottom"],10);s=isNaN(s)?0:s,o=isNaN(o)?0:o;var u=this.layout.size;s-=r?u.paddingLeft:u.paddingRight,o-=i?u.paddingTop:u.paddingBottom,this.position.x=s,this.position.y=o},d.prototype.layoutPosition=function(){var e=this.layout.size,t=this.layout.options,n={};t.isOriginLeft?(n.left=this.position.x+e.paddingLeft+"px",n.right=""):(n.right=this.position.x+e.paddingRight+"px",n.left=""),t.isOriginTop?(n.top=this.position.y+e.paddingTop+"px",n.bottom=""):(n.bottom=this.position.y+e.paddingBottom+"px",n.top=""),this.css(n),this.emitEvent("layout",[this])};var v=l?function(e,t){return"translate3d("+e+"px, "+t+"px, 0)"}:function(e,t){return"translate("+e+"px, "+t+"px)"};d.prototype._transitionTo=function(e,t){this.getPosition();var n=this.position.x,r=this.position.y,i=parseInt(e,10),s=parseInt(t,10),o=i===this.position.x&&s===this.position.y;this.setPosition(e,t);if(o&&!this.isTransitioning){this.layoutPosition();return}var u=e-n,a=t-r,f={},l=this.layout.options;u=l.isOriginLeft?u:-u,a=l.isOriginTop?a:-a,f.transform=v(u,a),this.transition({to:f,onTransitionEnd:{transform:this.layoutPosition},isCleaning:!0})},d.prototype.goTo=function(e,t){this.setPosition(e,t),this.layoutPosition()},d.prototype.moveTo=f?d.prototype._transitionTo:d.prototype.goTo,d.prototype.setPosition=function(e,t){this.position.x=parseInt(e,10),this.position.y=parseInt(t,10)},d.prototype._nonTransition=function(e){this.css(e.to),e.isCleaning&&this._removeStyles(e.to);for(var t in e.onTransitionEnd)e.onTransitionEnd[t].call(this)},d.prototype._transition=function(e){if(!parseFloat(this.layout.options.transitionDuration)){this._nonTransition(e);return}var t=this._transn;for(var n in e.onTransitionEnd)t.onEnd[n]=e.onTransitionEnd[n];for(n in e.to)t.ingProperties[n]=!0,e.isCleaning&&(t.clean[n]=!0);if(e.from){this.css(e.from);var r=this.element.offsetHeight;r=null}this.enableTransition(e.to),this.css(e.to),this.isTransitioning=!0};var m=a&&s(a)+",opacity";d.prototype.enableTransition=function(){if(this.isTransitioning)return;this.css({transitionProperty:m,transitionDuration:this.layout.options.transitionDuration}),this.element.addEventListener(c,this,!1)},d.prototype.transition=d.prototype[u?"_transition":"_nonTransition"],d.prototype.onwebkitTransitionEnd=function(e){this.ontransitionend(e)},d.prototype.onotransitionend=function(e){this.ontransitionend(e)};var g={"-webkit-transform":"transform","-moz-transform":"transform","-o-transform":"transform"};d.prototype.ontransitionend=function(e){if(e.target!==this.element)return;var t=this._transn,n=g[e.propertyName]||e.propertyName;delete t.ingProperties[n],i(t.ingProperties)&&this.disableTransition(),n in t.clean&&(this.element.style[e.propertyName]="",delete t.clean[n]);if(n in t.onEnd){var r=t.onEnd[n];r.call(this),delete t.onEnd[n]}this.emitEvent("transitionEnd",[this])},d.prototype.disableTransition=function(){this.removeTransitionStyles(),this.element.removeEventListener(c,this,!1),this.isTransitioning=!1},d.prototype._removeStyles=function(e){var t={};for(var n in e)t[n]="";this.css(t)};var y={transitionProperty:"",transitionDuration:""};return d.prototype.removeTransitionStyles=function(){this.css(y)},d.prototype.removeElem=function(){this.element.parentNode.removeChild(this.element),this.emitEvent("remove",[this])},d.prototype.remove=function(){if(!u||!parseFloat(this.layout.options.transitionDuration)){this.removeElem();return}var e=this;this.on("transitionEnd",function(){return e.removeElem(),!0}),this.hide()},d.prototype.reveal=function(){delete this.isHidden,this.css({display:""});var e=this.layout.options;this.transition({from:e.hiddenStyle,to:e.visibleStyle,isCleaning:!0})},d.prototype.hide=function(){this.isHidden=!0,this.css({display:""});var e=this.layout.options;this.transition({from:e.visibleStyle,to:e.hiddenStyle,isCleaning:!0,onTransitionEnd:{opacity:function(){this.isHidden&&this.css({display:"none"})}}})},d.prototype.destroy=function(){this.css({position:"",left:"",right:"",top:"",bottom:"",transition:"",transform:""})},d}var t=document.defaultView,n=t&&t.getComputedStyle?function(e){return t.getComputedStyle(e,null)}:function(e){return e.currentStyle};typeof timely.define=="function"&&timely.define.amd?timely.define("outlayer/item",["eventEmitter/EventEmitter","get-size/get-size","get-style-property/get-style-property"],o):(e.Outlayer={},e.Outlayer.Item=o(e.EventEmitter,e.getSize,e.getStyleProperty))}(window),function(e){function s(e,t){for(var n in t)e[n]=t[n];return e}function u(e){return o.call(e)==="[object Array]"}function a(e){var t=[];if(u(e))t=e;else if(e&&typeof e.length=="number")for(var n=0,r=e.length;n<r;n++)t.push(e[n]);else t.push(e);return t}function c(e,t){var n=l(t,e);n!==-1&&t.splice(n,1)}function h(e){return e.replace(/(.)([A-Z])/g,function(e,t,n){return t+"-"+n}).toLowerCase()}function p(o,u,l,p,d,v){function y(e,r){typeof e=="string"&&(e=t.querySelector(e));if(!e||!f(e)){n&&n.error("Bad "+this.constructor.namespace+" element: "+e);return}this.element=e,this.options=s({},this.options),this.option(r);var i=++m;this.element.outlayerGUID=i,g[i]=this,this._create(),this.options.isInitLayout&&this.layout()}function b(e,t){e.prototype[t]=s({},y.prototype[t])}var m=0,g={};return y.namespace="outlayer",y.Item=v,y.prototype.options={containerStyle:{position:"relative"},isInitLayout:!0,isOriginLeft:!0,isOriginTop:!0,isResizeBound:!0,transitionDuration:"0.4s",hiddenStyle:{opacity:0,transform:"scale(0.001)"},visibleStyle:{opacity:1,transform:"scale(1)"}},s(y.prototype,l.prototype),y.prototype.option=function(e){s(this.options,e)},y.prototype._create=function(){this.reloadItems(),this.stamps=[],this.stamp(this.options.stamp),s(this.element.style,this.options.containerStyle),this.options.isResizeBound&&this.bindResize()},y.prototype.reloadItems=function(){this.items=this._itemize(this.element.children)},y.prototype._itemize=function(e){var t=this._filterFindItemElements(e),n=this.constructor.Item,r=[];for(var i=0,s=t.length;i<s;i++){var o=t[i],u=new n(o,this);r.push(u)}return r},y.prototype._filterFindItemElements=function(e){e=a(e);var t=this.options.itemSelector,n=[];for(var r=0,i=e.length;r<i;r++){var s=e[r];if(!f(s))continue;if(t){d(s,t)&&n.push(s);var o=s.querySelectorAll(t);for(var u=0,l=o.length;u<l;u++)n.push(o[u])}else n.push(s)}return n},y.prototype.getItemElements=function(){var e=[];for(var t=0,n=this.items.length;t<n;t++)e.push(this.items[t].element);return e},y.prototype.layout=function(){this._resetLayout(),this._manageStamps();var e=this.options.isLayoutInstant!==undefined?this.options.isLayoutInstant:!this._isLayoutInited;this.layoutItems(this.items,e),this._isLayoutInited=!0},y.prototype._init=y.prototype.layout,y.prototype._resetLayout=function(){this.getSize()},y.prototype.getSize=function(){this.size=p(this.element)},y.prototype._getMeasurement=function(e,t){var n=this.options[e],r;n?(typeof n=="string"?r=this.element.querySelector(n):f(n)&&(r=n),this[e]=r?p(r)[t]:n):this[e]=0},y.prototype.layoutItems=function(e,t){e=this._getItemsForLayout(e),this._layoutItems(e,t),this._postLayout()},y.prototype._getItemsForLayout=function(e){var t=[];for(var n=0,r=e.length;n<r;n++){var i=e[n];i.isIgnored||t.push(i)}return t},y.prototype._layoutItems=function(e,t){function r(){n.emitEvent("layoutComplete",[n,e])}var n=this;if(!e||!e.length){r();return}this._itemsOn(e,"layout",r);var i=[];for(var s=0,o=e.length;s<o;s++){var u=e[s],a=this._getItemLayoutPosition(u);a.item=u,a.isInstant=t||u.isLayoutInstant,i.push(a)}this._processLayoutQueue(i)},y.prototype._getItemLayoutPosition=function(){return{x:0,y:0}},y.prototype._processLayoutQueue=function(e){for(var t=0,n=e.length;t<n;t++){var r=e[t];this._positionItem(r.item,r.x,r.y,r.isInstant)}},y.prototype._positionItem=function(e,t,n,r){r?e.goTo(t,n):e.moveTo(t,n)},y.prototype._postLayout=function(){var e=this._getContainerSize();e&&(this._setContainerMeasure(e.width,!0),this._setContainerMeasure(e.height,!1))},y.prototype._getContainerSize=i,y.prototype._setContainerMeasure=function(e,t){if(e===undefined)return;var n=this.size;n.isBorderBox&&(e+=t?n.paddingLeft+n.paddingRight+n.borderLeftWidth+n.borderRightWidth:n.paddingBottom+n.paddingTop+n.borderTopWidth+n.borderBottomWidth),e=Math.max(e,0),this.element.style[t?"width":"height"]=e+"px"},y.prototype._itemsOn=function(e,t,n){function o(){return r++,r===i&&n.call(s),!0}var r=0,i=e.length,s=this;for(var u=0,a=e.length;u<a;u++){var f=e[u];f.on(t,o)}},y.prototype.ignore=function(e){var t=this.getItem(e);t&&(t.isIgnored=!0)},y.prototype.unignore=function(e){var t=this.getItem(e);t&&delete t.isIgnored},y.prototype.stamp=function(e){e=this._find(e);if(!e)return;this.stamps=this.stamps.concat(e);for(var t=0,n=e.length;t<n;t++){var r=e[t];this.ignore(r)}},y.prototype.unstamp=function(e){e=this._find(e);if(!e)return;for(var t=0,n=e.length;t<n;t++){var r=e[t];c(r,this.stamps),this.unignore(r)}},y.prototype._find=function(e){if(!e)return;return typeof e=="string"&&(e=this.element.querySelectorAll(e)),e=a(e),e},y.prototype._manageStamps=function(){if(!this.stamps||!this.stamps.length)return;this._getBoundingRect();for(var e=0,t=this.stamps.length;e<t;e++){var n=this.stamps[e];this._manageStamp(n)}},y.prototype._getBoundingRect=function(){var e=this.element.getBoundingClientRect(),t=this.size;this._boundingRect={left:e.left+t.paddingLeft+t.borderLeftWidth,top:e.top+t.paddingTop+t.borderTopWidth,right:e.right-(t.paddingRight+t.borderRightWidth),bottom:e.bottom-(t.paddingBottom+t.borderBottomWidth)}},y.prototype._manageStamp=i,y.prototype._getElementOffset=function(e){var t=e.getBoundingClientRect(),n=this._boundingRect,r=p(e),i={left:t.left-n.left-r.marginLeft,top:t.top-n.top-r.marginTop,right:n.right-t.right-r.marginRight,bottom:n.bottom-t.bottom-r.marginBottom};return i},y.prototype.handleEvent=function(e){var t="on"+e.type;this[t]&&this[t](e)},y.prototype.bindResize=function(){if(this.isResizeBound)return;o.bind(e,"resize",this),this.isResizeBound=!0},y.prototype.unbindResize=function(){o.unbind(e,"resize",this),this.isResizeBound=!1},y.prototype.onresize=function(){function t(){e.resize(),delete e.resizeTimeout}this.resizeTimeout&&clearTimeout(this.resizeTimeout);var e=this;this.resizeTimeout=setTimeout(t,100)},y.prototype.resize=function(){var e=p(this.element),t=this.size&&e;if(t&&e.innerWidth===this.size.innerWidth)return;this.layout()},y.prototype.addItems=function(e){var t=this._itemize(e);return t.length&&(this.items=this.items.concat(t)),t},y.prototype.appended=function(e){var t=this.addItems(e);if(!t.length)return;this.layoutItems(t,!0),this.reveal(t)},y.prototype.prepended=function(e){var t=this._itemize(e);if(!t.length)return;var n=this.items.slice(0);this.items=t.concat(n),this._resetLayout(),this._manageStamps(),this.layoutItems(t,!0),this.reveal(t),this.layoutItems(n)},y.prototype.reveal=function(e){var t=e&&e.length;if(!t)return;for(var n=0;n<t;n++){var r=e[n];r.reveal()}},y.prototype.hide=function(e){var t=e&&e.length;if(!t)return;for(var n=0;n<t;n++){var r=e[n];r.hide()}},y.prototype.getItem=function(e){for(var t=0,n=this.items.length;t<n;t++){var r=this.items[t];if(r.element===e)return r}},y.prototype.getItems=function(e){if(!e||!e.length)return;var t=[];for(var n=0,r=e.length;n<r;n++){var i=e[n],s=this.getItem(i);s&&t.push(s)}return t},y.prototype.remove=function(e){e=a(e);var t=this.getItems(e);if(!t||!t.length)return;this._itemsOn(t,"remove",function(){this.emitEvent("removeComplete",[this,t])});for(var n=0,r=t.length;n<r;n++){var i=t[n];i.remove(),c(i,this.items)}},y.prototype.destroy=function(){var e=this.element.style;e.height="",e.position="",e.width="";for(var t=0,n=this.items.length;t<n;t++){var i=this.items[t];i.destroy()}this.unbindResize(),delete this.element.outlayerGUID,r&&r.removeData(this.element,this.constructor.namespace)},y.data=function(e){var t=e&&e.outlayerGUID;return t&&g[t]},y.create=function(e,i){function o(){y.apply(this,arguments)}return Object.create?o.prototype=Object.create(y.prototype):s(o.prototype,y.prototype),o.prototype.constructor=o,b(o,"options"),s(o.prototype.options,i),o.namespace=e,o.data=y.data,o.Item=function(){v.apply(this,arguments)},o.Item.prototype=new v,u(function(){var i=h(e),s=t.querySelectorAll(".js-"+i),u="data-"+i+"-options";for(var a=0,f=s.length;a<f;a++){var l=s[a],c=l.getAttribute(u),p;try{p=c&&JSON.parse(c)}catch(d){n&&n.error("Error parsing "+u+" on "+l.nodeName.toLowerCase()+(l.id?"#"+l.id:"")+": "+d);continue}var v=new o(l,p);r&&r.data(l,e,v)}}),r&&r.bridget&&r.bridget(e,o),o},y.Item=v,y}var t=e.document,n=e.console,r=e.jQuery,i=function(){},o=Object.prototype.toString,f=typeof HTMLElement=="object"?function(t){return t instanceof HTMLElement}:function(t){return t&&typeof t=="object"&&t.nodeType===1&&typeof t.nodeName=="string"},l=Array.prototype.indexOf?function(e,t){return e.indexOf(t)}:function(e,t){for(var n=0,r=e.length;n<r;n++)if(e[n]===t)return n;return-1};typeof timely.define=="function"&&timely.define.amd?timely.define("outlayer/outlayer",["eventie/eventie","doc-ready/doc-ready","eventEmitter/EventEmitter","get-size/get-size","matches-selector/matches-selector","./item"],p):e.Outlayer=p(e.eventie,e.docReady,e.EventEmitter,e.getSize,e.matchesSelector,e.Outlayer.Item)}(window),function(e){function n(e,n){var r=e.create("masonry");return r.prototype._resetLayout=function(){this.getSize(),this._getMeasurement("columnWidth","outerWidth"),this._getMeasurement("gutter","outerWidth"),this.measureColumns();var e=this.cols;this.colYs=[];while(e--)this.colYs.push(0);this.maxY=0},r.prototype.measureColumns=function(){this.getContainerWidth();if(!this.columnWidth){var e=this.items[0],t=e&&e.element;this.columnWidth=t&&n(t).outerWidth||this.containerWidth}this.columnWidth+=this.gutter,this.cols=Math.floor((this.containerWidth+this.gutter)/this.columnWidth),this.cols=Math.max(this.cols,1)},r.prototype.getContainerWidth=function(){var e=this.options.isFitWidth?this.element.parentNode:this.element,t=n(e);this.containerWidth=t&&t.innerWidth},r.prototype._getItemLayoutPosition=function(e){e.getSize();var n=e.size.outerWidth%this.columnWidth,r=n&&n<1?"round":"ceil",i=Math[r](e.size.outerWidth/this.columnWidth);i=Math.min(i,this.cols);var s=this._getColGroup(i),o=Math.min.apply(Math,s),u=t(s,o),a={x:this.columnWidth*u,y:o},f=o+e.size.outerHeight,l=this.cols+1-s.length;for(var c=0;c<l;c++)this.colYs[u+c]=f;return a},r.prototype._getColGroup=function(e){if(e<2)return this.colYs;var t=[],n=this.cols+1-e;for(var r=0;r<n;r++){var i=this.colYs.slice(r,r+e);t[r]=Math.max.apply(Math,i)}return t},r.prototype._manageStamp=function(e){var t=n(e),r=this._getElementOffset(e),i=this.options.isOriginLeft?r.left:r.right,s=i+t.outerWidth,o=Math.floor(i/this.columnWidth);o=Math.max(0,o);var u=Math.floor(s/this.columnWidth);u-=s%this.columnWidth?0:1,u=Math.min(this.cols-1,u);var a=(this.options.isOriginTop?r.top:r.bottom)+t.outerHeight;for(var f=o;f<=u;f++)this.colYs[f]=Math.max(a,this.colYs[f])},r.prototype._getContainerSize=function(){this.maxY=Math.max.apply(Math,this.colYs);var e={height:this.maxY};return this.options.isFitWidth&&(e.width=this._getContainerFitWidth()),e},r.prototype._getContainerFitWidth=function(){var e=0,t=this.cols;while(--t){if(this.colYs[t]!==0)break;e++}return(this.cols-e)*this.columnWidth-this.gutter},r.prototype.resize=function(){var e=this.containerWidth;this.getContainerWidth();if(e===this.containerWidth)return;this.layout()},r}var t=Array.prototype.indexOf?function(e,t){return e.indexOf(t)}:function(e,t){for(var n=0,r=e.length;n<r;n++){var i=e[n];if(i===t)return n}return-1};typeof timely.define=="function"&&timely.define.amd?timely.define("external_libs/masonry.pkgd",["outlayer/outlayer","get-size/get-size"],n):e.Masonry=n(e.Outlayer,e.getSize)}(window),timely.define("external_libs/jquery.debouncedresize",["jquery_timely"],function(e){var t=e.event,n,r;n=t.special.debouncedresize={setup:function(){e(this).on("resize",n.handler)},teardown:function(){e(this).off("resize",n.handler)},handler:function(e,i){var s=this,o=arguments,u=function(){e.type="debouncedresize",t.dispatch.apply(s,o)};r&&clearTimeout(r),i?u():r=setTimeout(u,n.threshold)},threshold:150}}),timely.define("scripts/calendar/posterboard_view",["jquery_timely","domReady","external_libs/masonry.pkgd","external_libs/jquery.debouncedresize"],function(e,t,n){var r=function(){var t,r=function(){var r=e(".ai1ec-posterboard-view");if(r.length===0)return;i(),t=new n(r[0],{itemSelector:".ai1ec-event",isFitWidth:!0,isResizeBound:!1,columnWidth:".ai1ec-event"})},i=function(){var t=e(".ai1ec-posterboard-view"),n=e("> .ai1ec-event",t),r,i,s;r=t.parent().width(),i=t.data("ai1ecTileMinWidth"),s=Math.floor(r/i),s=Math.min(s,n.length),i=Math.floor(r/s),t.css("width","auto"),n.width(i),n.each(function(){var t=e(".ai1ec-event-avatar img",this),n=t.width(),r=t.attr("width"),i=t.attr("height"),s=r&&i?r/i:1;t.height(n/s)})},s=function(){e(".ai1ec-posterboard-view").length&&t&&(i(),t.layout())};e(document).on("initialize_view.ai1ec","#ai1ec-calendar-view-container",r),e.event.special.debouncedresize.threshold=100,e(window).on("debouncedresize",s)};return{start:r}}),timely.require(["scripts/calendar/posterboard_view","jquery_timely"],function(e,t){e.start(),!0===t("#ai1ec_extended_views_js").data("added")&&t("#ai1ec-calendar-view-container").trigger("initialize_view.ai1ec")}),timely.define("pages/extended_views",function(){});