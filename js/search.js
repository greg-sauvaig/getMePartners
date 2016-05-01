$(function(){
    // make sure input are empty event in case of error and reload
    $('#searchFrom').val("");
    $("#searchFrom").geocomplete({
        details : "#mapform",
        detailsAttribute : "data-search"
    });
});
