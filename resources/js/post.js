import Post from "./post-class.js";
$(window).on('load',function (){
    new Post().fetchJobs();
});
$(document).ready(function() {
    let post = new Post();
    $('#pagination').on('click', '#next', function() {
        post.getPaginatedJob($(this))
    });
    $('#pagination').on('click', '#previous', function() {
        post.getPaginatedJob($(this))
    });
    $("#t-body").on('click',"#delete-job",function (){
        post.deleteJob($(this).data('id'));
    });
    $("#t-body").on('click',"#show-job",function (){
        post.redirectTosShowPage($(this).data('id'));
    });
    $("#t-body").on('click',"#edit-job",function (){
        post.redirectTosEditPage($(this).data('id'));
    });
    post.validateForm(false,'job-form');
});
