/**
 * Questo script mira ad essere una libreria per la validazione dei form tramite JS
 * author: Alberto Sinigaglia
 * co-author: Filippo Fantinato
 * 
 * Per usarla, definire dentro il form la seguente proprietà:
 * data-validate="1"
 * l'input i seguenti dati
 * data-error-field="id del div che conterrà l'errore quando è da visualizzare" 
 * data-rules="le regole che si vogliono applicare separate da |, e se hanno parametri nello stile regola:param1,param2" (per esempio se abbiamo un input numeric required e che deve essere tra 0-10 si può usare "between:0,10|required")
 * data-error-message="l'errore da mostrare, può contenere anche HTML"
 * 
 * Per aggiungere regole, basta aggiungere al object filters una nuova proprietà con come chiave il nome del vincolo, e come valore la funzione per la validazione
 */

/*
"use strict";
const filters = {
    email : function (input){
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(input.value).toLowerCase());
    },
    password : function(input) {
        const re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,1024}$/;
        return re.test(input.value);
    },
    required : function(input){
        return input.value != null && input.value != "" && input.value.length != 0;
    },
    equals : function(input, id){
        return input.value == document.getElementById(id).value;
    },
    max_length : function(input, max){
        return input.value.length <= max;
    },
    min_length : function(input, min){
        return input.value.length >= min;
    },
    length : function(input, len){
        return input.value.length == len;
    },
    alphabetic : function(input){
        return /^[A-Za-z\ ]*$/.test(input.value);
    },
    integer: function(input){
        return /^[0-9]*$/.test(input.value)
    },
    file_required: function(input){
        return input.files.length != 0;
    }
};
function removeError(input){
    input.classList.add('error')
    if(input.dataset.errorMessage)
    {
        document.getElementById(input.dataset.errorField).innerHTML = "<p>" + input.dataset.errorMessage + "</p>";
    }
}
function validateInput(input){
    let valid = true;
    if(input.dataset.rules){
        document.getElementById(input.dataset.errorField).innerHTML = "";
        input.classList.remove('error');
        let rules = input.dataset.rules.split('|');
        rules.forEach(r => {
            let params = [];
            if(r.includes(':')){
                let tmp = r.split(':');
                r = tmp[0];
                params = tmp[1].split(',');
            }
            if(filters[r] && !filters[r](input, ...params)){
                removeError(input);
                valid = false;
            } 
        })
    }
    return valid;
}
var input;
document.addEventListener("DOMContentLoaded", function(event) {
    for(let form of document.getElementsByTagName('form')){
        if(form.dataset.validate == "1"){
            let inputs = [...form.getElementsByTagName('input'), ...form.getElementsByTagName('textarea'), ...form.getElementsByTagName('select'),];

            for(let input of inputs){
                input.addEventListener('focusout', function(e){
                    e.preventDefault();
                    validateInput(e.target);
                })
                const onchangeHandler = function(e){
                    e.preventDefault();
                    // man mano che l'utente scrive, se l'errore è mostrato, allora controlla che non sia finalmente 
                    // valido quello che ha scritto
                    // non è molto supportato, ma per chi lo supporta penso possa essere "positivo"
                    input = e.target;
                    if(input.dataset.errorField && document.getElementById(input.dataset.errorField).innerHTML.trim()){
                        validateInput(e.target);
                    }
                };
                // IE9
                input.addEventListener('propertychange', onchangeHandler);
                // per il resto
                input.addEventListener('input', onchangeHandler)
            }
            

            form.addEventListener('submit', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                let valid = true;
                for(let input of inputs){
                    valid = validateInput(input)
                }
                if(valid) form.submit();
            })
        }
    }
    return false;
});
*/

// convertito con BABEL per retro-compatibilità Browsers: defaults, ie 6, ie_mob 11
// link 
// https://babeljs.io/repl#?browsers=defaults%2C%20ie%206%2C%20ie_mob%2011&build=&builtIns=false&spec=false&loose=false&code_lz=Q&debug=false&forceAllTransforms=false&shippedProposals=false&circleciRepo=&evaluate=false&fileSize=false&timeTravel=false&sourceType=module&lineWrap=true&presets=env%2Creact%2Cstage-2&prettier=false&targets=&version=7.12.12&externalPlugins=

