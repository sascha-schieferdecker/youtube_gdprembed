import "core-js"
import "regenerator-runtime"

/**
 * GDPR compliant youtube embedding
 * @param {string} contentId
 * @param {string} hideRel
 * @param {boolean} setCookie
 */
export default function youtubegdpr(contentId, hideRel, setCookie) {

    document.querySelectorAll('.acceptgdpr').forEach(elem => {
        elem.style.display = 'none';
    })

    if (window.youtubegdprExecuted != true) {
        var tag = document.createElement('script');

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        window.onYouTubeIframeAPIReady = function() {
            var playerDivs = document.querySelectorAll('.gdprplayer')
            var playerDivsArr = [].slice.call(playerDivs); // nodelist to array to use forEach();
            var players = new Array(playerDivsArr.length);
            playerDivsArr.forEach(function (e, i) { // forEach ...
                players[i] = new YT.Player(e.id, {
                    videoId: e.getAttribute('data-video'),
                    events: {
                        'onStateChange': onPlayerStateChange
                    }
                })
                if (Number(hideRel) > 0) {
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
        if (Number(hideRel) > 0) {
            if (event.data == YT.PlayerState.ENDED) {
                event.target.a.parentNode.classList.add("ended");
            } else if (event.data == YT.PlayerState.PAUSED) {
                event.target.a.parentNode.classList.add("paused");
            } else if (event.data == YT.PlayerState.PLAYING) {
                event.target.a.parentNode.classList.remove("ended");
                event.target.a.parentNode.classList.remove("paused");
            }
        }
    };

    window.youtubegdprExecuted = true;
}



