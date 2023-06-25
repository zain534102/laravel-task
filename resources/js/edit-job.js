import Post from "./post-class.js";
import {getUrlId} from "./helper.js";

$(document).ready(function (){
    let post = new Post();
    if($.isNumeric(getUrlId(true))){
        post.getEditableJob(getUrlId(true))
    }
    // $("#job-edit-form").submit(function (){
    //     event.preventDefault();
    // });
    post.validateForm(true,'job-edit-form',getUrlId(true));
});
