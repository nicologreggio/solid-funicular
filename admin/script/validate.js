"use strict";
const filters = {
    email : function (input){
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(input.value).toLowerCase());
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
document.addEventListener("DOMContentLoaded", function(event) {
    for(let form of document.getElementsByTagName('form')){
        if(form.dataset.validate == "1"){
            form.addEventListener('submit', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                let valid = true;
                for(let input of [...form.getElementsByTagName('input'), ...form.getElementsByTagName('textarea')]){
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

// convertito con BABEL per retrocompatibilità Browsers: defaults, ie 6, ie_mob 11
// link 
// https://babeljs.io/repl#?browsers=defaults%2C%20ie%206%2C%20ie_mob%2011&build=&builtIns=false&spec=false&loose=false&code_lz=Q&debug=false&forceAllTransforms=false&shippedProposals=false&circleciRepo=&evaluate=false&fileSize=false&timeTravel=false&sourceType=module&lineWrap=true&presets=env%2Creact%2Cstage-2&prettier=false&targets=&version=7.12.12&externalPlugins=
