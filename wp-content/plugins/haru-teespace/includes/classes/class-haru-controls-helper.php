<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

namespace Haru_TeeSpace\Classes;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

use \Elementor\Controls_Manager;

class Helper {

    /**
     * Include a file with variables
     *
     * @param $file_path
     * @param $variables
     *
     * @return string
     * @since  4.2.2
     */
    public static function include_with_variable( $file_path, $variables = []) {
        if ( file_exists( $file_path ) ) {
            extract($variables);

            ob_start();

            include $file_path;

            return ob_get_clean();
        }

        return '';
    }

    /**
     * check EAEL extension can load this page or post
     *
     * @param $id  page or post id
     *
     * @return bool
     * @since  4.0.4
     */
    public static function prevent_extension_loading( $post_id ) {
        $template_name = get_post_meta($post_id, '_elementor_template_type', true);
        $template_list = [
            'header',
            'footer',
            'single',
            'post',
            'page',
            'archive',
            'search-results',
            'error-404',
            'product',
            'product-archive',
            'section',
        ];

        return in_array($template_name, $template_list);
    }

    public static function fix_old_query( $settings ) {
        $update_query = false;

        foreach ( $settings as $key => $value ) {
            if ( strpos($key, 'eaeposts_') !== false ) {
                $settings[str_replace( 'eaeposts_', '', $key )] = $value;
                $update_query = true;
            }
        }

        if ( $update_query ) {
            global $wpdb;

            $post_id = get_the_ID();
            $data = get_post_meta( $post_id, '_elementor_data', true );
            $data = str_replace( 'eaeposts_', '', $data );
            $wpdb->update(
                $wpdb->postmeta,
                [
                    'meta_value' => $data,
                ],
                [
                    'post_id' => $post_id,
                    'meta_key' => '_elementor_data',
                ]
            );
        }

        return $settings;
    }

    public static function get_query_args($settings = [], $post_type = 'post') {
        $settings = wp_parse_args($settings, [
            'post_type' => $post_type,
            'posts_ids' => [],
            'orderby' => 'date',
            'order' => 'desc',
            'posts_per_page' => 3,
            'offset' => 0,
            'post__not_in' => [],
        ]);

        $args = [
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status' => 'publish',
            'posts_per_page' => $settings['posts_per_page'],
            'offset' => $settings['offset'],
        ];

        if ( 'by_id' === $settings['post_type'] ) {
            $args['post_type'] = 'any';
            $args['post__in'] = empty($settings['posts_ids']) ? [0] : $settings['posts_ids'];
        } else {
            $args['post_type'] = $settings['post_type'];

            if ( $args['post_type'] !== 'page' ) {
                $args['tax_query'] = [];

                $taxonomies = get_object_taxonomies( $settings['post_type'], 'objects' );

                foreach ( $taxonomies as $object ) {
                    $setting_key = $object->name . '_ids';

                    if ( ! empty( $settings[$setting_key] ) ) {
                        $args['tax_query'][] = [
                            'taxonomy' => $object->name,
                            'field' => 'term_id',
                            'terms' => $settings[$setting_key],
                        ];
                    }
                }

                if ( ! empty( $args['tax_query'] ) ) {
                    $args['tax_query']['relation'] = 'AND';
                }
            }
        }

        if ( ! empty( $settings['authors'] ) ) {
            $args['author__in'] = $settings['authors'];
        }

        if ( ! empty( $settings['post__not_in'] ) ) {
            $args['post__not_in'] = $settings['post__not_in'];
        }

        return $args;
    }

