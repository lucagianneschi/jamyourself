var newUser = {};

function showError(text) {
    $("#error").html("<span>" + text + "</span>");
}

function hideError() {
    $("#error").html("");
}

function showMessage(text) {
    $("#message").html("<span>" + text + "</span>");
}

function hideMessage() {
    $("#message").html("");
}


function checkStep(i) {
    var validate = true;

    switch (i) {
        case 1 :
            if (!newUser.type) {
                showError('Choose a valid profile!');
                validate = false;
            } else {
                hideError();
                validate = true;
            }
            break;
        case 2:
            break;
        case 3 :
            break;
        case 4:
            break;
    }

    return validate;

}

$().ready(function() {

    var step = 1;

    $(".next_step").click(function() {

        if (checkStep(step)) {
            actualStep = '#step' + step;
            step++;
            nextStep = '#step' + step;

            for (var i = 1; i <= 4; i++) {
                if (i === step) {
                    $(nextStep).css('display', 'block');
                }
                else
                    $(actualStep).css('display', 'none');
            }
            window.console.log(newUser);
        }
    });

    $(".prev_step").click(function() {
        actualStep = '#step' + step;
        step--;
        nextStep = '#step' + step;

        for (var i = 1; i <= 4; i++) {
            if (i === step) {
                $(nextStep).css('display', 'block');
            }
            else
                $(actualStep).css('display', 'none');
        }
    });


    $('#spotter_profile img').click(function() {
        $('#spotter_profile img').css('border', 'solid 1px red');
        $('#venue_profile img').css('border', 'none');
        $('#jammer_profile img').css('border', 'none');
        newUser.type = "SPOTTER";
    });

    $('#venue_profile img').click(function() {
        $('#spotter_profile img').css('border', 'none');
        $('#venue_profile img').css('border', 'solid 1px red');
        $('#jammer_profile img').css('border', 'none');
        newUser.type = "VENUE";
    });

    $('#jammer_profile img').click(function() {
        $('#spotter_profile img').css('border', 'none');
        $('#venue_profile img').css('border', 'none');
        $('#jammer_profile img').css('border', 'solid 1px red');
        newUser.type = "JAMMER";
    });

    $('#username').blur(function() {
        newUser.username = $(this).val();
    });
    $('#email').blur(function() {
        newUser.email = $(this).val();
    });
    $('#password').blur(function() {
        newUser.password = $(this).val();
    });
    $('#firstname').blur(function() {
        newUser.firstname = $(this).val();
    });
    $('#lastname').blur(function() {
        newUser.lastname = $(this).val();
    });
    $('#address').blur(function() {
        newUser.address = $(this).val();
    });
    $('#description').blur(function() {
        newUser.username = $(this).val();
    });
    $('#sex').blur(function() {
        newUser.username = $(this).val();
    });
    $('#birthday').blur(function() {
        newUser.username = $(this).val();
    });
    $('#url').blur(function() {
        newUser.username = $(this).val();
    });
});
