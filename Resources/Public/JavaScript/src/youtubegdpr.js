/*import "core-js"
import "regenerator-runtime"*/

/**
 * GDPR compliant youtube embedding
 * @param {string} contentId
 * @param {string} ratio
 * @param {boolean} setCookie
 * @param {sting} videoId
 */
export default function youtubegdpr(contentId, setCookie) {

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
                })
            }
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



