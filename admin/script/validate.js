/*

"use strict";

const filters = {
    email : function (email){
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    },
    required : function(value){
        return value != null && value != "" && value.length != 0;
    },
    equals : function(value, id){
        return value == document.getElementById(id).value;
    },
    max_length : function(value, max){
        return value.length <= max;
    },
    min_length : function(value, min){
        return value.length >= min;
    },
    length : function(value, len){
        return value.length == len;
    },
    alphabetic : function(value){
        return /^[A-Za-z\ ]*$/.test(value);
    },
    integer: function(value){
        return /^[0-9]*$/.test(value)
    }
};
document.addEventListener("DOMContentLoaded", function(event) {
    for(let form of document.getElementsByTagName('form')){
        if(form.dataset.validate == "1"){
            form.addEventListener('submit', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                let valid = true;
                for(let input of form.getElementsByTagName('input')){
                    document.getElementById(input.dataset.errorField).innerHTML = "";
                    input.classList.remove('error');
                    if(input.dataset.rules){
                        let rules = input.dataset.rules.split('|');
                        rules.forEach(r => {
                            let params = [];
                            if(r.includes(':')){
                                let tmp = r.split(':');
                                r = tmp[0];
                                params = tmp[1].split(',');
                            }
                            if(filters[r] && !filters[r](input.value, ...params)){
                                input.classList.add('error')
                                document.getElementById(input.dataset.errorField).innerHTML = "<p class='error'>"+input.dataset.errorMessage+"</p>";
                                valid = false;
                            } 
                        })
                    }
                }
                if(valid) form.submit();
            })
        }
    }
    return false;
});



*/
// convertito con BABEL per retrocompatibilità Browsers: defaults, ie 6, ie_mob 11
// link 
// https://babeljs.io/repl#?browsers=defaults%2C%20ie%206%2C%20ie_mob%2011&build=&builtIns=false&spec=false&loose=false&code_lz=Q&debug=false&forceAllTransforms=false&shippedProposals=false&circleciRepo=&evaluate=false&fileSize=false&timeTravel=false&sourceType=module&lineWrap=true&presets=env%2Creact%2Cstage-2&prettier=false&targets=&version=7.12.12&externalPlugins=
"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

var filters = {
  email: function email(_email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(_email).toLowerCase());
  },
  required: function required(value) {
    return value != null && value != "" && value.length != 0;
  },
  equals: function equals(value, id) {
    return value == document.getElementById(id).value;
  },
  max_length: function max_length(value, max) {
    return value.length <= max;
  },
  min_length: function min_length(value, min) {
    return value.length >= min;
  },
  length: function length(value, len) {
    return value.length == len;
  },
  alphabetic: function alphabetic(value) {
    return /^[A-Za-z\ ]*$/.test(value);
  },
  integer: function integer(value) {
    return /^[0-9]*$/.test(value);
  }
};
document.addEventListener("DOMContentLoaded", function (event) {
  var _iterator = _createForOfIteratorHelper(document.getElementsByTagName('form')),
      _step;

  try {
    var _loop = function _loop() {
      var form = _step.value;

      if (form.dataset.validate == "1") {
        form.addEventListener('submit', function (e) {
          e.preventDefault();
          e.stopImmediatePropagation();
          var valid = true;

          var _iterator2 = _createForOfIteratorHelper(form.getElementsByTagName('input')),
              _step2;

          try {
            var _loop2 = function _loop2() {
              var input = _step2.value;
              document.getElementById(input.dataset.errorField).innerHTML = "";
              input.classList.remove('error');

              if (input.dataset.rules) {
                var rules = input.dataset.rules.split('|');
                rules.forEach(function (r) {
                  var params = [];

                  if (r.includes(':')) {
                    var tmp = r.split(':');
                    r = tmp[0];
                    params = tmp[1].split(',');
                  }

                  if (filters[r] && !filters[r].apply(filters, [input.value].concat(_toConsumableArray(params)))) {
                    input.classList.add('error');
                    document.getElementById(input.dataset.errorField).innerHTML = "<p class='error'>" + input.dataset.errorMessage + "</p>";
                    valid = false;
                  }
                });
              }
            };

            for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
              _loop2();
            }
          } catch (err) {
            _iterator2.e(err);
          } finally {
            _iterator2.f();
          }

          if (valid) form.submit();
        });
      }
    };

    for (_iterator.s(); !(_step = _iterator.n()).done;) {
      _loop();
    }
  } catch (err) {
    _iterator.e(err);
  } finally {
    _iterator.f();
  }

  return false;
});