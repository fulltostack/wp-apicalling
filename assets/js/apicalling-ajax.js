jQuery(document).ready(function ($) {

    jQuery('#getData').on('click', function () {

        let checkCookies = getCookie('clickedTime');
        let date = new Date();
        let proceed = false;

        if (checkCookies != undefined && checkCookies != "") {
            let currentTime = date.getTime();
            let timeDiff = currentTime - checkCookies;
            let minOneHour = msToHours(timeDiff); 
            if (minOneHour > 0) {
                proceed = true;
            } else {
                alert('Less than 1 hour');
            }
        } else {
            document.cookie = "clickedTime=" + date.getTime();
            proceed = true;
        }

        if (proceed) {
            document.cookie = "clickedTime=" + date.getTime();
            jQuery.ajax({
                type: "POST",
                dataType: "json",
                url: apicalling_ajax_obj.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                data: {
                    'action': 'apicalling_ajax_request',
                },
                success: function (data) {
                    if (data.status == 200) {
                        alert('Fetch data successfully.');
                    }
                }
            });
        }
    });
});

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function msToHours(duration) {
    let hours = Math.floor((duration / (1000 * 60 * 60)) % 24);
    hours = (hours < 10) ? hours : hours;
    return hours;
}