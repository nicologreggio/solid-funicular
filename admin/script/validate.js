const filters = {
    email : function (email){
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    },
    required : function(value){
        return value != null && value != "" && value.length != 0;
    }
};
document.addEventListener("DOMContentLoaded", function(event) {
    for(form of document.getElementsByTagName('form')){
        if(form.dataset.validate == "1"){
            form.addEventListener('submit', function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                let valid = true;
                for(input of form.getElementsByTagName('input')){
                    input.classList.remove('error');
                    if(input.dataset.rules){
                       let rules = input.dataset.rules.split(',');
                       rules.forEach(r => {
                           if(filters[r] && !filters[r](input.value)){
                            input.classList.add('error')
                            console.log(input.dataset)
                            document.getElementById(input.dataset.errorField).innerHTML = input.dataset.errorMessage;
                            valid = false;
                           }
                       })
                    }
                }
                if(valid) form.submit();
            })
        }
    }
});