import {showError,showSuccess} from "./notification.js";
export default {
    index: {
        url: `http://localhost/jobs`,
        method: 'GET',
        success:((response)=>{
            console.log("success",response)
        }),
        error:((xhr, status, error)=>{
            showError(xhr.responseJSON)
        }),
        params:{}
    },
    create:{
        validation:{
            rules: {
                title: {
                    required: true,
                    minlength: 1,
                },
                description:{
                    required: true,
                    minlength: 1,
                    maxlength: 255,
                }
            },
            messages: {
                title: {
                    required: 'Title is required',
                },
                description: {
                    required: 'Description is required',
                },
            },
            highlight: function(element) {
                $(element).addClass('border border-red-500');
            },
            unhighlight: function(element) {
                $(element).removeClass('border border-red-500');
            },
            errorClass: 'text-red-600',
        },
        data:{
            url: 'http://localhost/jobs',
            method: 'POST',
            success:((response)=>{
                showSuccess(response.message);
            }),
            error:((xhr, status, error)=>{
                showError(xhr.responseJSON)
            }),
        }
    },
    delete:{
        url: "http://localhost/jobs/",
        method: "DELETE",
        success:((response)=>{
            showSuccess(response.message);
        }),
        error:((xhr, status, error)=>{
            showError(xhr.responseJSON)
        }),
        params: {
            '_token':$('meta[name="csrf-token"]').attr('content')
        }
    },
    show:{
        url: "http://localhost/jobs/",
        method: "GET",
        success:((response)=>{
            showSuccess(response.message);
        }),
        error:((xhr, status, error)=>{
            showError(xhr.responseJSON)
        }),
    },
    update:{
        url: "http://localhost/jobs",
        method: "PUT",
        success:((response)=>{
            showSuccess(response.message);
        }),
        error:((xhr, status, error)=>{
            showError(xhr.responseJSON)
        }),
    }
}
