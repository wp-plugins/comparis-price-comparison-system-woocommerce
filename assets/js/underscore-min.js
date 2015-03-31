//     Underscore.js 1.6.0
//     http://underscorejs.org
//     (c) 2009-2014 Jeremy Ashkenas, DocumentCloud and Investigative Reporters & Editors
//     Underscore may be freely distributed under the MIT license.
(function(){var n=this,t=n._,r={},e=Array.prototype,u=Object.prototype,i=Function.prototype,a=e.push,o=e.slice,c=e.concat,l=u.toString,f=u.hasOwnProperty,s=e.forEach,p=e.map,h=e.reduce,v=e.reduceRight,g=e.filter,d=e.every,m=e.some,y=e.indexOf,b=e.lastIndexOf,x=Array.isArray,w=Object.keys,_=i.bind,j=function(n){return n instanceof j?n:this instanceof j?void(this._wrapped=n):new j(n)};"undefined"!=typeof exports?("undefined"!=typeof module&&module.exports&&(exports=module.exports=j),exports._=j):n._=j,j.VERSION="1.6.0";var A=j.each=j.forEach=function(n,t,e){if(null==n)return n;if(s&&n.forEach===s)n.forEach(t,e);else if(n.length===+n.length){for(var u=0,i=n.length;i>u;u++)if(t.call(e,n[u],u,n)===r)return}else for(var a=j.keys(n),u=0,i=a.length;i>u;u++)if(t.call(e,n[a[u]],a[u],n)===r)return;return n};j.map=j.collect=function(n,t,r){var e=[];return null==n?e:p&&n.map===p?n.map(t,r):(A(n,function(n,u,i){e.push(t.call(r,n,u,i))}),e)};var O="Reduce of empty array with no initial value";j.reduce=j.foldl=j.inject=function(n,t,r,e){var u=arguments.length>2;if(null==n&&(n=[]),h&&n.reduce===h)return e&&(t=j.bind(t,e)),u?n.reduce(t,r):n.reduce(t);if(A(n,function(n,i,a){u?r=t.call(e,r,n,i,a):(r=n,u=!0)}),!u)throw new TypeError(O);return r},j.reduceRight=j.foldr=function(n,t,r,e){var u=arguments.length>2;if(null==n&&(n=[]),v&&n.reduceRight===v)return e&&(t=j.bind(t,e)),u?n.reduceRight(t,r):n.reduceRight(t);var i=n.length;if(i!==+i){var a=j.keys(n);i=a.length}if(A(n,function(o,c,l){c=a?a[--i]:--i,u?r=t.call(e,r,n[c],c,l):(r=n[c],u=!0)}),!u)throw new TypeError(O);return r},j.find=j.detect=function(n,t,r){var e;return k(n,function(n,u,i){return t.call(r,n,u,i)?(e=n,!0):void 0}),e},j.filter=j.select=function(n,t,r){var e=[];return null==n?e:g&&n.filter===g?n.filter(t,r):(A(n,function(n,u,i){t.call(r,n,u,i)&&e.push(n)}),e)},j.reject=function(n,t,r){return j.filter(n,function(n,e,u){return!t.call(r,n,e,u)},r)},j.every=j.all=function(n,t,e){t||(t=j.identity);var u=!0;return null==n?u:d&&n.every===d?n.every(t,e):(A(n,function(n,i,a){return(u=u&&t.call(e,n,i,a))?void 0:r}),!!u)};var k=j.some=j.any=function(n,t,e){t||(t=j.identity);var u=!1;return null==n?u:m&&n.some===m?n.some(t,e):(A(n,function(n,i,a){return u||(u=t.call(e,n,i,a))?r:void 0}),!!u)};j.contains=j.include=function(n,t){return null==n?!1:y&&n.indexOf===y?n.indexOf(t)!=-1:k(n,function(n){return n===t})},j.invoke=function(n,t){var r=o.call(arguments,2),e=j.isFunction(t);return j.map(n,function(n){return(e?t:n[t]).apply(n,r)})},j.pluck=function(n,t){return j.map(n,j.property(t))},j.where=function(n,t){return j.filter(n,j.matches(t))},j.findWhere=function(n,t){return j.find(n,j.matches(t))},j.max=function(n,t,r){if(!t&&j.isArray(n)&&n[0]===+n[0]&&n.length<65535)return Math.max.apply(Math,n);var e=-1/0,u=-1/0;return A(n,function(n,i,a){var o=t?t.call(r,n,i,a):n;o>u&&(e=n,u=o)}),e},j.min=function(n,t,r){if(!t&&j.isArray(n)&&n[0]===+n[0]&&n.length<65535)return Math.min.apply(Math,n);var e=1/0,u=1/0;return A(n,function(n,i,a){var o=t?t.call(r,n,i,a):n;u>o&&(e=n,u=o)}),e},j.shuffle=function(n){var t,r=0,e=[];return A(n,function(n){t=j.random(r++),e[r-1]=e[t],e[t]=n}),e},j.sample=function(n,t,r){return null==t||r?(n.length!==+n.length&&(n=j.values(n)),n[j.random(n.length-1)]):j.shuffle(n).slice(0,Math.max(0,t))};var E=function(n){return null==n?j.identity:j.isFunction(n)?n:j.property(n)};j.sortBy=function(n,t,r){return t=E(t),j.pluck(j.map(n,function(n,e,u){return{value:n,index:e,criteria:t.call(r,n,e,u)}}).sort(function(n,t){var r=n.criteria,e=t.criteria;if(r!==e){if(r>e||r===void 0)return 1;if(e>r||e===void 0)return-1}return n.index-t.index}),"value")};var F=function(n){return function(t,r,e){var u={};return r=E(r),A(t,function(i,a){var o=r.call(e,i,a,t);n(u,o,i)}),u}};j.groupBy=F(function(n,t,r){j.has(n,t)?n[t].push(r):n[t]=[r]}),j.indexBy=F(function(n,t,r){n[t]=r}),j.countBy=F(function(n,t){j.has(n,t)?n[t]++:n[t]=1}),j.sortedIndex=function(n,t,r,e){r=E(r);for(var u=r.call(e,t),i=0,a=n.length;a>i;){var o=i+a>>>1;r.call(e,n[o])<u?i=o+1:a=o}return i},j.toArray=function(n){return n?j.isArray(n)?o.call(n):n.length===+n.length?j.map(n,j.identity):j.values(n):[]},j.size=function(n){return null==n?0:n.length===+n.length?n.length:j.keys(n).length},j.first=j.head=j.take=function(n,t,r){return null==n?void 0:null==t||r?n[0]:0>t?[]:o.call(n,0,t)},j.initial=function(n,t,r){return o.call(n,0,n.length-(null==t||r?1:t))},j.last=function(n,t,r){return null==n?void 0:null==t||r?n[n.length-1]:o.call(n,Math.max(n.length-t,0))},j.rest=j.tail=j.drop=function(n,t,r){return o.call(n,null==t||r?1:t)},j.compact=function(n){return j.filter(n,j.identity)};var M=function(n,t,r){return t&&j.every(n,j.isArray)?c.apply(r,n):(A(n,function(n){j.isArray(n)||j.isArguments(n)?t?a.apply(r,n):M(n,t,r):r.push(n)}),r)};j.flatten=function(n,t){return M(n,t,[])},j.without=function(n){return j.difference(n,o.call(arguments,1))},j.partition=function(n,t){var r=[],e=[];return A(n,function(n){(t(n)?r:e).push(n)}),[r,e]},j.uniq=j.unique=function(n,t,r,e){j.isFunction(t)&&(e=r,r=t,t=!1);var u=r?j.map(n,r,e):n,i=[],a=[];return A(u,function(r,e){(t?e&&a[a.length-1]===r:j.contains(a,r))||(a.push(r),i.push(n[e]))}),i},j.union=function(){return j.uniq(j.flatten(arguments,!0))},j.intersection=function(n){var t=o.call(arguments,1);return j.filter(j.uniq(n),function(n){return j.every(t,function(t){return j.contains(t,n)})})},j.difference=function(n){var t=c.apply(e,o.call(arguments,1));return j.filter(n,function(n){return!j.contains(t,n)})},j.zip=function(){for(var n=j.max(j.pluck(arguments,"length").concat(0)),t=new Array(n),r=0;n>r;r++)t[r]=j.pluck(arguments,""+r);return t},j.object=function(n,t){if(null==n)return{};for(var r={},e=0,u=n.length;u>e;e++)t?r[n[e]]=t[e]:r[n[e][0]]=n[e][1];return r},j.indexOf=function(n,t,r){if(null==n)return-1;var e=0,u=n.length;if(r){if("number"!=typeof r)return e=j.sortedIndex(n,t),n[e]===t?e:-1;e=0>r?Math.max(0,u+r):r}if(y&&n.indexOf===y)return n.indexOf(t,r);for(;u>e;e++)if(n[e]===t)return e;return-1},j.lastIndexOf=function(n,t,r){if(null==n)return-1;var e=null!=r;if(b&&n.lastIndexOf===b)return e?n.lastIndexOf(t,r):n.lastIndexOf(t);for(var u=e?r:n.length;u--;)if(n[u]===t)return u;return-1},j.range=function(n,t,r){arguments.length<=1&&(t=n||0,n=0),r=arguments[2]||1;for(var e=Math.max(Math.ceil((t-n)/r),0),u=0,i=new Array(e);e>u;)i[u++]=n,n+=r;return i};var R=function(){};j.bind=function(n,t){var r,e;if(_&&n.bind===_)return _.apply(n,o.call(arguments,1));if(!j.isFunction(n))throw new TypeError;return r=o.call(arguments,2),e=function(){if(!(this instanceof e))return n.apply(t,r.concat(o.call(arguments)));R.prototype=n.prototype;var u=new R;R.prototype=null;var i=n.apply(u,r.concat(o.call(arguments)));return Object(i)===i?i:u}},j.partial=function(n){var t=o.call(arguments,1);return function(){for(var r=0,e=t.slice(),u=0,i=e.length;i>u;u++)e[u]===j&&(e[u]=arguments[r++]);for(;r<arguments.length;)e.push(arguments[r++]);return n.apply(this,e)}},j.bindAll=function(n){var t=o.call(arguments,1);if(0===t.length)throw new Error("bindAll must be passed function names");return A(t,function(t){n[t]=j.bind(n[t],n)}),n},j.memoize=function(n,t){var r={};return t||(t=j.identity),function(){var e=t.apply(this,arguments);return j.has(r,e)?r[e]:r[e]=n.apply(this,arguments)}},j.delay=function(n,t){var r=o.call(arguments,2);return setTimeout(function(){return n.apply(null,r)},t)},j.defer=function(n){return j.delay.apply(j,[n,1].concat(o.call(arguments,1)))},j.throttle=function(n,t,r){var e,u,i,a=null,o=0;r||(r={});var c=function(){o=r.leading===!1?0:j.now(),a=null,i=n.apply(e,u),e=u=null};return function(){var l=j.now();o||r.leading!==!1||(o=l);var f=t-(l-o);return e=this,u=arguments,0>=f?(clearTimeout(a),a=null,o=l,i=n.apply(e,u),e=u=null):a||r.trailing===!1||(a=setTimeout(c,f)),i}},j.debounce=function(n,t,r){var e,u,i,a,o,c=function(){var l=j.now()-a;t>l?e=setTimeout(c,t-l):(e=null,r||(o=n.apply(i,u),i=u=null))};return function(){i=this,u=arguments,a=j.now();var l=r&&!e;return e||(e=setTimeout(c,t)),l&&(o=n.apply(i,u),i=u=null),o}},j.once=function(n){var t,r=!1;return function(){return r?t:(r=!0,t=n.apply(this,arguments),n=null,t)}},j.wrap=function(n,t){return j.partial(t,n)},j.compose=function(){var n=arguments;return function(){for(var t=arguments,r=n.length-1;r>=0;r--)t=[n[r].apply(this,t)];return t[0]}},j.after=function(n,t){return function(){return--n<1?t.apply(this,arguments):void 0}},j.keys=function(n){if(!j.isObject(n))return[];if(w)return w(n);var t=[];for(var r in n)j.has(n,r)&&t.push(r);return t},j.values=function(n){for(var t=j.keys(n),r=t.length,e=new Array(r),u=0;r>u;u++)e[u]=n[t[u]];return e},j.pairs=function(n){for(var t=j.keys(n),r=t.length,e=new Array(r),u=0;r>u;u++)e[u]=[t[u],n[t[u]]];return e},j.invert=function(n){for(var t={},r=j.keys(n),e=0,u=r.length;u>e;e++)t[n[r[e]]]=r[e];return t},j.functions=j.methods=function(n){var t=[];for(var r in n)j.isFunction(n[r])&&t.push(r);return t.sort()},j.extend=function(n){return A(o.call(arguments,1),function(t){if(t)for(var r in t)n[r]=t[r]}),n},j.pick=function(n){var t={},r=c.apply(e,o.call(arguments,1));return A(r,function(r){r in n&&(t[r]=n[r])}),t},j.omit=function(n){var t={},r=c.apply(e,o.call(arguments,1));for(var u in n)j.contains(r,u)||(t[u]=n[u]);return t},j.defaults=function(n){return A(o.call(arguments,1),function(t){if(t)for(var r in t)n[r]===void 0&&(n[r]=t[r])}),n},j.clone=function(n){return j.isObject(n)?j.isArray(n)?n.slice():j.extend({},n):n},j.tap=function(n,t){return t(n),n};var S=function(n,t,r,e){if(n===t)return 0!==n||1/n==1/t;if(null==n||null==t)return n===t;n instanceof j&&(n=n._wrapped),t instanceof j&&(t=t._wrapped);var u=l.call(n);if(u!=l.call(t))return!1;switch(u){case"[object String]":return n==String(t);case"[object Number]":return n!=+n?t!=+t:0==n?1/n==1/t:n==+t;case"[object Date]":case"[object Boolean]":return+n==+t;case"[object RegExp]":return n.source==t.source&&n.global==t.global&&n.multiline==t.multiline&&n.ignoreCase==t.ignoreCase}if("object"!=typeof n||"object"!=typeof t)return!1;for(var i=r.length;i--;)if(r[i]==n)return e[i]==t;var a=n.constructor,o=t.constructor;if(a!==o&&!(j.isFunction(a)&&a instanceof a&&j.isFunction(o)&&o instanceof o)&&"constructor"in n&&"constructor"in t)return!1;r.push(n),e.push(t);var c=0,f=!0;if("[object Array]"==u){if(c=n.length,f=c==t.length)for(;c--&&(f=S(n[c],t[c],r,e)););}else{for(var s in n)if(j.has(n,s)&&(c++,!(f=j.has(t,s)&&S(n[s],t[s],r,e))))break;if(f){for(s in t)if(j.has(t,s)&&!c--)break;f=!c}}return r.pop(),e.pop(),f};j.isEqual=function(n,t){return S(n,t,[],[])},j.isEmpty=function(n){if(null==n)return!0;if(j.isArray(n)||j.isString(n))return 0===n.length;for(var t in n)if(j.has(n,t))return!1;return!0},j.isElement=function(n){return!(!n||1!==n.nodeType)},j.isArray=x||function(n){return"[object Array]"==l.call(n)},j.isObject=function(n){return n===Object(n)},A(["Arguments","Function","String","Number","Date","RegExp"],function(n){j["is"+n]=function(t){return l.call(t)=="[object "+n+"]"}}),j.isArguments(arguments)||(j.isArguments=function(n){return!(!n||!j.has(n,"callee"))}),"function"!=typeof/./&&(j.isFunction=function(n){return"function"==typeof n}),j.isFinite=function(n){return isFinite(n)&&!isNaN(parseFloat(n))},j.isNaN=function(n){return j.isNumber(n)&&n!=+n},j.isBoolean=function(n){return n===!0||n===!1||"[object Boolean]"==l.call(n)},j.isNull=function(n){return null===n},j.isUndefined=function(n){return n===void 0},j.has=function(n,t){return f.call(n,t)},j.noConflict=function(){return n._=t,this},j.identity=function(n){return n},j.constant=function(n){return function(){return n}},j.property=function(n){return function(t){return t[n]}},j.matches=function(n){return function(t){if(t===n)return!0;for(var r in n)if(n[r]!==t[r])return!1;return!0}},j.times=function(n,t,r){for(var e=Array(Math.max(0,n)),u=0;n>u;u++)e[u]=t.call(r,u);return e},j.random=function(n,t){return null==t&&(t=n,n=0),n+Math.floor(Math.random()*(t-n+1))},j.now=Date.now||function(){return(new Date).getTime()};var T={escape:{"&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#x27;"}};T.unescape=j.invert(T.escape);var I={escape:new RegExp("["+j.keys(T.escape).join("")+"]","g"),unescape:new RegExp("("+j.keys(T.unescape).join("|")+")","g")};j.each(["escape","unescape"],function(n){j[n]=function(t){return null==t?"":(""+t).replace(I[n],function(t){return T[n][t]})}}),j.result=function(n,t){if(null==n)return void 0;var r=n[t];return j.isFunction(r)?r.call(n):r},j.mixin=function(n){A(j.functions(n),function(t){var r=j[t]=n[t];j.prototype[t]=function(){var n=[this._wrapped];return a.apply(n,arguments),z.call(this,r.apply(j,n))}})};var N=0;j.uniqueId=function(n){var t=++N+"";return n?n+t:t},j.templateSettings={evaluate:/<%([\s\S]+?)%>/g,interpolate:/<%=([\s\S]+?)%>/g,escape:/<%-([\s\S]+?)%>/g};var q=/(.)^/,B={"'":"'","\\":"\\","\r":"r","\n":"n","	":"t","\u2028":"u2028","\u2029":"u2029"},D=/\\|'|\r|\n|\t|\u2028|\u2029/g;j.template=function(n,t,r){var e;r=j.defaults({},r,j.templateSettings);var u=new RegExp([(r.escape||q).source,(r.interpolate||q).source,(r.evaluate||q).source].join("|")+"|$","g"),i=0,a="__p+='";n.replace(u,function(t,r,e,u,o){return a+=n.slice(i,o).replace(D,function(n){return"\\"+B[n]}),r&&(a+="'+\n((__t=("+r+"))==null?'':_.escape(__t))+\n'"),e&&(a+="'+\n((__t=("+e+"))==null?'':__t)+\n'"),u&&(a+="';\n"+u+"\n__p+='"),i=o+t.length,t}),a+="';\n",r.variable||(a="with(obj||{}){\n"+a+"}\n"),a="var __t,__p='',__j=Array.prototype.join,"+"print=function(){__p+=__j.call(arguments,'');};\n"+a+"return __p;\n";try{e=new Function(r.variable||"obj","_",a)}catch(o){throw o.source=a,o}if(t)return e(t,j);var c=function(n){return e.call(this,n,j)};return c.source="function("+(r.variable||"obj")+"){\n"+a+"}",c},j.chain=function(n){return j(n).chain()};var z=function(n){return this._chain?j(n).chain():n};j.mixin(j),A(["pop","push","reverse","shift","sort","splice","unshift"],function(n){var t=e[n];j.prototype[n]=function(){var r=this._wrapped;return t.apply(r,arguments),"shift"!=n&&"splice"!=n||0!==r.length||delete r[0],z.call(this,r)}}),A(["concat","join","slice"],function(n){var t=e[n];j.prototype[n]=function(){return z.call(this,t.apply(this._wrapped,arguments))}}),j.extend(j.prototype,{chain:function(){return this._chain=!0,this},value:function(){return this._wrapped}}),"function"==typeof define&&define.amd&&define("underscore",[],function(){return j})}).call(this);
//# sourceMappingURL=underscore-min.map





/* ===================================================
 *  jquery-sortable.js v0.9.12
 *  http://johnny.github.com/jquery-sortable/
 * ===================================================
 *  Copyright (c) 2012 Jonas von Andrian
 *  All rights reserved.
 *
 *  Redistribution and use in source and binary forms, with or without
 *  modification, are permitted provided that the following conditions are met:
 *  * Redistributions of source code must retain the above copyright
 *    notice, this list of conditions and the following disclaimer.
 *  * Redistributions in binary form must reproduce the above copyright
 *    notice, this list of conditions and the following disclaimer in the
 *    documentation and/or other materials provided with the distribution.
 *  * The name of the author may not be used to endorse or promote products
 *    derived from this software without specific prior written permission.
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 *  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 *  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 *  DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> BE LIABLE FOR ANY
 *  DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 *  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 *  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
 *  ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 *  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * ========================================================== */


! function($, window, pluginName, undefined) {
    var eventNames,
        containerDefaults = {
            // If true, items can be dragged from this container
            drag: true,
            // If true, items can be droped onto this container
            drop: true,
            // Exclude items from being draggable, if the
            // selector matches the item
            exclude: "",
            // If true, search for nested containers within an item
            nested: true,
            // If true, the items are assumed to be arranged vertically
            vertical: true
        }, // end container defaults
        groupDefaults = {
            // This is executed after the placeholder has been moved.
            // $closestItemOrContainer contains the closest item, the placeholder
            // has been put at or the closest empty Container, the placeholder has
            // been appended to.
            afterMove: function($placeholder, container, $closestItemOrContainer) {},
            // The exact css path between the container and its items, e.g. "> tbody"
            containerPath: "",
            // The css selector of the containers
            containerSelector: "ol, ul",
            // Distance the mouse has to travel to start dragging
            distance: 0,
            // Time in milliseconds after mousedown until dragging should start.
            // This option can be used to prevent unwanted drags when clicking on an element.
            delay: 0,
            // The css selector of the drag handle
            handle: "",
            // The exact css path between the item and its subcontainers
            itemPath: "",
            // The css selector of the items
            itemSelector: "li",
            // Check if the dragged item may be inside the container.
            // Use with care, since the search for a valid container entails a depth first search
            // and may be quite expensive.
            isValidTarget: function($item, container) {
                return true
            },
            // Executed before onDrop if placeholder is detached.
            // This happens if pullPlaceholder is set to false and the drop occurs outside a container.
            onCancel: function($item, container, _super, event) {},
            // Executed at the beginning of a mouse move event.
            // The Placeholder has not been moved yet.
            onDrag: function($item, position, _super, event) {
                $item.css(position)
            },
            // Called after the drag has been started,
            // that is the mouse button is beeing held down and
            // the mouse is moving.
            // The container is the closest initialized container.
            // Therefore it might not be the container, that actually contains the item.
            onDragStart: function($item, container, _super, event) {
                $item.css({
                    height: $item.height(),
                    width: $item.width()
                })
                $item.addClass("dragged")
                $("body").addClass("dragging")
            },
            // Called when the mouse button is beeing released
            onDrop: function($item, container, _super, event) {
                $item.removeClass("dragged").removeAttr("style")
                $("body").removeClass("dragging")
            },
            // Called on mousedown. If falsy value is returned, the dragging will not start.
            // If clicked on input element, ignore
            onMousedown: function($item, _super, event) {
                if (!event.target.nodeName.match(/^(input|select)$/i)) {
                    event.preventDefault()
                    return true
                }
            },
            // Template for the placeholder. Can be any valid jQuery input
            // e.g. a string, a DOM element.
            // The placeholder must have the class "placeholder"
            placeholder: '<li class="placeholder"/>',
            // If true, the position of the placeholder is calculated on every mousemove.
            // If false, it is only calculated when the mouse is above a container.
            pullPlaceholder: true,
            // Specifies serialization of the container group.
            // The pair $parent/$children is either container/items or item/subcontainers.
            serialize: function($parent, $children, parentIsContainer) {
                var result = $.extend({}, $parent.data())

                if (parentIsContainer) return [$children]
                else if ($children[0]) {
                    result.children = $children
                }

                delete result.subContainers
                delete result.sortable

                return result
            },
            // Set tolerance while dragging. Positive values decrease sensitivity,
            // negative values increase it.
            tolerance: 0
        }, // end group defaults
        containerGroups = {},
        groupCounter = 0,
        emptyBox = {
            left: 0,
            top: 0,
            bottom: 0,
            right: 0
        },
        eventNames = {
            start: "touchstart.sortable mousedown.sortable",
            drop: "touchend.sortable touchcancel.sortable mouseup.sortable",
            drag: "touchmove.sortable mousemove.sortable",
            scroll: "scroll.sortable"
        },
        subContainerKey = "subContainers"

    /*
     * a is Array [left, right, top, bottom]
     * b is array [left, top]
     */
    function d(a, b) {
        var x = Math.max(0, a[0] - b[0], b[0] - a[1]),
            y = Math.max(0, a[2] - b[1], b[1] - a[3])
        return x + y;
    }

    function setDimensions(array, dimensions, tolerance, useOffset) {
        var i = array.length,
            offsetMethod = useOffset ? "offset" : "position"
        tolerance = tolerance || 0

        while (i--) {
            var el = array[i].el ? array[i].el : $(array[i]),
            // use fitting method
                pos = el[offsetMethod]()
            pos.left += parseInt(el.css('margin-left'), 10)
            pos.top += parseInt(el.css('margin-top'), 10)
            dimensions[i] = [
                pos.left - tolerance,
                pos.left + el.outerWidth() + tolerance,
                pos.top - tolerance,
                pos.top + el.outerHeight() + tolerance]
        }
    }

    function getRelativePosition(pointer, element) {
        var offset = element.offset()
        return {
            left: pointer.left - offset.left,
            top: pointer.top - offset.top
        }
    }

    function sortByDistanceDesc(dimensions, pointer, lastPointer) {
        pointer = [pointer.left, pointer.top]
        lastPointer = lastPointer && [lastPointer.left, lastPointer.top]

        var dim,
            i = dimensions.length,
            distances = []

        while (i--) {
            dim = dimensions[i]
            distances[i] = [i, d(dim, pointer), lastPointer && d(dim, lastPointer)]
        }
        distances = distances.sort(function(a, b) {
            return b[1] - a[1] || b[2] - a[2] || b[0] - a[0]
        })

        // last entry is the closest
        return distances
    }

    function ContainerGroup(options) {
        this.options = $.extend({}, groupDefaults, options)
        this.containers = []

        if (!this.options.rootGroup) {
            this.scrollProxy = $.proxy(this.scroll, this)
            this.dragProxy = $.proxy(this.drag, this)
            this.dropProxy = $.proxy(this.drop, this)
            this.placeholder = $(this.options.placeholder)

            if (!options.isValidTarget) this.options.isValidTarget = undefined
        }
    }

    ContainerGroup.get = function(options) {
        if (!containerGroups[options.group]) {
            if (options.group === undefined) options.group = groupCounter++

            containerGroups[options.group] = new ContainerGroup(options)
        }

        return containerGroups[options.group]
    }

    ContainerGroup.prototype = {
        dragInit: function(e, itemContainer) {
            this.$document = $(itemContainer.el[0].ownerDocument)

            // get item to drag
            this.item = $(e.target).closest(this.options.itemSelector)
            this.itemContainer = itemContainer

            if (this.item.is(this.options.exclude) || !this.options.onMousedown(this.item, groupDefaults.onMousedown, e)) {
                return
            }

            this.setPointer(e)
            this.toggleListeners('on')

            this.setupDelayTimer()
            this.dragInitDone = true
        },
        drag: function(e) {
            if (!this.dragging) {
                if (!this.distanceMet(e) || !this.delayMet) return

                this.options.onDragStart(this.item, this.itemContainer, groupDefaults.onDragStart, e)
                this.item.before(this.placeholder)
                this.dragging = true
            }

            this.setPointer(e)
            // place item under the cursor
            this.options.onDrag(this.item,
                getRelativePosition(this.pointer, this.item.offsetParent()),
                groupDefaults.onDrag,
                e)

            var x = e.pageX || e.originalEvent.pageX,
                y = e.pageY || e.originalEvent.pageY,
                box = this.sameResultBox,
                t = this.options.tolerance

            if (!box || box.top - t > y || box.bottom + t < y || box.left - t > x || box.right + t < x) if (!this.searchValidTarget()) this.placeholder.detach()
        },
        drop: function(e) {
            this.toggleListeners('off')

            this.dragInitDone = false

            if (this.dragging) {
                // processing Drop, check if placeholder is detached
                if (this.placeholder.closest("html")[0]) this.placeholder.before(this.item).detach()
                else this.options.onCancel(this.item, this.itemContainer, groupDefaults.onCancel, e)

                this.options.onDrop(this.item, this.getContainer(this.item), groupDefaults.onDrop, e)

                // cleanup
                this.clearDimensions()
                this.clearOffsetParent()
                this.lastAppendedItem = this.sameResultBox = undefined
                this.dragging = false
            }
        },
        searchValidTarget: function(pointer, lastPointer) {
            if (!pointer) {
                pointer = this.relativePointer || this.pointer
                lastPointer = this.lastRelativePointer || this.lastPointer
            }

            var distances = sortByDistanceDesc(this.getContainerDimensions(),
                    pointer,
                    lastPointer),
                i = distances.length

            while (i--) {
                var index = distances[i][0],
                    distance = distances[i][1]

                if (!distance || this.options.pullPlaceholder) {
                    var container = this.containers[index]
                    if (!container.disabled) {
                        if (!this.$getOffsetParent()) {
                            var offsetParent = container.getItemOffsetParent()
                            pointer = getRelativePosition(pointer, offsetParent)
                            lastPointer = getRelativePosition(lastPointer, offsetParent)
                        }
                        if (container.searchValidTarget(pointer, lastPointer)) return true
                    }
                }
            }
            if (this.sameResultBox) this.sameResultBox = undefined
        },
        movePlaceholder: function(container, item, method, sameResultBox) {
            var lastAppendedItem = this.lastAppendedItem
            if (!sameResultBox && lastAppendedItem && lastAppendedItem[0] === item[0]) return;

            item[method](this.placeholder)
            this.lastAppendedItem = item
            this.sameResultBox = sameResultBox
            this.options.afterMove(this.placeholder, container, item)
        },
        getContainerDimensions: function() {
            if (!this.containerDimensions) setDimensions(this.containers, this.containerDimensions = [], this.options.tolerance, !this.$getOffsetParent())
            return this.containerDimensions
        },
        getContainer: function(element) {
            return element.closest(this.options.containerSelector).data(pluginName)
        },
        $getOffsetParent: function() {
            if (this.offsetParent === undefined) {
                var i = this.containers.length - 1,
                    offsetParent = this.containers[i].getItemOffsetParent()

                if (!this.options.rootGroup) {
                    while (i--) {
                        if (offsetParent[0] != this.containers[i].getItemOffsetParent()[0]) {
                            // If every container has the same offset parent,
                            // use position() which is relative to this parent,
                            // otherwise use offset()
                            // compare #setDimensions
                            offsetParent = false
                            break;
                        }
                    }
                }

                this.offsetParent = offsetParent
            }
            return this.offsetParent
        },
        setPointer: function(e) {
            var pointer = this.getPointer(e)

            if (this.$getOffsetParent()) {
                var relativePointer = getRelativePosition(pointer, this.$getOffsetParent())
                this.lastRelativePointer = this.relativePointer
                this.relativePointer = relativePointer
            }

            this.lastPointer = this.pointer
            this.pointer = pointer
        },
        distanceMet: function(e) {
            var currentPointer = this.getPointer(e)
            return (Math.max(
                Math.abs(this.pointer.left - currentPointer.left),
                Math.abs(this.pointer.top - currentPointer.top)) >= this.options.distance)
        },
        getPointer: function(e) {
            return {
                left: e.pageX || e.originalEvent.pageX,
                top: e.pageY || e.originalEvent.pageY
            }
        },
        setupDelayTimer: function() {
            var that = this
            this.delayMet = !this.options.delay

            // init delay timer if needed
            if (!this.delayMet) {
                clearTimeout(this._mouseDelayTimer);
                this._mouseDelayTimer = setTimeout(function() {
                    that.delayMet = true
                }, this.options.delay)
            }
        },
        scroll: function(e) {
            this.clearDimensions()
            this.clearOffsetParent() // TODO is this needed?
        },
        toggleListeners: function(method) {
            var that = this,
                events = ['drag', 'drop', 'scroll']

            $.each(events, function(i, event) {
                that.$document[method](eventNames[event], that[event + 'Proxy'])
            })
        },
        clearOffsetParent: function() {
            this.offsetParent = undefined
        },
        // Recursively clear container and item dimensions
        clearDimensions: function() {
            this.traverse(function(object) {
                object._clearDimensions()
            })
        },
        traverse: function(callback) {
            callback(this)
            var i = this.containers.length
            while (i--) {
                this.containers[i].traverse(callback)
            }
        },
        _clearDimensions: function() {
            this.containerDimensions = undefined
        },
        _destroy: function() {
            containerGroups[this.options.group] = undefined
        }
    }

    function Container(element, options) {
        this.el = element
        this.options = $.extend({}, containerDefaults, options)

        this.group = ContainerGroup.get(this.options)
        this.rootGroup = this.options.rootGroup || this.group
        this.handle = this.rootGroup.options.handle || this.rootGroup.options.itemSelector

        var itemPath = this.rootGroup.options.itemPath
        this.target = itemPath ? this.el.find(itemPath) : this.el

        this.target.on(eventNames.start, this.handle, $.proxy(this.dragInit, this))

        if (this.options.drop) this.group.containers.push(this)
    }

    Container.prototype = {
        dragInit: function(e) {
            var rootGroup = this.rootGroup

            if (!this.disabled && !rootGroup.dragInitDone && this.options.drag && this.isValidDrag(e)) {
                rootGroup.dragInit(e, this)
            }
        },
        isValidDrag: function(e) {
            return e.which == 1 || e.type == "touchstart" && e.originalEvent.touches.length == 1
        },
        searchValidTarget: function(pointer, lastPointer) {
            var distances = sortByDistanceDesc(this.getItemDimensions(),
                    pointer,
                    lastPointer),
                i = distances.length,
                rootGroup = this.rootGroup,
                validTarget = !rootGroup.options.isValidTarget || rootGroup.options.isValidTarget(rootGroup.item, this)

            if (!i && validTarget) {
                rootGroup.movePlaceholder(this, this.target, "append")
                return true
            } else while (i--) {
                var index = distances[i][0],
                    distance = distances[i][1]
                if (!distance && this.hasChildGroup(index)) {
                    var found = this.getContainerGroup(index).searchValidTarget(pointer, lastPointer)
                    if (found) return true
                } else if (validTarget) {
                    this.movePlaceholder(index, pointer)
                    return true
                }
            }
        },
        movePlaceholder: function(index, pointer) {
            var item = $(this.items[index]),
                dim = this.itemDimensions[index],
                method = "after",
                width = item.outerWidth(),
                height = item.outerHeight(),
                offset = item.offset(),
                sameResultBox = {
                    left: offset.left,
                    right: offset.left + width,
                    top: offset.top,
                    bottom: offset.top + height
                }
            if (this.options.vertical) {
                var yCenter = (dim[2] + dim[3]) / 2,
                    inUpperHalf = pointer.top <= yCenter
                if (inUpperHalf) {
                    method = "before"
                    sameResultBox.bottom -= height / 2
                } else sameResultBox.top += height / 2
            } else {
                var xCenter = (dim[0] + dim[1]) / 2,
                    inLeftHalf = pointer.left <= xCenter
                if (inLeftHalf) {
                    method = "before"
                    sameResultBox.right -= width / 2
                } else sameResultBox.left += width / 2
            }
            if (this.hasChildGroup(index)) sameResultBox = emptyBox
            this.rootGroup.movePlaceholder(this, item, method, sameResultBox)
        },
        getItemDimensions: function() {
            if (!this.itemDimensions) {
                this.items = this.$getChildren(this.el, "item").filter(":not(.placeholder, .dragged)").get()
                setDimensions(this.items, this.itemDimensions = [], this.options.tolerance)
            }
            return this.itemDimensions
        },
        getItemOffsetParent: function() {
            var offsetParent,
                el = this.el
            // Since el might be empty we have to check el itself and
            // can not do something like el.children().first().offsetParent()
            if (el.css("position") === "relative" || el.css("position") === "absolute" || el.css("position") === "fixed") offsetParent = el
            else offsetParent = el.offsetParent()
            return offsetParent
        },
        hasChildGroup: function(index) {
            return this.options.nested && this.getContainerGroup(index)
        },
        getContainerGroup: function(index) {
            var childGroup = $.data(this.items[index], subContainerKey)
            if (childGroup === undefined) {
                var childContainers = this.$getChildren(this.items[index], "container")
                childGroup = false

                if (childContainers[0]) {
                    var options = $.extend({}, this.options, {
                        rootGroup: this.rootGroup,
                        group: groupCounter++
                    })
                    childGroup = childContainers[pluginName](options).data(pluginName).group
                }
                $.data(this.items[index], subContainerKey, childGroup)
            }
            return childGroup
        },
        $getChildren: function(parent, type) {
            var options = this.rootGroup.options,
                path = options[type + "Path"],
                selector = options[type + "Selector"]

            parent = $(parent)
            if (path) parent = parent.find(path)

            return parent.children(selector)
        },
        _serialize: function(parent, isContainer) {
            var that = this,
                childType = isContainer ? "item" : "container",

                children = this.$getChildren(parent, childType).not(this.options.exclude).map(function() {
                    return that._serialize($(this), !isContainer)
                }).get()

            return this.rootGroup.options.serialize(parent, children, isContainer)
        },
        traverse: function(callback) {
            $.each(this.items || [], function(item) {
                var group = $.data(this, subContainerKey)
                if (group) group.traverse(callback)
            });

            callback(this)
        },
        _clearDimensions: function() {
            this.itemDimensions = undefined
        },
        _destroy: function() {
            var that = this;

            this.target.off(eventNames.start, this.handle);
            this.el.removeData(pluginName)

            if (this.options.drop) this.group.containers = $.grep(this.group.containers, function(val) {
                return val != that
            })

            $.each(this.items || [], function() {
                $.removeData(this, subContainerKey)
            })
        }
    }

    var API = {
        enable: function() {
            this.traverse(function(object) {
                object.disabled = false
            })
        },
        disable: function() {
            this.traverse(function(object) {
                object.disabled = true
            })
        },
        serialize: function() {
            return this._serialize(this.el, true)
        },
        refresh: function() {
            this.traverse(function(object) {
                object._clearDimensions()
            })
        },
        destroy: function() {
            this.traverse(function(object) {
                object._destroy();
            })
        }
    }

    $.extend(Container.prototype, API)

    /**
     * jQuery API
     *
     * Parameters are
     *   either options on init
     *   or a method name followed by arguments to pass to the method
     */
    $.fn[pluginName] = function(methodOrOptions) {
        var args = Array.prototype.slice.call(arguments, 1)

        return this.map(function() {
            var $t = $(this),
                object = $t.data(pluginName)

            if (object && API[methodOrOptions]) return API[methodOrOptions].apply(object, args) || this
            else if (!object && (methodOrOptions === undefined || typeof methodOrOptions === "object")) $t.data(pluginName, new Container($t, methodOrOptions))

            return this
        });
    };

}(jQuery, window, 'sortable');