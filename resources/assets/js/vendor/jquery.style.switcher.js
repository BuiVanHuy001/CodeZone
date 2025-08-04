(function ($) {
    var jStyleSwitcher,
        _defaultOptions = {
            hasPreview: true,
            defaultThemeId: "jssDefault",
            fullPath: "css/",
            cookie: {
                expires: "",
                isManagingLoad: true,
            },
        },
        _cookieKey = "jss_selected",
        _docCookies = {};
    _docCookies = {
        getItem: function (sKey) {
            if (!sKey) {
                return null;
            }
            return (
                decodeURIComponent(
                    document.cookie.replace(
                        new RegExp(
                            "(?:(?:^|.*;)\\s*" +
                            encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") +
                            "\\s*\\=\\s*([^;]*).*$)|^.*$"
                        ),
                        "$1"
                    )
                ) || null
            );
        },
        setItem: function (sKey, sValue, vEnd, sPath, sDomain, bSecure) {
            if (!sKey || /^(?:expires|max\-age|path|domain|secure)$/i.test(sKey)) {
                return false;
            }
            var sExpires = "";
            if (vEnd) {
                switch (vEnd.constructor) {
                    case Number:
                        sExpires =
                            vEnd === Infinity
                                ? "; expires=Fri, 31 Dec 9999 23:59:59 GMT"
                                : "; max-age=" + vEnd;
                        break;
                    case String:
                        sExpires = "; expires=" + vEnd;
                        break;
                    case Date:
                        sExpires = "; expires=" + vEnd.toUTCString();
                        break;
                }
            }
            document.cookie =
                encodeURIComponent(sKey) +
                "=" +
                encodeURIComponent(sValue) +
                sExpires +
                (sDomain ? "; domain=" + sDomain : "") +
                (sPath ? "; path=" + sPath : "") +
                (bSecure ? "; secure" : "");
            return true;
        },
        removeItem: function (sKey, sPath, sDomain) {
            if (!this.hasItem(sKey)) {
                return false;
            }
            document.cookie =
                encodeURIComponent(sKey) +
                "=; expires=Thu, 01 Jan 1970 00:00:00 GMT" +
                (sDomain ? "; domain=" + sDomain : "") +
                (sPath ? "; path=" + sPath : "");
            return true;
        },
        hasItem: function (sKey) {
            if (!sKey) {
                return false;
            }
            return new RegExp(
                "(?:^|;\\s*)" +
                encodeURIComponent(sKey).replace(/[\-\.\+\*]/g, "\\$&") +
                "\\s*\\="
            ).test(document.cookie);
        },
        keys: function () {
            var aKeys = document.cookie
                .replace(/((?:^|\s*;)[^\=]+)(?=;|$)|^\s*|\s*(?:\=[^;]*)?(?:\1|$)/g, "")
                .split(/\s*(?:\=[^;]*)?;\s*/);
            for (var nLen = aKeys.length, nIdx = 0; nIdx < nLen; nIdx++) {
                aKeys[nIdx] = decodeURIComponent(aKeys[nIdx]);
            }
            return aKeys;
        },
    };

    jStyleSwitcher = function ($root, config) {
        return this.init($root, config);
    };

    jStyleSwitcher.prototype = {
        /**
         * {Object} DOM reference to style option list
         */
        $root: null,

        /**
         * {Object} configs for the style switcher
         */
        config: {},

        /**
         * {Object} jQuery reference to <link> tag for swapping CSS
         */
        $themeCss: null,

        /**
         * {String} default theme page was loaded with
         */
        defaultTheme: null,

        init: function ($root, config) {
            this.$root = $root;
            this.config = config ? config : {};
            this.setDefaultTheme();
            if (this.defaultTheme) {
                // try cookies
                if (this.config.cookie) {
                    this.checkCookie();
                }
                // try hover
                if (this.config.hasPreview) {
                    this.addHoverEvents();
                }
                // finally, add click events
                this.addClickEvents();
            } else {
                this.$root.addClass("jssError error level0");
            }
        },

        setDefaultTheme: function () {
            this.$themeCss = $("link[id=" + this.config.defaultThemeId + "]");
            if (this.$themeCss.length) {
                this.defaultTheme = this.$themeCss.attr("href");
            }
        },

        resetStyle: function () {
            this.updateStyle(this.defaultTheme);
        },

        updateStyle: function (newStyle) {
            this.$themeCss.attr("href", newStyle);
        },

        getFullAssetPath: function (asset) {
            return this.config.fullPath + asset + ".css";
        },

        checkCookie: function () {
            var styleCookie;
            // if using cookies and using JavaScript to load css
            if (this.config.cookie && this.config.cookie.isManagingLoad) {
                // check if css is set in cookie
                styleCookie = _docCookies.getItem(_cookieKey);
                if (styleCookie) {
                    newStyle = this.getFullAssetPath(styleCookie);
                    // update link tag
                    this.updateStyle(newStyle);
                    // update default ref
                    this.defaultTheme = newStyle;
                }
            }
        },

        addHoverEvents: function () {
            var self = this;
            this.$root.find("a").hover(
                function () {
                    var asset = $(this).data("theme"),
                        newStyle = self.getFullAssetPath(asset);
                    // update link tag
                    self.updateStyle(newStyle);
                },
                function () {
                    // reset link tag
                    self.resetStyle();
                }
            );
        },

        addClickEvents: function () {
            var self = this;
            this.$root.find(".setColor").on("click", function () {
                var asset = $(this).data("theme"),
                    newStyle = self.getFullAssetPath(asset);
                // update link tag
                self.updateStyle(newStyle);
                // update default ref
                self.defaultTheme = newStyle;
                // try to store cookie
                if (self.config.cookie) {
                    _docCookies.setItem(
                        _cookieKey,
                        asset,
                        self.config.cookie.expires,
                        "/"
                    );
                }
            });
        },
    };

    $.fn.styleSwitcher = function (options) {
        return new jStyleSwitcher(this, $.extend(true, _defaultOptions, options));
    };

    function createCookie(name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }
        document.cookie =
            encodeURIComponent(name) +
            "=" +
            encodeURIComponent(value) +
            expires +
            "; path=/";
    }

    function readCookie(name) {
        var nameEQ = encodeURIComponent(name) + "=";
        var ca = document.cookie.split(";");
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) === " ") c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0)
                return decodeURIComponent(c.substring(nameEQ.length, c.length));
        }
        return null;
    }

    function eraseCookie(name) {
        createCookie(name, "", -1);
    }

    $(function () {
        function setStyleCookie() {
            let styleCookieVal = $("body").hasClass("active-dark-mode")
                ? "dark"
                : "light";
            Cookies.set("styleCookieName", styleCookieVal, {expires: 7});
            // Cookies.set('styleCookieName', styleCookieVal);
        }

        if (Cookies.get("styleCookieName") === "dark") {
            $("body").addClass("active-dark-mode");
        } else if (Cookies.get("styleCookieName") === "light") {
            $("body").removeClass("active-light-mode");
        } else {
            $("body").removeClass("active-light-mode");
        }

        // Check Cookie
        // eraseCookie('jss_selected');
        var activeStyle = Cookies.get("styleCookieName");
        if (activeStyle === "dark") {
            $("#my_switcher").find(".setColor.dark").addClass("active");
            $("body").removeClass("active-light-mode").addClass("active-dark-mode");
            $("body").attr("data-theme", "dark");
        } else if (activeStyle === "light") {
            $("#my_switcher").find(".setColor.light").addClass("active");
            $("body").removeClass("active-dark-mode").addClass("active-light-mode");
            $("body").attr("data-theme", "light");
        } else {
            if ($("body").hasClass("active-dark-mode")) {
                $("#my_switcher").find(".setColor.light").removeClass("active");
                $("#my_switcher").find(".setColor.dark").addClass("active");
            } else {
                $("#my_switcher").find(".setColor.dark").removeClass("active");
                $("#my_switcher").find(".setColor.light").addClass("active");
            }
        }
        // Set Click
        $("#my_switcher .setColor").on("click", function () {
            $(this)
                .closest("ul")
                .find("li")
                .siblings()
                .find(".active")
                .removeClass("active");
            $(this).addClass("active");
            setStyleCookie();
        });

        $("#my_switcher .setColor.dark").on("click", function () {
            $("body").removeClass("active-light-mode").addClass("active-dark-mode");
            $("body").attr("data-theme", "dark");
            setStyleCookie();
        });
        $("#my_switcher .setColor.light").on("click", function () {
            $("body").removeClass("active-dark-mode").addClass("active-light-mode");
            $("body").attr("data-theme", "light");
            setStyleCookie();
        });
    });
})(jQuery);
