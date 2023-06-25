import {getUrlId} from "./helper.js";
import Post from "./post-class.js";

$(document).ready(function (){
    let post = new Post();
    if($.isNumeric(getUrlId())){
        post.showJob(getUrlId())
    }
});
