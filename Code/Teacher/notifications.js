function notifications(notifId) {
    let remove = setTimeout("removeNotif()", 3500);
    const el = document.getElementById(notifId);
    el.addEventListener("mouseover", function() {
        clearTimeout(remove);
    });
    el.addEventListener("mouseleave", function() {
        remove = setTimeout("removeNotif()", 3500);
    });
}

function errors(errorId) {
    console.log("shitsadwadwadwd");
    let remove = setTimeout("removeError()", 3500);
    const el = document.getElementById(errorId);
    el.addEventListener("mouseover", function() {
        clearTimeout(remove);
    });
    el.addEventListener("mouseleave", function() {
        remove = setTimeout("removeError()", 3500);
    });
}

function removeNotif() {
    document.getElementById("notification").remove();
}

function removeError() {
    document.getElementById("error").remove();
}