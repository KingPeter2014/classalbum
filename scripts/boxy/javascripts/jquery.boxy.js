/**
 * Boxy 0.1.4 - Facebook-style dialog, with frills
 *
 * (c) 2008 Jason Frame
 * Licensed under the MIT License (LICENSE)
 */
 
/*
 * jQuery plugin
 *
 * Options:
 *   message: confirmation message for form submit hook (default: "Please confirm:")
 * 
 * Any other options - e.g. 'clone' - will be passed onto the boxy constructor (or
 * Boxy.load for AJAX operations)
 */
jQuery.fn.boxy = function(options) {
    options = options || {};
    return this.each(function() {      
        var node = this.nodeName.toLowerCase(), self = this;
        if (node == 'a') {
            jQuery(this).click(function() {
                var active = Boxy.linkedTo(this),
                    href = this.getAttribute('href'),
                    localOptions = jQuery.extend({actuator: this, title: this.title}, options);
                    
                if (active) {
                    active.show();
                } else if (href.indexOf('#') >= 0) {
                    var content = jQuery(href.substr(href.indexOf('#'))),
                        newContent = content.clone(true);
                    content.remove();
                    localOptions.unloadOnHide = false;
                    new Boxy(newContent, localOptions);
                } else { // fall back to AJAX; could do with a same-origin check
                    if (!localOptions.cache) localOptions.unloadOnHide = true;
                    Boxy.load(this.href, localOptions);
                }
                
                return false;
            });
        } else if (node == 'form') {pat
            jQuery(this).bind('submit.boxy', function() {
                Boxy.confirm(options.message || 'Please confirm:', function() {
                    jQuery(self).unbind('submit.boxy').submit();
                });
                return false;
            });
        }
    });
};

//
// Boxy Class

function Boxy(element, options) {
    
    this.boxy = jQuery(Boxy.WRAPPER);
    jQuery.data(this.boxy[0], 'boxy', this);
    
    this.visible = false;
    this.options = jQuery.extend({}, Boxy.DEFAULTS, options || {});
    
    if (this.options.modal) {
        this.options = jQuery.extend(this.options, {center: true, draggable: true});
    }
    
    // options.actuator == DOM element that opened this boxy
    // association will be automatically deleted when this boxy is remove()d
    if (this.options.actuator) {
        jQuery.data(this.options.actuator, 'active.boxy', this);
    }
    
    this.setContent(element || "<div></div>");
    this._setupTitleBar();
    
    this.boxy.css('display', 'none').appendTo(document.body);
    this.toTop();

    if (this.options.fixed) {
        if (jQuery.browser.msie && jQuery.browser.version < 7) {
            this.options.fixed = false; // IE6 doesn't support fixed positioning
        } else {
            this.boxy.addClass('fixed');
        }
    }
    
    if (this.options.center && Boxy._u(this.options.x, this.options.y)) {
        this.center();
    } else {
        this.moveTo(
            Boxy._u(this.options.x) ? this.options.x : Boxy.DEFAULT_X,
            Boxy._u(this.options.y) ? this.options.y : Boxy.DEFAULT_Y
        );
    }
    
    if (this.options.show) this.show();

};

