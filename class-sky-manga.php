<?php
/**
 * Sky_iManga Class
 *
 * @author  : KENT <thietke4rum@gmail.com>
 * @since   : 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'Sky_iManga' ) ) :

	class Sky_iManga {

		/**
		 *    Initialize class
		 */
		public function __construct() {
			add_action( 'init', 'Sky_iManga::register_post_type' );

			add_action( 'add_meta_boxes', 'Sky_iManga::register_metabox' );

			add_action( 'wp_ajax_sky_new_chapper', 'Sky_iManga::ajax_new_chapper' );
			add_action( 'wp_ajax_nopriv_sky_new_chapper', 'Sky_iManga::ajax_new_chapper' );

			add_action( 'wp_ajax_sky_remove_chapper', 'Sky_iManga::ajax_remove_chapper' );
			add_action( 'wp_ajax_nopriv_sky_remove_chapper', 'Sky_iManga::ajax_remove_chapper' );

			add_action( 'wp_ajax_sky_show_chapter', 'Sky_iManga::ajax_show_chapter' );
			add_action( 'wp_ajax_nopriv_sky_show_chapter', 'Sky_iManga::ajax_show_chapter' );

			add_action( 'wp_ajax_sky_report_chapper', 'Sky_iManga::ajax_report_chapper' );
			add_action( 'wp_ajax_nopriv_sky_report_chapper', 'Sky_iManga::ajax_report_chapper' );

			add_action( 'wp_ajax_sky_fix_report', 'Sky_iManga::ajax_fix_report_chapper' );
			add_action( 'wp_ajax_nopriv_sky_fix_report', 'Sky_iManga::ajax_fix_report_chapper' );

			add_action( 'wp_ajax_sky_tang_dau', 'Sky_iManga::ajax_sky_tang_dau' );
			add_action( 'wp_ajax_nopriv_sky_tang_dau', 'Sky_iManga::ajax_sky_tang_dau' );

			add_action( 'wp_ajax_sky_add_trich_doan', 'Sky_iManga::ajax_add_trich_doan' );
			add_action( 'wp_ajax_nopriv_sky_add_trich_doan', 'Sky_iManga::ajax_add_trich_doan' );

			add_action( 'wp_ajax_sky_favorites', 'Sky_iManga::ajax_add_favorites' );
			add_action( 'wp_ajax_nopriv_sky_favorites', 'Sky_iManga::ajax_add_favorites' );

			add_action( 'wp_ajax_sky_change_name', 'Sky_iManga::ajax_sky_change_name' );
			add_action( 'wp_ajax_nopriv_sky_change_name', 'Sky_iManga::ajax_sky_change_name' );

			add_action( 'wp_ajax_sky_modal_update', 'Sky_iManga::ajax_sky_modal_update' );
			add_action( 'wp_ajax_nopriv_sky_modal_update', 'Sky_iManga::ajax_sky_modal_update' );

			add_action( 'wp_ajax_sky_modal_remove', 'Sky_iManga::ajax_sky_modal_remove' );
			add_action( 'wp_ajax_nopriv_sky_modal_remove', 'Sky_iManga::ajax_sky_modal_remove' );

			add_action( 'wp_ajax_sky_send_message', 'Sky_iManga::ajax_sky_send_message' );
			add_action( 'wp_ajax_nopriv_sky_send_message', 'Sky_iManga::ajax_sky_send_message' );

			add_action( 'wp_ajax_sky_read_message', 'Sky_iManga::ajax_sky_read_message' );
			add_action( 'wp_ajax_nopriv_sky_read_message', 'Sky_iManga::ajax_sky_read_message' );

			add_action( 'wp_ajax_sky_yeu_cau_truyen', 'Sky_iManga::ajax_sky_yeu_cau_truyen' );
			add_action( 'wp_ajax_nopriv_sky_yeu_cau_truyen', 'Sky_iManga::ajax_sky_yeu_cau_truyen' );

			add_action( 'wp_ajax_sky_follow', 'Sky_iManga::ajax_add_sky_follow' );
			add_action( 'wp_ajax_nopriv_sky_follow', 'Sky_iManga::ajax_add_sky_follow' );

			add_action( 'wp_ajax_sky_unfollow', 'Sky_iManga::ajax_add_sky_unfollow' );
			add_action( 'wp_ajax_nopriv_sky_unfollow', 'Sky_iManga::ajax_add_sky_unfollow' );

			add_action( 'wp_ajax_sky_remove', 'Sky_iManga::ajax_remove' );
			add_action( 'wp_ajax_nopriv_sky_remove', 'Sky_iManga::ajax_remove' );

			add_action( 'init', 'Sky_iManga::process_story' );

			add_action( 'init', 'Sky_iManga::process_user_manager' );

			add_action( 'sky_chapper_reading_before', 'Sky_iManga::process_chapper_reading', 3, 10 );

			add_action( 'sky_single_manga_before', 'sky_view_story' );

			add_filter( 'manage_edit-imanga_columns', 'Sky_iManga::add_table_columns_property' );
			add_filter( 'manage_imanga_posts_custom_column', 'Sky_iManga::show_table_columns_property' );

			add_action( 'save_post', 'Sky_iManga::update_point', 10, 3 );

			add_filter( 'pre_get_posts', 'Sky_iManga::sky_search_filter' );
		}

		public static function sky_search_filter( $query ) {

			if ( $query->is_search && ! is_admin() ) {
				$query->set( 'post_type', array( 'imanga' ) );
			}

			return $query;
		}

		/**
		 * Register post type
		 *
		 * @since 1.0.0
		 *
		 */
		public static function register_post_type() {
			$labels = array(
				'name'               => _x( 'Truyện Dài', 'post type general name', 'imanga' ),
				'singular_name'      => _x( 'Truyện Dài', 'post type singular name', 'imanga' ),
				'menu_name'          => _x( 'Truyện Dài', 'admin menu', 'imanga' ),
				'name_admin_bar'     => _x( 'Truyện Dài', 'add new on admin bar', 'imanga' ),
				'add_new'            => _x( 'Thêm Mới', 'book', 'imanga' ),
				'add_new_item'       => __( 'Thêm truyện', 'imanga' ),
				'new_item'           => __( 'Truyện Mới', 'imanga' ),
				'edit_item'          => __( 'Sửa truyện', 'imanga' ),
				'view_item'          => __( 'Xem truyện', 'imanga' ),
				'all_items'          => __( 'Tất cả truyện', 'imanga' ),
				'search_items'       => __( 'Tìm truyện', 'imanga' ),
				'parent_item_colon'  => __( 'Parent item:', 'imanga' ),
				'not_found'          => __( 'Not found.', 'imanga' ),
				'not_found_in_trash' => __( 'Not found in trash.', 'imanga' ),
			);

			$args = array(
				'labels'             => $labels,
				'description'        => '',
				'public'             => true,
				'publicly_queryable' => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'query_var'          => true,
				'rewrite'            => array( 'slug' => SKY_IMANGA_SLUG ),
				'capability_type'    => 'post',
				'has_archive'        => true,
				'menu_icon'          => 'dashicons-book-alt',
				'hierarchical'       => true,
				'can_export'         => true,
				'supports'           => array(
					'title',
					'editor',
					'thumbnail',
					'comments',
					'author',
				),
			);

			register_post_type( 'imanga', $args );

			register_taxonomy( 'manga-category', 'imanga', array(
				'labels'       => array(
					'name'          => esc_html__( 'Thể Loại', 'imanga' ),
					'add_new_item'  => esc_html__( 'Thêm Thể Loại Mới', 'imanga' ),
					'new_item_name' => esc_html__( 'New Category', 'imanga' ),
				),
				'hierarchical' => true,
				'query_var'    => true,
				'rewrite'      => array(
					'slug'       => SKY_IMANGA_CATEGORY_SLUG,
					'with_front' => true,
				),
			) );

			register_taxonomy( 'manga-author', 'imanga', array(
				'labels'       => array(
					'name'          => esc_html__( 'Tác Giả', 'imanga' ),
					'add_new_item'  => esc_html__( 'Thêm Tác Giả', 'imanga' ),
					'new_item_name' => esc_html__( 'New Author', 'imanga' ),
				),
				'hierarchical' => false,
				'query_var'    => true,
				'rewrite'      => array(
					'slug'       => SKY_IMANGA_AUTHOR_SLUG,
					'with_front' => true,
				),
			) );

			register_taxonomy( 'nhom-dich', 'imanga', array(
				'labels'       => array(
					'name'          => esc_html__( 'Nhóm Dịch', 'imanga' ),
					'add_new_item'  => esc_html__( 'Thêm Nhóm Dịch', 'imanga' ),
					'new_item_name' => esc_html__( 'Nhóm Dịch Mới', 'imanga' ),
				),
				'hierarchical' => true,
				'query_var'    => true,
				'rewrite'      => array(
					'slug'       => 'nhom-dich',
					'with_front' => true,
				),
			) );

			register_taxonomy( 'keyword', 'imanga', array(
				'labels'       => array(
					'name'          => esc_html__( 'Từ Khóa', 'imanga' ),
					'add_new_item'  => esc_html__( 'Thêm từ khóa', 'imanga' ),
					'new_item_name' => esc_html__( 'New Keyword', 'imanga' ),
				),
				'hierarchical' => false,
				'query_var'    => true,
				'rewrite'      => array(
					'slug'       => SKY_IMANGA_KEYWORD_SLUG,
					'with_front' => true,
				),
			) );
		}

		public static function add_table_columns_property( $columns ) {
			$columns[ 'featured' ] = 'Đề cử';

			return $columns;
		}

		public static function show_table_columns_property( $column_name ) {
			global $post;
			switch ( $column_name ) {
				case 'featured':
					?>
					<style type="text/css">
						th#featured {
							width: 75px;
						}
					</style>
					<?php
					$featured = get_post_meta( $post->ID, '_featured', true );
					$url      = wp_nonce_url( admin_url( 'admin-ajax.php?action=sky_set_feature&post_id=' . $post->ID ), 'sky-feature' );
					echo '<a href="' . esc_url( $url ) . '">';
					if ( 'yes' === $featured ) {
						echo '<span class="sky-feature" title="' . esc_html__( 'Yes', 'imanga' ) . '"><i class="dashicons dashicons-star-filled "></i></span>';
					} else {
						echo '<span class="sky-feature not-featured"  title="' . esc_html__( 'No', 'imanga' ) . '"><i class="dashicons dashicons-star-empty"></i></span>';
					}
					echo '</a>';
					break;
			}
		}

		/**
		 * Register metabox
		 *
		 * @since 1.0.0
		 *
		 */
		public static function register_metabox() {
			add_meta_box( 'sky-box-list-chapper', esc_html__( 'Danh sách chương', 'imanga' ), 'Sky_iManga::list_chapper_callback', 'imanga', 'advanced', 'high' );
			add_meta_box( 'sky-box-new-chapper', esc_html__( 'Thêm chương mới', 'imanga' ), 'Sky_iManga::add_chapper_new_callback', 'imanga', 'advanced', 'high' );
			add_meta_box( 'sky-box-type-chapper', esc_html__( 'Tình trạng', 'imanga' ), 'Sky_iManga::add_chapper_type_callback', 'imanga', 'side', 'high' );
		}

		/**
		 * Callback show list chapper
		 *
		 * @since 1.0.0
		 *
		 * @param $chapper_info
		 */
		public static function list_chapper_callback( $chapper_info ) {
			Sky_iManga::show_chapper( $chapper_info->ID, 10, 'desc' );
		}

		/**
		 * Callback add chapper new
		 *
		 * @since 1.0.0
		 *
		 * @param $chapper_info
		 */
		public static function add_chapper_new_callback( $chapper_info ) {
			?>
			<div id="sky-new-chapper">
				<p class="message"></p>
				<p>
					<label for="title"><?php echo esc_html__( 'Tiêu đề', 'imanga' ); ?></label>
					<input type="text" id="sky-chapper-title" />
				</p>
				<p>
					<label for="content"><?php echo esc_html__( 'Nội dung chương', 'imanga' ); ?></label>
					<textarea id="sky-chapper-content"></textarea>
				</p>
				<a class="button" href="#sky-new-chapper" id="sky-new" data-id="<?php echo $chapper_info->ID ?>">
					Thêm chương
				</a>
			</div>
			<?php
		}

		public static function add_chapper_type_callback( $chapper_info ) {
			$status = sky_get_post_meta( $chapper_info->ID, 'status', 'dang-ra' );
			?>
			<div id="sky-status">
				<div class="radio">
					<label>
						<input type="radio" name="sky-status" value="dang-ra" <?php checked( $status, 'dang-ra', true ) ?> />
						Đang ra
					</label>
				</div>
				<div class="radio">
					<label>
						<input type="radio" name="sky-status" value="hoan-thanh" <?php checked( $status, 'hoan-thanh', true ) ?> />
						Hoàn thành
					</label>
				</div>
			</div>
			<?php
		}

		/**
		 * Get list chapper
		 *
		 * @since 1.0.0
		 *
		 * @param $parent_id
		 *
		 * @param $limit
		 *
		 * @return array|bool|null|object
		 */
		public static function get_chapper( $parent_id, $limit = 0, $order = 'desc' ) {
			global $wpdb;

			$where = '';
			switch ( $order ) {
				case 'asc':
					$where .= ' ORDER BY id ASC';
					break;

				default:
					$where .= ' ORDER BY id DESC';
					break;
			}

			if ( ! empty( $limit ) ) {
				$where .= " LIMIT {$limit}";
			}
			$results = $wpdb->get_results( "SELECT * FROM wp_sky_chapper WHERE parent_id = {$parent_id}" . $where );

			if ( ! empty( $results ) ) {
				return $results;
			}

			return false;
		}

		public static function get_list_chapper($limit = 0, $order = 'desc' ) {
			global $wpdb;

			$where = '';
			switch ( $order ) {
				case 'asc':
					$where .= ' ORDER BY id ASC';
					break;

				default:
					$where .= ' ORDER BY id DESC';
					break;
			}

			if ( ! empty( $limit ) ) {
				$where .= " LIMIT {$limit}";
			}
			$results = $wpdb->get_results( "SELECT parent_id FROM wp_sky_chapper " . $where );

			if ( ! empty( $results ) ) {
				return $results;
			}

			return false;
		}

		/**
		 * Get chapper by id
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 *
		 * @return array|bool|null|object
		 */
		public static function get_chapper_by_id( $post_id ) {
			global $wpdb;

			$results = $wpdb->get_results( "SELECT * FROM wp_sky_chapper WHERE id = {$post_id}" );

			if ( ! empty( $results ) ) {
				return $results;
			}

			return false;
		}

		/**
		 * Get chapper by slug
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 *
		 * @return array|bool|null|object
		 */
		public static function get_chapper_by_slug( $post_id, $slug ) {
			global $wpdb;

			$results = $wpdb->get_results( "SELECT * FROM wp_sky_chapper WHERE slug = '$slug' AND parent_id = '$post_id'" );

			if ( ! empty( $results ) ) {
				return $results;
			}

			return false;
		}

		/**
		 * Find chapper
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 * @param $stt
		 *
		 * @return array|bool|null|object
		 */
		public static function find_chapper( $post_id, $stt ) {
			global $wpdb;

			$results = $wpdb->get_results( "SELECT * FROM wp_sky_chapper WHERE parent_id = {$post_id} AND stt = {$stt}" );

			if ( ! empty( $results ) ) {
				return $results;
			}

			return false;
		}

		/**
		 * Get chapper prev
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 *
		 * @return bool|string
		 */
		public static function prev_chapper( $post_id ) {
			$current_chapper = self::get_chapper_by_id( $post_id );
			if ( ! empty( $current_chapper[ 0 ]->stt ) ) {
				$current_stt = (int) $current_chapper[ 0 ]->stt;
				$prev_stt    = $current_stt - 1;

				$find_chapper = self::find_chapper( $current_chapper[ 0 ]->parent_id, $prev_stt );
				if ( ! empty( $find_chapper ) ) {
					return sky_permalink( $find_chapper[ 0 ]->parent_id, $find_chapper[ 0 ]->slug );
				}
			}

			return false;
		}

		/**
		 * Get chapper next
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 *
		 * @return bool|string
		 */
		public static function next_chapper( $post_id ) {
			$current_chapper = self::get_chapper_by_id( $post_id );
			if ( ! empty( $current_chapper[ 0 ]->stt ) ) {
				$current_stt = $current_chapper[ 0 ]->stt;

				$next_stt     = (int) $current_stt + 1;
				$find_chapper = self::find_chapper( $current_chapper[ 0 ]->parent_id, $next_stt );
				if ( ! empty( $find_chapper ) ) {
					return sky_permalink( $find_chapper[ 0 ]->parent_id, $find_chapper[ 0 ]->slug );
				}
			}

			return false;
		}

		/**
		 * Get chapper latest
		 *
		 * @since 1.0.0
		 *
		 * @param        $post_id
		 * @param string $style
		 */
		public static function get_chapper_latest( $post_id, $style = 'style-1' ) {
			$latest_id = (int) sky_get_post_meta( $post_id, 'chapter_end', 1 );

			$chapper_info = self::find_chapper( $post_id, $latest_id - 1 );
			if ( empty( $chapper_info[ 0 ] ) ) {
				return;
			}
			if ( 'style-1' === $style ) :
				?>
				<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>">
					<span class="text-info">
						<?php echo $chapper_info[ 0 ]->title ?>
					</span>
				</a>
			<?php elseif ( 'style-2' === $style ) : ?>
				<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>">
					<span class="text-red fz-16">
						<?php echo $chapper_info[ 0 ]->title ?>
					</span>
				</a>
			<?php elseif ( 'style-3' === $style ) : ?>
				<h5 class="media-heading"><?php echo $chapper_info[ 0 ]->title ?></h5>
				<small class="text-muted">
					<span class="glyphicon glyphicon-time" aria-hidden="true"></span>
					<?php echo sky_time_ago( $chapper_info[ 0 ]->time ); ?>
				</small>
				<?php
			else :
				echo $chapper_info[ 0 ]->title;
			endif;
		}

		/**
		 * Get time chapper latest
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 *
		 * @return bool|string
		 */
		public static function get_time_chapper_latest( $post_id ) {
			$latest_id = (int) sky_get_post_meta( $post_id, 'chapter_end', 1 );

			$chapper_info = self::find_chapper( $post_id, $latest_id - 1 );
			if ( empty( $chapper_info[ 0 ] ) ) {
				return false;
			}
			return sky_time_ago( $chapper_info[ 0 ]->time );
		}

		public static function get_chapper_first( $post_id, $class = '' ) {
			$chapper_info = self::find_chapper( $post_id, 1 );
			if ( empty( $chapper_info[ 0 ] ) ) {
				return;
			}
			?>
			<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>" <?php echo 'class="' . $class . '"' ?>>
				<?php echo $chapper_info[ 0 ]->title ?>
			</a>
			<?php
		}

		/**
		 * Show list chapper
		 *
		 * @since 1.0.0
		 *
		 * @param $parent_id
		 */
		public static function show_chapper( $parent_id, $limit = 0, $order = 'desc', $style = '' ) {
			$list_chapper = self::get_chapper( $parent_id, $limit, $order );

			if ( ! empty( $list_chapper ) ) {

				if ( empty( $style ) ) {
					echo '<ul>';
				}
				foreach ( $list_chapper as $chapper ) {
					if ( ! empty( $style ) ) {
						if ( 'style-1' == $style ) {
							?>
							<div class="item-value">
								<a href="<?php echo sky_permalink( $parent_id, $chapper->slug ); ?>">
									<?php echo $chapper->title; ?>
								</a>
							</div>
							<?php
						}
					} else {
						?>
						<li>
							<a href="<?php echo sky_permalink( $parent_id, $chapper->slug ); ?>">
								<?php echo $chapper->title; ?>
							</a>
						</li>
						<?php
					}
				}
				if ( empty( $style ) ) {
					echo '</ul>';
				}
			} else {
				echo '<p>There is no chapter</p>';
			}
		}

		/**
		 * Create chapper new
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 * @param $title
		 * @param $content
		 *
		 * @return false|int
		 */
		public static function create_chapper( $post_id, $title, $content, $stt ) {
			global $wpdb;
			$author_id = get_post_field( 'post_author', $post_id );

			delete_transient( 'sky_author_' . $author_id );
			delete_transient( 'sky_list_chapper_' . $post_id );

			$chapper_id = $wpdb->insert( 'wp_sky_chapper', array(
				'time'      => current_time( 'mysql' ),
				'parent_id' => absint( $post_id ),
				'stt'       => absint( $stt ),
				'title'     => stripslashes_deep( esc_html( $title ) ),
				'slug'      => sanitize_title( $title ),
				'content'   => stripslashes_deep( wp_kses_post( $content ) ),
				'author_id' => $author_id,
			) );

			return $chapper_id;
		}

		/**
		 * Create new chapper in dashboard
		 *
		 * @since 1.0.0
		 *
		 */
		public static function ajax_new_chapper() {
			$response = array();

			/**
			 * Validate data
			 */
			if ( ! empty( $_POST[ 'post_id' ] ) ) {
				$post_id    = absint( $_POST[ 'post_id' ] );
				$title      = sanitize_text_field( $_POST[ 'title' ] );
				$content    = trim( $_POST[ 'content' ] );
				$chapper_id = self::create_chapper( $post_id, $title, $content, 1 );
				if ( ! empty( $chapper_id ) ) {
					$author_id = get_post_field( 'post_author', $post_id );

					delete_transient( 'sky_author_' . $author_id );
					delete_transient( 'sky_list_chapper_' . $post_id );

					$response[ 'status' ]  = 'success';
					$response[ 'message' ] = esc_html__( 'Create chapper successfuly', 'imanga' );

					wp_send_json( $response );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Create chapper error', 'imanga' );
			wp_send_json( $response );
		}

		/**
		 * Show chapper
		 *
		 * @since 1.0.0
		 *
		 */
		public static function ajax_show_chapter() {
			if ( ! empty( $_POST[ 'post_id' ] ) ) {
				$post_id      = absint( $_POST[ 'post_id' ] );
				$list_chapper = self::get_chapper( $post_id );

				if ( ! empty( $list_chapper ) ) {
					$columns = (int) $_POST[ 'columns' ];
					?>

					<div class="panel panel-free">
						<!--<div class="panel-heading">
							<span class="label label-free">FREE</span>Danh sách chương miễn phí
						</div>-->
						<div class="panel-body">
							<div class="list-chap" id="list_container">
								<div class="row">
									<?php $x = 0;

									$col = 'col-md-6';
									if ( 3 == $columns ) {
										$col = 'col-md-4';
									}
									foreach ( $list_chapper as $chapper ) : ?>
										<div class="<?php echo $col; ?>">
											<div class="item">
												<a href="<?php echo sky_permalink( $post_id, $chapper->slug ); ?>" title="<?php echo $chapper->title; ?>">
													<?php echo $chapper->title; ?>
													<span class="text-muted">
														(<?php echo sky_time_ago( $chapper->time ); ?>)
													</span>
												</a>
											</div>
										</div>
										<?php
										$x ++;
										if ( $x % $columns == 0 ) {
											echo '</div><div class="row">';
										}
										?>
									<?php endforeach; ?>
								</div>

							</div>
							<nav aria-label="Page navigation">
								<!--								<ul class="pull-right pagination">-->
								<!--									<li>-->
								<!--										<a href="javascript:void(0)" onclick="showChapter(6209,1,1000,'cuu tinh ba the quyet')">Xem hết</a>-->
								<!--									</li>-->
								<!--								</ul>-->
								<ul class="pull-right pagination" id="pagingControls">
								</ul>
							</nav>
						</div>
					</div>
					<!-- end chap free -->
					<script type="text/javascript">
						var pager = new Imtech.Pager();
						jQuery(document).ready(function ( $ ) {
							pager.paragraphsPerPage = 15; // set amount elements per page
							pager.pagingContainer = $('#list_container'); // set of main container
							pager.paragraphs = $('div.row', pager.pagingContainer); // set of required containers
							pager.showPage(1);
						});
					</script>

					<?php
				} else {
					echo '<p>Truyện chưa có chương nào!</p>';
				}
				die;
			}
		}

		public static function ajax_report_chapper() {
			/**
			 * Validate $_POST
			 */
			$_POST = wp_kses_post_deep( $_POST );
			if ( ! empty( $_POST[ 'user_report' ] ) ) {
				$chapper_id  = absint( $_POST[ 'chapper_id' ] );
				$parent_id   = absint( $_POST[ 'parent_id' ] );
				$label       = stripslashes_deep( $_POST[ 'label' ] );
				$user_report = absint( $_POST[ 'user_report' ] );
				$author      = absint( $_POST[ 'author' ] );
				$content     = stripslashes_deep( wp_kses_post( $_POST[ 'content' ] ) );

				global $wpdb;

				$report_id = $wpdb->insert( 'wp_sky_report_chapper', array(
					'time'        => current_time( 'mysql' ),
					'chapper_id'  => $chapper_id,
					'parent_id'   => $parent_id,
					'label'       => $label,
					'content'     => $content,
					'user_id'     => $author,
					'user_report' => $user_report,
				) );

				$info_chapper = Sky_iManga::get_chapper_by_id( $chapper_id );

				self::create_notice( 'Báo lỗi chương', sky_get_user_name( $user_report ) . ' đã báo lỗi <strong>' . $info_chapper[ 0 ]->title . '</strong> của truyện <strong>' . get_the_title( $parent_id ) . '</strong> với bạn vì lý do: ' . $content, $author, $user_report );
				self::create_notice( 'Báo lỗi chương bởi thành viên ' . sky_get_user_name( $user_report ), sky_get_user_name( $user_report ) . ' đã báo lỗi <strong>' . $info_chapper[ 0 ]->title . '</strong> của truyện <strong>' . get_the_title( $parent_id ) . '</strong> với bạn vì lý do: ' . $content, 1, $user_report );

				self::create_log( 'Báo lỗi chương', 'Bạn đã báo lỗi <strong>' . $info_chapper[ 0 ]->title . '</strong> cho ' . sky_get_user_name( $author ) . ' của truyện <strong>' . get_the_title( $parent_id ) . '</strong>', $author );

				$response[ 'status' ]  = 'success';
				$response[ 'message' ] = esc_html__( 'Report chapper successfuly', 'imanga' );
				wp_send_json( $response );
			}
			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Report chapper error', 'imanga' );
			wp_send_json( $response );
		}

		public static function ajax_fix_report_chapper() {
			/**
			 * Validate $_POST
			 */
			$_POST = wp_kses_post_deep( $_POST );
			if ( ! empty( $_POST[ 'user_report' ] ) ) {
				$report_id   = absint( $_POST[ 'report_id' ] );
				$user_report = absint( $_POST[ 'user_report' ] );
				$type        = sanitize_text_field( $_POST[ 'type' ] );

				global $wpdb;

				$results = $wpdb->get_results( "SELECT * FROM wp_sky_report_chapper WHERE id = {$report_id}" );
				if ( ! empty( $results ) ) {
					$info_chapper = Sky_iManga::get_chapper_by_id( $results[ 0 ]->chapper_id );

					if ( 'ok' === $type ) {
						$point = (int) sky_get_user_meta( $user_report, 'point', 0 );

						$update_point = $point + SKY_POINT_REPORT;
						update_user_meta( $user_report, 'point', $update_point );

						self::create_notice( 'Chỉnh sửa lỗi chương', 'Cám ơn bạn đã báo lỗi <strong>' . $info_chapper[ 0 ]->title . '</strong> của truyện <strong>' . get_the_title( $results[ 0 ]->parent_id ) . '</strong>, chúng tôi đã sửa nó!', $user_report, sky_get_user_id() );
						self::create_log( 'Chỉnh sửa lỗi chương', 'Bạn đã hoàn tất chỉnh sửa <strong>' . $info_chapper[ 0 ]->title . '</strong> của truyện <strong>' . get_the_title( $results[ 0 ]->parent_id ) . '</strong> và đã gửi thông báo tới!' . sky_get_user_name( $user_report ), sky_get_user_id() );
					} else {
						self::create_notice( 'Chỉnh sửa lỗi chương', 'Cám ơn bạn đã báo lỗi <strong>' . $info_chapper[ 0 ]->title . '</strong> của truyện <strong>' . get_the_title( $results[ 0 ]->parent_id ) . '</strong>, chúng tôi thấy bạn báo lỗi sai, bạn vui lòng kiểm tra lại.', $user_report, sky_get_user_id() );
						self::create_log( 'Chỉnh sửa lỗi chương', 'Bạn đã báo lỗi sai <strong>' . $info_chapper[ 0 ]->title . '</strong> của truyện <strong>' . get_the_title( $results[ 0 ]->parent_id ) . '</strong> và đã gửi thông báo tới!' . sky_get_user_name( $user_report ), sky_get_user_id() );
					}

					global $wpdb;
					$wpdb->delete( 'wp_sky_report_chapper', array( 'id' => $report_id ) );

					$response[ 'status' ]  = 'success';
					$response[ 'message' ] = esc_html__( 'Remove report chapper successfuly', 'imanga' );
					wp_send_json( $response );
				}
			}
			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Remove report chapper error', 'imanga' );
			wp_send_json( $response );
		}

		public static function ajax_sky_tang_dau() {
			/**
			 * Validate $_POST
			 */
			$_POST = wp_kses_post_deep( $_POST );
			if ( ! empty( $_POST[ 'type' ] ) && ! empty( $_POST[ 'author' ] ) ) {
				$user_id = sky_get_user_id();

				$point_user = sky_get_point( $user_id );
				$message    = 'Có lỗi trong quá trình tặng đậu, liên hệ admin để giải quyết!';
				if ( ! empty( $point_user ) ) {
					$author_id = absint( $_POST[ 'author' ] );
					$type      = absint( $_POST[ 'type' ] );

					switch ( $type ) {
						case '1':
							if ( $point_user < SKY_POST_TANG_DAU ) {
								$message = 'Số đậu hiện có của bạn không đủ để tặng! Bạn phải có ít nhất ' . SKY_POST_TANG_DAU . ' đậu.';
							} else {
								sky_update_point( $author_id, SKY_POST_TANG_DAU );
								sky_update_point( $user_id, SKY_POST_TANG_DAU, '-' );
								$message = 'Cảm ơn bạn đã tặng ' . SKY_POST_TANG_DAU . ' đậu, đây là động lực rất lớn cho người đăng truyện.';
								self::create_log( 'Tặng đậu cho ' . sky_get_user_name( $author_id ), 'Bạn đã tặng ' . SKY_POST_TANG_DAU . ' đậu cho ' . sky_get_user_name( $author_id ), $user_id );
								self::create_log( 'Được tặng đậu bởi ' . sky_get_user_name( $user_id ), 'Bạn đã được ' . sky_get_user_name( $user_id ) . ' tặng ' . SKY_POST_TANG_DAU . ' đậu! Chúc mừng bạn!', $author_id );
							}
							break;

						case '2':
							if ( $point_user < SKY_POST_TRU_DAU ) {
								$message = 'Số đậu hiện có của bạn không đủ để ném! Bạn phải có ít nhất ' . SKY_POST_TRU_DAU . ' đậu.';
							} else {
								sky_update_point( $author_id, SKY_POST_TRU_DAU, '-' );
								sky_update_point( $author_id, SKY_POST_BONUS_DAU );
								$message = 'Nếu thấy dở quá thì đừng ngại ném thêm vài cái bạn nhé, chỉ ' . SKY_POST_TRU_DAU . ' đậu một phát thôi và bạn còn được thêm ' . SKY_POST_BONUS_DAU . ' đậu nữa';
							}
							break;

						default:
							$message = 'Có lỗi trong quá trình tặng đậu, liên hệ admin để giải quyết!';
							break;
					}
				} else {
					$message = 'Số đậu hiện có của bạn không đủ để tặng!';
				}
				$response[ 'status' ]  = 'success';
				$response[ 'message' ] = $message;
				wp_send_json( $response );
			}
			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Not dau', 'imanga' );
			wp_send_json( $response );
		}

		/**
		 * Remove chapper in dashboard
		 *
		 * @since 1.0.0
		 *
		 */
		public static function ajax_remove_chapper() {
			$response = array();

			/**
			 * Validate data
			 */
			if ( ! empty( $_POST[ 'chapper_id' ] ) ) {
				$chapper_id = absint( $_POST[ 'chapper_id' ] );
				$parent_id  = absint( $_POST[ 'parent_id' ] );
				if ( ! empty( $chapper_id ) ) {
					global $wpdb;

					$author_id = get_post_field( 'post_author', $parent_id );

					delete_transient( 'sky_author_' . $author_id );
					delete_transient( 'sky_list_chapper_' . $parent_id );

					$wpdb->delete( 'wp_sky_chapper', array( 'id' => absint( $chapper_id ) ) );

					$response[ 'status' ]  = 'success';
					$response[ 'message' ] = esc_html__( 'Create chapper successfuly', 'imanga' );
					wp_send_json( $response );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Remove chapper error', 'imanga' );
			wp_send_json( $response );
		}

		/**
		 * Add favorites
		 *
		 * @since 1.0.0
		 *
		 */
		public static function ajax_add_favorites() {
			$response = array();

			/**
			 * Validate data
			 */
			if ( ! empty( $_POST[ 'chapper_id' ] ) ) {
				$chapper_id = absint( $_POST[ 'chapper_id' ] );
				$parent_id  = absint( $_POST[ 'parent_id' ] );
				if ( ! empty( $chapper_id ) ) {

					$favorites = get_user_meta( sky_get_user_id(), 'favorites', true );
					if ( empty( $favorites ) || ! is_array( $favorites ) ) {
						$favorites = array();
					}

					$favorites[] = array(
						'id'        => $chapper_id,
						'parent_id' => $parent_id,
					);

					update_user_meta( sky_get_user_id(), 'favorites', array_unique( $favorites ) );

					self::create_log( 'Tủ truyện', 'Bạn đã thêm ' . get_the_title( $parent_id ) . ' vào tủ truyện của mình!', sky_get_user_id() );

					$response[ 'status' ]  = 'success';
					$response[ 'message' ] = esc_html__( 'Add favorites successfuly', 'imanga' );
					wp_send_json( $response );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Add favorites error', 'imanga' );
			wp_send_json( $response );
		}

		/**
		 * Change name
		 *
		 * @since 1.0.0
		 *
		 */
		public static function ajax_sky_change_name() {
			$response = array();

			/**
			 * Validate data
			 */
			if ( ! empty( $_POST[ 'nick_name' ] ) ) {
				$nick_name = sanitize_text_field( $_POST[ 'nick_name' ] );
				if ( ! empty( $nick_name ) ) {
					$user_id    = sky_get_user_id();
					$user_point = sky_get_point( $user_id );

					if ( $user_point < SKY_POINT_CHANGE_NAME ) {
						$response[ 'status' ]  = 'error';
						$response[ 'message' ] = esc_html__( 'Bạn không đủ xu!', 'imanga' );
						wp_send_json( $response );
					} else {
						wp_update_user( array(
							'ID'           => sky_get_user_id(),
							'display_name' => $nick_name,
						) );

						sky_update_point( sky_get_user_id(), SKY_POINT_CHANGE_NAME, '-' );

						self::create_log( 'Đổi tên', 'Bạn đã đổi sang tên ' . $nick_name . ' với ' . SKY_POINT_CHANGE_NAME . ' xu!', sky_get_user_id() );

						$response[ 'status' ]  = 'success';
						$response[ 'message' ] = esc_html__( 'Chúc mừng bạn đã đổi thành công!', 'imanga' );
						wp_send_json( $response );
					}
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Không được để trống tên!', 'imanga' );
			wp_send_json( $response );
		}

		/**
		 * Change name
		 *
		 * @since 1.0.0
		 *
		 */
		public static function ajax_sky_yeu_cau_truyen() {
			$response = array();

			/**
			 * Validate data
			 */
			$name = sanitize_text_field( $_POST[ 'name' ] );
			if ( ! empty( $name ) ) {
				global $wpdb;
				$from        = absint( $_POST[ 'from' ] );
				$to          = absint( $_POST[ 'to' ] );
				$point       = absint( $_POST[ 'point' ] );
				$user_point  = (int) sky_get_point( sky_get_user_id() );
				$total_point = (int) ( $to - $from ) * $point;

				if ( $user_point > $total_point ) {
					$id = $wpdb->insert( 'wp_sky_yeu_cau_truyen', array(
						'time'    => current_time( 'mysql' ),
						'user_id' => sky_get_user_id(),
						'txtname' => $name,
						'txtfrom' => $from,
						'txtto'   => $to,
						'point'   => $point,
						'status'  => 'Đang xử lý',
						'link'    => null,
					) );

					if ( ! empty( $id ) ) {
						$response[ 'status' ]   = 'success';
						$response[ 'redirect' ] = esc_url( home_url( '/account/yeu-cau-truyen/' ) );
						$response[ 'message' ]  = esc_html__( 'Chúc mừng bạn đã gửi yêu cầu thành công. Nhớ thường xuyên vào lại mục Yêu Cầu Truyện này để xem đã có converter nào nhận làm truyện bạn yêu cầu chưa nhé', 'imanga' );

						self::create_log( 'Yêu cầu truyện', 'Bạn đã yêu cầu truyện ' . $name . ' với ' . ( ( $to - $from ) * $point ) . ' xu!', sky_get_user_id() );

						sky_update_point( sky_get_user_id(), ( $to - $from ) * $point, '-' );
						wp_send_json( $response );
					} else {
						$response[ 'status' ]  = 'error';
						$response[ 'message' ] = esc_html__( 'Có lỗi khi yêu cầu truyện, liên hệ admin để hỗ trợ thêm', 'imanga' );
						wp_send_json( $response );
					}
				} else {
					$response[ 'status' ]  = 'error';
					$response[ 'message' ] = esc_html__( 'Bạn không đủ đậu để yêu cầu truyện', 'imanga' );
					wp_send_json( $response );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Sorry, unexpected error. Please try again later!', 'imanga' );
			wp_send_json( $response );
		}

		public static function ajax_sky_modal_update() {
			$response = array();

			/**
			 * Validate data
			 */
			$name = sanitize_text_field( $_POST[ 'modal-name' ] );
			if ( ! empty( $name ) ) {
				global $wpdb;
				$story_id = sanitize_text_field( $_POST[ 'story_id' ] );
				$status   = sanitize_text_field( $_POST[ 'modal-status' ] );
				$link     = sanitize_text_field( $_POST[ 'modal-link' ] );

				$wpdb->update( 'wp_sky_yeu_cau_truyen', array(
					'time'   => current_time( 'mysql' ),
					'status' => $status,
					'link'   => $link,
				), array( 'id' => $story_id ) );

				$response[ 'status' ]   = 'success';
				$response[ 'redirect' ] = esc_url( home_url( '/account/yeu-cau-truyen/' ) );
				$response[ 'message' ]  = esc_html__( 'Cập nhật thành công', 'imanga' );
				wp_send_json( $response );
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Sorry, unexpected error. Please try again later!', 'imanga' );
			wp_send_json( $response );
		}

		public static function ajax_sky_modal_remove() {
			$response = array();

			/**
			 * Validate data
			 */
			$story_id = sanitize_text_field( $_POST[ 'story_id' ] );
			if ( ! empty( $story_id ) ) {
				global $wpdb;

				$wpdb->delete( 'wp_sky_yeu_cau_truyen', array( 'id' => absint( $story_id ) ) );

				$response[ 'status' ]  = 'success';
				$response[ 'message' ] = esc_html__( 'Xóa thành công', 'imanga' );
				wp_send_json( $response );
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Sorry, unexpected error. Please try again later!', 'imanga' );
			wp_send_json( $response );
		}

		public static function create_log( $title, $content, $user_id ) {
			global $wpdb;

			return $wpdb->insert( 'wp_sky_log', array(
				'time'    => current_time( 'mysql' ),
				'title'   => stripslashes_deep( $title ),
				'content' => stripslashes_deep( wp_kses_post( $content ) ),
				'user_id' => absint( $user_id ),
			) );
		}

		public static function create_notice( $title, $content, $user_id, $user_send ) {
			global $wpdb;

			return $wpdb->insert( 'wp_sky_message', array(
				'time'      => current_time( 'mysql' ),
				'title'     => stripslashes_deep( $title ),
				'content'   => stripslashes_deep( wp_kses_post( $content ) ),
				'user_id'   => absint( $user_id ),
				'user_send' => absint( $user_send ),
				'status'    => 'unread',
			) );
		}

		public static function ajax_sky_send_message() {
			$response = array();

			/**
			 * Validate data
			 */
			$user_send = sanitize_text_field( $_POST[ 'user_send' ] );
			if ( ! empty( $user_send ) ) {

				$title   = sanitize_text_field( $_POST[ 'title' ] );
				$content = sanitize_text_field( $_POST[ 'content' ] );
				$user_id = sanitize_text_field( $_POST[ 'user_id' ] );

				$id = self::create_notice( $title, $content, $user_id, $user_send );

				if ( ! empty( $id ) ) {
					$response[ 'status' ]   = 'success';
					$response[ 'redirect' ] = esc_url( home_url( '/account/thong-bao/' ) );
					$response[ 'message' ]  = esc_html__( 'Tin nhắn bạn được gửi thành công', 'imanga' );

					wp_send_json( $response );
				} else {
					$response[ 'status' ]  = 'error';
					$response[ 'message' ] = esc_html__( 'Có lỗi khi gửi tin nhắn, liên hệ admin để hỗ trợ thêm', 'imanga' );
					wp_send_json( $response );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Sorry, unexpected error. Please try again later!', 'imanga' );
			wp_send_json( $response );
		}

		public static function ajax_sky_read_message() {
			$response = array();

			/**
			 * Validate data
			 */
			$message_id = absint( $_POST[ 'message_id' ] );
			$user_id    = absint( $_POST[ 'user_id' ] );
			if ( ! empty( $message_id ) && ! empty( $user_id ) ) {

				$current_user = sky_get_user_id();
				if ( $user_id == $current_user ) {

					global $wpdb;

					$results = $wpdb->get_results( "SELECT * FROM wp_sky_message WHERE id = {$message_id}" );

					if ( ! empty( $results ) ) {
						$response[ 'status' ]  = 'success';
						$response[ 'message' ] = $results[ 0 ]->content;

						$wpdb->update( 'wp_sky_message', array(
							'status' => 'read',
						), array( 'id' => $message_id ) );

						wp_send_json( $response );
					}

					$response[ 'status' ]  = 'error';
					$response[ 'message' ] = esc_html__( 'Có lỗi khi đọc tin nhắn, liên hệ admin để hỗ trợ thêm', 'imanga' );
					wp_send_json( $response );
				} else {
					$response[ 'status' ]  = 'error';
					$response[ 'message' ] = esc_html__( 'Bạn không được phép đọc tin này!', 'imanga' );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Sorry, unexpected error. Please try again later!', 'imanga' );
			wp_send_json( $response );
		}

		/**
		 * Add follow
		 *
		 * @since 1.0.0
		 *
		 */
		public static function ajax_add_sky_follow() {
			$response = array();

			/**
			 * Validate data
			 */
			if ( ! empty( $_POST[ 'parent_id' ] ) ) {
				$parent_id = absint( $_POST[ 'parent_id' ] );
				if ( ! empty( $parent_id ) ) {

					$follow = get_user_meta( sky_get_user_id(), 'follow', true );
					if ( empty( $follow ) || ! is_array( $follow ) ) {
						$follow = array();
					}

					$follow[] = $parent_id;

					$user_follow = sky_get_post_meta( $parent_id, 'user_follow', array() );

					$user_follow[] = sky_get_user_id();

					update_user_meta( sky_get_user_id(), 'follow', array_unique( $follow ) );
					update_post_meta( $parent_id, 'user_follow', array_unique( $user_follow ) );

					//					self::create_log( 'Theo dõi truyện', 'Bạn đang theo dõi truyện <a href="' . get_permalink( $parent_id ) . '">' . get_the_title( $parent_id ) . '</a>', sky_get_user_id() );

					$response[ 'status' ]  = 'success';
					$response[ 'message' ] = esc_html__( 'Add follow successfuly', 'imanga' );
					wp_send_json( $response );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Add follow error', 'imanga' );
			wp_send_json( $response );
		}

		public static function ajax_add_sky_unfollow() {
			$response = array();

			/**
			 * Validate data
			 */
			if ( ! empty( $_POST[ 'parent_id' ] ) ) {
				$parent_id = absint( $_POST[ 'parent_id' ] );
				if ( ! empty( $parent_id ) ) {

					$follow = get_user_meta( sky_get_user_id(), 'follow', true );
					if ( empty( $follow ) || ! is_array( $follow ) ) {
						$follow = array();
					}

					if ( ( $key = array_search( $parent_id, $follow ) ) !== false ) {
						unset( $follow[ $key ] );
					}

					$user_follow = sky_get_post_meta( $parent_id, 'user_follow', array() );
					if ( ( $key = array_search( sky_get_user_id(), $user_follow ) ) !== false ) {
						unset( $user_follow[ $key ] );
					}

					update_user_meta( sky_get_user_id(), 'follow', array_unique( $follow ) );
					update_post_meta( $parent_id, 'user_follow', array_unique( $user_follow ) );

					//					self::create_log( 'Bỏ theo dõi truyện', 'Bạn đã bỏ theo dõi truyện <a href="' . get_permalink( $parent_id ) . '">' . get_the_title( $parent_id ) . '</a>', sky_get_user_id() );

					$response[ 'status' ]  = 'success';
					$response[ 'message' ] = esc_html__( 'Unfollow successfuly', 'imanga' );
					wp_send_json( $response );
				}
			}

			$response[ 'status' ]  = 'error';
			$response[ 'message' ] = esc_html__( 'Unfollow error', 'imanga' );
			wp_send_json( $response );
		}

		/**
		 * Create new story front-end
		 *
		 * @since 1.0.0
		 *
		 */
		public static function process_story() {
			if ( isset( $_POST[ 'Addstory' ] ) ) {
				$title_post = ! empty( $_POST[ 'title_post' ] ) ? sanitize_text_field( $_POST[ 'title_post' ] ) : '';
				if ( ! empty( $title_post ) ) {
					$post_now = self::check_post( $title_post, 'id' );
					if ( $post_now === 0 ) {

						$content_post = ! empty( $_POST[ 'content_post' ] ) ? stripslashes_deep( wp_kses_post( $_POST[ 'content_post' ] ) ) : '';
						$post_status  = 'pending';
						if ( sky_can_remove() ) {
							$post_status = 'publish';
						}
						$data_story = array(
							'post_type'    => 'imanga',
							'post_title'   => $title_post,
							'post_content' => $content_post,
							'post_status'  => $post_status,
							'post_author'  => sky_get_user_id(),
						);
						$story_id   = wp_insert_post( $data_story );

						$thumbnail   = ! empty( $_POST[ 'thumbnail' ] ) ? sanitize_text_field( $_POST[ 'thumbnail' ] ) : '';
						$author_post = ! empty( $_POST[ 'author_post' ] ) ? sanitize_text_field( $_POST[ 'author_post' ] ) : '';
						$is_18       = ! empty( $_POST[ 'is_18' ] ) ? sanitize_text_field( $_POST[ 'is_18' ] ) : 'no';
						$type        = ! empty( $_POST[ 'type' ] ) ? sanitize_text_field( $_POST[ 'type' ] ) : 'suu-tam';
						if ( 'sang-tac' == $type ) {
							$author_post = sky_get_user_name( sky_get_user_id() );
						}
						$author_post = array_unique( explode( ',', $author_post ) );

						$keyword = ! empty( $_POST[ 'keyword' ] ) ? sanitize_text_field( $_POST[ 'keyword' ] ) : '';
						$keyword = array_unique( explode( ',', $keyword ) );

						$nhom_dich = ! empty( $_POST[ 'nhom_dich' ] ) ? sanitize_text_field( $_POST[ 'nhom_dich' ] ) : '';
						$nhom_dich = array_unique( explode( ',', $nhom_dich ) );
						if ( 'sang-tac' == $type || 'convert' == $type || 'dich' == $type ) {
							$nhom_dich = array( sky_get_user_name( sky_get_user_id() ) );
						}

						update_post_meta( $story_id, 'thumbnail', $thumbnail );
						update_post_meta( $story_id, 'type', $type );
						update_post_meta( $story_id, 'is_18', $is_18 );

						wp_set_object_terms( $story_id, array_map( 'intval', $_POST[ 'category' ] ), 'manga-category' );
						wp_set_object_terms( $story_id, $author_post, 'manga-author' );
						wp_set_object_terms( $story_id, $keyword, 'keyword' );
						wp_set_object_terms( $story_id, $nhom_dich, 'nhom-dich' );

						$url_thumbnail = sky_upload_imgur();
						if ( ! empty( $url_thumbnail ) ) {
							update_post_meta( $story_id, 'thumbnail', $url_thumbnail );
						}

						wp_redirect( home_url( '/account/list_story/' ) );
					} else {
						?>
						<script type="text/javascript">
							alert('Trùng truyện');
						</script>
						<?php
					}
				}
			}

			if ( isset( $_POST[ 'Editstory' ] ) ) {
				$title_post = ! empty( $_POST[ 'title_post' ] ) ? sanitize_text_field( $_POST[ 'title_post' ] ) : '';
				$story_id   = ! empty( $_POST[ 'story_id' ] ) ? sanitize_text_field( $_POST[ 'story_id' ] ) : '';
				if ( ! empty( $title_post ) && ! empty( $story_id ) ) {
					$content_post = ! empty( $_POST[ 'content_post' ] ) ? stripslashes_deep( wp_kses_post( $_POST[ 'content_post' ] ) ) : '';
					$data_story   = array(
						'ID'           => $story_id,
						'post_type'    => 'imanga',
						'post_title'   => $title_post,
						'post_content' => $content_post,
						'post_status'  => 'publish',
					);
					$author_id    = get_post_field( 'post_author', $story_id );

					$story_id = wp_update_post( $data_story );

					$thumbnail   = ! empty( $_POST[ 'thumbnail' ] ) ? sanitize_text_field( $_POST[ 'thumbnail' ] ) : '';
					$status      = ! empty( $_POST[ 'status' ] ) ? sanitize_text_field( $_POST[ 'status' ] ) : 'dang-ra';
					$author_post = ! empty( $_POST[ 'author_post' ] ) ? sanitize_text_field( $_POST[ 'author_post' ] ) : '';
					$is_18       = ! empty( $_POST[ 'is_18' ] ) ? sanitize_text_field( $_POST[ 'is_18' ] ) : 'no';
					$type        = ! empty( $_POST[ 'type' ] ) ? sanitize_text_field( $_POST[ 'type' ] ) : 'suu-tam';
					if ( 'sang-tac' == $type ) {
						$author_post = sky_get_user_name( $author_id );
					}
					$author_post = array_unique( explode( ',', $author_post ) );

					$keyword = ! empty( $_POST[ 'keyword' ] ) ? sanitize_text_field( $_POST[ 'keyword' ] ) : '';
					$keyword = array_unique( explode( ',', $keyword ) );

					$nhom_dich = ! empty( $_POST[ 'nhom_dich' ] ) ? sanitize_text_field( $_POST[ 'nhom_dich' ] ) : '';
					$nhom_dich = array_unique( explode( ',', $nhom_dich ) );
					if ( 'sang-tac' == $type || 'convert' == $type || 'dich' == $type ) {
						$nhom_dich = array( sky_get_user_name( $author_id ) );
					}

					update_post_meta( $story_id, 'thumbnail', $thumbnail );
					update_post_meta( $story_id, 'status', $status );
					update_post_meta( $story_id, 'type', $type );
					update_post_meta( $story_id, 'is_18', $is_18 );
					wp_set_object_terms( $story_id, $keyword, 'keyword' );
					wp_set_object_terms( $story_id, $nhom_dich, 'nhom-dich' );
					wp_set_object_terms( $story_id, array_map( 'intval', $_POST[ 'category' ] ), 'manga-category' );
					wp_set_object_terms( $story_id, $author_post, 'manga-author' );

					$url_thumbnail = sky_upload_imgur();
					if ( ! empty( $url_thumbnail ) ) {
						update_post_meta( $story_id, 'thumbnail', $url_thumbnail );
					}

					wp_redirect( home_url( '/account/list_story/' ) );
				}
			}

			if ( isset( $_POST[ 'Newchapper' ] ) ) {
				$chapter_begin = ! empty( $_POST[ 'chapter_begin' ] ) ? absint( $_POST[ 'chapter_begin' ] ) : 1;
				$chapter_end   = ! empty( $_POST[ 'chapter_end' ] ) ? absint( $_POST[ 'chapter_end' ] ) : 0;
				$stt           = ! empty( $_POST[ 'stt' ] ) ? $_POST[ 'stt' ] : array();
				$content       = ! empty( $_POST[ 'content' ] ) ? $_POST[ 'content' ] : array();
				$story_id      = ! empty( $_POST[ 'story_id' ] ) ? absint( $_POST[ 'story_id' ] ) : '';
				$title         = ! empty( $_POST[ 'title' ] ) ? $_POST[ 'title' ] : '';

				$point_chapper = 0;

				$point = (int) sky_get_type_point( $story_id, 'chapper' );

				for ( $i = $chapter_begin; $i <= $chapter_end; $i ++ ) {
					self::create_chapper( $story_id, $title[ $i ], $content[ $i ], $stt[ $i ] );
					$point_chapper = absint( $point_chapper ) + $point;
					self::create_log( 'Đăng chapper', 'Bạn đã nhận được ' . $point . ' xu khi đăng chapper ' . $title[ $i ], sky_get_user_id() );
					sky_update_post_date( $story_id );
				}

				/**
				 * Send notice
				 */
				$user_follow = sky_get_post_meta( $story_id, 'user_follow', array() );
				if ( ! empty( $user_follow ) ) {
					$author_id      = get_post_field( 'post_author', $story_id );
					$title_notice   = 'Cập nhật ' . $title[ $chapter_end ] . ' tại truyện ' . get_the_title( $story_id );
					$content_notice = 'Bạn có thể đọc ' . $title[ $chapter_end ] . ' mới đăng <a href="' . sky_permalink( $story_id, sanitize_title( $title[ $chapter_end ] ) ) . '">tại đây</a>';
					foreach ( $user_follow as $user_id ) {
						self::create_notice( $title_notice, $content_notice, $user_id, $author_id );
					}
				}

				update_post_meta( $story_id, 'chapter_end', absint( $chapter_end ) + 1 );

				sky_update_point( sky_get_user_id(), $point_chapper );

				wp_redirect( home_url( '/account/list_story/' ) );
			}

			if ( isset( $_POST[ 'search_stt' ] ) ) {
				$post_id = ! empty( $_POST[ 'post_id' ] ) ? absint( $_POST[ 'post_id' ] ) : '';
				if ( ! empty( $post_id ) ) {
					$search_stt   = ! empty( $_POST[ 'search_stt' ] ) ? absint( $_POST[ 'search_stt' ] ) : '';
					$info_chapper = self::find_chapper( $post_id, $search_stt );

					if ( ! empty( $info_chapper ) ) {
						wp_redirect( home_url( '/account/edit_chapter/' . $info_chapper[ 0 ]->id ) );
					}
				}
			}

			if ( isset( $_POST[ 'Editchapter' ] ) ) {
				$chapper_id      = ! empty( $_POST[ 'chapper_id' ] ) ? absint( $_POST[ 'chapper_id' ] ) : 1;
				$chapper_title   = ! empty( $_POST[ 'chapper_title' ] ) ? esc_html( $_POST[ 'chapper_title' ] ) : '';
				$chapper_content = ! empty( $_POST[ 'chapper_content' ] ) ? stripslashes_deep( wp_kses_post( $_POST[ 'chapper_content' ] ) ) : '';
				if ( ! empty( $chapper_title ) ) {
					global $wpdb;

					$wpdb->update( 'wp_sky_chapper', array(
						'time'    => current_time( 'mysql' ),
						'title'   => stripslashes_deep( $chapper_title ),
						'slug'    => stripslashes_deep( sanitize_title( $chapper_title ) ),
						'content' => $chapper_content,
					), array( 'id' => $chapper_id ) );

					$info_chapper = self::get_chapper_by_id( $chapper_id );
					if ( ! empty( $info_chapper ) ) {
						self::create_log( 'Sửa chapper', 'Bạn đã sửa chapper ' . $chapper_title, sky_get_user_id() );
						sky_update_post_date( $info_chapper[ 0 ]->parent_id );
					}
				}
			}

			if ( isset( $_POST[ 'change_avatar' ] ) ) {
				$url_thumbnail = sky_upload_imgur();
				if ( ! empty( $url_thumbnail ) ) {
					update_user_meta( sky_get_user_id(), 'avatar', $url_thumbnail );
				}
			}
		}

		public static function process_user_manager() {
			if ( sky_can_remove() ) {
				if ( isset( $_POST[ 'change_info_user' ] ) && ! empty( $_POST[ 'user_id' ] ) && ! empty( $_POST[ 'user_name' ] ) ) {
					$user_id      = sanitize_text_field( $_POST[ 'user_id' ] );
					$current_user = sky_get_user_id();
					$user_name    = sanitize_text_field( $_POST[ 'user_name' ] );
					$point        = absint( $_POST[ 'point' ] );

					wp_update_user( array(
						'ID'           => $user_id,
						'display_name' => $user_name,
					) );

					sky_update_point( $user_id, $point );

					$nick_name = 'MODDER';
					if ( $current_user == 1 ) {
						$nick_name = 'ADMIN';
					} else {
						self::create_notice( "[{$nick_name}] chỉnh sửa thông tin", sky_get_user_name( $current_user ) . " đã đổi thông tin cho thành viên " . sky_get_user_name( $user_id ) . "<br>Thông tin sau khi chỉnh sửa là:<br>+ Tên: {$user_name}<br>+ Số xu: {$point}", 1, 1 );
					}

					self::create_log( "[{$nick_name}] chỉnh sửa thông tin", "Bạn đã đổi thông tin cho thành viên " . sky_get_user_name( $user_id ) . "<br>Thông tin sau khi chỉnh sửa là:<br>+ Tên: {$user_name}<br>+ Số xu: {$point}", $current_user );

					self::create_notice( "[{$nick_name}] chỉnh sửa thông tin", "Bạn đã được đổi thông tin bởi {$nick_name} " . sky_get_user_name( $current_user ) . "<br>Thông tin sau khi chỉnh sửa là:<br>+ Tên: {$user_name}<br>+ Số xu: {$point}", $user_id, 1 );
					?>
					<script type="text/javascript">
						alert('Cập nhật thành công');
					</script>
					<?php
				}
			}
		}

		public static function check_post( $title = '', $return = 'count' ) {
			global $wpdb;
			if ( $return === 'count' ) {

				return $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_title = \"{$title}\"" );
			} elseif ( $return === 'id' ) {

				return (int) $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = \"{$title}\"" );
			}
		}

		public static function ajax_add_trich_doan() {
			/**
			 * validate data
			 */
			$_POST = wp_kses_post_deep( $_POST );

			$post_id = absint( $_POST[ 'post_id' ] );
			$content = sanitize_text_field( $_POST[ 'content' ] );
			$user_id = sky_get_user_id();

			global $wpdb;

			$total = $wpdb->get_var( "SELECT COUNT(*) FROM wp_sky_read_try WHERE parent_id = $post_id" );

			if ( $total <= 0 ) {

				$chapper_id = $wpdb->insert( 'wp_sky_read_try', array(
					'time'      => current_time( 'mysql' ),
					'parent_id' => $post_id,
					'user_id'   => $user_id,
					'content'   => $content,
				) );
			} else {
				$content_id = $wpdb->get_var( "SELECT id FROM wp_sky_read_try WHERE parent_id = $post_id" );
				$wpdb->update( 'wp_sky_read_try', array(
					'time'    => current_time( 'mysql' ),
					'slug'    => sanitize_title( $title ),
					'user_id' => $user_id,
					'content' => $content,
				), array( 'id' => $content_id ) );
			}
			if ( ! empty( $chapper_id ) ) {
				wp_send_json( 1 );
			}

			wp_send_json( - 1 );
		}

		public static function get_trich_doan( $post_id, $show = 'content' ) {
			global $wpdb;

			$info = $wpdb->get_results( "SELECT * FROM wp_sky_read_try WHERE parent_id = $post_id LIMIT 1" );

			if ( empty( $info[ 0 ] ) ) {
				return false;
			}

			switch ( $show ) {
				case 'content':
					$html = $info[ 0 ]->content;
					break;

				case 'time':
					$html = $info[ 0 ]->time;
					break;

				default:
					$author_obj = get_user_by( 'id', $info[ 0 ]->user_id );
					$html       = $author_obj->display_name;
					break;
			}

			return $html;
		}

		public static function process_chapper_reading( $info_chapper, $user_id ) {
			$reading = get_user_meta( $user_id, 'reading', true );
			if ( empty( $reading ) || ! is_array( $reading ) ) {
				$reading = array();
			}

			if ( ! empty( $info_chapper->stt ) ) {
				unset( $reading[ 'parent_' . $info_chapper->parent_id ] );

				sky_array_insert( $reading, 0, array( 'parent_' . $info_chapper->parent_id => 'chapper_' . $info_chapper->id ) );

				update_user_meta( $user_id, 'reading', array_unique( $reading ) );
			}
		}

		public static function get_chapper_reading( $post_id, $user_id = '' ) {

			if ( ! is_user_logged_in() ) {
				if ( ! empty( $_COOKIE[ 'sky_reading' ] ) ) {
					$sky_reading   = sky_decode_json_js( $_COOKIE[ 'sky_reading' ] );
					$read_continue = false;
					foreach ( $sky_reading as $reading_parent_id => $reading_id ) {
						$reading_parent_id = str_replace( 'parent_', '', $reading_parent_id );

						if ( $reading_parent_id != $post_id ) {
							continue;
						}

						$reading_id           = str_replace( 'chapper_', '', $reading_id );
						$reading_info_chapper = Sky_iManga::get_chapper_by_id( $reading_id );

						if ( empty( $reading_info_chapper ) ) {
							continue;
						}
						?>
						<a href="<?php echo sky_permalink( $post_id, $reading_info_chapper[ 0 ]->slug ); ?>" title="<?php echo $reading_info_chapper[ 0 ]->title ?>" class="btn btn-sky">
							Đọc tiếp
						</a>
						<?php
						$read_continue = true;
						break;
					}

					if ( empty( $read_continue ) ) {
						$chapper_info = self::find_chapper( $post_id, 1 );
						if ( empty( $chapper_info[ 0 ] ) ) {
							return;
						}
						?>
						<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>" class="btn btn-sky">
							Đọc từ đầu
						</a>
						<?php
					}
				} else {
					$chapper_info = self::find_chapper( $post_id, 1 );
					if ( empty( $chapper_info[ 0 ] ) ) {
						return;
					}
					?>
					<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>" class="btn btn-sky">
						Đọc từ đầu
					</a>
					<?php
				}

				return;
			} else {

				if ( empty( $user_id ) ) {
					$user_id = sky_get_user_id();
				}

				$reading = get_user_meta( $user_id, 'reading', true );
				if ( ! empty( $reading[ 'parent_' . $post_id ] ) ) {
					$reading_info_chapper = Sky_iManga::get_chapper_by_id( $post_id );
					if ( empty( $reading_info_chapper ) ) {
						$chapper_info = self::find_chapper( $post_id, 1 );
						if ( empty( $chapper_info[ 0 ] ) ) {
							return;
						}
						?>
						<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>" class="btn btn-sky">
							Đọc từ đầu
						</a>
						<?php
					} else {
						$chapper_id        = str_replace( 'chapper_', '', $reading[ 'parent_' . $post_id ] );
						$find_chapper_info = Sky_iManga::get_chapper_by_id( $chapper_id );
						if ( ! empty( $find_chapper_info[ 0 ] ) ) {
							?>
							<a href="<?php echo sky_permalink( $post_id, $find_chapper_info[ 0 ]->slug ); ?>" title="<?php echo $find_chapper_info[ 0 ]->title ?>" class="btn btn-sky">
								Đọc tiếp
							</a>
							<?php
						} else {
							$chapper_info = self::find_chapper( $post_id, 1 );
							?>
							<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>" class="btn btn-sky">
								Đọc từ đầu
							</a>
							<?php
						}
					}
				} else {
					$chapper_info = self::find_chapper( $post_id, 1 );
					if ( empty( $chapper_info[ 0 ] ) ) {
						$chapper_info = self::find_chapper( $post_id, 0 );
						if ( empty( $chapper_info[ 0 ] ) ) {
							return;
						}
					}
					?>
					<a href="<?php echo sky_permalink( $post_id, $chapper_info[ 0 ]->slug ); ?>" title="<?php echo $chapper_info[ 0 ]->title ?>" class="btn btn-sky">
						Đọc từ đầu
					</a>
					<?php
				}
			}
		}

		public static function ajax_remove() {
			/**
			 * Validate
			 */
			$_POST = wp_kses_post_deep( $_POST );

			if ( ! empty( $_POST[ 'type' ] ) ) {
				$type       = ! empty( $_POST[ 'type' ] ) ? sanitize_text_field( $_POST[ 'type' ] ) : '';
				$user_id    = ! empty( $_POST[ 'user_id' ] ) ? sanitize_text_field( $_POST[ 'user_id' ] ) : sky_get_user_id();
				$parent_id  = ! empty( $_POST[ 'parent_id' ] ) ? sanitize_text_field( $_POST[ 'parent_id' ] ) : '';
				$chapper_id = ! empty( $_POST[ 'chapper_id' ] ) ? sanitize_text_field( $_POST[ 'chapper_id' ] ) : '';

				$response = array();
				switch ( $type ) {
					case 'remove-reading':
						$reading = get_user_meta( $user_id, 'reading', true );

						if ( ( $key = array_search( 'parent_' . $parent_id, $reading ) ) !== false ) {
							unset( $reading[ $key ] );
						}

						unset( $reading[ $parent_id ] );
						unset( $reading[ 'parent_' . $parent_id ] );

						update_user_meta( $user_id, 'reading', array_unique( $reading ) );

						$response[ 'status' ]  = 'success';
						$response[ 'message' ] = 'Remove reading success';
						break;

					case 'remove-follow':
						$follow = get_user_meta( $user_id, 'follow', true );
						if ( ( $key = array_search( $parent_id, $follow ) ) !== false ) {
							unset( $follow[ $key ] );
						}
						unset( $follow[ $parent_id ] );

						$user_follow = sky_get_post_meta( $parent_id, 'user_follow', array() );
						if ( ( $key = array_search( $user_id, $user_follow ) ) !== false ) {
							unset( $user_follow[ $key ] );
						}
						unset( $user_follow[ $user_id ] );

						update_user_meta( $user_id, 'follow', array_values( array_unique( $follow ) ) );
						update_post_meta( $parent_id, 'user_follow', array_values( array_unique( $user_follow ) ) );

						$response[ 'status' ]  = 'success';
						$response[ 'message' ] = 'Remove reading success';
						break;

					case 'remove-favorites':
						$favorites = get_user_meta( $user_id, 'favorites', true );

						foreach ( (array) $favorites as $index => $info ) {
							if ( empty( $info[ 'id' ] ) ) {
								continue;
							}

							if ( (int) $chapper_id == $info[ 'id' ] ) {
								if ( ( $key = array_search( $index, $favorites ) ) !== false ) {
									unset( $favorites[ $key ] );
								}
								unset( $favorites[ $index ] );
								break;
							}
						}

						update_user_meta( $user_id, 'favorites', array_values( array_unique( $favorites ) ) );

						$response[ 'status' ]  = 'success';
						$response[ 'message' ] = 'Remove reading success' . json_encode( array_values( array_unique( $favorites ) ) );
						break;
				}

				wp_send_json( $response );
			}
			wp_send_json( '-1' );
		}

		/**
		 * Get report by author id
		 *
		 * @since 1.0.0
		 *
		 * @param $post_id
		 *
		 * @return array|bool|null|object
		 */
		public static function get_report_by_id( $author_id ) {
			global $wpdb;

			$results = $wpdb->get_results( "SELECT * FROM wp_sky_report_chapper WHERE user_id = {$author_id} ORDER BY time DESC" );

			if ( ! empty( $results ) ) {
				return $results;
			}

			return false;
		}

		public static function update_point( $post_id ) {
			$post_type = get_post_type( $post_id );

			if ( 'imanga' != $post_type || ! is_admin() ) {
				return;
			}

			$author_id = get_post_field( 'post_author', $post_id );

			if ( 'publish' == get_post_status( $post_id ) ) {

				$point = sky_get_type_point( $post_id );
				sky_update_point( $author_id, $point );

				self::create_log( 'Đăng truyện', 'Bạn đã nhận được ' . $point . ' xu khi đăng truyện ' . get_the_title( $post_id ), $author_id );
			}
		}
	}

	new Sky_iManga();

endif;