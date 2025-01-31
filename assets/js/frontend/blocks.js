! function(e) {
    var t = {};

    function n(r) {
        if (t[r]) return t[r].exports;
        var o = t[r] = {
            i: r,
            l: !1,
            exports: {}
        };
        return e[r].call(o.exports, o, o.exports, n), o.l = !0, o.exports
    }
    n.m = e, n.c = t, n.d = function(e, t, r) {
        n.o(e, t) || Object.defineProperty(e, t, {
            enumerable: !0,
            get: r
        })
    }, n.r = function(e) {
        "undefined" != typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }, n.t = function(e, t) {
        if (1 & t && (e = n(e)), 8 & t) return e;
        if (4 & t && "object" == typeof e && e && e.__esModule) return e;
        var r = Object.create(null);
        if (n.r(r), Object.defineProperty(r, "default", {
                enumerable: !0,
                value: e
            }), 2 & t && "string" != typeof e)
            for (var o in e) n.d(r, o, function(t) {
                return e[t]
            }.bind(null, o));
        return r
    }, n.n = function(e) {
        var t = e && e.__esModule ? function() {
            return e.default
        } : function() {
            return e
        };
        return n.d(t, "a", t), t
    }, n.o = function(e, t) {
        return Object.prototype.hasOwnProperty.call(e, t)
    }, n.p = "", n(n.s = 5)
}([function(e, t) {
    e.exports = window.wp.element
}, function(e, t) {
    e.exports = window.wp.htmlEntities
}, function(e, t) {
    e.exports = window.wc.wcBlocksRegistry
}, function(e, t) {
    e.exports = window.wp.i18n
}, function(e, t) {
    e.exports = window.wc.wcSettings
}, function(e, t, n) {
    "use strict";
    n.r(t);
    var r = n(0),
        o = n(2),
        i = n(3),
        c = n(4),
        l = n(1);
    const u = Object(c.getSetting)("iris_data", {}),
        s = Object(i.__)("Iris Payment", "wc-iris-gateway"),
        a = Object(l.decodeEntities)(u.title) || s,
        d = () => Object(l.decodeEntities)(u.description || ""),
        p = {
            name: "iris",
            label: Object(r.createElement)(e => {
                const {
                    PaymentMethodLabel: t
                } = e.components;
                return Object(r.createElement)(t, {
                    text: a
                })
            }, null),
            content: Object(r.createElement)(d, null),
            edit: Object(r.createElement)(d, null),
            canMakePayment: e => {
                let {
                    cartNeedsShipping: t,
                    selectedShippingMethods: n
                } = e;
                const r = u.enableForUserRoles.includes(u.currentUserRole[0]);
                if (u.enableForUserRoles.length && !1 === r) return !1;
                if (!u.enableForVirtual && !t) return !1;
                if (!u.enableForShippingMethods.length) return !0;
                const o = Object.values(n);
                return !1 !== u.enableForShippingMethods.some(e => o.some(t => t.includes(e))) || void 0
            },
            ariaLabel: a,
            supports: {
                features: u.supports
            }
        };
    Object(o.registerPaymentMethod)(p)
}]);