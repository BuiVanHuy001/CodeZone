
if (typeof EventEmitter !== 'undefined') {

    (function (t) {
        function e() {
        }

        function i(a) {
            if (a) {
                var u = "undefined" == typeof console ? e : function (t) {
                    console.error(t)
                };
                return a.bridget = function (t, e) {
                    var r, s, i;
                    (i = e).prototype.option || (i.prototype.option = function (t) {
                        a.isPlainObject(t) && (this.options = a.extend(!0, this.options, t))
                    }), r = t, s = e, a.fn[r] = function (e) {
                        if ("string" != typeof e) return this.each(function () {
                            var t = a.data(this, r);
                            t ? (t.option(e), t._init()) : (t = new s(this, e), a.data(this, r, t))
                        });
                        for (var t = p.call(arguments, 1), i = 0, o = this.length; i < o; i++) {
                            var n = this[i], n = a.data(n, r);
                            if (n) if (a.isFunction(n[e]) && "_" !== e.charAt(0)) {
                                n = n[e].apply(n, t);
                                if (void 0 !== n) return n
                            } else u("no such method '" + e + "' for " + r + " instance"); else u("cannot call methods on " + r + " prior to initialization; attempted to call '" + e + "'")
                        }
                        return this
                    }
                }, a.bridget
            }
        }

        var p = Array.prototype.slice;
        "function" == typeof define && define.amd ? define("jquery-bridget/jquery.bridget", ["jquery"], i) : "object" == typeof exports ? i(require("jquery")) : i(t.jQuery)
    })(window), function (i) {
        function o(t) {
            var e = i.event;
            return e.target = e.target || e.srcElement || t, e
        }

        let t = document.documentElement, e = function () {
        }
        t.addEventListener ? e = function (t, e, i) {
            t.addEventListener(e, i, !1)
        } : t.attachEvent && (e = function (e, t, i) {
            e[t + i] = i.handleEvent ? function () {
                var t = o(e);
                i.handleEvent.call(i, t)
            } : function () {
                var t = o(e);
                i.call(e, t)
            }, e.attachEvent("on" + t, e[t + i])
        });
        var n = function () {
        };
        t.removeEventListener ? n = function (t, e, i) {
            t.removeEventListener(e, i, !1)
        } : t.detachEvent && (n = function (e, i, o) {
            e.detachEvent("on" + i, e[i + o]);
            try {
                delete e[i + o]
            } catch (t) {
                e[i + o] = void 0
            }
        });
        n = {bind: e, unbind: n};
        "function" == typeof define && define.amd ? define("eventie/eventie", n) : "object" == typeof exports ? module.exports = n : i.eventie = n
    }(window), function () {
        function t() {
        }

        function r(t, e) {
            for (var i = t.length; i--;) if (t[i].listener === e) return i;
            return -1
        }

        function e(t) {
            return function () {
                return this[t].apply(this, arguments)
            }
        }

        var i = t.prototype, o = this, n = o.EventEmitter;
        i.getListeners = function (t) {
            var e, i, o = this._getEvents();
            if (t instanceof RegExp) for (i in e = {}, o) o.hasOwnProperty(i) && t.test(i) && (e[i] = o[i]); else e = o[t] || (o[t] = []);
            return e
        }, i.flattenListeners = function (t) {
            for (var e = [], i = 0; t.length > i; i += 1) e.push(t[i].listener);
            return e
        }, i.getListenersAsObject = function (t) {
            var e, i = this.getListeners(t);
            return i instanceof Array && ((e = {})[t] = i), e || i
        }, i.addListener = function (t, e) {
            var i, o = this.getListenersAsObject(t), n = "object" == typeof e;
            for (i in o) o.hasOwnProperty(i) && -1 === r(o[i], e) && o[i].push(n ? e : {listener: e, once: !1});
            return this
        }, i.on = e("addListener"), i.addOnceListener = function (t, e) {
            return this.addListener(t, {listener: e, once: !0})
        }, i.once = e("addOnceListener"), i.defineEvent = function (t) {
            return this.getListeners(t), this
        }, i.defineEvents = function (t) {
            for (var e = 0; t.length > e; e += 1) this.defineEvent(t[e]);
            return this
        }, i.removeListener = function (t, e) {
            var i, o, n = this.getListenersAsObject(t);
            for (o in n) n.hasOwnProperty(o) && (i = r(n[o], e), -1 !== i && n[o].splice(i, 1));
            return this
        }, i.off = e("removeListener"), i.addListeners = function (t, e) {
            return this.manipulateListeners(!1, t, e)
        }, i.removeListeners = function (t, e) {
            return this.manipulateListeners(!0, t, e)
        }, i.manipulateListeners = function (t, e, i) {
            var o, n, r = t ? this.removeListener : this.addListener, s = t ? this.removeListeners : this.addListeners;
            if ("object" != typeof e || e instanceof RegExp) for (o = i.length; o--;) r.call(this, e, i[o]); else for (o in e) e.hasOwnProperty(o) && (n = e[o]) && ("function" == typeof n ? r : s).call(this, o, n);
            return this
        }, i.removeEvent = function (t) {
            var e, i = typeof t, o = this._getEvents();
            if ("string" == i) delete o[t]; else if (t instanceof RegExp) for (e in o) o.hasOwnProperty(e) && t.test(e) && delete o[e]; else delete this._events;
            return this
        }, i.removeAllListeners = e("removeEvent"), i.emitEvent = function (t, e) {
            var i, o, n, r, s = this.getListenersAsObject(t);
            for (n in s) if (s.hasOwnProperty(n)) for (o = s[n].length; o--;) i = s[n][o], !0 === i.once && this.removeListener(t, i.listener), r = i.listener.apply(this, e || []), r === this._getOnceReturnValue() && this.removeListener(t, i.listener);
            return this
        }, i.trigger = e("emitEvent"), i.emit = function (t) {
            var e = Array.prototype.slice.call(arguments, 1);
            return this.emitEvent(t, e)
        }, i.setOnceReturnValue = function (t) {
            return this._onceReturnValue = t, this
        }, i._getOnceReturnValue = function () {
            return !this.hasOwnProperty("_onceReturnValue") || this._onceReturnValue
        }, i._getEvents = function () {
            return this._events || (this._events = {})
        }, t.noConflict = function () {
            return o.EventEmitter = n, t
        }, "function" == typeof define && define.amd ? define("eventEmitter/EventEmitter", [], function () {
            return t
        }) : "object" == typeof module && module.exports ? module.exports = t : o.EventEmitter = t
    }.call(this), function (t) {
        function e(t) {
            if (t) {
                if ("string" == typeof r[t]) return t;
                t = t.charAt(0).toUpperCase() + t.slice(1);
                for (var e, i = 0, o = n.length; i < o; i++) if (e = n[i] + t, "string" == typeof r[e]) return e
            }
        }

        var n = "Webkit Moz ms Ms O".split(" "), r = document.documentElement.style;
        "function" == typeof define && define.amd ? define("get-style-property/get-style-property", [], function () {
            return e
        }) : "object" == typeof exports ? module.exports = e : t.getStyleProperty = e
    }(window), function (L) {
        function x(t) {
            var e = parseFloat(t);
            return -1 === t.indexOf("%") && !isNaN(e) && e
        }

        function t(g) {
            var v, _, I, z = !1;
            return function (t) {
                if (z || (z = !0, y = L.getComputedStyle, m = y ? function (t) {
                    return y(t, null)
                } : function (t) {
                    return t.currentStyle
                }, v = function (t) {
                    t = m(t);
                    return t || E("Style returned " + t + ". Are you running this code in a hidden iframe on Firefox? See http://bit.ly/getsizebug1"), t
                }, (_ = g("boxSizing")) && ((c = document.createElement("div")).style.width = "200px", c.style.padding = "1px 2px 3px 4px", c.style.borderStyle = "solid", c.style.borderWidth = "1px 2px 3px 4px", c.style[_] = "border-box", (l = document.body || document.documentElement).appendChild(c), f = v(c), I = 200 === x(f.width), l.removeChild(c))), (t = "string" == typeof t ? document.querySelector(t) : t) && "object" == typeof t && t.nodeType) {
                    var e = v(t);
                    if ("none" === e.display) return function () {
                        for (var t = {
                            width: 0,
                            height: 0,
                            innerWidth: 0,
                            innerHeight: 0,
                            outerWidth: 0,
                            outerHeight: 0
                        }, e = 0, i = b.length; e < i; e++) t[b[e]] = 0;
                        return t
                    }();
                    var i = {};
                    i.width = t.offsetWidth, i.height = t.offsetHeight;
                    for (var o = i.isBorderBox = !(!_ || !e[_] || "border-box" !== e[_]), n = 0, r = b.length; n < r; n++) {
                        var s = b[n], a = function (t, e) {
                            if (L.getComputedStyle || -1 === e.indexOf("%")) return e;
                            var i = t.style, o = i.left, n = t.runtimeStyle, r = n && n.left;
                            return r && (n.left = t.currentStyle.left), i.left = e, e = i.pixelLeft, i.left = o, r && (n.left = r), e
                        }(t, a = e[s]), a = parseFloat(a);
                        i[s] = isNaN(a) ? 0 : a
                    }
                    var u = i.paddingLeft + i.paddingRight, p = i.paddingTop + i.paddingBottom,
                        h = i.marginLeft + i.marginRight, d = i.marginTop + i.marginBottom,
                        f = i.borderLeftWidth + i.borderRightWidth, l = i.borderTopWidth + i.borderBottomWidth, c = o && I,
                        o = x(e.width);
                    !1 !== o && (i.width = o + (c ? 0 : u + f));
                    o = x(e.height);
                    return !1 !== o && (i.height = o + (c ? 0 : p + l)), i.innerWidth = i.width - (u + f), i.innerHeight = i.height - (p + l), i.outerWidth = i.width + h, i.outerHeight = i.height + d, i
                }
                var y, c, l, f, m
            }
        }

        var E = "undefined" == typeof console ? function () {
            } : function (t) {
                console.error(t)
            },
            b = ["paddingLeft", "paddingRight", "paddingTop", "paddingBottom", "marginLeft", "marginRight", "marginTop", "marginBottom", "borderLeftWidth", "borderRightWidth", "borderTopWidth", "borderBottomWidth"];
        "function" == typeof define && define.amd ? define("get-size/get-size", ["get-style-property/get-style-property"], t) : "object" == typeof exports ? module.exports = t(require("desandro-get-style-property")) : L.getSize = t(L.getStyleProperty)
    }(window), function (e) {
        function i(t) {
            "function" == typeof t && (i.isReady ? t() : s.push(t))
        }

        function o(t) {
            t = "readystatechange" === t.type && "complete" !== r.readyState;
            i.isReady || t || n()
        }

        function n() {
            i.isReady = !0;
            for (var t = 0, e = s.length; t < e; t++) (0, s[t])()
        }

        function t(t) {
            return "complete" === r.readyState ? n() : (t.bind(r, "DOMContentLoaded", o), t.bind(r, "readystatechange", o), t.bind(e, "load", o)), i
        }

        var r = e.document, s = [];
        i.isReady = !1, "function" == typeof define && define.amd ? define("doc-ready/doc-ready", ["eventie/eventie"], t) : "object" == typeof exports ? module.exports = t(require("eventie")) : e.docReady = t(e.eventie)
    }(window), function (n) {
        function i(t, e) {
            return t[o](e)
        }

        function r(t) {
            t.parentNode || document.createDocumentFragment().appendChild(t)
        }

        var t, o = function () {
            if (n.matches) return "matches";
            if (n.matchesSelector) return "matchesSelector";
            for (var t = ["webkit", "moz", "ms", "o"], e = 0, i = t.length; e < i; e++) {
                var o = t[e] + "MatchesSelector";
                if (n[o]) return o
            }
        }();
        t = o ? i(document.createElement("div"), "div") ? i : function (t, e) {
            return r(t), i(t, e)
        } : function (t, e) {
            r(t);
            for (var i = t.parentNode.querySelectorAll(e), o = 0, n = i.length; o < n; o++) if (i[o] === t) return !0;
            return !1
        }, "function" == typeof define && define.amd ? define("matches-selector/matches-selector", [], function () {
            return t
        }) : "object" == typeof exports ? module.exports = t : window.matchesSelector = t
    }(Element.prototype), function (i, o) {
        "function" == typeof define && define.amd ? define("fizzy-ui-utils/utils", ["doc-ready/doc-ready", "matches-selector/matches-selector"], function (t, e) {
            return o(i, t, e)
        }) : "object" == typeof exports ? module.exports = o(i, require("doc-ready"), require("desandro-matches-selector")) : i.fizzyUIUtils = o(i, i.docReady, i.matchesSelector)
    }(window, function (d, t, p) {
        var i, f = {
            extend: function (t, e) {
                for (var i in e) t[i] = e[i];
                return t
            }, modulo: function (t, e) {
                return (t % e + e) % e
            }
        }, e = Object.prototype.toString;
        f.isArray = function (t) {
            return "[object Array]" == e.call(t)
        }, f.makeArray = function (t) {
            var e = [];
            if (f.isArray(t)) e = t; else if (t && "number" == typeof t.length) for (var i = 0, o = t.length; i < o; i++) e.push(t[i]); else e.push(t);
            return e
        }, f.indexOf = Array.prototype.indexOf ? function (t, e) {
            return t.indexOf(e)
        } : function (t, e) {
            for (var i = 0, o = t.length; i < o; i++) if (t[i] === e) return i;
            return -1
        }, f.removeFrom = function (t, e) {
            e = f.indexOf(t, e);
            -1 != e && t.splice(e, 1)
        }, f.isElement = "function" == typeof HTMLElement || "object" == typeof HTMLElement ? function (t) {
            return t instanceof HTMLElement
        } : function (t) {
            return t && "object" == typeof t && 1 == t.nodeType && "string" == typeof t.nodeName
        }, f.setText = function (t, e) {
            t[i = i || (void 0 !== document.documentElement.textContent ? "textContent" : "innerText")] = e
        }, f.getParent = function (t, e) {
            for (; t != document.body;) if (t = t.parentNode, p(t, e)) return t
        }, f.getQueryElement = function (t) {
            return "string" == typeof t ? document.querySelector(t) : t
        }, f.handleEvent = function (t) {
            var e = "on" + t.type;
            this[e] && this[e](t)
        }, f.filterFindElements = function (t, e) {
            for (var i = [], o = 0, n = (t = f.makeArray(t)).length; o < n; o++) {
                var r = t[o];
                if (f.isElement(r)) if (e) {
                    p(r, e) && i.push(r);
                    for (var s = r.querySelectorAll(e), a = 0, u = s.length; a < u; a++) i.push(s[a])
                } else i.push(r)
            }
            return i
        }, f.debounceMethod = function (t, e, o) {
            var n = t.prototype[e], r = e + "Timeout";
            t.prototype[e] = function () {
                var t = this[r];
                t && clearTimeout(t);
                var e = arguments, i = this;
                this[r] = setTimeout(function () {
                    n.apply(i, e), delete i[r]
                }, o || 100)
            }
        }, f.toDashed = function (t) {
            return t.replace(/(.)([A-Z])/g, function (t, e, i) {
                return e + "-" + i
            }).toLowerCase()
        };
        var l = d.console;
        return f.htmlInit = function (p, h) {
            t(function () {
                for (var t = f.toDashed(h), e = document.querySelectorAll(".js-" + t), i = "data-" + t + "-options", o = 0, n = e.length; o < n; o++) {
                    var r, s = e[o], a = s.getAttribute(i);
                    try {
                        r = a && JSON.parse(a)
                    } catch (t) {
                        l && l.error("Error parsing " + i + " on " + s.nodeName.toLowerCase() + (s.id ? "#" + s.id : "") + ": " + t);
                        continue
                    }
                    var u = new p(s, r), a = d.jQuery;
                    a && a.data(s, h, u)
                }
            })
        }, f
    }), function (n, r) {
        "function" == typeof define && define.amd ? define("outlayer/item", ["eventEmitter/EventEmitter", "get-size/get-size", "get-style-property/get-style-property", "fizzy-ui-utils/utils"], function (t, e, i, o) {
            return r(n, t, e, i, o)
        }) : "object" == typeof exports ? module.exports = r(n, require("wolfy87-eventemitter"), require("get-size"), require("desandro-get-style-property"), require("fizzy-ui-utils")) : (n.Outlayer = {}, n.Outlayer.Item = r(n, n.EventEmitter, n.getSize, n.getStyleProperty, n.fizzyUIUtils))
    }(window, function (t, e, i, r, o) {
        function n(t, e) {
            t && (this.element = t, this.layout = e, this.position = {x: 0, y: 0}, this._create())
        }

        var s = t.getComputedStyle, a = s ? function (t) {
            return s(t, null)
        } : function (t) {
            return t.currentStyle
        }, u = r("transition"), p = r("transform"), h = u && p, t = !!r("perspective"), d = {
            WebkitTransition: "webkitTransitionEnd",
            MozTransition: "transitionend",
            OTransition: "otransitionend",
            transition: "transitionend"
        }[u], f = ["transform", "transition", "transitionDuration", "transitionProperty"], l = function () {
            for (var t = {}, e = 0, i = f.length; e < i; e++) {
                var o = f[e], n = r(o);
                n && n !== o && (t[o] = n)
            }
            return t
        }();
        o.extend(n.prototype, e.prototype), n.prototype._create = function () {
            this._transn = {ingProperties: {}, clean: {}, onEnd: {}}, this.css({position: "absolute"})
        }, n.prototype.handleEvent = function (t) {
            var e = "on" + t.type;
            this[e] && this[e](t)
        }, n.prototype.getSize = function () {
            this.size = i(this.element)
        }, n.prototype.css = function (t) {
            var e, i = this.element.style;
            for (e in t) i[l[e] || e] = t[e]
        }, n.prototype.getPosition = function () {
            var t = a(this.element), e = this.layout.options, i = e.isOriginLeft, o = e.isOriginTop,
                n = parseInt(t[i ? "left" : "right"], 10), e = parseInt(t[o ? "top" : "bottom"], 10), n = isNaN(n) ? 0 : n,
                e = isNaN(e) ? 0 : e, t = this.layout.size;
            n -= i ? t.paddingLeft : t.paddingRight, e -= o ? t.paddingTop : t.paddingBottom, this.position.x = n, this.position.y = e
        }, n.prototype.layoutPosition = function () {
            var t = this.layout.size, e = this.layout.options, i = {}, o = e.isOriginLeft ? "paddingLeft" : "paddingRight",
                n = e.isOriginLeft ? "left" : "right", r = e.isOriginLeft ? "right" : "left", o = this.position.x + t[o],
                o = e.percentPosition && !e.isHorizontal ? o / t.width * 100 + "%" : o + "px";
            i[n] = o, i[r] = "";
            n = e.isOriginTop ? "paddingTop" : "paddingBottom", o = e.isOriginTop ? "top" : "bottom", r = e.isOriginTop ? "bottom" : "top", n = this.position.y + t[n], n = e.percentPosition && e.isHorizontal ? n / t.height * 100 + "%" : n + "px";
            i[o] = n, i[r] = "", this.css(i), this.emitEvent("layout", [this])
        };
        var c = t ? function (t, e) {
            return "translate3d(" + t + "px, " + e + "px, 0)"
        } : function (t, e) {
            return "translate(" + t + "px, " + e + "px)"
        };
        n.prototype._transitionTo = function (t, e) {
            this.getPosition();
            var i = this.position.x, o = this.position.y, n = parseInt(t, 10), r = parseInt(e, 10),
                r = n === this.position.x && r === this.position.y;
            this.setPosition(t, e), !r || this.isTransitioning ? (i = t - i, e -= o, i = (o = this.layout.options).isOriginLeft ? i : -i, e = o.isOriginTop ? e : -e, (o = {}).transform = c(i, e), this.transition({
                to: o,
                onTransitionEnd: {transform: this.layoutPosition},
                isCleaning: !0
            })) : this.layoutPosition()
        }, n.prototype.goTo = function (t, e) {
            this.setPosition(t, e), this.layoutPosition()
        }, n.prototype.moveTo = h ? n.prototype._transitionTo : n.prototype.goTo, n.prototype.setPosition = function (t, e) {
            this.position.x = parseInt(t, 10), this.position.y = parseInt(e, 10)
        }, n.prototype._nonTransition = function (t) {
            for (var e in this.css(t.to), t.isCleaning && this._removeStyles(t.to), t.onTransitionEnd) t.onTransitionEnd[e].call(this)
        }, n.prototype._transition = function (t) {
            if (parseFloat(this.layout.options.transitionDuration)) {
                var e, i = this._transn;
                for (e in t.onTransitionEnd) i.onEnd[e] = t.onTransitionEnd[e];
                for (e in t.to) i.ingProperties[e] = !0, t.isCleaning && (i.clean[e] = !0);
                t.from && (this.css(t.from), this.element.offsetHeight, 0), this.enableTransition(t.to), this.css(t.to), this.isTransitioning = !0
            } else this._nonTransition(t)
        };
        var y = p && o.toDashed(p) + ",opacity";
        n.prototype.enableTransition = function () {
            this.isTransitioning || (this.css({
                transitionProperty: y,
                transitionDuration: this.layout.options.transitionDuration
            }), this.element.addEventListener(d, this, !1))
        }, n.prototype.transition = n.prototype[u ? "_transition" : "_nonTransition"], n.prototype.onwebkitTransitionEnd = function (t) {
            this.ontransitionend(t)
        }, n.prototype.onotransitionend = function (t) {
            this.ontransitionend(t)
        };
        var m = {"-webkit-transform": "transform", "-moz-transform": "transform", "-o-transform": "transform"};
        n.prototype.ontransitionend = function (t) {
            var e, i;
            t.target === this.element && (e = this._transn, i = m[t.propertyName] || t.propertyName, delete e.ingProperties[i], function (t) {
                for (var e in t) return;
                return 1
            }(e.ingProperties) && this.disableTransition(), i in e.clean && (this.element.style[t.propertyName] = "", delete e.clean[i]), i in e.onEnd && (e.onEnd[i].call(this), delete e.onEnd[i]), this.emitEvent("transitionEnd", [this]))
        }, n.prototype.disableTransition = function () {
            this.removeTransitionStyles(), this.element.removeEventListener(d, this, !1), this.isTransitioning = !1
        }, n.prototype._removeStyles = function (t) {
            var e, i = {};
            for (e in t) i[e] = "";
            this.css(i)
        };
        var g = {transitionProperty: "", transitionDuration: ""};
        return n.prototype.removeTransitionStyles = function () {
            this.css(g)
        }, n.prototype.removeElem = function () {
            this.element.parentNode.removeChild(this.element), this.css({display: ""}), this.emitEvent("remove", [this])
        }, n.prototype.remove = function () {
            var t;
            u && parseFloat(this.layout.options.transitionDuration) ? ((t = this).once("transitionEnd", function () {
                t.removeElem()
            }), this.hide()) : this.removeElem()
        }, n.prototype.reveal = function () {
            delete this.isHidden, this.css({display: ""});
            var t = this.layout.options, e = {};
            e[this.getHideRevealTransitionEndProperty("visibleStyle")] = this.onRevealTransitionEnd, this.transition({
                from: t.hiddenStyle,
                to: t.visibleStyle,
                isCleaning: !0,
                onTransitionEnd: e
            })
        }, n.prototype.onRevealTransitionEnd = function () {
            this.isHidden || this.emitEvent("reveal")
        }, n.prototype.getHideRevealTransitionEndProperty = function (t) {
            var e, t = this.layout.options[t];
            if (t.opacity) return "opacity";
            for (e in t) return e
        }, n.prototype.hide = function () {
            this.isHidden = !0, this.css({display: ""});
            var t = this.layout.options, e = {};
            e[this.getHideRevealTransitionEndProperty("hiddenStyle")] = this.onHideTransitionEnd, this.transition({
                from: t.visibleStyle,
                to: t.hiddenStyle,
                isCleaning: !0,
                onTransitionEnd: e
            })
        }, n.prototype.onHideTransitionEnd = function () {
            this.isHidden && (this.css({display: "none"}), this.emitEvent("hide"))
        }, n.prototype.destroy = function () {
            this.css({position: "", left: "", right: "", top: "", bottom: "", transition: "", transform: ""})
        }, n
    }), function (r, s) {
        "function" == typeof define && define.amd ? define("outlayer/outlayer", ["eventie/eventie", "eventEmitter/EventEmitter", "get-size/get-size", "fizzy-ui-utils/utils", "./item"], function (t, e, i, o, n) {
            return s(r, t, e, i, o, n)
        }) : "object" == typeof exports ? module.exports = s(r, require("eventie"), require("wolfy87-eventemitter"), require("get-size"), require("fizzy-ui-utils"), require("./item")) : r.Outlayer = s(r, r.eventie, r.EventEmitter, r.getSize, r.fizzyUIUtils, r.Outlayer.Item)
    }(window, function (t, e, i, n, r, o) {
        function s(t, e) {
            var i = r.getQueryElement(t);
            i ? (this.element = i, p && (this.$element = p(this.element)), this.options = r.extend({}, this.constructor.defaults), this.option(e), e = ++h, this.element.outlayerGUID = e, (d[e] = this)._create(), this.options.isInitLayout && this.layout()) : u && u.error("Bad element for " + this.constructor.namespace + ": " + (i || t))
        }

        function a() {
        }

        var u = t.console, p = t.jQuery, h = 0, d = {};
        return s.namespace = "outlayer", s.Item = o, s.defaults = {
            containerStyle: {position: "relative"},
            isInitLayout: !0,
            isOriginLeft: !0,
            isOriginTop: !0,
            isResizeBound: !0,
            isResizingContainer: !0,
            transitionDuration: "0.4s",
            hiddenStyle: {opacity: 0, transform: "scale(0.001)"},
            visibleStyle: {opacity: 1, transform: "scale(1)"}
        }, r.extend(s.prototype, i.prototype), s.prototype.option = function (t) {
            r.extend(this.options, t)
        }, s.prototype._create = function () {
            this.reloadItems(), this.stamps = [], this.stamp(this.options.stamp), r.extend(this.element.style, this.options.containerStyle), this.options.isResizeBound && this.bindResize()
        }, s.prototype.reloadItems = function () {
            this.items = this._itemize(this.element.children)
        }, s.prototype._itemize = function (t) {
            for (var e = this._filterFindItemElements(t), i = this.constructor.Item, o = [], n = 0, r = e.length; n < r; n++) {
                var s = new i(e[n], this);
                o.push(s)
            }
            return o
        }, s.prototype._filterFindItemElements = function (t) {
            return r.filterFindElements(t, this.options.itemSelector)
        }, s.prototype.getItemElements = function () {
            for (var t = [], e = 0, i = this.items.length; e < i; e++) t.push(this.items[e].element);
            return t
        }, s.prototype._init = s.prototype.layout = function () {
            this._resetLayout(), this._manageStamps();
            var t = void 0 !== this.options.isLayoutInstant ? this.options.isLayoutInstant : !this._isLayoutInited;
            this.layoutItems(this.items, t), this._isLayoutInited = !0
        }, s.prototype._resetLayout = function () {
            this.getSize()
        }, s.prototype.getSize = function () {
            this.size = n(this.element)
        }, s.prototype._getMeasurement = function (t, e) {
            var i, o = this.options[t];
            o ? ("string" == typeof o ? i = this.element.querySelector(o) : r.isElement(o) && (i = o), this[t] = i ? n(i)[e] : o) : this[t] = 0
        }, s.prototype.layoutItems = function (t, e) {
            t = this._getItemsForLayout(t), this._layoutItems(t, e), this._postLayout()
        }, s.prototype._getItemsForLayout = function (t) {
            for (var e = [], i = 0, o = t.length; i < o; i++) {
                var n = t[i];
                n.isIgnored || e.push(n)
            }
            return e
        }, s.prototype._layoutItems = function (t, e) {
            if (this._emitCompleteOnItems("layout", t), t && t.length) {
                for (var i = [], o = 0, n = t.length; o < n; o++) {
                    var r = t[o], s = this._getItemLayoutPosition(r);
                    s.item = r, s.isInstant = e || r.isLayoutInstant, i.push(s)
                }
                this._processLayoutQueue(i)
            }
        }, s.prototype._getItemLayoutPosition = function () {
            return {x: 0, y: 0}
        }, s.prototype._processLayoutQueue = function (t) {
            for (var e = 0, i = t.length; e < i; e++) {
                var o = t[e];
                this._positionItem(o.item, o.x, o.y, o.isInstant)
            }
        }, s.prototype._positionItem = function (t, e, i, o) {
            o ? t.goTo(e, i) : t.moveTo(e, i)
        }, s.prototype._postLayout = function () {
            this.resizeContainer()
        }, s.prototype.resizeContainer = function () {
            var t;
            !this.options.isResizingContainer || (t = this._getContainerSize()) && (this._setContainerMeasure(t.width, !0), this._setContainerMeasure(t.height, !1))
        }, s.prototype._getContainerSize = a, s.prototype._setContainerMeasure = function (t, e) {
            var i;
            void 0 !== t && ((i = this.size).isBorderBox && (t += e ? i.paddingLeft + i.paddingRight + i.borderLeftWidth + i.borderRightWidth : i.paddingBottom + i.paddingTop + i.borderTopWidth + i.borderBottomWidth), t = Math.max(t, 0), this.element.style[e ? "width" : "height"] = t + "px")
        }, s.prototype._emitCompleteOnItems = function (t, e) {
            function i() {
                n.emitEvent(t + "Complete", [e])
            }

            function o() {
                ++s === r && i()
            }

            var n = this, r = e.length;
            if (e && r) for (var s = 0, a = 0, u = e.length; a < u; a++) e[a].once(t, o); else i()
        }, s.prototype.ignore = function (t) {
            t = this.getItem(t);
            t && (t.isIgnored = !0)
        }, s.prototype.unignore = function (t) {
            t = this.getItem(t);
            t && delete t.isIgnored
        }, s.prototype.stamp = function (t) {
            if (t = this._find(t)) {
                this.stamps = this.stamps.concat(t);
                for (var e = 0, i = t.length; e < i; e++) {
                    var o = t[e];
                    this.ignore(o)
                }
            }
        }, s.prototype.unstamp = function (t) {
            if (t = this._find(t)) for (var e = 0, i = t.length; e < i; e++) {
                var o = t[e];
                r.removeFrom(this.stamps, o), this.unignore(o)
            }
        }, s.prototype._find = function (t) {
            return t ? ("string" == typeof t && (t = this.element.querySelectorAll(t)), r.makeArray(t)) : void 0
        }, s.prototype._manageStamps = function () {
            if (this.stamps && this.stamps.length) {
                this._getBoundingRect();
                for (var t = 0, e = this.stamps.length; t < e; t++) {
                    var i = this.stamps[t];
                    this._manageStamp(i)
                }
            }
        }, s.prototype._getBoundingRect = function () {
            var t = this.element.getBoundingClientRect(), e = this.size;
            this._boundingRect = {
                left: t.left + e.paddingLeft + e.borderLeftWidth,
                top: t.top + e.paddingTop + e.borderTopWidth,
                right: t.right - (e.paddingRight + e.borderRightWidth),
                bottom: t.bottom - (e.paddingBottom + e.borderBottomWidth)
            }
        }, s.prototype._manageStamp = a, s.prototype._getElementOffset = function (t) {
            var e = t.getBoundingClientRect(), i = this._boundingRect, t = n(t);
            return {
                left: e.left - i.left - t.marginLeft,
                top: e.top - i.top - t.marginTop,
                right: i.right - e.right - t.marginRight,
                bottom: i.bottom - e.bottom - t.marginBottom
            }
        }, s.prototype.handleEvent = function (t) {
            var e = "on" + t.type;
            this[e] && this[e](t)
        }, s.prototype.bindResize = function () {
            this.isResizeBound || (e.bind(t, "resize", this), this.isResizeBound = !0)
        }, s.prototype.unbindResize = function () {
            this.isResizeBound && e.unbind(t, "resize", this), this.isResizeBound = !1
        }, s.prototype.onresize = function () {
            this.resizeTimeout && clearTimeout(this.resizeTimeout);
            var t = this;
            this.resizeTimeout = setTimeout(function () {
                t.resize(), delete t.resizeTimeout
            }, 100)
        }, s.prototype.resize = function () {
            this.isResizeBound && this.needsResizeLayout() && this.layout()
        }, s.prototype.needsResizeLayout = function () {
            var t = n(this.element);
            return this.size && t && t.innerWidth !== this.size.innerWidth
        }, s.prototype.addItems = function (t) {
            t = this._itemize(t);
            return t.length && (this.items = this.items.concat(t)), t
        }, s.prototype.appended = function (t) {
            t = this.addItems(t);
            t.length && (this.layoutItems(t, !0), this.reveal(t))
        }, s.prototype.prepended = function (t) {
            var e = this._itemize(t);
            e.length && (t = this.items.slice(0), this.items = e.concat(t), this._resetLayout(), this._manageStamps(), this.layoutItems(e, !0), this.reveal(e), this.layoutItems(t))
        }, s.prototype.reveal = function (t) {
            this._emitCompleteOnItems("reveal", t);
            for (var e = t && t.length, i = 0; e && i < e; i++) t[i].reveal()
        }, s.prototype.hide = function (t) {
            this._emitCompleteOnItems("hide", t);
            for (var e = t && t.length, i = 0; e && i < e; i++) t[i].hide()
        }, s.prototype.revealItemElements = function (t) {
            t = this.getItems(t);
            this.reveal(t)
        }, s.prototype.hideItemElements = function (t) {
            t = this.getItems(t);
            this.hide(t)
        }, s.prototype.getItem = function (t) {
            for (var e = 0, i = this.items.length; e < i; e++) {
                var o = this.items[e];
                if (o.element === t) return o
            }
        }, s.prototype.getItems = function (t) {
            for (var e = [], i = 0, o = (t = r.makeArray(t)).length; i < o; i++) {
                var n = t[i], n = this.getItem(n);
                n && e.push(n)
            }
            return e
        }, s.prototype.remove = function (t) {
            var e = this.getItems(t);
            if (this._emitCompleteOnItems("remove", e), e && e.length) for (var i = 0, o = e.length; i < o; i++) {
                var n = e[i];
                n.remove(), r.removeFrom(this.items, n)
            }
        }, s.prototype.destroy = function () {
            var t = this.element.style;
            t.height = "", t.position = "", t.width = "";
            for (var e = 0, i = this.items.length; e < i; e++) this.items[e].destroy();
            this.unbindResize();
            t = this.element.outlayerGUID;
            delete d[t], delete this.element.outlayerGUID, p && p.removeData(this.element, this.constructor.namespace)
        }, s.data = function (t) {
            t = (t = r.getQueryElement(t)) && t.outlayerGUID;
            return t && d[t]
        }, s.create = function (t, e) {
            function i() {
                s.apply(this, arguments)
            }

            return Object.create ? i.prototype = Object.create(s.prototype) : r.extend(i.prototype, s.prototype), (i.prototype.constructor = i).defaults = r.extend({}, s.defaults), r.extend(i.defaults, e), i.prototype.settings = {}, i.namespace = t, i.data = s.data, (i.Item = function () {
                o.apply(this, arguments)
            }).prototype = new o, r.htmlInit(i, t), p && p.bridget && p.bridget(t, i), i
        }, s.Item = o, s
    }), function (t, e) {
        "function" == typeof define && define.amd ? define("isotope/js/item", ["outlayer/outlayer"], e) : "object" == typeof exports ? module.exports = e(require("outlayer")) : (t.Isotope = t.Isotope || {}, t.Isotope.Item = e(t.Outlayer))
    }(window, function (t) {
        function e() {
            t.Item.apply(this, arguments)
        }

        (e.prototype = new t.Item)._create = function () {
            this.id = this.layout.itemGUID++, t.Item.prototype._create.call(this), this.sortData = {}
        }, e.prototype.updateSortData = function () {
            if (!this.isIgnored) {
                this.sortData.id = this.id, this.sortData["original-order"] = this.id, this.sortData.random = Math.random();
                var t, e = this.layout.options.getSortData, i = this.layout._sorters;
                for (t in e) {
                    var o = i[t];
                    this.sortData[t] = o(this.element, this)
                }
            }
        };
        var i = e.prototype.destroy;
        return e.prototype.destroy = function () {
            i.apply(this, arguments), this.css({display: ""})
        }, e
    }), function (t, e) {
        "function" == typeof define && define.amd ? define("isotope/js/layout-mode", ["get-size/get-size", "outlayer/outlayer"], e) : "object" == typeof exports ? module.exports = e(require("get-size"), require("outlayer")) : (t.Isotope = t.Isotope || {}, t.Isotope.LayoutMode = e(t.getSize, t.Outlayer))
    }(window, function (e, n) {
        function r(t) {
            (this.isotope = t) && (this.options = t.options[this.namespace], this.element = t.element, this.items = t.filteredItems, this.size = t.size)
        }

        return function () {
            for (var t = ["_resetLayout", "_getItemLayoutPosition", "_manageStamp", "_getContainerSize", "_getElementOffset", "needsResizeLayout"], e = 0, i = t.length; e < i; e++) {
                var o = t[e];
                r.prototype[o] = function (t) {
                    return function () {
                        return n.prototype[t].apply(this.isotope, arguments)
                    }
                }(o)
            }
        }(), r.prototype.needsVerticalResizeLayout = function () {
            var t = e(this.isotope.element);
            return this.isotope.size && t && t.innerHeight != this.isotope.size.innerHeight
        }, r.prototype._getMeasurement = function () {
            this.isotope._getMeasurement.apply(this, arguments)
        }, r.prototype.getColumnWidth = function () {
            this.getSegmentSize("column", "Width")
        }, r.prototype.getRowHeight = function () {
            this.getSegmentSize("row", "Height")
        }, r.prototype.getSegmentSize = function (t, e) {
            var i = t + e, o = "outer" + e;
            this._getMeasurement(i, o), this[i] || (t = this.getFirstItemSize(), this[i] = t && t[o] || this.isotope.size["inner" + e])
        }, r.prototype.getFirstItemSize = function () {
            var t = this.isotope.filteredItems[0];
            return t && t.element && e(t.element)
        }, r.prototype.layout = function () {
            this.isotope.layout.apply(this.isotope, arguments)
        }, r.prototype.getSize = function () {
            this.isotope.getSize(), this.size = this.isotope.size
        }, r.modes = {}, r.create = function (t, e) {
            function i() {
                r.apply(this, arguments)
            }

            return i.prototype = new r, e && (i.options = e), r.modes[i.prototype.namespace = t] = i
        }, r
    }), function (t, e) {
        "function" == typeof define && define.amd ? define("masonry/masonry", ["outlayer/outlayer", "get-size/get-size", "fizzy-ui-utils/utils"], e) : "object" == typeof exports ? module.exports = e(require("outlayer"), require("get-size"), require("fizzy-ui-utils")) : t.Masonry = e(t.Outlayer, t.getSize, t.fizzyUIUtils)
    }(window, function (t, a, u) {
        t = t.create("masonry");
        return t.prototype._resetLayout = function () {
            this.getSize(), this._getMeasurement("columnWidth", "outerWidth"), this._getMeasurement("gutter", "outerWidth"), this.measureColumns();
            var t = this.cols;
            for (this.colYs = []; t--;) this.colYs.push(0);
            this.maxY = 0
        }, t.prototype.measureColumns = function () {
            this.getContainerWidth(), this.columnWidth || (i = (e = this.items[0]) && e.element, this.columnWidth = i && a(i).outerWidth || this.containerWidth);
            var t = this.columnWidth += this.gutter, e = this.containerWidth + this.gutter, i = e / t, t = t - e % t,
                i = Math[t && t < 1 ? "round" : "floor"](i);
            this.cols = Math.max(i, 1)
        }, t.prototype.getContainerWidth = function () {
            var t = this.options.isFitWidth ? this.element.parentNode : this.element, t = a(t);
            this.containerWidth = t && t.innerWidth
        }, t.prototype._getItemLayoutPosition = function (t) {
            t.getSize();
            for (var e = t.size.outerWidth % this.columnWidth, i = Math[e && e < 1 ? "round" : "ceil"](t.size.outerWidth / this.columnWidth), i = Math.min(i, this.cols), o = this._getColGroup(i), e = Math.min.apply(Math, o), n = u.indexOf(o, e), i = {
                x: this.columnWidth * n,
                y: e
            }, r = e + t.size.outerHeight, s = this.cols + 1 - o.length, a = 0; a < s; a++) this.colYs[n + a] = r;
            return i
        }, t.prototype._getColGroup = function (t) {
            if (t < 2) return this.colYs;
            for (var e = [], i = this.cols + 1 - t, o = 0; o < i; o++) {
                var n = this.colYs.slice(o, o + t);
                e[o] = Math.max.apply(Math, n)
            }
            return e
        }, t.prototype._manageStamp = function (t) {
            var e = a(t), i = this._getElementOffset(t), o = this.options.isOriginLeft ? i.left : i.right,
                t = o + e.outerWidth, o = Math.floor(o / this.columnWidth), o = Math.max(0, o),
                n = Math.floor(t / this.columnWidth);
            n -= t % this.columnWidth ? 0 : 1;
            for (var n = Math.min(this.cols - 1, n), r = (this.options.isOriginTop ? i.top : i.bottom) + e.outerHeight, s = o; s <= n; s++) this.colYs[s] = Math.max(r, this.colYs[s])
        }, t.prototype._getContainerSize = function () {
            this.maxY = Math.max.apply(Math, this.colYs);
            var t = {height: this.maxY};
            return this.options.isFitWidth && (t.width = this._getContainerFitWidth()), t
        }, t.prototype._getContainerFitWidth = function () {
            for (var t = 0, e = this.cols; --e && 0 === this.colYs[e];) t++;
            return (this.cols - t) * this.columnWidth - this.gutter
        }, t.prototype.needsResizeLayout = function () {
            var t = this.containerWidth;
            return this.getContainerWidth(), t !== this.containerWidth
        }, t
    }), function (t, e) {
        "function" == typeof define && define.amd ? define("isotope/js/layout-modes/masonry", ["../layout-mode", "masonry/masonry"], e) : "object" == typeof exports ? module.exports = e(require("../layout-mode"), require("masonry-layout")) : e(t.Isotope.LayoutMode, t.Masonry)
    }(window, function (t, e) {
        var i = t.create("masonry"), o = i.prototype._getElementOffset, n = i.prototype.layout,
            t = i.prototype._getMeasurement;
        (function (t, e) {
            for (var i in e) t[i] = e[i]
        })(i.prototype, e.prototype), i.prototype._getElementOffset = o, i.prototype.layout = n, i.prototype._getMeasurement = t;
        var r = i.prototype.measureColumns;
        i.prototype.measureColumns = function () {
            this.items = this.isotope.filteredItems, r.call(this)
        };
        var s = i.prototype._manageStamp;
        return i.prototype._manageStamp = function () {
            this.options.isOriginLeft = this.isotope.options.isOriginLeft, this.options.isOriginTop = this.isotope.options.isOriginTop, s.apply(this, arguments)
        }, i
    }), function (t, e) {
        "function" == typeof define && define.amd ? define("isotope/js/layout-modes/fit-rows", ["../layout-mode"], e) : "object" == typeof exports ? module.exports = e(require("../layout-mode")) : e(t.Isotope.LayoutMode)
    }(window, function (t) {
        t = t.create("fitRows");
        return t.prototype._resetLayout = function () {
            this.x = 0, this.y = 0, this.maxY = 0, this._getMeasurement("gutter", "outerWidth")
        }, t.prototype._getItemLayoutPosition = function (t) {
            t.getSize();
            var e = t.size.outerWidth + this.gutter, i = this.isotope.size.innerWidth + this.gutter;
            0 !== this.x && e + this.x > i && (this.x = 0, this.y = this.maxY);
            i = {x: this.x, y: this.y};
            return this.maxY = Math.max(this.maxY, this.y + t.size.outerHeight), this.x += e, i
        }, t.prototype._getContainerSize = function () {
            return {height: this.maxY}
        }, t
    }), function (t, e) {
        "function" == typeof define && define.amd ? define("isotope/js/layout-modes/vertical", ["../layout-mode"], e) : "object" == typeof exports ? module.exports = e(require("../layout-mode")) : e(t.Isotope.LayoutMode)
    }(window, function (t) {
        t = t.create("vertical", {horizontalAlignment: 0});
        return t.prototype._resetLayout = function () {
            this.y = 0
        }, t.prototype._getItemLayoutPosition = function (t) {
            t.getSize();
            var e = (this.isotope.size.innerWidth - t.size.outerWidth) * this.options.horizontalAlignment, i = this.y;
            return this.y += t.size.outerHeight, {x: e, y: i}
        }, t.prototype._getContainerSize = function () {
            return {height: this.y}
        }, t
    }), function (s, a) {
        "function" == typeof define && define.amd ? define(["outlayer/outlayer", "get-size/get-size", "matches-selector/matches-selector", "fizzy-ui-utils/utils", "isotope/js/item", "isotope/js/layout-mode", "isotope/js/layout-modes/masonry", "isotope/js/layout-modes/fit-rows", "isotope/js/layout-modes/vertical"], function (t, e, i, o, n, r) {
            return a(s, t, 0, i, o, n, r)
        }) : "object" == typeof exports ? module.exports = a(s, require("outlayer"), require("get-size"), require("desandro-matches-selector"), require("fizzy-ui-utils"), require("./item"), require("./layout-mode"), require("./layout-modes/masonry"), require("./layout-modes/fit-rows"), require("./layout-modes/vertical")) : s.Isotope = a(s, s.Outlayer, s.getSize, s.matchesSelector, s.fizzyUIUtils, s.Isotope.Item, s.Isotope.LayoutMode)
    }(window, function (t, o, e, i, r, n, s) {
        var a = t.jQuery, u = String.prototype.trim ? function (t) {
            return t.trim()
        } : function (t) {
            return t.replace(/^\s+|\s+$/g, "")
        }, p = document.documentElement.textContent ? function (t) {
            return t.textContent
        } : function (t) {
            return t.innerText
        }, h = o.create("isotope", {layoutMode: "masonry", isJQueryFiltering: !0, sortAscending: !0});
        h.Item = n, h.LayoutMode = s, h.prototype._create = function () {
            for (var t in this.itemGUID = 0, this._sorters = {}, this._getSorters(), o.prototype._create.call(this), this.modes = {}, this.filteredItems = this.items, this.sortHistory = ["original-order"], s.modes) this._initLayoutMode(t)
        }, h.prototype.reloadItems = function () {
            this.itemGUID = 0, o.prototype.reloadItems.call(this)
        }, h.prototype._itemize = function () {
            for (var t = o.prototype._itemize.apply(this, arguments), e = 0, i = t.length; e < i; e++) t[e].id = this.itemGUID++;
            return this._updateItemsSortData(t), t
        }, h.prototype._initLayoutMode = function (t) {
            var e = s.modes[t], i = this.options[t] || {};
            this.options[t] = e.options ? r.extend(e.options, i) : i, this.modes[t] = new e(this)
        }, h.prototype.layout = function () {
            return !this._isLayoutInited && this.options.isInitLayout ? void this.arrange() : void this._layout()
        }, h.prototype._layout = function () {
            var t = this._getIsInstant();
            this._resetLayout(), this._manageStamps(), this.layoutItems(this.filteredItems, t), this._isLayoutInited = !0
        }, h.prototype.arrange = function (t) {
            function e() {
                o.reveal(i.needReveal), o.hide(i.needHide)
            }

            this.option(t), this._getIsInstant();
            var i = this._filter(this.items);
            this.filteredItems = i.matches;
            var o = this;
            this._bindArrangeComplete(), this._isInstant ? this._noTransition(e) : e(), this._sort(), this._layout()
        }, h.prototype._init = h.prototype.arrange, h.prototype._getIsInstant = function () {
            var t = void 0 !== this.options.isLayoutInstant ? this.options.isLayoutInstant : !this._isLayoutInited;
            return this._isInstant = t
        }, h.prototype._bindArrangeComplete = function () {
            function t() {
                e && i && o && n.emitEvent("arrangeComplete", [n.filteredItems])
            }

            var e, i, o, n = this;
            this.once("layoutComplete", function () {
                e = !0, t()
            }), this.once("hideComplete", function () {
                i = !0, t()
            }), this.once("revealComplete", function () {
                o = !0, t()
            })
        }, h.prototype._filter = function (t) {
            for (var e = this.options.filter, i = [], o = [], n = [], r = this._getFilterTest(e = e || "*"), s = 0, a = t.length; s < a; s++) {
                var u, p = t[s];
                p.isIgnored || ((u = r(p)) && i.push(p), u && p.isHidden ? o.push(p) : u || p.isHidden || n.push(p))
            }
            return {matches: i, needReveal: o, needHide: n}
        }, h.prototype._getFilterTest = function (e) {
            return a && this.options.isJQueryFiltering ? function (t) {
                return a(t.element).is(e)
            } : "function" == typeof e ? function (t) {
                return e(t.element)
            } : function (t) {
                return i(t.element, e)
            }
        }, h.prototype.updateSortData = function (t) {
            t = t ? (t = r.makeArray(t), this.getItems(t)) : this.items;
            this._getSorters(), this._updateItemsSortData(t)
        }, h.prototype._getSorters = function () {
            var t, e = this.options.getSortData;
            for (t in e) {
                var i = e[t];
                this._sorters[t] = d(i)
            }
        }, h.prototype._updateItemsSortData = function (t) {
            for (var e = t && t.length, i = 0; e && i < e; i++) t[i].updateSortData()
        };
        var d = function (t) {
            if ("string" != typeof t) return t;
            var e, i, o = u(t).split(" "), n = o[0], t = (t = n.match(/^\[(.+)\]$/)) && t[1],
                r = (i = n, (e = t) ? function (t) {
                    return t.getAttribute(e)
                } : function (t) {
                    t = t.querySelector(i);
                    return t && p(t)
                }), s = h.sortDataParsers[o[1]];
            return s ? function (t) {
                return t && s(r(t))
            } : function (t) {
                return t && r(t)
            }
        };
        h.sortDataParsers = {
            parseInt: function (t) {
                return parseInt(t, 10)
            }, parseFloat: function (t) {
                return parseFloat(t)
            }
        }, h.prototype._sort = function () {
            var t, a, u, e = this.options.sortBy;
            e && (t = [].concat.apply(e, this.sortHistory), a = t, u = this.options.sortAscending, this.filteredItems.sort(function (t, e) {
                for (var i = 0, o = a.length; i < o; i++) {
                    var n = a[i], r = t.sortData[n], s = e.sortData[n];
                    if (s < r || r < s) return (s < r ? 1 : -1) * ((void 0 !== u[n] ? u[n] : u) ? 1 : -1)
                }
                return 0
            }), e != this.sortHistory[0] && this.sortHistory.unshift(e))
        }, h.prototype._mode = function () {
            var t = this.options.layoutMode, e = this.modes[t];
            if (!e) throw Error("No layout mode: " + t);
            return e.options = this.options[t], e
        }, h.prototype._resetLayout = function () {
            o.prototype._resetLayout.call(this), this._mode()._resetLayout()
        }, h.prototype._getItemLayoutPosition = function (t) {
            return this._mode()._getItemLayoutPosition(t)
        }, h.prototype._manageStamp = function (t) {
            this._mode()._manageStamp(t)
        }, h.prototype._getContainerSize = function () {
            return this._mode()._getContainerSize()
        }, h.prototype.needsResizeLayout = function () {
            return this._mode().needsResizeLayout()
        }, h.prototype.appended = function (t) {
            t = this.addItems(t);
            t.length && (t = this._filterRevealAdded(t), this.filteredItems = this.filteredItems.concat(t))
        }, h.prototype.prepended = function (t) {
            var e = this._itemize(t);
            e.length && (this._resetLayout(), this._manageStamps(), t = this._filterRevealAdded(e), this.layoutItems(this.filteredItems), this.filteredItems = t.concat(this.filteredItems), this.items = e.concat(this.items))
        }, h.prototype._filterRevealAdded = function (t) {
            t = this._filter(t);
            return this.hide(t.needHide), this.reveal(t.matches), this.layoutItems(t.matches, !0), t.matches
        }, h.prototype.insert = function (t) {
            var e = this.addItems(t);
            if (e.length) {
                for (var i, o = e.length, n = 0; n < o; n++) i = e[n], this.element.appendChild(i.element);
                t = this._filter(e).matches;
                for (n = 0; n < o; n++) e[n].isLayoutInstant = !0;
                for (this.arrange(), n = 0; n < o; n++) delete e[n].isLayoutInstant;
                this.reveal(t)
            }
        };
        var f = h.prototype.remove;
        return h.prototype.remove = function (t) {
            t = r.makeArray(t);
            var e = this.getItems(t);
            f.call(this, t);
            var i = e && e.length;
            if (i) for (var o = 0; o < i; o++) {
                var n = e[o];
                r.removeFrom(this.filteredItems, n)
            }
        }, h.prototype.shuffle = function () {
            for (var t = 0, e = this.items.length; t < e; t++) this.items[t].sortData.random = Math.random();
            this.options.sortBy = "random", this._sort(), this._layout()
        }, h.prototype._noTransition = function (t) {
            var e = this.options.transitionDuration;
            this.options.transitionDuration = 0;
            t = t.call(this);
            return this.options.transitionDuration = e, t
        }, h.prototype.getFilteredItemElements = function () {
            for (var t = [], e = 0, i = this.filteredItems.length; e < i; e++) t.push(this.filteredItems[e].element);
            return t
        }, h
    });
} else {
    console.error('EventEmitter is not defined');
}
