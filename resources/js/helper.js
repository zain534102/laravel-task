function addMethodInValidator(){
    $.validator.addMethod(
        'lettersonly',
        function(value, element) {
            return this.optional(element) || /^[\w\-\s]+$/i.test(value);
        },
        'Letters only please'
    );
}
function getUrlId(isEdit=false){
    let queryParam = window.location.pathname.split('/');
    if(isEdit){
        return queryParam[queryParam.length-2];
    }
   return window.location.pathname.split('/').pop();
}
export {
    addMethodInValidator,
    getUrlId
}
