<?php
/**
 * XMLSitemapFeed CLASS
 *
 * @package XML Sitemap & Google News
 */

/**
 * XMLSitemapFeed CLASS
 */
class XMLSitemapFeed {

	/**
	 * Defaults
	 *
	 * @var array
	 */
	private $defaults = array();

	/**
	 * News defaults
	 *
	 * @var array
	 */
	public $default_news_tags = array(
		'name'       => '',
		'post_type'  => array( 'post' ),
		'categories' => '',
	);

	/**
	 * Front pages
	 *
	 * @var null/array $frontpages
	 */
	public $frontpages = null;

	/**
	 * Signifies whether the request has been filtered.
	 *
	 * @var bool
	 */
	public $request_filtered = false;

	/**
	 * Signifies whether the current query is for a sitemap feed.
	 *
	 * @var bool
	 */
	public $is_sitemap = false;

	/**
	 * Signifies whether the request has been filtered for news.
	 *
	 * @var bool
	 */
	public $request_filtered_news = false;

	/**
	 * Signifies whether the current query is for a news feed.
	 *
	 * @var bool
	 */
	public $is_news = false;

	/**
	 * Allowed domain names
	 *
	 * @var null|array $domains
	 */
	private $domains = null;

	/**
	 * Site public scheme
	 *
	 * @var string $domain
	 */
	private $scheme;

	/**
	 * Excluded post types
	 *
	 * @var array
	 */
	private $disabled_post_types = array(
		'attachment',
		'reply', // bbPress.
		'buddypress', // BuddyPress Directory internal post type.
	);

	/**
	 * Excluded taxonomies
	 *
	 * @var array
	 */
	private $disabled_taxonomies = array(
		'product_shipping_class',
		// 'post_format',
	);

	/**
	 * Maximum number of posts in any taxonomy term
	 *
	 * @var null|int $taxonomy_termmaxposts
	 */
	public $taxonomy_termmaxposts = null;

	/**
	 * Unix last modified date
	 *
	 * @var int $lastmodified
	 */
	public $lastmodified;

	/**
	 * Unix time spanning first post date and last modified date
	 *
	 * @var int $timespan
	 */
	public $timespan = 0;

	/**
	 * Post type total approved comment count
	 *
	 * @var int $comment_count
	 */
	public $comment_count = 0;

	/**
	 * Blog pages
	 *
	 * @var null/array $blogpages
	 */
	public $blogpages = null;

	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {}

	/**
	 * Default options
	 *
	 * @param bool $key Which key to get.
	 *
	 * @return array
	 */
	public function defaults( $key = false ) {
		if ( empty( $this->defaults ) ) :

			// sitemaps.
			$sitemaps = ( '1' !== get_option( 'blog_public' ) ) ? array() : array(
				'sitemap' => 'sitemap.xml',
			);

			$this->defaults = array(
				'sitemaps'          => $sitemaps,
				'general_settings'  => array(
					'server' => class_exists( 'SimpleXMLElement' ) ? 'core' : 'plugin',
					'limit'  => 2000,
				),
				'post_types'        => array(
					'post' => array(
						'active'           => '1',
						'archive'          => 'yearly',
						'priority'         => '0.7',
						'dynamic_priority' => '',
						'tags'             => array(
							'image' => 'featured',
							/*'video' => ''*/
						),
					),
					'page' => array(
						'active'           => '1',
						'priority'         => '0.5',
						'dynamic_priority' => '',
						'tags'             => array(
							'image' => 'attached',
							/*'video' => ''*/
						),
					),
				),
				'taxonomies'        => '',
				'taxonomy_settings' => array(
					'active'           => '',
					'priority'         => '0.3',
					'dynamic_priority' => '',
					'limit'            => 2000,
				),
				'authors'           => '',
				'author_settings'   => array(
					'active'   => '1',
					'priority' => '0.3',
					'limit'    => 2000,
				),
				'robots'            => '',
				'urls'              => '',
				'custom_sitemaps'   => '',
				'domains'           => '',
			);

		endif;

		if ( $key ) {
			$return = ( isset( $this->defaults[ $key ] ) ) ? $this->defaults[ $key ] : '';
		} else {
			$return = $this->defaults;
		}

		return apply_filters( 'xmlsf_defaults', $return, $key );
	}

	/**
	 * Get domain
	 *
	 * @return array
	 */
	public function get_allowed_domains() {
		// Allowed domain.
		if ( null === $this->domains ) {
			$host          = wp_parse_url( home_url(), PHP_URL_HOST );
			$this->domains = ( ! empty( $host ) ) ? (array) $host : array();
			$domains       = get_option( 'xmlsf_domains' );

			if ( ! empty( $domains ) ) {
				$this->domains = array_merge( $this->domains, (array) $domains );
			}
		}

		return $this->domains;
	}

	/**
	 * Get scheme
	 *
	 * @return string
	 */
	public function scheme() {
		// Scheme to use.
		if ( empty( $this->scheme ) ) {
			$scheme       = wp_parse_url( home_url(), PHP_URL_SCHEME );
			$this->scheme = $scheme ? $scheme : 'http';
		}

		return $this->scheme;
	}

	/**
	 * Get disabled taxonomies
	 *
	 * @return array
	 */
	public function disabled_taxonomies() {
		return apply_filters( 'xmlsf_disabled_taxonomies', $this->disabled_taxonomies );
	}

	/**
	 * Get disabled post types
	 *
	 * @return array
	 */
	public function disabled_post_types() {
		return apply_filters( 'xmlsf_disabled_post_types', $this->disabled_post_types );
	}
}