    public static function get_product_query_args($settings = [], $post_type = 'product') {
        global $wp_query, $paged;
            
        if ( is_front_page() ) {
            $paged = get_query_var( 'page' ) ? intval( get_query_var( 'page' ) ) : 1;
        } else {
            $paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
        }

        $settings = wp_parse_args($settings, [
            'post_type' => $post_type,
            'product_ids' => [],
            'orderby' => 'date',
            'order' => 'desc',
            'posts_per_page' => 3,
            // 'offset' => 0,
            'post__not_in' => [],
        ]);

        $args = [
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'post_status' => 'publish',
            'paged'          => isset($settings['paged']) ? $settings['paged'] : $paged,
            'posts_per_page' => $settings['posts_per_page'],
            // 'offset' => $settings['offset'],
        ];

        if ( 'by_id' === $settings['post_type'] ) {
            $args['post_type'] = 'product';
            $args['post__in'] = empty($settings['product_ids']) ? [0] : $settings['product_ids'];

            if ( ! empty( $settings['product_cat_ids'] ) ) {
                $args['tax_query'] = [];

                $args['tax_query'][] = [
                    'taxonomy' => 'product_cat',
                    'field' => 'term_id',
                    'terms' => $settings['product_cat_ids'],
                ];
            }
        } else {
            $args['post_type'] = $settings['post_type'];

            // if ( $args['post_type'] !== 'page' ) {
                $args['tax_query'] = [];

                $taxonomies = get_object_taxonomies( $settings['post_type'], 'objects' );

                foreach ( $taxonomies as $object ) {
                    $setting_key = $object->name . '_ids';

                    if ( ! empty( $settings[$setting_key] ) ) {
                        $args['tax_query'][] = [
                            'taxonomy' => $object->name,
                            'field' => 'term_id',
                            'terms' => $settings[$setting_key],
                        ];
                    }
                }

                if ( ! empty( $args['tax_query'] ) ) {
                    $args['tax_query']['relation'] = 'AND';
                }
            // }
        }

        // if ( ! empty( $settings['authors'] ) ) {
        //     $args['author__in'] = $settings['authors'];
        // }

        if ( ! empty( $settings['post__not_in'] ) ) {
            $args['post__not_in'] = $settings['post__not_in'];
        }

        return $args;
    }

    public static function get_product_variable_list($settings = [], $post_type = 'product') {
        $data = [];
        $args = [
            'status'    => 'publish',
            'orderby' => 'name',
            'order'   => 'ASC',
            'limit' => -1,
        ];

        $all_products = wc_get_products( $args );

        foreach ( $all_products as $key => $product ) {
            if ($product->get_type() == "variable") {
                $data[$product->get_id()] = $product->get_title();
            }
        }

        return $data;
    }

    /**
     * Get All POst Types
     * @return array
     */
    public static function get_post_types() {
        $post_types = get_post_types( ['public' => true, 'show_in_nav_menus' => true], 'objects' );
        $post_types = wp_list_pluck( $post_types, 'label', 'name' );

        return array_diff_key( $post_types, ['elementor_library', 'attachment'] );
    }

    /**
     * Get all types of post.
     *
     * @param  string  $post_type
     *
     * @return array
     */
    public static function get_post_list( $post_type = 'any' ) {
        return self::get_query_post_list( $post_type );
    }

    /**
     * Post Orderby Options
     *
     * @return array
     */
    public static function get_post_orderby_options() {
        $orderby = array(
            'ID' => 'Post ID',
            'author' => 'Post Author',
            'title' => 'Title',
            'date' => 'Date',
            'modified' => 'Last Modified Date',
            'parent' => 'Parent Id',
            'rand' => 'Random',
            'comment_count' => 'Comment Count',
            'menu_order' => 'Menu Order',
        );

        return $orderby;
    }

    /**
     * Product Orderby Options
     *
     * @return array
     */
    public static function get_product_orderby_options() {
        $orderby = array(
            'ID' => 'Product ID',
            'author' => 'Product Author',
            'title' => 'Title',
            'date' => 'Date',
            'modified' => 'Last Modified Date',
            'parent' => 'Parent Id',
            'rand' => 'Random',
            'comment_count' => 'Comment Count',
            'menu_order' => 'Menu Order',
        );

        return $orderby;
    }

