function updateURLParameter(url, param, paramVal)
{
    var TheAnchor = null;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";

    if (additionalURL) 
    {
        var tmpAnchor = additionalURL.split("#");
        var TheParams = tmpAnchor[0];
            TheAnchor = tmpAnchor[1];
        if(TheAnchor)
            additionalURL = TheParams;

        tempArray = additionalURL.split("&");

        for (var i=0; i<tempArray.length; i++)
        {
            if(tempArray[i].split('=')[0] != param)
            {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }        
    }
    else
    {
        var tmpAnchor = baseURL.split("#");
        var TheParams = tmpAnchor[0];
            TheAnchor  = tmpAnchor[1];

        if(TheParams)
            baseURL = TheParams;
    }

    if(TheAnchor)
        paramVal += "#" + TheAnchor;

    var rows_txt = temp + "" + param + "=" + paramVal;
    return baseURL + "?" + newAdditionalURL + rows_txt;
}

function changePage(pageNum) {
    $('#qsContainer').fadeOut('fast', function() {
        $('#qsContainer').load('extra/questions.extra.php?pageNum='+pageNum, function(){
            $('#qsContainer').fadeIn('fast');
        });
    });

    window.history.replaceState(null, null, window.location.pathname);
    var newURL = updateURLParameter(window.location.href, 'locId', 'newLoc');
    newURL = updateURLParameter(newURL, 'resId', 'newResId');
    window.history.replaceState('', '', updateURLParameter(window.location.href, "pageNum", pageNum));

    $('.pageNum').css({'background':'white','color':'#116eee'})
    $('#pageNum'+pageNum).css({'background':'#116eee','color':'white'})
}

function changeAnswer(qid) {
    if($('#qid'+qid+'_answer').length) {

        answer = $('#qid'+qid+'_answer').val()

    } else if($('#qid'+qid+'_answer0').length) {

        i = 0
        while(i < 5) {
            if($('#qid'+qid+'_answer'+i).length && $('#qid'+qid+'_answer'+i).is(':checked')) {
                answer = $('#qid'+qid+'_answer'+i+'_label > div > p').html()
            }
            i += 1
        }

    } else if($('#qid'+qid+'_choice0').length) {

        answer = "__00__"
        i = 0
        while(i < 5) {
            if($('#qid'+qid+'_choice'+i).length && $('#qid'+qid+'_choice'+i).is(':checked')) {
                answer += ";;;" + $('#qid'+qid+'_choice'+i+'_label > div > p').html()
            }
            i += 1
        }
        answer = answer.replace("__00__;;;", "")

    }

    $.ajax({
        url: 'includes/changeAnswer.inc.php',
        type: 'POST',
        data: {
            qid: qid,
            answer: answer
        },
        success: function() {
            if($('#qid'+qid+'_answer').val() !== "") {
                $('#que_'+qid).css({'background':'#afffc8'})
            } else {
                $('#que_'+qid).css({'background':'white'})
            }
        }
    });
};

function resetAnswer(qid) {
    const conf = confirm("Are you sure you want to clear the answer?")
    if(conf) {
        $.ajax({
            url: 'includes/changeAnswer.inc.php',
            type: 'POST',
            data: {
                qid: qid,
                answer: ""
            },
            success: function() {
                $('#que_'+qid).css({'background':'white'})
                
                if($('#qid'+qid+'_answer').length) {

                    $('#qid'+qid+'_answer').val("")

                } else if($('#qid'+qid+'_answer0').length) {

                    i = 0
                    while(i < 5) {
                        if($('#qid'+qid+'_answer'+i).length) {
                            $('#qid'+qid+'_answer'+i).prop('checked', false)
                        }
                        i += 1
                    }

                } else if($('#qid'+qid+'_choice0').length) {

                    i = 0
                    while(i < 5) {
                        if($('#qid'+qid+'_choice'+i).length) {
                            $('#qid'+qid+'_choice'+i).prop('checked', false)
                        }
                        i += 1
                    }

                }
            }
        });
    }
};

$body = $("body");
$(document).on({
    ajaxStart: function() {
        $body.addClass("loading");
    },
    ajaxStop: function() {
        $body.removeClass("loading");
    }
});