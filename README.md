# youtube_gdprembed

Extension for responsive embedding of youtube videos via javascript to comply with GDPR rules. 

Preferences can be stored in cookie. Option to disable showing related videos via Youtube javascript API. Furthermore the extension tries to fetch preview images from youtube in the background to display them without loading them in the users browser.

The existing extensions are either not available for TYPO3 v9 or do not fit my usecase.

## Installation

``
composer require saschaschieferdecker/youtube_gdprembed
``

or via [TER]

## Configuration

* Include the Typoscript-Setup in your template

...

## Notes

Until 2019 you could hide related videos by setting a "rel=0" paramater while embedding. 

This does no longer work. Related videos from your own channel are still shown. 

So this extension makes use of the technique of [Maximilian Laumeister] to hide these related videos by using another Youtube API.


## Contributions

...

[TER]: https://extensions.typo3.org
[Maximilian Laumeister]: https://www.maxlaumeister.com/blog/hide-related-videos-in-youtube-embeds/
