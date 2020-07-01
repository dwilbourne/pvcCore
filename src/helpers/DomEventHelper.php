<?php

namespace pvc\helpers;

/**
 *
 * class DOMEventHelper.  Assists in working with DOM events.
 *
 */
class DomEventHelper {

    /**
     * @var $domEventList array.  list of valid Dom events
     */

    static array $domEventList = [
        "abort",
        "afterprint",
        "animationend",
        "animationiteration",
        "animationstart",
        "beforeprint",
        "beforeunload",
        "blur",
        "canplay",
        "canplaythrough",
        "change",
        "click",
        "contextmenu",
        "copy",
        "cut",
        "dblclick",
        "drag",
        "dragend",
        "dragenter",
        "dragleave",
        "dragover",
        "dragstart",
        "drop",
        "durationchange",
        "ended",
        "error",
        "focus",
        "focusin",
        "focusout",
        "fullscreenchange",
        "fullscreenerror",
        "hashchange",
        "input",
        "invalid",
        "keydown",
        "keypress",
        "keyup",
        "load",
        "loadeddata",
        "loadedmetadata",
        "loadstart",
        "message",
        "mousedown",
        "mouseenter",
        "mouseleave",
        "mousemove",
        "mouseover",
        "mouseout",
        "mouseup",
        // "mousewheel", deprecated - use wheel event instead
        "offline",
        "online",
        "open",
        "pagehide",
        "pageshow",
        "paste",
        "pause",
        "play",
        "playing",
        "popstate",
        "progress",
        "ratechange",
        "resize",
        "reset",
        "scroll",
        "search",
        "seeked",
        "seeking",
        "select",
        "show",
        "stalled",
        "storage",
        "submit",
        "suspend",
        "timeupdate",
        "toggle",
        "touchcancel",
        "touchend",
        "touchmove",
        "touchstart",
        "transitionend",
        "unload",
        "volumechange",
        "waiting"
    ];

    /**
     * @function isEvent boolean. Returns whether a given string is a DOM event or not
     * @var $event string.
     */

    static function isEvent(string $eventName): bool
    {
        $key = array_search($eventName, self::$domEventList);
        return ($key === false ? false : true);
    }
}