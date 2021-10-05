$(document).ready(function (){
    $(document).on('click', '#save-media-button', function (e){
        e.preventDefault()
        $(this).prop('disabled', true)
        $('#spinner-area').show()
        let url = $(this).data('url')
        $.ajax({
            url: url,
            type : 'POST',
            success : function (result){
                var data = JSON.parse(result)
                window.location.href = data.url
            }
        })
    })



    function runProgressBar(){
        var myProgressBar = setInterval(progressBar, 1000);
    }
    function progressBar(){

        let percentUrl = $( '#save-media-button').data('percent-url')

        $.ajax({
            url: percentUrl,
            type : 'POST',
            success: function (result){
                if (result >= 100){
                    clearInterval(myProgressBar);
                }
                $('#progress-percent').html(result)
            }
        })
    }

})

function saveMedia()
{
    $('#spinner-area').show()
    let url = $("#save-media-input").val()
    alert(url)
    $.ajax({
        url: url,
        type : 'POST',
        success : function (result){
            var data = JSON.parse(result)
            window.location.href = data.url
        }
    })
}