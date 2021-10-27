

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(t){if("function"==typeof define&&define.amd&&define("uikit",function(){var n=window.UIkit||t(window,window.jQuery,window.document);return n.load=function(t,e,o,i){var r,s=t.split(","),a=[],u=(i.config&&i.config.uikit&&i.config.uikit.base?i.config.uikit.base:"").replace(/\/+$/g,"");if(!u)throw new Error("Please define base path to UIkit in the requirejs config.");for(r=0;r<s.length;r+=1){var c=s[r].replace(/\./g,"/");a.push(u+"/components/"+c)}e(a,function(){o(n)})},n}),!window.jQuery)throw new Error("UIkit requires jQuery");window&&window.jQuery&&t(window,window.jQuery,window.document)}(function(t,n,e){"use strict";var o={},i=t.UIkit?Object.create(t.UIkit):void 0;if(o.version="2.20.3",o.noConflict=function(){return i&&(t.UIkit=i,n.UIkit=i,n.fn.uk=i.fn),o},o.prefix=function(t){return t},o.$=n,o.$doc=o.$(document),o.$win=o.$(window),o.$html=o.$("html"),o.support={},o.support.transition=function(){var t=function(){var t,n=e.body||e.documentElement,o={WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd otransitionend",transition:"transitionend"};for(t in o)if(void 0!==n.style[t])return o[t]}();return t&&{end:t}}(),o.support.animation=function(){var t=function(){var t,n=e.body||e.documentElement,o={WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd oanimationend",animation:"animationend"};for(t in o)if(void 0!==n.style[t])return o[t]}();return t&&{end:t}}(),function(){var n=0;t.requestAnimationFrame=t.requestAnimationFrame||t.webkitRequestAnimationFrame||function(e){var o=(new Date).getTime(),i=Math.max(0,16-(o-n)),r=t.setTimeout(function(){e(o+i)},i);return n=o+i,r},t.cancelAnimationFrame||(t.cancelAnimationFrame=function(t){clearTimeout(t)})}(),o.support.touch="ontouchstart"in document||t.DocumentTouch&&document instanceof t.DocumentTouch||t.navigator.msPointerEnabled&&t.navigator.msMaxTouchPoints>0||t.navigator.pointerEnabled&&t.navigator.maxTouchPoints>0||!1,o.support.mutationobserver=t.MutationObserver||t.WebKitMutationObserver||null,o.Utils={},o.Utils.str2json=function(t,n){try{return n?JSON.parse(t.replace(/([\$\w]+)\s*:/g,function(t,n){return'"'+n+'":'}).replace(/'([^']+)'/g,function(t,n){return'"'+n+'"'})):new Function("","var json = "+t+"; return JSON.parse(JSON.stringify(json));")()}catch(e){return!1}},o.Utils.debounce=function(t,n,e){var o;return function(){var i=this,r=arguments,s=function(){o=null,e||t.apply(i,r)},a=e&&!o;clearTimeout(o),o=setTimeout(s,n),a&&t.apply(i,r)}},o.Utils.removeCssRules=function(t){var n,e,o,i,r,s,a,u,c,d;t&&setTimeout(function(){try{for(d=document.styleSheets,i=0,a=d.length;a>i;i++){for(o=d[i],e=[],o.cssRules=o.cssRules,n=r=0,u=o.cssRules.length;u>r;n=++r)o.cssRules[n].type===CSSRule.STYLE_RULE&&t.test(o.cssRules[n].selectorText)&&e.unshift(n);for(s=0,c=e.length;c>s;s++)o.deleteRule(e[s])}}catch(f){}},0)},o.Utils.isInView=function(t,e){var i=n(t);if(!i.is(":visible"))return!1;var r=o.$win.scrollLeft(),s=o.$win.scrollTop(),a=i.offset(),u=a.left,c=a.top;return e=n.extend({topoffset:0,leftoffset:0},e),c+i.height()>=s&&c-e.topoffset<=s+o.$win.height()&&u+i.width()>=r&&u-e.leftoffset<=r+o.$win.width()?!0:!1},o.Utils.checkDisplay=function(t,e){var i=o.$("[data-uk-margin], [data-uk-grid-match], [data-uk-grid-margin], [data-uk-check-display]",t||document);return t&&!i.length&&(i=n(t)),i.trigger("display.uk.check"),e&&("string"!=typeof e&&(e='[class*="uk-animation-"]'),i.find(e).each(function(){var t=o.$(this),n=t.attr("class"),e=n.match(/uk\-animation\-(.+)/);t.removeClass(e[0]).width(),t.addClass(e[0])})),i},o.Utils.options=function(t){if(n.isPlainObject(t))return t;var e=t?t.indexOf("{"):-1,i={};if(-1!=e)try{i=o.Utils.str2json(t.substr(e))}catch(r){}return i},o.Utils.animate=function(t,e){var i=n.Deferred();return t=o.$(t),e=e,t.css("display","none").addClass(e).one(o.support.animation.end,function(){t.removeClass(e),i.resolve()}).width(),t.css("display",""),i.promise()},o.Utils.uid=function(t){return(t||"id")+(new Date).getTime()+"RAND"+Math.ceil(1e5*Math.random())},o.Utils.template=function(t,n){for(var e,o,i,r,s=t.replace(/\n/g,"\\n").replace(/\{\{\{\s*(.+?)\s*\}\}\}/g,"{{!$1}}").split(/(\{\{\s*(.+?)\s*\}\})/g),a=0,u=[],c=0;a<s.length;){if(e=s[a],e.match(/\{\{\s*(.+?)\s*\}\}/))switch(a+=1,e=s[a],o=e[0],i=e.substring(e.match(/^(\^|\#|\!|\~|\:)/)?1:0),o){case"~":u.push("for(var $i=0;$i<"+i+".length;$i++) { var $item = "+i+"[$i];"),c++;break;case":":u.push("for(var $key in "+i+") { var $val = "+i+"[$key];"),c++;break;case"#":u.push("if("+i+") {"),c++;break;case"^":u.push("if(!"+i+") {"),c++;break;case"/":u.push("}"),c--;break;case"!":u.push("__ret.push("+i+");");break;default:u.push("__ret.push(escape("+i+"));")}else u.push("__ret.push('"+e.replace(/\'/g,"\\'")+"');");a+=1}return r=new Function("$data",["var __ret = [];","try {","with($data){",c?'__ret = ["Not all blocks are closed correctly."]':u.join(""),"};","}catch(e){__ret = [e.message];}",'return __ret.join("").replace(/\\n\\n/g, "\\n");',"function escape(html) { return String(html).replace(/&/g, '&amp;').replace(/\"/g, '&quot;').replace(/</g, '&lt;').replace(/>/g, '&gt;');}"].join("\n")),n?r(n):r},o.Utils.events={},o.Utils.events.click=o.support.touch?"tap":"click",t.UIkit=o,o.fn=function(t,e){var i=arguments,r=t.match(/^([a-z\-]+)(?:\.([a-z]+))?/i),s=r[1],a=r[2];return o[s]?this.each(function(){var t=n(this),r=t.data(s);r||t.data(s,r=o[s](this,a?void 0:e)),a&&r[a].apply(r,Array.prototype.slice.call(i,1))}):(n.error("UIkit component ["+s+"] does not exist."),this)},n.UIkit=o,n.fn.uk=o.fn,o.langdirection="rtl"==o.$html.attr("dir")?"right":"left",o.components={},o.component=function(t,e){var i=function(e,r){var s=this;return this.UIkit=o,this.element=e?o.$(e):null,this.options=n.extend(!0,{},this.defaults,r),this.plugins={},this.element&&this.element.data(t,this),this.init(),(this.options.plugins.length?this.options.plugins:Object.keys(i.plugins)).forEach(function(t){i.plugins[t].init&&(i.plugins[t].init(s),s.plugins[t]=!0)}),this.trigger("init.uk.component",[t,this]),this};return i.plugins={},n.extend(!0,i.prototype,{defaults:{plugins:[]},boot:function(){},init:function(){},on:function(t,n,e){return o.$(this.element||this).on(t,n,e)},one:function(t,n,e){return o.$(this.element||this).one(t,n,e)},off:function(t){return o.$(this.element||this).off(t)},trigger:function(t,n){return o.$(this.element||this).trigger(t,n)},find:function(t){return o.$(this.element?this.element:[]).find(t)},proxy:function(t,n){var e=this;n.split(" ").forEach(function(n){e[n]||(e[n]=function(){return t[n].apply(t,arguments)})})},mixin:function(t,n){var e=this;n.split(" ").forEach(function(n){e[n]||(e[n]=t[n].bind(e))})},option:function(){return 1==arguments.length?this.options[arguments[0]]||void 0:(2==arguments.length&&(this.options[arguments[0]]=arguments[1]),void 0)}},e),this.components[t]=i,this[t]=function(){var e,i;if(arguments.length)switch(arguments.length){case 1:"string"==typeof arguments[0]||arguments[0].nodeType||arguments[0]instanceof jQuery?e=n(arguments[0]):i=arguments[0];break;case 2:e=n(arguments[0]),i=arguments[1]}return e&&e.data(t)?e.data(t):new o.components[t](e,i)},o.domready&&o.component.boot(t),i},o.plugin=function(t,n,e){this.components[t].plugins[n]=e},o.component.boot=function(t){o.components[t].prototype&&o.components[t].prototype.boot&&!o.components[t].booted&&(o.components[t].prototype.boot.apply(o,[]),o.components[t].booted=!0)},o.component.bootComponents=function(){for(var t in o.components)o.component.boot(t)},o.domObservers=[],o.domready=!1,o.ready=function(t){o.domObservers.push(t),o.domready&&t(document)},o.on=function(t,n,e){return t&&t.indexOf("ready.uk.dom")>-1&&o.domready&&n.apply(o.$doc),o.$doc.on(t,n,e)},o.one=function(t,n,e){return t&&t.indexOf("ready.uk.dom")>-1&&o.domready?(n.apply(o.$doc),o.$doc):o.$doc.one(t,n,e)},o.trigger=function(t,n){return o.$doc.trigger(t,n)},o.domObserve=function(t,n){o.support.mutationobserver&&(n=n||function(){},o.$(t).each(function(){var t=this,e=o.$(t);if(!e.data("observer"))try{var i=new o.support.mutationobserver(o.Utils.debounce(function(){n.apply(t,[]),e.trigger("changed.uk.dom")},50));i.observe(t,{childList:!0,subtree:!0}),e.data("observer",i)}catch(r){}}))},o.init=function(t){t=t||document,o.domObservers.forEach(function(n){n(t)})},o.on("domready.uk.dom",function(){o.init(),o.domready&&o.Utils.checkDisplay()}),n(function(){o.$body=o.$("body"),o.ready(function(){o.domObserve("[data-uk-observe]")}),o.on("changed.uk.dom",function(t){o.init(t.target),o.Utils.checkDisplay(t.target)}),o.trigger("beforeready.uk.dom"),o.component.bootComponents(),setInterval(function(){var t,n={x:window.pageXOffset,y:window.pageYOffset},e=function(){(n.x!=window.pageXOffset||n.y!=window.pageYOffset)&&(t={x:0,y:0},window.pageXOffset!=n.x&&(t.x=window.pageXOffset>n.x?1:-1),window.pageYOffset!=n.y&&(t.y=window.pageYOffset>n.y?1:-1),n={dir:t,x:window.pageXOffset,y:window.pageYOffset},o.$doc.trigger("scrolling.uk.document",[n]))};return o.support.touch&&o.$html.on("touchmove touchend MSPointerMove MSPointerUp pointermove pointerup",e),(n.x||n.y)&&e(),e}(),15),o.trigger("domready.uk.dom"),o.support.touch&&navigator.userAgent.match(/(iPad|iPhone|iPod)/g)&&o.$win.on("load orientationchange resize",o.Utils.debounce(function(){var t=function(){return n(".uk-height-viewport").css("height",window.innerHeight),t};return t()}(),100)),o.trigger("afterready.uk.dom"),o.domready=!0}),o.$html.addClass(o.support.touch?"uk-touch":"uk-notouch"),o.support.touch){var r,s=!1,a="uk-hover",u=".uk-overlay, .uk-overlay-hover, .uk-overlay-toggle, .uk-animation-hover, .uk-has-hover";o.$html.on("touchstart MSPointerDown pointerdown",u,function(){s&&n("."+a).removeClass(a),s=n(this).addClass(a)}).on("touchend MSPointerUp pointerup",function(t){r=n(t.target).parents(u),s&&s.not(r).removeClass(a)})}return o});

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(t){"use strict";var i=[];t.component("stackMargin",{defaults:{cls:"uk-margin-small-top"},boot:function(){t.ready(function(i){t.$("[data-uk-margin]",i).each(function(){var i,n=t.$(this);n.data("stackMargin")||(i=t.stackMargin(n,t.Utils.options(n.attr("data-uk-margin"))))})})},init:function(){var n=this;this.columns=this.element.children(),this.columns.length&&(t.$win.on("resize orientationchange",function(){var i=function(){n.process()};return t.$(function(){i(),t.$win.on("load",i)}),t.Utils.debounce(i,20)}()),t.$html.on("changed.uk.dom",function(){n.columns=n.element.children(),n.process()}),this.on("display.uk.check",function(){n.columns=n.element.children(),this.element.is(":visible")&&this.process()}.bind(this)),i.push(this))},process:function(){return t.Utils.stackMargin(this.columns,this.options),this},revert:function(){return this.columns.removeClass(this.options.cls),this}}),t.ready(function(){var i=[],n=function(){i.forEach(function(t){if(t.is(":visible")){var i=t.parent().width(),n=t.data("width"),s=i/n,e=Math.floor(s*t.data("height"));t.css({height:n>i?e:t.data("height")})}})};return t.$win.on("resize",t.Utils.debounce(n,15)),function(s){t.$("iframe.uk-responsive-width",s).each(function(){var n=t.$(this);!n.data("responsive")&&n.attr("width")&&n.attr("height")&&(n.data("width",n.attr("width")),n.data("height",n.attr("height")),n.data("responsive",!0),i.push(n))}),n()}}()),t.Utils.stackMargin=function(i,n){n=t.$.extend({cls:"uk-margin-small-top"},n),n.cls=n.cls,i=t.$(i).removeClass(n.cls);var s=!1,e=i.filter(":visible:first"),a=e.length?e.position().top+e.outerHeight()-1:!1;a!==!1&&i.each(function(){var i=t.$(this);i.is(":visible")&&(s?i.addClass(n.cls):i.position().top>=a&&(s=i.addClass(n.cls)))})}}(UIkit);

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(e){function t(e,t,n,o){return Math.abs(e-t)>=Math.abs(n-o)?e-t>0?"Left":"Right":n-o>0?"Up":"Down"}function n(){p=null,g.last&&(g.el.trigger("longTap"),g={})}function o(){p&&clearTimeout(p),p=null}function i(){a&&clearTimeout(a),l&&clearTimeout(l),u&&clearTimeout(u),p&&clearTimeout(p),a=l=u=p=null,g={}}function r(e){return e.pointerType==e.MSPOINTER_TYPE_TOUCH&&e.isPrimary}if(!e.fn.swipeLeft){var a,l,u,p,c,g={},s=750;e(function(){var y,w,v,f=0,M=0;"MSGesture"in window&&(c=new MSGesture,c.target=document.body),e(document).on("MSGestureEnd gestureend",function(e){var t=e.originalEvent.velocityX>1?"Right":e.originalEvent.velocityX<-1?"Left":e.originalEvent.velocityY>1?"Down":e.originalEvent.velocityY<-1?"Up":null;t&&(g.el.trigger("swipe"),g.el.trigger("swipe"+t))}).on("touchstart MSPointerDown pointerdown",function(t){("MSPointerDown"!=t.type||r(t.originalEvent))&&(v="MSPointerDown"==t.type||"pointerdown"==t.type?t:t.originalEvent.touches[0],y=Date.now(),w=y-(g.last||y),g.el=e("tagName"in v.target?v.target:v.target.parentNode),a&&clearTimeout(a),g.x1=v.pageX,g.y1=v.pageY,w>0&&250>=w&&(g.isDoubleTap=!0),g.last=y,p=setTimeout(n,s),!c||"MSPointerDown"!=t.type&&"pointerdown"!=t.type&&"touchstart"!=t.type||c.addPointer(t.originalEvent.pointerId))}).on("touchmove MSPointerMove pointermove",function(e){("MSPointerMove"!=e.type||r(e.originalEvent))&&(v="MSPointerMove"==e.type||"pointermove"==e.type?e:e.originalEvent.touches[0],o(),g.x2=v.pageX,g.y2=v.pageY,f+=Math.abs(g.x1-g.x2),M+=Math.abs(g.y1-g.y2))}).on("touchend MSPointerUp pointerup",function(n){("MSPointerUp"!=n.type||r(n.originalEvent))&&(o(),g.x2&&Math.abs(g.x1-g.x2)>30||g.y2&&Math.abs(g.y1-g.y2)>30?u=setTimeout(function(){g.el.trigger("swipe"),g.el.trigger("swipe"+t(g.x1,g.x2,g.y1,g.y2)),g={}},0):"last"in g&&(isNaN(f)||30>f&&30>M?l=setTimeout(function(){var t=e.Event("tap");t.cancelTouch=i,g.el.trigger(t),g.isDoubleTap?(g.el.trigger("doubleTap"),g={}):a=setTimeout(function(){a=null,g.el.trigger("singleTap"),g={}},250)},0):g={},f=M=0))}).on("touchcancel MSPointerCancel",i),e(window).on("scroll",i)}),["swipe","swipeLeft","swipeRight","swipeUp","swipeDown","doubleTap","tap","singleTap","longTap"].forEach(function(t){e.fn[t]=function(n){return e(this).on(t,n)}})}}(jQuery);

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(t){"use strict";var i=[];t.component("gridMatchHeight",{defaults:{target:!1,row:!0},boot:function(){t.ready(function(i){t.$("[data-uk-grid-match]",i).each(function(){var i,n=t.$(this);n.data("gridMatchHeight")||(i=t.gridMatchHeight(n,t.Utils.options(n.attr("data-uk-grid-match"))))})})},init:function(){var n=this;this.columns=this.element.children(),this.elements=this.options.target?this.find(this.options.target):this.columns,this.columns.length&&(t.$win.on("load resize orientationchange",function(){var i=function(){n.match()};return t.$(function(){i()}),t.Utils.debounce(i,50)}()),t.$html.on("changed.uk.dom",function(){n.columns=n.element.children(),n.elements=n.options.target?n.find(n.options.target):n.columns,n.match()}),this.on("display.uk.check",function(){this.element.is(":visible")&&this.match()}.bind(this)),i.push(this))},match:function(){var i=this.columns.filter(":visible:first");if(i.length){var n=Math.ceil(100*parseFloat(i.css("width"))/parseFloat(i.parent().css("width")))>=100;return n?this.revert():t.Utils.matchHeights(this.elements,this.options),this}},revert:function(){return this.elements.css("min-height",""),this}}),t.component("gridMargin",{defaults:{cls:"uk-grid-margin"},boot:function(){t.ready(function(i){t.$("[data-uk-grid-margin]",i).each(function(){var i,n=t.$(this);n.data("gridMargin")||(i=t.gridMargin(n,t.Utils.options(n.attr("data-uk-grid-margin"))))})})},init:function(){t.stackMargin(this.element,this.options)}}),t.Utils.matchHeights=function(i,n){i=t.$(i).css("min-height",""),n=t.$.extend({row:!0},n);var e=function(i){if(!(i.length<2)){var n=0;i.each(function(){n=Math.max(n,t.$(this).outerHeight())}).each(function(){var i=t.$(this),e=n-("border-box"==i.css("box-sizing")?0:i.outerHeight()-i.height());i.css("min-height",e+"px")})}};n.row?(i.first().width(),setTimeout(function(){var n=!1,s=[];i.each(function(){var i=t.$(this),h=i.offset().top;h!=n&&s.length&&(e(t.$(s)),s=[],h=i.offset().top),s.push(i),n=h}),s.length&&e(t.$(s))},0)):e(i)}}(UIkit);

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(t){"use strict";function i(i){var a=t.$(i),n="auto";if(a.is(":visible"))n=a.outerHeight();else{var s={position:a.css("position"),visibility:a.css("visibility"),display:a.css("display")};n=a.css({position:"absolute",visibility:"hidden",display:"block"}).outerHeight(),a.css(s)}return n}t.component("nav",{defaults:{toggle:">li.uk-parent > a[href='#']",lists:">li.uk-parent > ul",multiple:!1},boot:function(){t.ready(function(i){t.$("[data-uk-nav]",i).each(function(){var i=t.$(this);if(!i.data("nav")){t.nav(i,t.Utils.options(i.attr("data-uk-nav")))}})})},init:function(){var i=this;this.on("click.uikit.nav",this.options.toggle,function(a){a.preventDefault();var n=t.$(this);i.open(n.parent()[0]==i.element[0]?n:n.parent("li"))}),this.find(this.options.lists).each(function(){var a=t.$(this),n=a.parent(),s=n.hasClass("uk-active");a.wrap('<div style="overflow:hidden;height:0;position:relative;"></div>'),n.data("list-container",a.parent()),n.attr("aria-expanded",n.hasClass("uk-open")),s&&i.open(n,!0)})},open:function(a,n){var s=this,e=this.element,o=t.$(a);this.options.multiple||e.children(".uk-open").not(a).each(function(){var i=t.$(this);i.data("list-container")&&i.data("list-container").stop().animate({height:0},function(){t.$(this).parent().removeClass("uk-open")})}),o.toggleClass("uk-open"),o.attr("aria-expanded",o.hasClass("uk-open")),o.data("list-container")&&(n?(o.data("list-container").stop().height(o.hasClass("uk-open")?"auto":0),this.trigger("display.uk.check")):o.data("list-container").stop().animate({height:o.hasClass("uk-open")?i(o.data("list-container").find("ul:first")):0},function(){s.trigger("display.uk.check")}))}})}(UIkit);

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(t){"use strict";t.component("buttonRadio",{defaults:{target:".uk-button"},boot:function(){t.$html.on("click.buttonradio.uikit","[data-uk-button-radio]",function(i){var e=t.$(this);if(!e.data("buttonRadio")){var a=t.buttonRadio(e,t.Utils.options(e.attr("data-uk-button-radio"))),n=t.$(i.target);n.is(a.options.target)&&n.trigger("click")}})},init:function(){var i=this;this.find(i.options.target).attr("aria-checked","false").filter(".uk-active").attr("aria-checked","true"),this.on("click",this.options.target,function(e){var a=t.$(this);a.is('a[href="#"]')&&e.preventDefault(),i.find(i.options.target).not(a).removeClass("uk-active").blur(),a.addClass("uk-active"),i.find(i.options.target).not(a).attr("aria-checked","false"),a.attr("aria-checked","true"),i.trigger("change.uk.button",[a])})},getSelected:function(){return this.find(".uk-active")}}),t.component("buttonCheckbox",{defaults:{target:".uk-button"},boot:function(){t.$html.on("click.buttoncheckbox.uikit","[data-uk-button-checkbox]",function(i){var e=t.$(this);if(!e.data("buttonCheckbox")){var a=t.buttonCheckbox(e,t.Utils.options(e.attr("data-uk-button-checkbox"))),n=t.$(i.target);n.is(a.options.target)&&n.trigger("click")}})},init:function(){var i=this;this.find(i.options.target).attr("aria-checked","false").filter(".uk-active").attr("aria-checked","true"),this.on("click",this.options.target,function(e){var a=t.$(this);a.is('a[href="#"]')&&e.preventDefault(),a.toggleClass("uk-active").blur(),a.attr("aria-checked",a.hasClass("uk-active")),i.trigger("change.uk.button",[a])})},getSelected:function(){return this.find(".uk-active")}}),t.component("button",{defaults:{},boot:function(){t.$html.on("click.button.uikit","[data-uk-button]",function(){var i=t.$(this);if(!i.data("button")){{t.button(i,t.Utils.options(i.attr("data-uk-button")))}i.trigger("click")}})},init:function(){var t=this;this.element.attr("aria-pressed",this.element.hasClass("uk-active")),this.on("click",function(i){t.element.is('a[href="#"]')&&i.preventDefault(),t.toggle(),t.trigger("change.uk.button",[t.element.blur().hasClass("uk-active")])})},toggle:function(){this.element.toggleClass("uk-active"),this.element.attr("aria-pressed",this.element.hasClass("uk-active"))}})}(UIkit);

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(t){"use strict";t.component("alert",{defaults:{fade:!0,duration:200,trigger:".uk-alert-close"},boot:function(){t.$html.on("click.alert.uikit","[data-uk-alert]",function(i){var o=t.$(this);if(!o.data("alert")){var e=t.alert(o,t.Utils.options(o.attr("data-uk-alert")));t.$(i.target).is(e.options.trigger)&&(i.preventDefault(),e.close())}})},init:function(){var t=this;this.on("click",this.options.trigger,function(i){i.preventDefault(),t.close()})},close:function(){var t=this.trigger("close.uk.alert"),i=function(){this.trigger("closed.uk.alert").remove()}.bind(this);this.options.fade?t.css("overflow","hidden").css("max-height",t.height()).animate({height:0,opacity:0,"padding-top":0,"padding-bottom":0,"margin-top":0,"margin-bottom":0},this.options.duration,i):i()}})}(UIkit);

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(t){"use strict";var e,i=!1;t.component("dropdown",{defaults:{mode:"hover",remaintime:800,justify:!1,boundary:t.$win,delay:0,hoverDelayIdle:250},remainIdle:!1,boot:function(){var e=t.support.touch?"click":"mouseenter";t.$html.on(e+".dropdown.uikit","[data-uk-dropdown]",function(i){var o=t.$(this);if(!o.data("dropdown")){var s=t.dropdown(o,t.Utils.options(o.attr("data-uk-dropdown")));("click"==e||"mouseenter"==e&&"hover"==s.options.mode)&&s.element.trigger(e),s.element.find(".uk-dropdown").length&&i.preventDefault()}})},init:function(){var o=this;this.dropdown=this.find(".uk-dropdown"),this.centered=this.dropdown.hasClass("uk-dropdown-center"),this.justified=this.options.justify?t.$(this.options.justify):!1,this.boundary=t.$(this.options.boundary),this.flipped=this.dropdown.hasClass("uk-dropdown-flip"),this.boundary.length||(this.boundary=t.$win),this.element.attr("aria-haspopup","true"),this.element.attr("aria-expanded",this.element.hasClass("uk-open")),"click"==this.options.mode||t.support.touch?this.on("click.uikit.dropdown",function(e){var i=t.$(e.target);i.parents(".uk-dropdown").length||((i.is("a[href='#']")||i.parent().is("a[href='#']")||o.dropdown.length&&!o.dropdown.is(":visible"))&&e.preventDefault(),i.blur()),o.element.hasClass("uk-open")?(i.is("a:not(.js-uk-prevent)")||i.is(".uk-dropdown-close")||!o.dropdown.find(e.target).length)&&o.hide():o.show()}):this.on("mouseenter",function(){o.remainIdle&&clearTimeout(o.remainIdle),e&&clearTimeout(e),i&&i==o||(e=i&&i!=o?setTimeout(function(){e=setTimeout(o.show.bind(o),o.options.delay)},o.options.hoverDelayIdle):setTimeout(o.show.bind(o),o.options.delay))}).on("mouseleave",function(){e&&clearTimeout(e),o.remainIdle=setTimeout(function(){i&&i==o&&o.hide()},o.options.remaintime)}).on("click",function(e){var i=t.$(e.target);o.remainIdle&&clearTimeout(o.remainIdle),(i.is("a[href='#']")||i.parent().is("a[href='#']"))&&e.preventDefault(),o.show()})},show:function(){t.$html.off("click.outer.dropdown"),i&&i!=this&&i.hide(),e&&clearTimeout(e),this.checkDimensions(),this.element.addClass("uk-open"),this.element.attr("aria-expanded","true"),this.trigger("show.uk.dropdown",[this]),t.Utils.checkDisplay(this.dropdown,!0),i=this,this.registerOuterClick()},hide:function(){this.element.removeClass("uk-open"),this.remainIdle&&clearTimeout(this.remainIdle),this.remainIdle=!1,this.element.attr("aria-expanded","false"),this.trigger("hide.uk.dropdown",[this]),i==this&&(i=!1)},registerOuterClick:function(){var o=this;t.$html.off("click.outer.dropdown"),setTimeout(function(){t.$html.on("click.outer.dropdown",function(s){e&&clearTimeout(e);var n=t.$(s.target);i!=o||!n.is("a:not(.js-uk-prevent)")&&!n.is(".uk-dropdown-close")&&o.dropdown.find(s.target).length||(o.hide(),t.$html.off("click.outer.dropdown"))})},10)},checkDimensions:function(){if(this.dropdown.length){this.justified&&this.justified.length&&this.dropdown.css("min-width","");var e=this,i=this.dropdown.css("margin-"+t.langdirection,""),o=i.show().offset(),s=i.outerWidth(),n=this.boundary.width(),d=this.boundary.offset()?this.boundary.offset().left:0;if(this.centered&&(i.css("margin-"+t.langdirection,-1*(parseFloat(s)/2-i.parent().width()/2)),o=i.offset(),(s+o.left>n||o.left<0)&&(i.css("margin-"+t.langdirection,""),o=i.offset())),this.justified&&this.justified.length){var r=this.justified.outerWidth();if(i.css("min-width",r),"right"==t.langdirection){var a=n-(this.justified.offset().left+r),h=n-(i.offset().left+i.outerWidth());i.css("margin-right",a-h)}else i.css("margin-left",this.justified.offset().left-o.left);o=i.offset()}s+(o.left-d)>n&&(i.addClass("uk-dropdown-flip"),o=i.offset()),o.left-d<0&&(i.addClass("uk-dropdown-stack"),i.hasClass("uk-dropdown-flip")&&(this.flipped||(i.removeClass("uk-dropdown-flip"),o=i.offset(),i.addClass("uk-dropdown-flip")),setTimeout(function(){(i.offset().left-d<0||!e.flipped&&i.outerWidth()+(o.left-d)<n)&&i.removeClass("uk-dropdown-flip")},0)),this.trigger("stack.uk.dropdown",[this])),i.css("display","")}}})}(UIkit);