Boxy.EF = function() {};
var ico1 = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAAABmJLR0QAAAAAAAD5Q7t/AAAACXBI';
ico1+='WXMAAABIAAAASABGyWs+AAAACXZwQWcAAAAQAAAAEABcxq3DAAACVUlEQVQ4y32TS0tVURTHf2uf';
ico1+='fR5qZZ70ilgD7THKsKwgaJgG0RcQuo2LwrHTRn2DBhE4SPIziDSUEotIaiCBQqaYXq/cfNx7PGfv';
ico1+='3WAfECrak73W3uv1X/+1hEfzAGdwbjzQ+m4YBt2IKP51nLN5bmqmKGYRmQF2NJCKqOeV7s7qQH+a';
ico1+='dHQkf/tLeVvL/kGL1fX6na2dxhXn7KTG8aDS01kdujSYFComLwAHKBAFASABKAERqJzsJO06nXz8';
ico1+='ulL9ubX7RYdxOJqmlWR7LyYzECjQpTPK62Epi8BhBm1RzNn+3qTe2B9VSunu3LST5SAOjPWG4kCs';
ico1+='142DUMA5LzdziKIOojBMlXWiMqMoLFgLXTE8vg5jg4CFwMH9C/BkBNK4DGIht17WOG9oLBhguA/G';
ico1+='h+DIQBhApGHiBigFCxswvwaBBut8q7SnxwdxAu++w5sleDgMk7c9HICpz7Cw7iEE9pggz5f1QcTB';
ico1+='bhNeLsLiD+iIoD2E92swswQHmc9c2NIHUM55PKZ8jBXcuwhDvZAb/3e1D8bOQ6RKuM4HwpUVGLxh';
ico1+='buBaH0zcgljDiwVfTaLh6U0Y6QVrwJUNB9AizioszkEBLNdg9hus/4KpT34GcgMDKSzv+szK+rYh';
ico1+='oHFFLZQDrEswCBt78Oytn97cQabg1QeIQzg0fsC0A5MdUhRFXeV5Ptc83G71nMrobIM27R0RDyMO';
ico1+='oBBPaxxAewSxztiubbbyo6M5DUzXG43LSq1Wz1XSJDmRYEV5+uSYLgEUllazxcpmvVWrN14D0/Ln';
ico1+='Okf/WWf3j3X+DRcmFXQtWLlUAAAALnpUWHRjcmVhdGUtZGF0ZQAAeNozMjCw0DWw1DUyDTE0sDI1';
ico1+='sTKw0DawsDIwAABCRgUcYD4SOgAAAC56VFh0bW9kaWZ5LWRhdGUAAHjaMzIwsNA1sNQ1MgkxNLIy';
ico1+='MbQyNtA2sLAyMAAAQgcFFI2R7f4AAAAASUVORK5CYII=" />';
jQuery.extend(Boxy, {
    
    WRAPPER:    "<table cellspacing='0' cellpadding='0' border='0' class='boxy-wrapper'>" +
                "<tr><td class='top-left'></td><td class='top'></td><td class='top-right'></td></tr>" +
                "<tr><td class='leftt'></td><td class='boxy-inner'></td><td class='rightt'></td></tr>" +
                "<tr><td class='bottom-left'></td><td class='bottom'></td><td class='bottom-right'></td></tr>" +
                "</table>",
    
    DEFAULTS: {
        title:                  ' ',           // titlebar text. if null, titlebar will not be visible if not set.
        closeable:              true,           // display close link in titlebar?
        draggable:              true,           // can this dialog be dragged?
        clone:                  false,          // clone content prior to insertion into dialog?
        actuator:               null,           // element which opened this dialog
        center:                 true,           // center dialog in viewport?
        show:                   true,           // show dialog immediately?
        modal:                  true,          // make dialog modal?
        fixed:                  true,           // use fixed positioning, if supported? absolute positioning used otherwise
        closeText:              ico1,      // text to use for default close link
        unloadOnHide:           true,          // should this dialog be removed from the DOM after being hidden?
        clickToFront:           false,          // bring dialog to foreground on any click (not just titlebar)?
        behaviours:             Boxy.EF,        // function used to apply behaviours to all content embedded in dialog.
        afterDrop:              Boxy.EF,        // callback fired after dialog is dropped. executes in context of Boxy instance.
        afterShow:              Boxy.EF,        // callback fired after dialog becomes visible. executes in context of Boxy instance.
        afterHide:              Boxy.EF,        // callback fired after dialog is hidden. executed in context of Boxy instance.
        beforeUnload:           Boxy.EF         // callback fired after dialog is unloaded. executed in context of Boxy instance.
    },
    
    DEFAULT_X:          50,
    DEFAULT_Y:          50,
    zIndex:             1337,
    dragConfigured:     false, // only set up one drag handler for all boxys
    resizeConfigured:   false,
    dragging:           null,
    
    // load a URL and display in boxy
    // url - url to load
    // options keys (any not listed below are passed to boxy constructor)
    //   type: HTTP method, default: GET
    //   cache: cache retrieved content? default: false
    //   filter: jQuery selector used to filter remote content
    load: function(url, options) {
        
        options = options || {};
        
        var ajax = {
            url: url, type: 'GET', dataType: 'html', cache: false, success: function(html) {
                html = jQuery(html);
                if (options.filter) html = jQuery(options.filter, html);
                new Boxy(html, options);
            }
        };
        
        jQuery.each(['type', 'cache'], function() {
            if (this in options) {
                ajax[this] = options[this];
                delete options[this];
            }
        });
        
        jQuery.ajax(ajax);
        
    },
    
    // allows you to get a handle to the containing boxy instance of any element
    // e.g. <a href='#' onclick='alert(Boxy.get(this));'>inspect!</a>.
    // this returns the actual instance of the boxy 'class', not just a DOM element.
    // Boxy.get(this).hide() would be valid, for instance.
    get: function(ele) {
        var p = jQuery(ele).parents('.boxy-wrapper');
        return p.length ? jQuery.data(p[0], 'boxy') : null;
    },
    
    // returns the boxy instance which has been linked to a given element via the
    // 'actuator' constructor option.
    linkedTo: function(ele) {
        return jQuery.data(ele, 'active.boxy');
    },
    
    // displays an alert box with a given message, calling optional callback
    // after dismissal.
    alert: function(message, callback, options) {
    	imgdata = '';
    	imgdata	+= 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlz';
    	imgdata	+= 'AAAN1wAADdcBQiibeAAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAP0SURB';
    	imgdata	+= 'VFiFvVfNamVFEP6qz7k/CYybkfEnuPIR5q6dwUVEfIUBV26y9xFcidtAEAKiL+Aq4MYBV0I2PoAL';
    	imgdata	+= 'GWYmgkPQgST3/FS56Kru6nP6GiJiQXPvObe766uvfi+dPMTiQvBEAo6aBhvcIhTc0ncCQDiv22Qc';
    	imgdata	+= 'cU6M47cJ37UXgifvvY/Txx8D9+7ffvi/kNevsHl6htNnvwKtBBw9OgSGX4DfX0x2EhAWAC0AanU1';
    	imgdata	+= 'AJQBT4EwAAZkBGTQ1QPcx9+9LN8FHh0C357gqIVg88aDuXJqAFoCYakAFhkANaq88IEqH7NyaQE0';
    	imgdata	+= 'gHTxvUn3AnjrQwCCTVujiBZRcVhFEPZsLPwjA2o9dxEANQAHfe7numYAaBEVhxUQ1jtY2AFAOFtP';
    	imgdata	+= 'rSp1bDHmIAoA1GTLw9oBWCkwAxEitYULRgXQA9wq/QGQ4BQIwFy6IwOgrMyUJwBrx4K64Z1PS0t4';
    	imgdata	+= 'AC6+AWQBUB+tB80BCANyUwEQzM+T1awBUgAexMx1DdDsKwOWKZEYEOsagTDqyykA87EpSjGwdjGx';
    	imgdata	+= 'yvtqEvYy9ebzYC5iddMA0FAD0LpA2wEmuWQXgP2YckVscFZKg97tArEE0GYgwYPwcaGuqUmzjilX';
    	imgdata	+= 'KB/jXTJExSmVDQDpASswHkTBirGxBmi1g4G16mZncZ+tLgoZYjYlAAhlmaVQYWQZlTd7dQC0isEW';
    	imgdata	+= 'xpwNRd1wOgxAIPcAcpsb9+nYMSBVBqbluinv8joygAS/vogUcShdVGXANSsEPbtr6Ueo3vQ/SrBO';
    	imgdata	+= 'KYzU1fwSy+FJq62JDFpmbX/lvtS49DGkCcb9KFY07NO1We411yvCfQYh4+QOu9eAqNFtAsDlIXGt';
    	imgdata	+= '1QYLamJtH2vaAcg2guNe5wE7z6UxMAY8AJlYKn1MJRsspMtFhoxeJ3/9rHs6HUA8iAkz1g2FXSVM';
    	imgdata	+= 'aM3iFqAuNxaLXNE8//Mn5BBW9sw9fAPwNoOZMVLrBUlxF9NJWlU+6fs0RGbe/GRCvwB/fK93bDMA';
    	imgdata	+= 'dmyk71UARrVOMmY1aVezAA1D2Uy88LVjoYt934NJbqk1I+6Rqp5osAnFgAs68dCING7VZLxSJhUA';
    	imgdata	+= 'b3Ng2mJ1yQwAxAUa5Q3ku9rgql2NgasyVVMM3OS4kA7wY3phi4x5lEoAtKiQDRPaXKZZ8OwrFENp';
    	imgdata	+= '8vk0KCc5PCNT+uxzSFYcltrdNDB/+2Jyzhetwfm8K2NgKlVvSq/Tq6YcDc76u/wxcSxMLc8ACOeX';
    	imgdata	+= 'L7FZHQDb5w7ECMh1tCoNFr7bWacEcs2v/TWrlO3VAXD5EgDhvCXG8Y9nOH38EfDggzpKHxN3Eqm/';
    	imgdata	+= 'vrwAnp4BxDimk4dY/PAKXz6/xmevO+z/S1V3kntLXB3s4evD+/j8b5KoiyHTK51PAAAAAElFTkSu';
    	imgdata	+= 'QmCCMTE0Mw==';
    	message = '<img src="data:image/png;base64,'+imgdata+'" align="left" style="padding-right: 20px;"/>' + message;
    	//add customization for icon alert
        return Boxy.ask(message, ['OK'], callback, options);
    },
    
    // displays an alert box with a given message, calling after callback iff
    // user selects OK.
    confirm: function(message, after, options) {
		var img = 'iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAFMklEQVR42rWXe1BUVRjAv3P3wd2F';
		img+='XRaVZZZHPmCULBLLyYqamESlUYupP0r6o9FxKgMLcfoHNVMwZ8Ry1FQIncYJyonMfBA6qPikmWIQ';
		img+='AZGHPCrZXZ4Xdtm9u3vv3dO5vGKXZWHJ/Wb3/rHfud/3+x7nO2cRzEAq8pOlFOYXmlgcqqRlNp4X';
		img+='HvEC6JMyyrCvtpAvi+//sC5RqdJ8HByiTqbVIaoxhSAA09XTZTJZrxkN3YXthsHSDfsqnI8NoLZw';
		img+='zaKQ2SHHZut0r4EUAUJub+KhDwBxiTmA1qa/q38urUv/4lTdnf8NUP/j2vUR86IK5IF0IFBTvyCC';
		img+='YAHAYXJwuXlXt7Z0DBw7fd0waWm82qv5Pvmj6CcXHKXkFIV8KNaQNwLBmXm8I/dCxl/GwSPn/hjw';
		img+='CDGp2frCpNVPxMwtoWiJxBfnLiA8gMU4wH2w6/zrZyvZq9MGuFuQoIqar2tQzgoMn8w59mZgdA1Z';
		img+='5LQClF+6U7OnsH35n+28bVoAjUWJWZExur1I6kFJGs3JDad4yABZg2STk2AHgFVvhPVZN9ZeaXSW';
		img+='TAvAcG7lQ7VOFT0++qGIiWPBAsDbesHaayQgAgSoQ0AZFgWUghijPJeB67XBroOl+Rer8eaWXsBe';
		img+='AW7lPjU//rm5rZQCuWpJxMIgiYZpgZJzjU3Hb8IRvQmqgpUoaOu789NT345dRwV4SJiDBfZBJZy5';
		img+='Zf597wWc+E8/OLwCXMtelLw0LqqUkrk2LSapF2wOuFF2W//+KZzsdEKdhRuOJjNFu3B3elwjpXQ1';
		img+='h+2dIDANYDdycKsGNW8pwkv1ZrB4Bdj51pwlb8TD9QAZpse0eKShHBxkF5vzylvwNsYGY5Mud1Ok';
		img+='ZNObEVZZsEwuvoJJnZzWdjIMmKGZYDcC3K6H1i2FEN9hAvOUPRAkhzm8ExQT6kkgKArMLAf9438v';
		img+='zoqgVyVozZIAVuoUvXH/qcWGtesBLteg+m2n8fPdlikyMBOpO6zeGBUpnETIMmFECywB6AEouISu';
		img+='HCzHa/rYKXrAV7n3Ff1epNZ+QhqIafddIKafY0jjDgCknUD77rTj7QTA+y6YrlTvV9AKufOoVmvf';
		img+='QJFumeBcnBdi9N0AbQawphyFVzoHocrdzowAKr9UyoOD+N9CwxwrkBwAuZ+MeNi5g6TeQhKe+R06';
		img+='fLMNf+ae/hkD1B8I2B4eac9BAR6cC8PDykH60Eoa8NCv6OKpSryx3wbdnmzNCKD1G2nb7HB+nqea';
		img+='8ybinAyszh7gss+gk2XN+HOT3bPzGQH89KlCk/Qs2ydRk+DHj+qRtNtJ5LWNwKQVoQyjGRcT56w3';
		img+='ez4DnM9QxCQsYZulKjcFAeBI9IOk6985hDIbuvDhAfvokfUYAc5uVj79wgJrrcR9TBEAnsw4xgrO';
		img+='xIMottuCm6djz2eAtESZKlrLF88KxJHuAOJw7usHW04ZJJOO7/ELgCixOrncxoPr2Tey/VhOwBwn';
		img+='WBkWHt+teLz8snO5VBsWukpCywDGDTXRuWAX4G5de8cnebX3pmvPZ4CSPcs0iSsTGERPvH2Iu8BQ';
		img+='fc2Wsrsm5n4n7vALwOWcWM3Lr8YzSAETDx4ygPrqq2DFjqbFD3vhgV8ASrNCNC89gxikwq7+xV1A';
		img+='Dp3+Ryys2m/zH0BJhlTzYhzPUKqJGeDJEBroAlj9NSx+2OcngPxUiSZlqcAA7XoO4JESWMg1fPUR';
		img+='WNzK+AkgdRmiNIH4gE4Nce46EYKzA/62Aj7stECbXwBE0dBAOQTxb6obAPk6yUOCgBu9sE4l/wI5';
		img+='51s//xoC8QAAAABJRU5ErkJggg==';
        message = '<img src="data:image/png;base64,'+img+'" align="left" style="padding-right: 20px;"/>'+ message;
		return Boxy.ask(message, ['OK', 'Cancel'], function(response) {
            if (response == 'OK') after();
        }, options);
    },
    
    // asks a question with multiple responses presented as buttons
    // selected item is returned to a callback method.
    // answers may be either an array or a hash. if it's an array, the
    // the callback will received the selected value. if it's a hash,
    // you'll get the corresponding key.
    ask: function(question, answers, callback, options) {
		options = jQuery.extend({modal: true, closeable: false},
                                options || {},
                                {show: true, unloadOnHide: true});
        
        var body = jQuery('<div></div>').append(jQuery('<div class="question"></div>').html(question));
        
        // ick
        var map = {}, answerStrings = [];
        if (answers instanceof Array) {
            for (var i = 0; i < answers.length; i++) {
                map[answers[i]] = answers[i];
                answerStrings.push(answers[i]);
            }
        } else {
            for (var k in answers) {
                map[answers[k]] = k;
                answerStrings.push(answers[k]);
            }
        }
        
        var buttons = jQuery('<form class="answers"></form>');
        buttons.html(jQuery.map(answerStrings, function(v) {
            //return "<button type='button'>" + v + "</button>";
        	return "<input type='button' value='"+v+"' />";
        }).join(' '));
        
        jQuery('input[type=button]', buttons).click(function() {
            var clicked = this;
            Boxy.get(this).hide(function() {
                if (callback) callback(map[clicked.value]);
            });
        });
        
        body.append(buttons);
        
        new Boxy(body, options);
        
    },
    
    // returns true if a modal boxy is visible, false otherwise
    isModalVisible: function() {
        return jQuery('.boxy-modal-blackout').length > 0;
    },
    
    _u: function() {
        for (var i = 0; i < arguments.length; i++)
            if (typeof arguments[i] != 'undefined') return false;
        return true;
    },
    
    _handleResize: function(evt) {
        var d = jQuery(document);
        jQuery('.boxy-modal-blackout').css('display', 'none').css({
            width: d.width(), height: d.height()
        }).css('display', 'block');
    },
    
    _handleDrag: function(evt) {
        var d;
        if (d = Boxy.dragging) {
            d[0].boxy.css({left: evt.pageX - d[1], top: evt.pageY - d[2]});
        }
    },
    
    _nextZ: function() {
        return Boxy.zIndex++;
    },
    
    _viewport: function() {
        var d = document.documentElement, b = document.body, w = window;
        return jQuery.extend(
            jQuery.browser.msie ?
                { left: b.scrollLeft || d.scrollLeft, top: b.scrollTop || d.scrollTop } :
                { left: w.pageXOffset, top: w.pageYOffset },
            !Boxy._u(w.innerWidth) ?
                { width: w.innerWidth, height: w.innerHeight } :
                (!Boxy._u(d) && !Boxy._u(d.clientWidth) && d.clientWidth != 0 ?
                    { width: d.clientWidth, height: d.clientHeight } :
                    { width: b.clientWidth, height: b.clientHeight }) );
    }

});

