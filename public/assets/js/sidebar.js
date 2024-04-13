$(document).ready(function(){
    const urlArr = window.location.href.split("/");
    const lengthOfUrlArr = urlArr.length;
    const navigationPage = urlArr[lengthOfUrlArr - 1].split(".")[0];
    $("a").removeClass("sidebarActive");
    $(`.${navigationPage}`).addClass("sidebarActive");
    // if (navigationPage == 'dashboard') {
    //     $(".dashboardActive").removeClass("d-none");
    //     $(".dashboardDeactive").addClass("d-none");
    // } else {
    //     $(".dashboardActive").addClass("d-none");
    //     $(".dashboardDeactive").removeClass("d-none");
    // }
})