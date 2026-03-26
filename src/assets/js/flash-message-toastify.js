(function (global) {
  "use strict";

  function safeJsonParse(value, fallback) {
    if (typeof value !== "string" || value.trim() === "") return fallback;
    try {
      return JSON.parse(value);
    } catch (e) {
      return fallback;
    }
  }

  function buildColorMap(options) {
    var colorMap = {
      success: "linear-gradient(to right, #00b09b, #96c93d)",
      error: "linear-gradient(to right, #ff5f6d, #ffc371)",
      danger: "linear-gradient(to right, #ff5f6d, #ffc371)",
      warning: "linear-gradient(to right, #f7971e, #ffd200)",
      info: "linear-gradient(to right, #2193b0, #6dd5ed)",
      default: "#333",
    };

    if (options && typeof options.alertTypes === "object" && options.alertTypes) {
      Object.assign(colorMap, options.alertTypes);
    }
    if (global.toastColorOverrides && typeof global.toastColorOverrides === "object") {
      Object.assign(colorMap, global.toastColorOverrides);
    }
    if (options && typeof options.colors === "object" && options.colors) {
      Object.assign(colorMap, options.colors);
    }

    return colorMap;
  }

  function showToastsFromElement(el) {
    if (!el) return;
    if (typeof global.Toastify !== "function") return;

    var toasts = safeJsonParse(el.getAttribute("data-toasts"), []);
    console.debug("FlashMessage toasts found:", toasts); //production remove
    if (!Array.isArray(toasts) || toasts.length === 0) return;

    var options = safeJsonParse(el.getAttribute("data-options"), {}) || {};
    var colorMap = buildColorMap(options);

    // Consume once to prevent duplicate toasts on subsequent PJAX events.
    el.setAttribute("data-toasts", "[]");

    toasts.forEach(function (t) {
      if (!t || typeof t.text !== "string") return;
      var background = colorMap[t.type] || colorMap.default;

      global.Toastify({
        text: t.text,
        duration: typeof t.duration === "number" ? t.duration : 4000,
        gravity: options.gravity || "top",
        position: options.position || "right",
        close: !!options.close,
        offset: options.offset || { x: 0, y: 0 },
        stopOnFocus: options.stopOnFocus !== false,
        style: { background: background },
      }).showToast();
    });
  }

  function scanAndShow(root) {
    var scope = root || document;
    var nodes = scope.querySelectorAll(".portalium-flash-toastify[data-toasts]");
    for (var i = 0; i < nodes.length; i++) showToastsFromElement(nodes[i]);
  }

  // Initial page load
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function () {
      scanAndShow(document);
    });
  } else {
    scanAndShow(document);
  }

  // PJAX updates (Yii2 triggers jQuery events)
  if (global.jQuery) {
    global.jQuery(document).on("pjax:end", function (event, xhr, options) {
      if (options && options.container) {
        var container = document.querySelector(options.container);
        if (container) {
          scanAndShow(container);
          return;
        }
      }
      // Fallback: scan whole doc
      scanAndShow(document);
    });
  }

  global.portaliumFlashToastify = global.portaliumFlashToastify || {};
  global.portaliumFlashToastify.scanAndShow = scanAndShow;

  global.portaliumFlashToastify.showToasts = function (toasts, options) {
    var elFake = document.createElement("div");
    elFake.setAttribute("data-toasts", JSON.stringify(toasts || []));
    elFake.setAttribute("data-options", JSON.stringify(options || {}));
    showToastsFromElement(elFake);
  };
})(window);