Boxy.prototype = {
    
    // Returns the size of this boxy instance without displaying it.
    // Do not use this method if boxy is already visible, use getSize() instead.
    estimateSize: function() {
        this.boxy.css({visibility: 'hidden', display: 'block'});
        var dims = this.getSize();
        this.boxy.css('display', 'none').css('visibility', 'visible');
        return dims;
    },
                
    // Returns the dimensions of the entire boxy dialog as [width,height]
    getSize: function() {
        return [this.boxy.width(), this.boxy.height()];
    },
    
    // Returns the dimensions of the content region as [width,height]
    getContentSize: function() {
        var c = this.getContent();
        return [c.width(), c.height()];
    },
    
    // Returns the position of this dialog as [x,y]
    getPosition: function() {
        var b = this.boxy[0];
        return [b.offsetLeft, b.offsetTop];
    },
    
    // Returns the center point of this dialog as [x,y]
    getCenter: function() {
        var p = this.getPosition();
        var s = this.getSize();
        return [Math.floor(p[0] + s[0] / 2), Math.floor(p[1] + s[1] / 2)];
    },
                
    // Returns a jQuery object wrapping the inner boxy region.
    // Not much reason to use this, you're probably more interested in getContent()
    getInner: function() {
        return jQuery('.boxy-inner', this.boxy);
    },
    
    // Returns a jQuery object wrapping the boxy content region.
    // This is the user-editable content area (i.e. excludes titlebar)
    getContent: function() {
        return jQuery('.boxy-content', this.boxy);
    },
    
    // Replace dialog content
    setContent: function(newContent) {
        newContent = jQuery(newContent).css({display: 'block'}).addClass('boxy-content');
        if (this.options.clone) newContent = newContent.clone(true);
        this.getContent().remove();
        this.getInner().append(newContent);
        this._setupDefaultBehaviours(newContent);
        this.options.behaviours.call(this, newContent);
        return this;
    },
    
    // Move this dialog to some position, funnily enough
    moveTo: function(x, y) {
        this.moveToX(x).moveToY(y);
        return this;
    },
    
    // Move this dialog (x-coord only)
    moveToX: function(x) {
        if (typeof x == 'number') this.boxy.css({left: x});
        else this.centerX();
        return this;
    },
    
    // Move this dialog (y-coord only)
    moveToY: function(y) {
        if (typeof y == 'number') this.boxy.css({top: y});
        else this.centerY();
        return this;
    },
    
    // Move this dialog so that it is centered at (x,y)
    centerAt: function(x, y) {
        var s = this[this.visible ? 'getSize' : 'estimateSize']();
        if (typeof x == 'number') this.moveToX(x - s[0] / 2);
        if (typeof y == 'number') this.moveToY(y - s[1] / 2);
        return this;
    },
    
    centerAtX: function(x) {
        return this.centerAt(x, null);
    },
    
    centerAtY: function(y) {
        return this.centerAt(null, y);
    },
    
    // Center this dialog in the viewport
    // axis is optional, can be 'x', 'y'.
    center: function(axis) {
        var v = Boxy._viewport();
        var o = this.options.fixed ? [0, 0] : [v.left, v.top];
        if (!axis || axis == 'x') this.centerAt(o[0] + v.width / 2, null);
        if (!axis || axis == 'y') this.centerAt(null, o[1] + v.height / 2);
        return this;
    },
    
    // Center this dialog in the viewport (x-coord only)
    centerX: function() {
        return this.center('x');
    },
    
    // Center this dialog in the viewport (y-coord only)
    centerY: function() {
        return this.center('y');
    },
    
    // Resize the content region to a specific size
    resize: function(width, height, after) {
        if (!this.visible) return;
        var bounds = this._getBoundsForResize(width, height);
        this.boxy.css({left: bounds[0], top: bounds[1]});
        this.getContent().css({width: bounds[2], height: bounds[3]});
        if (after) after(this);
        return this;
    },
    
    // Tween the content region to a specific size
    tween: function(width, height, after) {
        if (!this.visible) return;
        var bounds = this._getBoundsForResize(width, height);
        var self = this;
        this.boxy.stop().animate({left: bounds[0], top: bounds[1]});
        this.getContent().stop().animate({width: bounds[2], height: bounds[3]}, function() {
            if (after) after(self);
        });
        return this;
    },
    
    // Returns true if this dialog is visible, false otherwise
    isVisible: function() {
        return this.visible;    
    },
    
    // Make this boxy instance visible
    show: function() {
        if (this.visible) return;
        if (this.options.modal) {
            var self = this;
            if (!Boxy.resizeConfigured) {
                Boxy.resizeConfigured = true;
                jQuery(window).resize(function() { Boxy._handleResize(); });
            }
            this.modalBlackout = jQuery('<div class="boxy-modal-blackout"></div>')
                .css({zIndex: Boxy._nextZ(),
                      opacity: 0.2,//0.7
                      width: (jQuery.browser.msie)?jQuery(document).width()-17:jQuery(document).width(),//modified for ie-it adds extra horizontal scrollbars whn boxy shows
                      height: jQuery(document).height()})
                .appendTo(document.body);
            this.toTop();
            if (this.options.closeable) {
                jQuery(document.body).bind('keypress.boxy', function(evt) {
                    var key = evt.which || evt.keyCode;
                    if (key == 27) {
                        self.hide();
                        jQuery(document.body).unbind('keypress.boxy');
                    }
                });
            }
        }
        this.boxy.stop().css({opacity: 1}).show();
        this.visible = true;
        this._fire('afterShow');
        return this;
    },
    
    // Hide this boxy instance
    hide: function(after) {
        if (!this.visible) return;
        var self = this;
        if (this.options.modal) {
            jQuery(document.body).unbind('keypress.boxy');
            this.modalBlackout.animate({opacity: 0}, function() {
                jQuery(this).remove();
            });
        }
        this.boxy.stop().animate({opacity: 0}, 300, function() {
            self.boxy.css({display: 'none'});
            self.visible = false;
            self._fire('afterHide');
            if (after) after(self);
            if (self.options.unloadOnHide) self.unload();
        });
        return this;
    },
    
    toggle: function() {
        this[this.visible ? 'hide' : 'show']();
        return this;
    },
    
    hideAndUnload: function(after) {
        this.options.unloadOnHide = true;
        this.hide(after);
        return this;
    },
    
    unload: function() {
        this._fire('beforeUnload');
        this.boxy.remove();
        if (this.options.actuator) {
            jQuery.data(this.options.actuator, 'active.boxy', false);
        }
    },
    
    // Move this dialog box above all other boxy instances
    toTop: function() {
        this.boxy.css({zIndex: Boxy._nextZ()});
        return this;
    },
    
    // Returns the title of this dialog
    getTitle: function() {
        return jQuery('> .title-bar h2', this.getInner()).html();
    },
    
    // Sets the title of this dialog
    setTitle: function(t) {
        jQuery('> .title-bar h2', this.getInner()).html(t);
        return this;
    },
    
    //
    // Don't touch these privates
    
    _getBoundsForResize: function(width, height) {
        var csize = this.getContentSize();
        var delta = [width - csize[0], height - csize[1]];
        var p = this.getPosition();
        return [Math.max(p[0] - delta[0] / 2, 0),
                Math.max(p[1] - delta[1] / 2, 0), width, height];
    },
    
    _setupTitleBar: function() {
        if (this.options.title) {
            var self = this;
            var tb = jQuery("<div class='title-bar'></div>").html("<h2>" + this.options.title + "</h2>");
            if (this.options.closeable) {
                tb.append(jQuery("<a href='#' class='close' title='Press ESC to close'></a>").html(this.options.closeText));
            }
            if (this.options.draggable) {
                tb[0].onselectstart = function() { return false; }
                tb[0].unselectable = 'on';
                tb[0].style.MozUserSelect = 'none';
                if (!Boxy.dragConfigured) {
                    jQuery(document).mousemove(Boxy._handleDrag);
                    Boxy.dragConfigured = true;
                }
                tb.mousedown(function(evt) {
                    self.toTop();
                    Boxy.dragging = [self, evt.pageX - self.boxy[0].offsetLeft, evt.pageY - self.boxy[0].offsetTop];
                    jQuery(this).addClass('dragging');
                }).mouseup(function() {
                    jQuery(this).removeClass('dragging');
                    Boxy.dragging = null;
                    self._fire('afterDrop');
                });
            }
            this.getInner().prepend(tb);
            this._setupDefaultBehaviours(tb);
        }
    },
    
    _setupDefaultBehaviours: function(root) {
        var self = this;
        if (this.options.clickToFront) {
            root.click(function() { self.toTop(); });
        }
        jQuery('.close', root).click(function() {
            self.hide();
            return false;
        }).mousedown(function(evt) { evt.stopPropagation(); });
    },
    
    _fire: function(event) {
        this.options[event].call(this);
    }
    
};
