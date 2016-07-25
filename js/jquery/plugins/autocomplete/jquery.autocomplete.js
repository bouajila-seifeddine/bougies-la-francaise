!function(e){e.fn.extend({autocomplete:function(t,a){var n="string"==typeof t;return a=e.extend({},e.Autocompleter.defaults,{url:n?t:null,data:n?null:t,delay:n?e.Autocompleter.defaults.delay:10,max:a&&!a.scroll?10:150},a),a.highlight=a.highlight||function(e){return e},a.formatMatch=a.formatMatch||a.formatItem,this.each(function(){new e.Autocompleter(this,a)})},result:function(e){return this.bind("result",e)},search:function(e){return this.trigger("search",[e])},flushCache:function(){return this.trigger("flushCache")},setOptions:function(e){return this.trigger("setOptions",[e])},unautocomplete:function(){return this.trigger("unautocomplete")}}),e.Autocompleter=function(t,a){function n(){var e=S.selected();if(!e)return!1;var t=e.result;if(b=t,a.multiple){var n=i(C.val());n.length>1&&(t=n.slice(0,n.length-1).join(a.multipleSeparator)+a.multipleSeparator+t),t+=a.multipleSeparator}return C.val(t),u(),C.trigger("result",[e.data,e.value]),!0}function r(e,t){if(p==v.DEL)return void S.hide();var n=C.val();(t||n!=b)&&(b=n,n=o(n),n.length>=a.minChars?(C.addClass(a.loadingClass),a.matchCase||(n=n.toLowerCase()),f(n,c,u)):(m(),S.hide()))}function i(t){if(!t)return[""];var n=t.split(a.multipleSeparator),r=[];return e.each(n,function(t,a){e.trim(a)&&(r[t]=e.trim(a))}),r}function o(e){if(!a.multiple)return e;var t=i(e);return t[t.length-1]}function l(n,r){a.autoFill&&o(C.val()).toLowerCase()==n.toLowerCase()&&p!=v.BACKSPACE&&(C.val(C.val()+r.substring(o(b).length)),e.Autocompleter.Selection(t,b.length,b.length+r.length))}function s(){clearTimeout(d),d=setTimeout(u,200)}function u(){var n=S.visible();S.hide(),clearTimeout(d),m(),a.mustMatch&&C.search(function(e){if(!e)if(a.multiple){var t=i(C.val()).slice(0,-1);C.val(t.join(a.multipleSeparator)+(t.length?a.multipleSeparator:""))}else C.val("")}),n&&e.Autocompleter.Selection(t,t.value.length,t.value.length)}function c(e,t){t&&t.length&&A?(m(),S.display(t,e),l(e,t[0].value),S.show()):u()}function f(n,r,i){a.matchCase||(n=n.toLowerCase());var l=w.load(n);if(l&&l.length)r(n,l);else if("string"==typeof a.url&&a.url.length>0){var s={timestamp:+new Date};e.each(a.extraParams,function(e,t){s[e]="function"==typeof t?t():t}),e.ajax({mode:"abort",port:"autocomplete"+t.name,dataType:a.dataType,url:a.url,data:e.extend({q:o(n),limit:a.max},s),success:function(e){var t=a.parse&&a.parse(e)||h(e);w.add(n,t),r(n,t)}})}else S.emptyList(),i(n)}function h(t){for(var n=[],r=t.split("\n"),i=0;i<r.length;i++){var o=e.trim(r[i]);o&&(o=o.split("|"),n[n.length]={data:o,value:o[0],result:a.formatResult&&a.formatResult(o,o[0])||o[0]})}return n}function m(){C.removeClass(a.loadingClass)}var d,p,g,v={UP:38,DOWN:40,DEL:46,TAB:9,RETURN:13,ESC:27,COMMA:188,PAGEUP:33,PAGEDOWN:34,BACKSPACE:8},C=e(t).attr("autocomplete","off").addClass(a.inputClass),b="",w=e.Autocompleter.Cache(a),A=0,T={mouseDownOnSelect:!1},S=e.Autocompleter.Select(a,t,n,T);e.browser.opera&&e(t.form).bind("submit.autocomplete",function(){return g?(g=!1,!1):void 0}),C.bind((e.browser.opera?"keypress":"keydown")+".autocomplete",function(t){switch(p=t.keyCode,t.keyCode){case v.UP:t.preventDefault(),S.visible()?S.prev():r(0,!0);break;case v.DOWN:t.preventDefault(),S.visible()?S.next():r(0,!0);break;case v.PAGEUP:t.preventDefault(),S.visible()?S.pageUp():r(0,!0);break;case v.PAGEDOWN:t.preventDefault(),S.visible()?S.pageDown():r(0,!0);break;case a.multiple&&","==e.trim(a.multipleSeparator)&&v.COMMA:case v.TAB:case v.RETURN:if(n())return t.preventDefault(),g=!0,!1;break;case v.ESC:S.hide();break;default:clearTimeout(d),d=setTimeout(r,a.delay)}}).focus(function(){A++}).blur(function(){A=0,T.mouseDownOnSelect||s()}).click(function(){A++>1&&!S.visible()&&r(0,!0)}).bind("search",function(){function t(e,t){var n;if(t&&t.length)for(var r=0;r<t.length;r++)if(t[r].result.toLowerCase()==e.toLowerCase()){n=t[r];break}"function"==typeof a?a(n):C.trigger("result",n&&[n.data,n.value])}var a=arguments.length>1?arguments[1]:null;e.each(i(C.val()),function(e,a){f(a,t,t)})}).bind("flushCache",function(){w.flush()}).bind("setOptions",function(){e.extend(a,arguments[1]),"data"in arguments[1]&&w.populate()}).bind("unautocomplete",function(){S.unbind(),C.unbind(),e(t.form).unbind(".autocomplete")})},e.Autocompleter.defaults={inputClass:"ac_input",resultsClass:"ac_results",loadingClass:"ac_loading",minChars:1,delay:400,matchCase:!1,matchSubset:!0,matchContains:!1,cacheLength:10,max:100,mustMatch:!1,extraParams:{},selectFirst:!0,formatItem:function(e){return e[0]},formatMatch:null,autoFill:!1,width:0,multiple:!1,multipleSeparator:", ",highlight:function(e,t){return e.replace(new RegExp("(?![^&;]+;)(?!<[^<>]*)("+t.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi,"\\$1")+")(?![^<>]*>)(?![^&;]+;)","gi"),"<strong>$1</strong>")},scroll:!0,scrollHeight:180},e.Autocompleter.Cache=function(t){function a(e,a){t.matchCase||(e=e.toLowerCase());var n=e.indexOf(a);return-1==n?!1:0==n||t.matchContains}function n(e,a){l>t.cacheLength&&i(),o[e]||l++,o[e]=a}function r(){if(!t.data)return!1;var a={},r=0;t.url||(t.cacheLength=1),a[""]=[];for(var i=0,o=t.data.length;o>i;i++){var l=t.data[i];l="string"==typeof l?[l]:l;var s=t.formatMatch(l,i+1,t.data.length);if(s!==!1){var u=s.charAt(0).toLowerCase();a[u]||(a[u]=[]);var c={value:s,data:l,result:t.formatResult&&t.formatResult(l)||s};a[u].push(c),r++<t.max&&a[""].push(c)}}e.each(a,function(e,a){t.cacheLength++,n(e,a)})}function i(){o={},l=0}var o={},l=0;return setTimeout(r,25),{flush:i,add:n,populate:r,load:function(n){if(!t.cacheLength||!l)return null;if(!t.url&&t.matchContains){var r=[];for(var i in o)if(i.length>0){var s=o[i];e.each(s,function(e,t){a(t.value,n)&&r.push(t)})}return r}if(o[n])return o[n];if(t.matchSubset)for(var u=n.length-1;u>=t.minChars;u--){var s=o[n.substr(0,u)];if(s){var r=[];return e.each(s,function(e,t){a(t.value,n)&&(r[r.length]=t)}),r}}return null}}},e.Autocompleter.Select=function(t,a,n,r){function i(){C&&(m=e("<div/>").hide().addClass(t.resultsClass).css("position","absolute").appendTo(document.body),d=e("<ul/>").appendTo(m).mouseover(function(t){o(t).nodeName&&"LI"==o(t).nodeName.toUpperCase()&&(g=e("li",d).removeClass(p.ACTIVE).index(o(t)),e(o(t)).addClass(p.ACTIVE))}).click(function(t){return e(o(t)).addClass(p.ACTIVE),n(),a.focus(),!1}).mousedown(function(){r.mouseDownOnSelect=!0}).mouseup(function(){r.mouseDownOnSelect=!1}),t.width>0&&m.css("width",t.width),C=!1)}function o(e){for(var t=e.target;t&&"LI"!=t.tagName;)t=t.parentNode;return t?t:[]}function l(e){f.slice(g,g+1).removeClass(p.ACTIVE),s(e);var a=f.slice(g,g+1).addClass(p.ACTIVE);if(t.scroll){var n=0;f.slice(0,g).each(function(){n+=this.offsetHeight}),n+a[0].offsetHeight-d.scrollTop()>d[0].clientHeight?d.scrollTop(n+a[0].offsetHeight-d.innerHeight()):n<d.scrollTop()&&d.scrollTop(n)}}function s(e){g+=e,0>g?g=f.size()-1:g>=f.size()&&(g=0)}function u(e){return t.max&&t.max<e?t.max:e}function c(){d.empty();for(var a=u(h.length),n=0;a>n;n++)if(h[n]){var r=t.formatItem(h[n].data,n+1,a,h[n].value,v);if(r!==!1){var i=e("<li/>").html(t.highlight(r,v)).addClass(n%2==0?"ac_even":"ac_odd").appendTo(d)[0];e.data(i,"ac_data",h[n])}}f=d.find("li"),t.selectFirst&&(f.slice(0,1).addClass(p.ACTIVE),g=0),e.fn.bgiframe&&d.bgiframe()}var f,h,m,d,p={ACTIVE:"ac_over"},g=-1,v="",C=!0;return{display:function(e,t){i(),h=e,v=t,c()},next:function(){l(1)},prev:function(){l(-1)},pageUp:function(){l(0!=g&&0>g-8?-g:-8)},pageDown:function(){l(g!=f.size()-1&&g+8>f.size()?f.size()-1-g:8)},hide:function(){m&&m.hide(),f&&f.removeClass(p.ACTIVE),g=-1},visible:function(){return m&&m.is(":visible")},current:function(){return this.visible()&&(f.filter("."+p.ACTIVE)[0]||t.selectFirst&&f[0])},show:function(){var n=e(a).offset();if(m.css({width:"string"==typeof t.width||t.width>0?t.width:e(a).width(),top:n.top+a.offsetHeight,left:n.left}).show(),t.scroll&&(d.css({maxHeight:t.scrollHeight,overflow:"auto"}),e.browser.msie&&"undefined"==typeof document.body.style.maxHeight)){var r=0;f.each(function(){r+=this.offsetHeight});var i=r>t.scrollHeight;d.css("height",i?t.scrollHeight:r),i||f.width(d.width()-parseInt(f.css("padding-left"))-parseInt(f.css("padding-right")))}},selected:function(){var t=f&&f.filter("."+p.ACTIVE).removeClass(p.ACTIVE);return t&&t.length&&e.data(t[0],"ac_data")},emptyList:function(){d&&d.empty()},unbind:function(){m&&m.remove()}}},e.Autocompleter.Selection=function(e,t,a){if(e.createTextRange){var n=e.createTextRange();n.collapse(!0),n.moveStart("character",t),n.moveEnd("character",a),n.select()}else e.setSelectionRange?e.setSelectionRange(t,a):e.selectionStart&&(e.selectionStart=t,e.selectionEnd=a);e.focus()}}(jQuery);