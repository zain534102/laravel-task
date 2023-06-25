import constants from './constants';
import {showSuccess} from "./notification.js";
import toastr from 'toastr';
import {addMethodInValidator} from "./helper.js";
export default class Post{
    constructor(data={}){
        addMethodInValidator();
    }

    /**
     * Make Ajax call
     * @param data
     */
    makeAjaxCall(data){
        $.ajax({
            url: data.url,
            method: data.method,
            data: {...data.params},
            success: data.success,
            error: data.error,
        })
    }

    /**
     * Fetch all jobs
     * @param data
     * @param removeExisting
     */
    fetchJobs(data={},removeExisting= false){
        this.makeAjaxCall({...constants.index,success:((response)=>{ this.appendRow(response,removeExisting)}),...data})
    }

    /**
     * Gets Paginated jobs
     * @param clickableObject
     */
    getPaginatedJob(clickableObject){
        const url = clickableObject.data('link');
        if(url === "undefined") return;
        let data = {url: url};
        this.fetchJobs(data,true)
    }

    /**
     * Delete specific job
     * @param id
     */
    deleteJob(id){
        this.makeAjaxCall({...constants.delete,url: 'http://localhost/jobs/'+id,
            success:((response)=>{
                showSuccess(response.message);
                this.fetchJobs({},true);
            })
        })
    }

    /**
     * Show job details on edit page
     * @param id
     */
    getEditableJob(id){
        this.makeAjaxCall({...constants.show,
            url: `${constants.show.url}${id}/show`,
            success: ((response)=>{
                if(response.data.job){
                    $("#title").val(response.data.job.title);
                    $("#description").val(response.data.job.description);
                }
                else {
                    toastr.error("Sorry! Dont have any data");
                }
            })
        });
    }

    /**
     * Show Job
     * @param id
     */
    showJob(id){
        this.makeAjaxCall({...constants.show,
                url: `${constants.show.url}${id}/show`,
                success: ((response)=>{
                    if(response.data.job){
                        $("#job-title").text(response.data.job.title);
                        $("#job-description").text(response.data.job.description);
                    }
                    else {
                        $("#no-data").show();
                    }
                })
            })
    }

    /**
     * Redirect to show page
     * @param id
     */
    redirectTosShowPage(id){
        window.location.href= `${constants.index.url}/${id}`;
    }

    /**
     * Redirect to edit page
     * @param id
     */
    redirectTosEditPage(id){
        window.location.href= `${constants.index.url}/${id}/edit`;
    }

    /**
     * Append rows in table
     * @param response
     * @param removeExisting
     */
    appendRow(response,removeExisting){
        if(removeExisting){
            $("#t-body").empty();
        }
        $.each(response?.data?.jobs,function (index,item){
            let row = "<tr class=\"border-b border-gray-200 hover:bg-gray-100\">\n" +
                "                            <td class=\"py-3 px-2 text-left whitespace-nowrap\">\n" +
                "                                <div class=\"flex items-center\">\n" +
                "                                    <span class=\"font-medium\">"+item.id+"</span>\n" +
                "                                </div>\n" +
                "                            </td>\n" +
                "                            <td class=\"py-3 px-6 text-left\">\n" +
                "                                <div class=\"flex items-center\">\n" +
                "                                    <span>"+item.title+"</span>\n" +
                "                                </div>\n" +
                "                            </td>\n" +
                "                            <td class=\"py-3 px-12 text-center\">\n" +
                "                                <div class=\"flex items-center justify-center\">\n" +
                "                                    <span class=\"truncate sm:w-60\">"+item.description+"</span>\n" +
                "                                </div>\n" +
                "                            </td>\n" +
                "                            <td class=\"py-3 px-6 text-center\">\n" +
                "                                <div class=\"flex item-center justify-center\">\n" +
                "                                    <div id=\"show-job\" data-id='"+item.id+"' class=\"w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer\">\n" +
                "                                        <svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n" +
                "                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15 12a3 3 0 11-6 0 3 3 0 016 0z\" />\n" +
                "                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\" />\n" +
                "                                        </svg>\n" +
                "                                    </div>\n" +
                "                                    <div id=\"edit-job\" data-id='"+item.id+"' class=\"w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer\">\n" +
                "                                        <svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n" +
                "                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z\" />\n" +
                "                                        </svg>\n" +
                "                                    </div>\n" +
                "                                    <div id=\"delete-job\" data-id='"+item.id+"' class=\"w-4 mr-2 transform hover:text-purple-500 hover:scale-110 cursor-pointer\">\n" +
                "                                        <svg xmlns=\"http://www.w3.org/2000/svg\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\">\n" +
                "                                            <path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16\" />\n" +
                "                                        </svg>\n" +
                "                                    </div>\n" +
                "                                </div>\n" +
                "                            </td>\n" +
                "                        </tr>";
            $("#t-body").append(row);
        });
        this.showPagination(response,removeExisting);
    }

