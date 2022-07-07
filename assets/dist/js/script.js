var link = $("#form").attr("action");
$("#draft").mouseenter(function(){
    $("#form").attr("action",link+"/1");
});
$("#public").mouseenter(function(){
    $("#form").attr("action",link+"/3");
});
$("#private").mouseenter(function(){
    $("#form").attr("action",link+"/2");
});