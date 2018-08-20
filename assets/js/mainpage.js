$(document).ready(function() {

    $("#showpop").click(function() {
        $(".pop_container").show();
        $(".hip-hop_container").hide();
        $(".electronic_container").hide();
        $(".country_container").hide();
        $(".rock_container").hide();
        $(".rb_container").hide();
        $(".latino_container").hide();
    });

    $("#showhiphop").click(function() {
        $(".pop_container").hide();
        $(".hip-hop_container").show();
        $(".electronic_container").hide();
        $(".country_container").hide();
        $(".rock_container").hide();
        $(".rb_container").hide();
        $(".latino_container").hide();
    });

    $("#showelectronic").click(function() {
        $(".pop_container").hide();
        $(".hip-hop_container").hide();
        $(".electronic_container").show();
        $(".country_container").hide();
        $(".rock_container").hide();
        $(".rb_container").hide();
        $(".latino_container").hide();
    });

    $("#showcountry").click(function() {
        $(".pop_container").hide();
        $(".hip-hop_container").hide();
        $(".electronic_container").hide();
        $(".country_container").show();
        $(".rock_container").hide();
        $(".rb_container").hide();
        $(".latino_container").hide();
    });

    $("#showrock").click(function() {
        $(".pop_container").hide();
        $(".hip-hop_container").hide();
        $(".electronic_container").hide();
        $(".country_container").hide();
        $(".rock_container").show();
        $(".rb_container").hide();
        $(".latino_container").hide();
    });

    $("#showrb").click(function() {
        $(".pop_container").hide();
        $(".hip-hop_container").hide();
        $(".electronic_container").hide();
        $(".country_container").hide();
        $(".rock_container").hide();
        $(".rb_container").show();
        $(".latino_container").hide();
    });

    $("#showlatino").click(function() {
        $(".pop_container").hide();
        $(".hip-hop_container").hide();
        $(".electronic_container").hide();
        $(".country_container").hide();
        $(".rock_container").hide();
        $(".rb_container").hide();
        $(".latino_container").show();
    });
});


// $(document).ready(function() {
//     // Tabs
//     $('#navigation').tabs({
//         ajaxOptions: {
//             error: function (xhr, status, index, anchor) {
//                 $(anchor.hash).html(
//                     "Couldn't load this tab. We'll try to fix this as soon as possible. " +
//                     "If this wouldn't be a demo.");
//             }
//         }
//     });
// });