    /**
     * validate form
     * @param isEdit
     * @param formName
     * @param id
     */
    validateForm(isEdit=false,formName,id=null){
        const form = $(`#${formName}`);
        form.validate({
            ...constants.create.validation,submitHandler: function(form) {
                event.preventDefault();
                if ($(form).valid()) {
                    let formData = $(form).serializeArray();
                    let payload ={};
                    $.each(formData,function (index,item){
                        payload[item.name] = item.value;
                    });
                    payload['_token'] = $('meta[name="csrf-token"]').attr('content');
                    if(!isEdit){
                        new Post().makeAjaxCall({...constants.create.data,params:payload})
                    }
                    else {
                        new Post().makeAjaxCall({...constants.update,params:payload,url: `${constants.update.url}/${id}`})
                    }
                }
                form.reset()
            },
        });
    }

    /**
     * Show pagination in data table
     * @param response
     * @param removeExisting
     */
    showPagination(response,removeExisting){
        if(removeExisting){
            $("#pagination").empty();
        }
        let paginationData = response.meta.pagination;
        let pagination = "<span class=\"text-sm text-gray-700 dark:text-gray-400\">\n" +
            "                                Showing <span class=\"font-semibold text-gray-900 dark:text-white\">1</span> to <span\n" +
            "                                class=\"font-semibold text-gray-900 dark:text-white\">10</span> of <span\n" +
            "                                class=\"font-semibold text-gray-900 dark:text-white\">"+paginationData.total+"</span> Entries\n" +
            "                        </span>\n" +
            "                        <div class=\"inline-flex mt-2 xs:mt-0\">\n" +
            "                            <!-- Buttons -->\n" +
            "                            <button\n" +
            "                                data-link=\""+paginationData.links.previous +"\" id=\"previous\" class=\"cursor-pointer inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white\">\n" +
            "                                <svg aria-hidden=\"true\" class=\"w-5 h-5 mr-2\" fill=\"currentColor\" viewBox=\"0 0 20 20\"\n" +
            "                                     xmlns=\"http://www.w3.org/2000/svg\">\n" +
            "                                    <path fill-rule=\"evenodd\"\n" +
            "                                          d=\"M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z\"\n" +
            "                                          clip-rule=\"evenodd\"></path>\n" +
            "                                </svg>\n" +
            "                                Prev\n" +
            "                            </button>\n" +
            "                            <button\n" +
            "                                data-link=\""+paginationData.links.next +"\" id=\"next\" class=\"cursor-pointer inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gray-800 border-0 border-l border-gray-700 rounded-r hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white\">\n" +
            "                                Next\n" +
            "                                <svg aria-hidden=\"true\" class=\"w-5 h-5 ml-2\" fill=\"currentColor\" viewBox=\"0 0 20 20\"\n" +
            "                                     xmlns=\"http://www.w3.org/2000/svg\">\n" +
            "                                    <path fill-rule=\"evenodd\"\n" +
            "                                          d=\"M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z\"\n" +
            "                                          clip-rule=\"evenodd\"></path>\n" +
            "                                </svg>\n" +
            "                            </button>";
        $("#pagination").append(pagination);

    }

}
