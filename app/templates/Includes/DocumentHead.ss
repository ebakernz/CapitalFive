<!doctype html>
<html lang="en">
<head>

	<% base_tag %>

	<meta charset="utf-8">
	<title><% if MetaTitle %>$MetaTitle<% else %>$MenuTitle.XML | $SiteConfig.Title<% end_if %></title>

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
	
	<% if MetaDescription %><meta name="description" content="$MetaDescription" /><% end_if %>
	<% if MetaKeywords %><meta name="keywords" content="$MetaKeywords" /><% end_if %>
	<% if ExtraMeta %>$ExtraMeta<% end_if %>

	<meta property="og:type" content="website">
	<meta property="og:url" content="{$absoluteBaseURL}{$URLSegment}" />
	<meta property="og:title" content="$Title" />

	<% if MetaDescription %>
		<meta property="og:description" content="$MetaDescription" />
	<% end_if %>

	<% if OgImage %>
		<meta property="og:image" content="$OgImage.AbsoluteURL" />
    	<% else %>
		<meta property="og:image" content="{$absoluteBaseHref}app/images/sample-logo.png" />
	<% end_if %>

	<link rel="shortcut icon" type="image/ico" href="/favicon.ico" />
	<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
	<link rel="shortcut-icon" href="/favicon.ico" />

	<% include GoogleAnalytics %>

</head>
<body class="<% if URLSegment == 'Security' %>Security<% else %>$ClassName<% end_if %>">
