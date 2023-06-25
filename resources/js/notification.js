import toastr from 'toastr';
import constants from "./constants.js";
toastr.options = {
    closeButton: true,
    progressBar: true,
    positionClass: 'toast-top-right',
    timeOut: 5000
};
function showSuccess(message){
    toastr.success(message);
}
function showError(response){
    if (response.errors && response.message) {
        if (Object.keys(response.errors).length) {
            $.each(response.errors,function (index,item){
                $.each(item,function (index,errorMessage){
                    toastr.error(errorMessage);
                });
            });
        }
    }
}
export {
    showSuccess,
    showError
}