"use strict";function _createForOfIteratorHelper(e,t){var r;if("undefined"==typeof Symbol||null==e[Symbol.iterator]){if(Array.isArray(e)||(r=_unsupportedIterableToArray(e))||t&&e&&"number"==typeof e.length){r&&(e=r);var n=0,a=function(){};return{s:a,n:function(){return n>=e.length?{done:!0}:{done:!1,value:e[n++]}},e:function(e){throw e},f:a}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var o,u=!0,i=!1;return{s:function(){r=e[Symbol.iterator]()},n:function(){var e=r.next();return u=e.done,e},e:function(e){i=!0,o=e},f:function(){try{u||null==r.return||r.return()}finally{if(i)throw o}}}}function _toConsumableArray(e){return _arrayWithoutHoles(e)||_iterableToArray(e)||_unsupportedIterableToArray(e)||_nonIterableSpread()}function _nonIterableSpread(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}function _unsupportedIterableToArray(e,t){if(e){if("string"==typeof e)return _arrayLikeToArray(e,t);var r=Object.prototype.toString.call(e).slice(8,-1);return"Object"===r&&e.constructor&&(r=e.constructor.name),"Map"===r||"Set"===r?Array.from(e):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?_arrayLikeToArray(e,t):void 0}}function _iterableToArray(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}function _arrayWithoutHoles(e){if(Array.isArray(e))return _arrayLikeToArray(e)}function _arrayLikeToArray(e,t){(null==t||t>e.length)&&(t=e.length);for(var r=0,n=new Array(t);r<t;r++)n[r]=e[r];return n}var input,filters={email:function(e){return/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(String(e.value).toLowerCase())},password:function(e){return/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,1024}$/.test(e.value)},required:function(e){return null!=e.value&&""!=e.value&&0!=e.value.length},equals:function(e,t){return e.value==document.getElementById(t).value},max_length:function(e,t){return e.value.length<=t},min_length:function(e,t){return e.value.length>=t},length:function(e,t){return e.value.length==t},alphabetic:function(e){return/^[A-Za-z\ ]*$/.test(e.value)},integer:function(e){return/^[0-9]*$/.test(e.value)},file_required:function(e){return 0!=e.files.length}};function removeError(e){e.classList.add("error"),e.dataset.errorMessage&&(document.getElementById(e.dataset.errorField).innerHTML="<p>"+e.dataset.errorMessage+"</p>")}function validateInput(e){var t=!0;e.dataset.rules&&(document.getElementById(e.dataset.errorField).innerHTML="",e.classList.remove("error"),e.dataset.rules.split("|").forEach(function(r){var n=[];if(r.includes(":")){var a=r.split(":");r=a[0],n=a[1].split(",")}filters[r]&&!filters[r].apply(filters,[e].concat(_toConsumableArray(n)))&&(removeError(e),t=!1)}));return t}document.addEventListener("DOMContentLoaded",function(e){var t,r=_createForOfIteratorHelper(document.getElementsByTagName("form"));try{var n=function(){var e=t.value;if("1"==e.dataset.validate){var r,n=[].concat(_toConsumableArray(e.getElementsByTagName("input")),_toConsumableArray(e.getElementsByTagName("textarea")),_toConsumableArray(e.getElementsByTagName("select"))),a=_createForOfIteratorHelper(n);try{var o=function(){var e=r.value;e.addEventListener("focusout",function(e){e.preventDefault(),validateInput(e.target)});var t=function(t){t.preventDefault(),(e=t.target).dataset.errorField&&document.getElementById(e.dataset.errorField).innerHTML.trim()&&validateInput(t.target)};e.addEventListener("propertychange",t),e.addEventListener("input",t)};for(a.s();!(r=a.n()).done;)o()}catch(e){a.e(e)}finally{a.f()}e.addEventListener("submit",function(t){t.preventDefault(),t.stopImmediatePropagation();var r,a=!0,o=_createForOfIteratorHelper(n);try{for(o.s();!(r=o.n()).done;){a=validateInput(r.value)}}catch(e){o.e(e)}finally{o.f()}a&&e.submit()})}};for(r.s();!(t=r.n()).done;)n()}catch(e){r.e(e)}finally{r.f()}return!1});