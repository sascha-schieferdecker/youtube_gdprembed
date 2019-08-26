# youtube_gdprembed

Extension for responsive embedding of youtube videos via javascript to comply with GDPR rules. 

The existing extensions are either not available for TYPO3 v9 or do not fit my usecase.

## Features

* Provides a new content type

* Preferences can be stored in cookie. 

* Option to disable showing related videos via Youtube javascript API. 

* Extension tries to fetch preview images from youtube on the server via the oembed API to display them without loading them in the users browser.

* Custom CSS and JS easy to implement

* No dependency on jQuery or other frameworks 

* Dataprocessor can be replaced by custom processor if needed

* Supports Chrome, Firefox, IE11 and main mobile browsers

## Installation

``
composer require saschaschieferdecker/youtube_gdprembed
``

or via [TER]

## Configuration

* Include the Typoscript-Setup in your template

* Edit the settings via constant editor or customize the setup directly:

```TYPOSCRIPT
plugin.tx_youtubegdprembed {
    settings {
        # ID of page with privacy information
        privacyPage = {$plugin.tx_youtubegdprembed.settings.privacyPage}

        # Set a cookie that user has accepted information about youtube
        persistAcceptance = {$plugin.tx_youtubegdprembed.settings.persistAcceptance}

        # Storage and folder for storing the downloaded preview images
        storagePreviewImages = {$plugin.tx_youtubegdprembed.settings.storagePreviewImages}
    }
}

# Define Output template
tt_content {
    youtubegdprembed_youtube =< lib.contentElement
    youtubegdprembed_youtube {
        templateName = Youtube.html
        templateRootPaths {
            198 = {$plugin.tx_youtubegdprembed.settings.templateRootPath}
        }
        dataProcessing {
            1 = SaschaSchieferdecker\YoutubeGdprembed\DataProcessing\YoutubeProcessor
        }
    }
}

page.includeCSSLibs {
    youtubegdprembed = {$plugin.tx_youtubegdprembed.settings.cssFile}
}
page.includeJSFooterlibs {
    youtubegdprembed = {$plugin.tx_youtubegdprembed.settings.jsFile}
}

```

## Notes

Until October 2018 you could hide related videos by setting a "rel=0" paramater while embedding. 

This does no longer work as before. Related videos from your own channel are still shown. 

So this extension makes use of the rather hacky workaround described by [Maximilian Laumeister] to hide these related videos by creating some CSS overlays, if the corresponding option is set. My JS is nicer though ;) Did I mention IE11 sucks?


## Contributions

Contributions are very welcome, feel free to create a pull request.

[TER]: https://extensions.typo3.org
[Maximilian Laumeister]: https://www.maxlaumeister.com/blog/hide-related-videos-in-youtube-embeds/
