
let seconds = 0;

function incSeconds(playerName, url, interval=5, data={})
{
    seconds = seconds + 1;
    if (seconds % interval === 0){
        let currentTime = playerName.currentTime()
        data.currentTime = currentTime
        saveWatchHistory(url, data)
    }
}

function playVideo(playerName, url, interval=5, data={})
{
    mySeconds = setInterval(function(){
        incSeconds(playerName, url, interval, data);
        }, 1000);

}

function pauseVideo()
{
    clearInterval(mySeconds)
}

function saveWatchHistory(url, data)
{

    $.ajax({
        url: url,
        data:data,
        type: 'post',
        success: function (result){
            console.log(result)
        }
    })

}