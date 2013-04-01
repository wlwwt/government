# ******************************************************************************
#	(c) 2012 Georg Ringer <typo3@ringerge.org>
#
#	You can redistribute it and/or modify it under the terms of the
#	GNU General Public License as published by the Free Software Foundation;
#	either version 2 of the License, or (at your option) any later version.
# ******************************************************************************


# **********************************************************
# Changes to EXT:news
# **********************************************************

plugin.tx_news {
	view {
		templateRootPath = EXT:theme_government/Resources/Private/Extensions/news/Templates/
		partialRootPath = EXT:theme_government/Resources/Private/Extensions/news/Partials/
		layoutRootPath = EXT:theme_government/Resources/Private/Extensions/news/Layouts/
        widget.Tx_News_ViewHelpers_Widget_PaginateViewHelper.templateRootPath = EXT:theme_government/Resources/Private/Extensions/news/
	}
	
	settings {
		defaultDetailPid = {$plugin.theme_configuration.news.detail}
		cropMaxCharacters = {$plugin.theme_configuration.news.crop}
		list {
			paginate.insertAbove = 0
			media.image.maxWidth = {$plugin.theme_configuration.news.list.width}
			media.image.maxHeight = {$plugin.theme_configuration.news.list.height}
			paginate {
				itemsPerPage = 3
				insertAbove = 0
				insertBelow = 1
			}
		}
		detail {
			media.image.maxWidth = 974
			showSocialShareButtons = 1
			media.image.small.width = 150c
			media.image.small.height = 150c
		}
	}
}