;/*! UIkit 2.20.3 | http://www.getuikit.com | (c) 2014 YOOtheme | MIT License */
!function(a){"use strict";var t={x:window.scrollX,y:window.scrollY},n=(a.$win,a.$doc,a.$html),i={show:function(i){if(i=a.$(i),i.length){var o=a.$("body"),s=i.find(".uk-offcanvas-bar:first"),e="right"==a.langdirection,f=s.hasClass("uk-offcanvas-bar-flip")?-1:1,r=f*(e?-1:1);t={x:window.pageXOffset,y:window.pageYOffset},i.addClass("uk-active"),o.css({width:window.innerWidth,height:window.innerHeight}).addClass("uk-offcanvas-page"),o.css(e?"margin-right":"margin-left",(e?-1:1)*s.outerWidth()*r).width(),n.css("margin-top",-1*t.y),s.addClass("uk-offcanvas-bar-show"),this._initElement(i),s.trigger("show.uk.offcanvas",[i,s]),i.attr("aria-hidden","false")}},hide:function(i){var o=a.$("body"),s=a.$(".uk-offcanvas.uk-active"),e="right"==a.langdirection,f=s.find(".uk-offcanvas-bar:first"),r=function(){o.removeClass("uk-offcanvas-page").css({width:"",height:"","margin-left":"","margin-right":""}),s.removeClass("uk-active"),f.removeClass("uk-offcanvas-bar-show"),n.css("margin-top",""),window.scrollTo(t.x,t.y),f.trigger("hide.uk.offcanvas",[s,f]),s.attr("aria-hidden","true")};s.length&&(a.support.transition&&!i?(o.one(a.support.transition.end,function(){r()}).css(e?"margin-right":"margin-left",""),setTimeout(function(){f.removeClass("uk-offcanvas-bar-show")},0)):r())},_initElement:function(t){t.data("OffcanvasInit")||(t.on("click.uk.offcanvas swipeRight.uk.offcanvas swipeLeft.uk.offcanvas",function(t){var n=a.$(t.target);if(!t.type.match(/swipe/)&&!n.hasClass("uk-offcanvas-close")){if(n.hasClass("uk-offcanvas-bar"))return;if(n.parents(".uk-offcanvas-bar:first").length)return}t.stopImmediatePropagation(),i.hide()}),t.on("click","a[href^='#']",function(){var t=a.$(this),n=t.attr("href");"#"!=n&&(a.$doc.one("hide.uk.offcanvas",function(){var i;try{i=a.$(n)}catch(o){i=""}i.length||(i=a.$('[name="'+n.replace("#","")+'"]')),i.length&&t.attr("data-uk-smooth-scroll")&&a.Utils.scrollToElement?a.Utils.scrollToElement(i,a.Utils.options(t.attr("data-uk-smooth-scroll")||"{}")):window.location.href=n}),i.hide())}),t.data("OffcanvasInit",!0))}};a.component("offcanvasTrigger",{boot:function(){n.on("click.offcanvas.uikit","[data-uk-offcanvas]",function(t){t.preventDefault();var n=a.$(this);if(!n.data("offcanvasTrigger")){{a.offcanvasTrigger(n,a.Utils.options(n.attr("data-uk-offcanvas")))}n.trigger("click")}}),n.on("keydown.uk.offcanvas",function(a){27===a.keyCode&&i.hide()})},init:function(){var t=this;this.options=a.$.extend({target:t.element.is("a")?t.element.attr("href"):!1},this.options),this.on("click",function(a){a.preventDefault(),i.show(t.options.target)})}}),a.offcanvas=i}(UIkit);
