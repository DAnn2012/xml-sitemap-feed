<?php
/**
 * XML Sitemap Index Feed Template
 *
 * @package XML Sitemap Feed plugin for WordPress
 */

if ( ! defined( 'WPINC' ) ) die;

// Do xml tag via echo or SVN parser is going to freak out.
echo '<?xml version="1.0" encoding="' . get_bloginfo('charset') . '"?>'; ?>
<?php xmlsf_xml_stylesheet(); ?>
<?php do_action( 'xmlsf_generator' ); ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
		http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd">
	<sitemap>
		<loc><?php echo xmlsf_sitemap_url( 'root' ); ?></loc>
		<lastmod><?php echo get_date_from_gmt( get_lastpostdate( 'GMT' ), DATE_W3C ); ?></lastmod>
	</sitemap>
<?php

// Public post types.
$post_types = xmlsf_get_post_types();
foreach ( $post_types as $post_type => $settings ) :
	$archive = isset( $settings['archive'] ) ? $settings['archive'] : '';
	$archive_data = apply_filters( 'xmlsf_index_archive_data', array(), $post_type, $archive );

	foreach ( $archive_data as $url => $lastmod ) {
?>
	<sitemap>
		<loc><?php echo $url; ?></loc>
		<lastmod><?php echo $lastmod; ?></lastmod>
	</sitemap>
<?php
	}
endforeach;

// Public taxonomies.
$taxonomies = xmlsf_get_taxonomies();
foreach ( $taxonomies as $taxonomy ) : ?>
	<sitemap>
		<loc><?php echo xmlsf_sitemap_url( 'taxonomy', array( 'type' => $taxonomy ) ); ?></loc>
<?php if ( $lastmod = xmlsf_get_taxonomy_modified( $taxonomy ) ) { ?>
		<lastmod><?php echo $lastmod; ?></lastmod>
<?php } ?>
	</sitemap>
<?php
endforeach;

// Authors.
if ( xmlsf_do_authors() ) : ?>
	<sitemap>
		<loc><?php echo xmlsf_sitemap_url( 'author' ); ?></loc>
		<lastmod><?php echo get_date_from_gmt( get_lastpostdate( 'GMT' ), DATE_W3C ); ?></lastmod>
	</sitemap>
<?php
endif;

// Custom URLs sitemap.
if ( apply_filters( 'xmlsf_custom_urls', get_option( 'xmlsf_urls' ) ) ) :
?>
	<sitemap>
		<loc><?php echo xmlsf_sitemap_url( 'custom' ); ?></loc>
	</sitemap>
<?php
endif;

// Custom sitemaps.
$custom_sitemaps = apply_filters( 'xmlsf_custom_sitemaps', get_option( 'xmlsf_custom_sitemaps', array() ) );
if ( is_array( $custom_sitemaps ) ) :
	foreach ( $custom_sitemaps as $url ) {
		if ( empty( $url ) ) continue;
?>
	<sitemap>
		<loc><?php echo esc_url( $url ); ?></loc>
	</sitemap>
<?php
	}
endif;
?></sitemapindex>
<?php xmlsf_usage(); ?>
