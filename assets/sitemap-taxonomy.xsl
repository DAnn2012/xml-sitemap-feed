<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>XML Sitemap — Taxonomy</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style type="text/css">body{font-family:"Lucida Grande","Lucida Sans Unicode",Tahoma,Verdana,sans-serif;font-size:13px}#header,#footer{padding:2px;margin:10px;font-size:8pt;color:gray}a{color:black}td{font-size:11px}th{text-align:left;padding-right:30px;font-size:11px}tr.high{background-color:whitesmoke}#footer img{vertical-align:middle}</style>
</head>
<body>
	<h1>XML Sitemap — Taxonomy</h1>
	<div id="header">
		<p>This is an XML Sitemap to aid search engines like <a href="https://www.google.com">Google</a>, <a href="https://www.bing.com/">Bing</a>, <a href="https://www.yahoo.com">Yahoo!</a> and <a href="https://www.ask.com">Ask</a> indexing your site better. Read more about XML sitemaps on <a href="https://www.sitemaps.org/">Sitemaps.org</a>.</p>
	</div>
	<div id="content">
		<table cellpadding="5">
			<tr class="high">
				<th>#</th>
				<th>URL</th>
				<th>Priority</th>
				<th>Last Modified</th>
			</tr>
<xsl:variable name="lower" select="'abcdefghijklmnopqrstuvwxyz'"/>
<xsl:variable name="upper" select="'ABCDEFGHIJKLMNOPQRSTUVWXYZ'"/>
<xsl:for-each select="sitemap:urlset/sitemap:url">
			<tr><xsl:if test="position() mod 2 != 1"><xsl:attribute  name="class">high</xsl:attribute></xsl:if>
				<td><xsl:value-of select="position()"/></td>
				<td><xsl:variable name="itemURL"><xsl:value-of select="sitemap:loc"/></xsl:variable><a href="{$itemURL}"><xsl:value-of select="sitemap:loc"/></a></td>
				<td><xsl:if test="sitemap:priority"><xsl:value-of select="concat(sitemap:priority*100,'%')"/></xsl:if></td>
				<td><xsl:if test="sitemap:lastmod"><xsl:value-of select="concat(substring(sitemap:lastmod,0,11),concat(' ', substring(sitemap:lastmod,12,8)))"/> (<xsl:value-of select="substring(sitemap:lastmod,20,6)"/>)</xsl:if></td>
			</tr>
</xsl:for-each>
		</table>
	</div>
	<div id="footer">
		<p><img src="data:image/gif;base64,R0lGODlhUAAPAJEAAGZmZv////9mAImOeSwAAAAAUAAPAAACoISPqcvtD0+YtNqLs968myCE4kiW5jkGw8q27gvDwYfWdq3G+i7T9w/M8Ya7GQAUoiSTEyYSKYA2nSKhdXUdCIlaXzRVDVdB0+dS2lJZ1bkt0Sgti6NysvM5jbq2ai2WywJHYrZUaEhIWJXm99foNiRI9XUoV4g4GJjJyEgBGAkEivIIyPUZeppCqorlheo6ulr00UFba3uLEaG7y9urUAAAOw%3D%3D" alt="XML Sitemap" title="XML Sitemap" /> managed by <a href="https://status301.net/wordpress-plugins/xml-sitemap-feed/">XML Sitemap &amp; Google News</a> for <a href="https://wordpress.org/">WordPress</a>.</p>
	</div>
</body>
</html>
</xsl:template>
</xsl:stylesheet>
