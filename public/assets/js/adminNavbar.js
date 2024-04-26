$(document).ready(function() {
    const menu = $(".menu");
    menu.click(() => {
        $(".sidebar").toggleClass("d-none");
        $(".dataTables_wrapper").toggleClass("sidebarMenu")
    })
})