    /**
     * Get Post Categories
     *
     * @return array
     */
    public static function get_terms_list( $taxonomy = 'category', $key = 'term_id' ) {
        $options = [];
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ]);

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $options[$term->{$key}] = $term->name;
            }
        }

        return $options;
    }


    /**
     * Get Custom Taxonomy Terms
     *
     * @return array
     */
    public static function get_terms( $taxonomy = 'category', $terms_ids = array() ) {
        $args = [
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
        ];

        if ( $terms_ids ) {
            $args['include'] = $terms_ids;
        }

        $terms = get_terms( $args );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            return $terms;
        }

        return $terms;
    }


    /**
     * Get all elementor page templates
     *
     * @param  null  $type
     *
     * @return array
     */
    public static function get_elementor_templates( $type = null ) {
        $options = [];

        if ( $type ) {
            $args = [
                'post_type' => 'elementor_library',
                'posts_per_page' => -1,
            ];
            $args['tax_query'] = [
                [
                    'taxonomy' => 'elementor_library_type',
                    'field' => 'slug',
                    'terms' => $type,
                ],
            ];

            $page_templates = get_posts($args);

            if (!empty($page_templates) && !is_wp_error($page_templates)) {
                foreach ($page_templates as $post) {
                    $options[$post->ID] = $post->post_title;
                }
            }
        } else {
            $options = self::get_query_post_list('elementor_library');
        }

        return $options;
    }

    /**
     * Get all megamenu templates
     *
     * @param  null  $type
     *
     * @return array
     */
    public static function get_megamenu_templates() {
        $options = [];

        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'haru_megamenu',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'suppress_filters' => true 
        );

        $megamenu_templates = get_posts( $args );

        if ( !empty( $megamenu_templates ) && !is_wp_error( $megamenu_templates ) ) {
            foreach ( $megamenu_templates as $post ) {
                $options[$post->ID] = $post->post_title;
            }
        }

        return $options;
    }

    /**
     * Get all content templates
     *
     * @param  null  $type
     *
     * @return array
     */
    public static function get_content_templates() {
        $options = [];

        $args = array(
            'posts_per_page'   => -1,
            'offset'           => 0,
            'category'         => '',
            'category_name'    => '',
            'orderby'          => 'post_date',
            'order'            => 'DESC',
            'include'          => '',
            'exclude'          => '',
            'meta_key'         => '',
            'meta_value'       => '',
            'post_type'        => 'haru_content',
            'post_mime_type'   => '',
            'post_parent'      => '',
            'suppress_filters' => true 
        );

        $content_templates = get_posts( $args );

        if ( !empty( $content_templates ) && !is_wp_error( $content_templates ) ) {
            foreach ( $content_templates as $post ) {
                $options[$post->ID] = $post->post_title;
            }
        }

        return $options;
    }

    /**
     * Get all Authors
     *
     * @return array
     */
    public static function get_authors_list()
    {
        $users = get_users([
            'capability' => array( 'edit_posts' ),
            'has_published_posts' => true,
            'fields' => [
                'ID',
                'display_name',
            ],
        ]);

        if (!empty($users)) {
            return wp_list_pluck($users, 'display_name', 'ID');
        }

        return [];
    }

    /**
     * Get all Tags
     *
     * @param  array  $args
     *
     * @return array
     */
    public static function get_tags_list($args = array())
    {
        $options = [];
        $tags = get_tags($args);

        if (!is_wp_error($tags) && !empty($tags)) {
            foreach ($tags as $tag) {
                $options[$tag->term_id] = $tag->name;
            }
        }

        return $options;
    }

    /**
     * Get all taxonomies by post
     *
     * @param  array   $args
     *
     * @param  string  $output
     * @param  string  $operator
     *
     * @return array
     */
    public static function get_taxonomies_by_post($args = [], $output = 'names', $operator = 'and')
    {
        global $wp_taxonomies;

        $field = ('names' === $output) ? 'name' : false;

        // Handle 'object_type' separately.
        if (isset($args['object_type'])) {
            $object_type = (array) $args['object_type'];
            unset($args['object_type']);
        }

        $taxonomies = wp_filter_object_list($wp_taxonomies, $args, $operator);

        if (isset($object_type)) {
            foreach ($taxonomies as $tax => $tax_data) {
                if (!array_intersect($object_type, $tax_data->object_type)) {
                    unset($taxonomies[$tax]);
                }
            }
        }

        if ($field) {
            $taxonomies = wp_list_pluck($taxonomies, $field);
        }

        return $taxonomies;
    }

    /**
     * Get Contact Form 7 [ if exists ]
     */
    public static function get_wpcf7_list()
    {
        $options = array();

        if (function_exists('wpcf7')) {
            $wpcf7_form_list = get_posts(array(
                'post_type' => 'wpcf7_contact_form',
                'showposts' => 999,
            ));
            $options[0] = esc_html__('Select a Contact Form', 'essential-addons-for-elementor-lite');
            if (!empty($wpcf7_form_list) && !is_wp_error($wpcf7_form_list)) {
                foreach ($wpcf7_form_list as $post) {
                    $options[$post->ID] = $post->post_title;
                }
            } else {
                $options[0] = esc_html__('Create a Form First', 'essential-addons-for-elementor-lite');
            }
        }
        return $options;
    }

    /**
     * Get Gravity Form [ if exists ]
     *
     * @return array
     */
    public static function get_gravity_form_list()
    {
        $options = array();

        if (class_exists('GFCommon')) {
            $gravity_forms = \RGFormsModel::get_forms(null, 'title');

            if (!empty($gravity_forms) && !is_wp_error($gravity_forms)) {

                $options[0] = esc_html__('Select Gravity Form', 'essential-addons-for-elementor-lite');
                foreach ($gravity_forms as $form) {
                    $options[$form->id] = $form->title;
                }

            } else {
                $options[0] = esc_html__('Create a Form First', 'essential-addons-for-elementor-lite');
            }
        }

        return $options;
    }

    /**
     * Get WeForms Form List
     *
     * @return array
     */
    public static function get_weform_list()
    {
        $wpuf_form_list = get_posts(array(
            'post_type' => 'wpuf_contact_form',
            'showposts' => 999,
        ));

        $options = array();

        if (!empty($wpuf_form_list) && !is_wp_error($wpuf_form_list)) {
            $options[0] = esc_html__('Select weForm', 'essential-addons-for-elementor-lite');
            foreach ($wpuf_form_list as $post) {
                $options[$post->ID] = $post->post_title;
            }
        } else {
            $options[0] = esc_html__('Create a Form First', 'essential-addons-for-elementor-lite');
        }

        return $options;
    }

    /**
     * Get Ninja Form List
     *
     * @return array
     */
    public static function get_ninja_form_list()
    {
        $options = array();

        if (class_exists('Ninja_Forms')) {
            $contact_forms = Ninja_Forms()->form()->get_forms();

            if (!empty($contact_forms) && !is_wp_error($contact_forms)) {

                $options[0] = esc_html__('Select Ninja Form', 'essential-addons-for-elementor-lite');

                foreach ($contact_forms as $form) {
                    $options[$form->get_id()] = $form->get_setting('title');
                }
            }
        } else {
            $options[0] = esc_html__('Create a Form First', 'essential-addons-for-elementor-lite');
        }

        return $options;
    }

    /**
     * Get Caldera Form List
     *
     * @return array
     */
    public static function get_caldera_form_list()
    {
        $options = array();

        if (class_exists('Caldera_Forms')) {
            $contact_forms = \Caldera_Forms_Forms::get_forms(true, true);

            if (!empty($contact_forms) && !is_wp_error($contact_forms)) {
                $options[0] = esc_html__('Select Caldera Form', 'essential-addons-for-elementor-lite');
                foreach ($contact_forms as $form) {
                    $options[$form['ID']] = $form['name'];
                }
            }
        } else {
            $options[0] = esc_html__('Create a Form First', 'essential-addons-for-elementor-lite');
        }

        return $options;
    }

    /**
     * Get WPForms List
     *
     * @return array
     */
    public static function get_wpforms_list()
    {
        $options = array();

        if (class_exists('\WPForms\WPForms')) {
            $args = array(
                'post_type' => 'wpforms',
                'posts_per_page' => -1,
            );

            $contact_forms = get_posts($args);

            if (!empty($contact_forms) && !is_wp_error($contact_forms)) {
                $options[0] = esc_html__('Select a WPForm', 'essential-addons-for-elementor-lite');
                foreach ($contact_forms as $post) {
                    $options[$post->ID] = $post->post_title;
                }
            }
        } else {
            $options[0] = esc_html__('Create a Form First', 'essential-addons-for-elementor-lite');
        }

        return $options;
    }

    /**
     * Get FluentForms List
     *
     * @return array
     */
    public static function get_fluent_forms_list()
    {

        $options = array();

        if (defined('FLUENTFORM')) {
            global $wpdb;

            $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}fluentform_forms");
            if ($result) {
                $options[0] = esc_html__('Select a Fluent Form', 'essential-addons-for-elementor-lite');
                foreach ($result as $form) {
                    $options[$form->id] = $form->title;
                }
            } else {
                $options[0] = esc_html__('Create a Form First', 'essential-addons-for-elementor-lite');
            }
        }

        return $options;

    }

    public static function get_ninja_tables_list()
    {
        $tables = get_posts([
            'post_type' => 'ninja-table',
            'post_status' => 'publish',
            'posts_per_page' => '-1',
        ]);

        if (!empty($tables)) {
            return wp_list_pluck($tables, 'post_title', 'ID');
        }

        return [];
    }

    public static function get_terms_as_list($term_type = 'category', $length = 1)
    {
        if ($term_type === 'category') {
            $terms = get_the_category();
        }

        if ($term_type === 'tags') {
            $terms = get_the_tags();
        }

        if (empty($terms)) {
            return;
        }

        $count = 0;

        $html = '<ul class="post-carousel-categories">';
        foreach ($terms as $term) {
            if ($count === $length) {break;}
            $link = ($term_type === 'category') ? get_category_link($term->term_id) : get_tag_link($term->term_id);
            $html .= '<li>';
            $html .= '<a href="' . esc_url($link) . '">';
            $html .= $term->name;
            $html .= '</a>';
            $html .= '</li>';
            $count++;
        }
        $html .= '</ul>';

        return $html;

    }

    /**
     * This function is responsible for counting doc post under a category.
     *
     * @param int $term_count
     * @param int $term_id
     * @return int $term_count;
     */
    public static function get_doc_post_count($term_count = 0, $term_id = '')
    {
        $tax_terms = get_terms('doc_category', ['child_of' => $term_id]);

        foreach ($tax_terms as $tax_term) {
            $term_count += $tax_term->count;
        }

        return $term_count;
    }

    public static function get_dynamic_args(array $settings, array $args)
    {
        if ($settings['post_type'] === 'source_dynamic' && is_archive()) {

            $data = get_queried_object();
            if (isset($data->post_type)) {
                $args['post_type'] = $data->post_type;

                $args['tax_query'] = [];

                if ($data->taxonomy) {
                    $args['tax_query'][] = [
                        'taxonomy' => $data->taxonomy,
                        'field' => 'term_id',
                        'terms' => $data->term_id,
                    ];
                }
            } else {
                global $wp_query;

                $args['post_type'] = $wp_query->query_vars['post_type'];
            }

            if (get_query_var('author') > 0) {
                $args['author__in'] = get_query_var('author');
            }

            if (get_query_var('year') || get_query_var('monthnum') || get_query_var('day')) {
                $args['date_query'] = [
                    'year' => get_query_var('year'),
                    'month' => get_query_var('monthnum'),
                    'day' => get_query_var('day'),
                ];
            }

            if (!empty($args['tax_query'])) {
                $args['tax_query']['relation'] = 'AND';
            }
        }

        return $args;
    }

    public static function get_multiple_kb_terms($prettify = false, $term_id = true)
    {
        $args = [
            'taxonomy' => 'knowledge_base',
            'hide_empty' => true,
            'parent' => 0,
        ];

        $terms = get_terms($args);

        if (is_wp_error($terms)) {
            return [];
        }

        if ($prettify) {
            $pretty_taxonomies = [];

            foreach ($terms as $term) {
                $pretty_taxonomies[$term_id ? $term->term_id : $term->slug] = $term->name;
            }

            return $pretty_taxonomies;
        }

        return $terms;
    }

    public static function get_betterdocs_multiple_kb_status()
    {
        if (\BetterDocs_DB::get_settings('multiple_kb') == 1) {
            return 'true';
        }

        return '';
    }

    public static function get_query_post_list($post_type = 'any', $limit = -1, $search = '')
    {
        global $wpdb;
        $where = '';
        $data = [];

        if (-1 == $limit) {
            $limit = '';
        } elseif (0 == $limit) {
            $limit = "limit 0,1";
        } else {
            $limit = $wpdb->prepare(" limit 0,%d", esc_sql($limit));
        }

        if ('any' === $post_type) {
            $in_search_post_types = get_post_types(['exclude_from_search' => false]);
            if (empty($in_search_post_types)) {
                $where .= ' AND 1=0 ';
            } else {
                $where .= " AND {$wpdb->posts}.post_type IN ('" . join("', '",
                    array_map('esc_sql', $in_search_post_types)) . "')";
            }
        } elseif (!empty($post_type)) {
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_type = %s", esc_sql($post_type));
        }

        if (!empty($search)) {
            $where .= $wpdb->prepare(" AND {$wpdb->posts}.post_title LIKE %s", '%' . esc_sql($search) . '%');
        }

        $query = "select post_title,ID  from $wpdb->posts where post_status = 'publish' $where $limit";
        $results = $wpdb->get_results($query);
        if (!empty($results)) {
            foreach ($results as $row) {
                $data[$row->ID] = $row->post_title;
            }
        }
        return $data;
    }
}
