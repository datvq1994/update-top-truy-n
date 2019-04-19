<section class="sky-section bg-w">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8">
				<div class="block block-default">
					<div class="block-header">
						<h2 class="title"><span class="glyphicon glyphicon-send"></span>&nbsp;Truyện mới cập nhật</h2>
					</div>
					<div class="block-content">

	<?php 
		$arr_post = Sky_iManga::get_list_chapper('16', 'DESC' );
		$arr_id_post = [];
		foreach ($arr_post as $key => $value) {
			if (! in_array($value->parent_id, $arr_id_post)){
				array_push($arr_id_post, $value->parent_id);
			}
		}
	?>
	<?php 
		$args = array(
			'post_status' => 'publish', // Chỉ lấy những bài viết được publish
			'post_type' => 'imanga', // Lấy những bài viết thuộc post, nếu lấy những bài trong 'trang' thì để là page 
			'post__in' => $arr_id_post,
			'orderby'=>'post__in',
			'showposts' => 16, // số lượng bài viết
		);
	?>
	
<?php $getposts = new WP_query($args); ?>
<?php global $wp_query; $wp_query->in_the_loop = true; ?>
<?php while ($getposts->have_posts()) : $getposts->the_post(); ?>
<div class="col-md-6">
	<div class="media">

  	<a class="cover media-left" href="<?php the_permalink() ?>" title="<?php the_title() ?>"> <img class="lazy thumbnail" src="<?php echo sky_thumb_src( get_the_ID(), 'thumbnail-200x300', '200x300' ) ?>" title="<?php the_title() ?>" alt="<?php the_title() ?>" width="90" height="120" style="display: block;"> </a>
	   <div class="media-body">
		    <h4>
				<a href="<?php the_permalink() ?>" title="<?php the_title() ?>">
					<?php the_title() ?>
				</a> 
		    </h4> 
			<div class="info">
			 	<?php if(function_exists('the_ratings')) { the_ratings(); } ?>
			    <ul class="list-unstyled chaplist">
			    	<?php Sky_iManga::show_chapper( get_the_ID(), '2', 'DESC', 'style-1' ); ?>
			    	<li>
					</li>
				 </ul>
		   </div>
		</div>			

	</div>		
