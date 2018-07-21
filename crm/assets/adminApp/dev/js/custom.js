$(function(){
    var pathname = window.location.pathname; // Returns path only
    var url      = window.location.href;  
    console.log(pathname);
    console.log(url);
    console.log(pathname.split("/"));
    var split = pathname.split("/");
    switch(split[2]){
        case 'templates':
            // $('.menu-li').removeClass('active');
            $('.menu_li').addClass('active');
        break;
    }
});