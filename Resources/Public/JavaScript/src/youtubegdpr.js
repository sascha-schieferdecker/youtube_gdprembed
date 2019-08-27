import "core-js"
import "regenerator-runtime"

/**
 * GDPR compliant youtube embedding
 * @param {string} contentId
 * @param {string} hideRel
 * @param {boolean} setCookie
 */
export default function youtubegdpr(contentId, setCookie) {

    document.querySelectorAll('.acceptgdpr').forEach(elem => {
        elem.style.display = 'none';
    })

    if(Number(setCookie) > 0) {
        var date = new Date();
        date.setTime(date.getTime()+(365*24*60*60*1000));
        document.cookie = "youtubegdpr=accepted; expires= " + date.toGMTString() + "; path=/ "
    }

    if (window.youtubegdprExecuted != true) {
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        window.onYouTubeIframeAPIReady = function() {
            var playerDivs = document.querySelectorAll('.gdprplayer')
            var playerDivsArr = [].slice.call(playerDivs);
            var players = new Array(playerDivsArr.length);
            playerDivsArr.forEach(function (e, i) {
                let hideRel = Number(e.getAttribute('data-hiderel'));
                if (hideRel > 0) {
                    players[i] = new YT.Player(e.id, {
                        videoId: e.getAttribute('data-video'),
                        events: {
                            'onStateChange': onPlayerStateChange
                        },
                        playerVars: {
                            modestbranding: 1,
                            rel: 0,
                            showinfo: 0
                        }
                    })
                    let elem = document.getElementById(e.id);
                    elem.parentNode.parentNode.addEventListener("click", function() {
                        let playerState = players[i].getPlayerState();
                        if (playerState == YT.PlayerState.ENDED) {
                            players[i].seekTo(0);
                        } else if (playerState == YT.PlayerState.PAUSED) {
                            players[i].playVideo();
                        }
                    });
                }
                else {
                    players[i] = new YT.Player(e.id, {
                        videoId: e.getAttribute('data-video'),
                        playerVars: {
                            modestbranding: 1,
                            rel: 0,
                            showinfo: 0
                        }
                    })
                }
            })
        }
    }

    function playVideo(target) {
        target.playVideo();
    }
    function rewindVideo(target) {
        target.seekTo(0);
    }

    let onPlayerStateChange = function(event) {
        if (event.data == YT.PlayerState.ENDED) {
            event.target.a.parentNode.classList.add("ended");
        } else if (event.data == YT.PlayerState.PAUSED) {
            event.target.a.parentNode.classList.add("paused");
        } else if (event.data == YT.PlayerState.PLAYING) {
            event.target.a.parentNode.classList.remove("ended");
            event.target.a.parentNode.classList.remove("paused");
        }
    };

    window.youtubegdprExecuted = true;
}