</div>
<?php endwhile; wp_reset_postdata(); ?>
						<a href="<?php echo home_url( 'danh-sach/truyen-moi/' ) ?>" class="pull-right cnt-view">
							Xem tiếp
						</a>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-4">
				<div class="block block-default block-reading-list">
					<div class="block-header">
						<h2 class="title"><span class="glyphicon glyphicon-bookmark"></span>
							&nbsp;Bạn đang đọc
							<span class="pull-right">
								<a href="<?php echo ( is_user_logged_in() ) ? esc_url( home_url( '/account/favorites/' ) ) : '#modal-login' ?>" data-toggle="modal">
									<small class="text-muted">Tủ truyện</small>
								</a>
							</span>
						</h2>
					</div>
					<div class="block-content">
						<ul class="list-group">
							<?php
							$reading = get_user_meta( sky_get_user_id(), 'reading', true );
							if ( is_user_logged_in() && ! empty( $reading ) ) :
								if ( ! empty( $reading ) && is_array( $reading ) ) :
									$i_reading = 0;
									foreach ( (array) $reading as $reading_parent_id => $reading_id ) :

										if ( empty( $reading_parent_id ) ) {
											continue;
										}

										if ( 5 <= $i_reading ++ ) {
											break;
										}

										$reading_parent_id    = str_replace( 'parent_', '', $reading_parent_id );
										$reading_id           = str_replace( 'chapper_', '', $reading_id );
										$reading_info_chapper = Sky_iManga::get_chapper_by_id( $reading_id );

										if ( empty( $reading_info_chapper ) ) {
											continue;
										}
										?>
										<li class="list-group-item list-group-item-with-thumb reading-<?php echo $reading_parent_id ?>">
											<div class="content">
												<a class="thumb" href="<?php echo get_permalink( $reading_parent_id ) ?>" title="<?php echo get_the_title( $reading_parent_id ); ?>">
													<img class="img-responsive" src="<?php echo sky_thumb_src( $reading_parent_id, 'thumbnail-200x300', '200x300' ) ?>" alt="<?php echo get_the_title( $reading_parent_id ); ?>">
												</a>
												<div class="info">
													<h2 class="title">
														<a href="<?php echo get_permalink( $reading_parent_id ) ?>" title="<?php echo get_the_title( $reading_parent_id ); ?>">
															<?php echo get_the_title( $reading_parent_id ); ?>
														</a>
													</h2>
													<p class="chap">
														<?php Sky_iManga::get_chapper_latest( $reading_parent_id ) ?>
														<a href="javascript:void(0)">
															<span class="glyphicon glyphicon-remove sky-remove" aria-hidden="true" data-user-id="<?php echo sky_get_user_id() ?>" data-type="remove-reading" data-parent_id="<?php echo $reading_parent_id ?>" data-chapper_id="<?php echo $reading_id ?>" data-remove="reading-<?php echo $reading_parent_id ?>"></span>
														</a>
													</p>
												</div>
												<div class="actions">
													<a href="<?php echo get_permalink( $reading_parent_id ) ?>" class="btn-view">
														Xem tiếp
														<i class="sky-icon icon-right"></i>
													</a>
												</div>
											</div>
										</li>
										<?php
									endforeach;
								else :
									echo '<li class="list-group-item list-group-item-with-thumb"><div class="content">Bạn chưa đọc truyện nào!</div></li>';
								endif;
							else :
								if ( ! empty( $_COOKIE[ 'sky_reading' ] ) ) {
									$sky_reading = sky_decode_json_js( $_COOKIE[ 'sky_reading' ] );
									$i_reading   = 0;
									foreach ( $sky_reading as $reading_parent_id => $reading_id ) {
										if ( 5 <= $i_reading ++ ) {
											break;
										}

										$reading_parent_id    = str_replace( 'parent_', '', $reading_parent_id );
										$reading_id           = str_replace( 'chapper_', '', $reading_id );

										$reading_info_chapper = Sky_iManga::get_chapper_by_id( $reading_id );

										if ( empty( $reading_info_chapper ) ) {
											continue;
										}
										?>
										<li class="list-group-item list-group-item-with-thumb reading-<?php echo $reading_parent_id ?>">
											<div class="content">
												<a class="thumb" href="<?php echo get_permalink( $reading_parent_id ) ?>" title="<?php echo get_the_title( $reading_parent_id ); ?>">
													<img class="img-responsive" src="<?php echo sky_thumb_src( $reading_parent_id, 'thumbnail-200x300', '200x300' ) ?>" alt="<?php echo get_the_title( $reading_parent_id ); ?>">
												</a>
												<div class="info">
													<h2 class="title">
														<a href="<?php echo get_permalink( $reading_parent_id ) ?>" title="<?php echo get_the_title( $reading_parent_id ); ?>">
															<?php echo get_the_title( $reading_parent_id ); ?>
														</a>
													</h2>
													<p class="chap">
														<?php Sky_iManga::get_chapper_latest( $reading_parent_id ) ?>
														<!--<a href="javascript:void(0)">
															<span class="glyphicon glyphicon-remove sky-remove" aria-hidden="true" data-user-id="<?php echo sky_get_user_id() ?>" data-type="remove-reading" data-parent_id="<?php echo $reading_parent_id ?>" data-chapper_id="<?php echo $reading_id ?>" data-remove="reading-<?php echo $reading_parent_id ?>"></span>
														</a>-->
													</p>
												</div>
												<div class="actions">
													<a href="<?php echo get_permalink( $reading_parent_id ) ?>" class="btn-view">
														Xem tiếp
														<i class="sky-icon icon-right"></i>
													</a>
												</div>
											</div>
										</li>
										<?php
									}
								} else {
									$args_random  = array(
										'post_type'      => 'imanga',
										'posts_per_page' => 7,
										'post_status'    => 'publish',
									);
									$random_query = new WP_Query( $args_random );

									if ( $random_query->have_posts() ) {
										while ( $random_query->have_posts() ) {
											$random_query->the_post();
											?>
											<li class="list-group-item list-group-item-with-thumb">
												<div class="content">
													<a class="thumb" href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>">
														<img class="img-responsive" src="<?php echo sky_thumb_src( get_the_ID(), 'thumbnail-200x300', '200x300' ) ?>" alt="<?php echo the_title(); ?>">
													</a>
													<div class="info">
														<h2 class="title">
															<a href="<?php the_permalink() ?>" title="<?php echo the_title(); ?>">
																<?php echo the_title(); ?>
															</a>
														</h2>
														<p class="chap">
															<?php Sky_iManga::get_chapper_first( get_the_ID() ) ?>
														</p>
													</div>
													<div class="actions">
														<a href="<?php the_permalink() ?>" class="btn-view">
															Xem tiếp
															<i class="sky-icon icon-right"></i>
														</a>
													</div>
												</div>
											</li>
											<?php
										}
										echo '</ul>';
										/* Restore original Post Data */
										wp_reset_postdata();
									}
								}
							endif;
							?>
						</ul>
					</div>
				</div>
<div class="block block-default">
					<div class="block-header">
						<h2 class="title"><center>Truyện đọc nhiều</center></h2>
					</div>
					<div class="block-content">
						<?php sky_get_manga( 'top-ngay', 'style-top-reading',5 ) ?>
					</div>
				</div>
			</div>
			</div>
		</div>
</section>