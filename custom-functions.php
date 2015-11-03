<?php
	/*
		Table of Contents

		1. Theme Logo
		2. Theme Menu
		3. Slider
		4. Slider + Thumb
		5. Advance Search
		6. Advance Search Div
		7. Advance Search Form
		8. Homepage Video
		9. Services
		10. Property List
		11. Blog
		12. Welcome Text
		13. Agent List
		14. Featured List
		15. Testimonials
		16. Share Icons
		17. Header social icons
		18. Header call information
		19. Partners List
	*/


	/*---------------------------------------------
	1. THEME LOGO
	----------------------------------------------*/

	function homeland_theme_logo() {
		$homeland_logo = esc_attr( get_option('homeland_logo') ); 
		$homeland_blog_name = esc_attr( get_bloginfo('name') ); ?>

		<!--LOGO-->		
		<aside class="logo clear">
			<h1>
				<a href="<?php echo esc_url( home_url() ); ?>">
					<img src="<?php if(empty( $homeland_logo )) : echo get_template_directory_uri() . "/img/logo.png"; else : echo $homeland_logo; endif; ?>" alt="<?php echo $homeland_blog_name; ?>" title="<?php echo $homeland_blog_name; ?>" />
				</a>
			</h1>
		</aside><?php
	}


	/*---------------------------------------------
	2. THEME MENU
	----------------------------------------------*/

	function homeland_theme_menu() {
		?>
			<!--MENU-->
			<nav class="clear">
				<?php
					wp_nav_menu( array( 
						'theme_location' => 'primary-menu', 
						'fallback_cb' => 'homeland_menu_fallback', 
						'container_class' => 'theme-menu', 
						'container_id' => 'dropdown', 
						'menu_id' => 'main-menu', 
						'menu_class' => 'sf-menu' 
					) );
				?>
			</nav>	
		<?php
	}
	

	/*---------------------------------------------
	3. SLIDER
	----------------------------------------------*/

	function homeland_slider() {
		global $post;

		$homeland_slider_order = esc_attr( get_option('homeland_slider_order') );
		$homeland_slider_orderby = esc_attr( get_option('homeland_slider_orderby') );
		$homeland_slider_limit = esc_attr( get_option('homeland_slider_limit') );
		$homeland_slider_button = get_option('homeland_slider_button');
		$homeland_hide_properties_details = get_option('homeland_hide_properties_details');
		$homeland_currency = get_option('homeland_property_currency');
		$homeland_slider_display_list = get_option('homeland_slider_display_list');
		
		if($homeland_slider_display_list == 'All') :
			$args = array( 
				'post_type' => 'homeland_properties', 
				'orderby' => $homeland_slider_orderby, 
				'order' => $homeland_slider_order, 
				'posts_per_page' => $homeland_slider_limit
			);
		else :
			$args = array( 
				'post_type' => 'homeland_properties', 
				'orderby' => $homeland_slider_orderby, 
				'order' => $homeland_slider_order, 
				'posts_per_page' => $homeland_slider_limit, 
				'meta_query' => array( array( 
					'key' => 'homeland_featured', 
					'value' => 'on', 
					'compare' => '==' 
				)) 
			);	
		endif;	

		$wp_query = new WP_Query( $args );

		if ($wp_query->have_posts()) : ?>
			<!--SLIDER-->
			<section class="slider-block">
				<div class="home-flexslider flex-loading">
					<ul class="slides"><?php
						while ($wp_query->have_posts()) : 
							$wp_query->the_post(); 
							$homeland_price_per = get_post_meta( $post->ID, 'homeland_price_per', true );
							$homeland_price = get_post_meta($post->ID, 'homeland_price', true );
							$homeland_price_format = get_option('homeland_price_format'); 

							?>
							<li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<div class="slide-image">
									<?php if ( has_post_thumbnail() ) : the_post_thumbnail('homeland_slider'); endif; ?>
								</div>
								<?php
									if(empty( $homeland_hide_properties_details )) : ?>
										<div class="inside">
											<div class="slider-actions">
												<div class="portfolio-slide-desc">
													<?php 
														the_title( '<h2>', '</h2>' ); 
														the_excerpt(); 
													?>
												</div>	
												<div class="pactions clear">
													<?php 
														if(!empty($homeland_price)) : ?>
															<label>
																<i class="fa fa-tag"></i>
																<span>
																	<?php
																		echo $homeland_currency;
																		if($homeland_price_format == "Dot") :
																			echo number_format ( esc_attr ( $homeland_price ), 0, ".", "." );
																		elseif($homeland_price_format == "None") : echo $homeland_price;
																		else : echo number_format ( esc_attr ( $homeland_price ) );
																		endif;
																		if(!empty($homeland_price_per)) : echo "/" . $homeland_price_per; endif; 
																	?>
																</span>
															</label><?php
														endif;
													?>
													<a href="<?php the_permalink(); ?>">
														<span>
															<?php 
																if(!empty( $homeland_slider_button )) : echo $homeland_slider_button;
																else : _e( 'More Details', CODEEX_THEME_NAME );
																endif;
															?>
														</span><i class="fa fa-plus-circle"></i>
													</a>
												</div>
											</div>
										</div><?php
									endif;
								?>
							</li><?php
						endwhile; ?>
					</ul>	
				</div>	
			</section><?php
		endif;	
	}


	/*---------------------------------------------
	4. SLIDER + THUMB
	----------------------------------------------*/

	function homeland_slider_thumb() {
		global $post;

		$homeland_slider_order = esc_attr( get_option('homeland_slider_order') );
		$homeland_slider_orderby = esc_attr( get_option('homeland_slider_orderby') );
		$homeland_slider_limit = esc_attr( get_option('homeland_slider_limit') );
		$homeland_slider_button = get_option('homeland_slider_button');
		$homeland_hide_properties_details = get_option('homeland_hide_properties_details');
		$homeland_currency = get_option('homeland_property_currency'); 
		$homeland_slider_display_list = get_option('homeland_slider_display_list');
		
		if($homeland_slider_display_list == 'All') :
			$args = array( 
				'post_type' => 'homeland_properties', 
				'orderby' => $homeland_slider_orderby, 
				'order' => $homeland_slider_order, 
				'posts_per_page' => $homeland_slider_limit
			);
		else :
			$args = array( 
				'post_type' => 'homeland_properties', 
				'orderby' => $homeland_slider_orderby, 
				'order' => $homeland_slider_order, 
				'posts_per_page' => $homeland_slider_limit, 
				'meta_query' => array( array( 
					'key' => 'homeland_featured', 
					'value' => 'on', 
					'compare' => '==' 
				)) 
			);	
		endif;

		$wp_query = new WP_Query( $args );

		if ($wp_query->have_posts()) : ?>
			<!--SLIDER-->
			<section class="slider-block-thumb">
				<div class="home-thumb-flexslider flex-loading">
					<ul class="slides"><?php
						while ($wp_query->have_posts()) : 
							$wp_query->the_post(); 
							$homeland_price_per = get_post_meta( $post->ID, 'homeland_price_per', true );
							$homeland_price = get_post_meta($post->ID, 'homeland_price', true );
							$homeland_price_format = get_option('homeland_price_format');
							$homeland_thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'homeland_property_thumb' ); 
							$mlsLink = get_post_meta( $posts[0]->ID, 'mls_link', true );
							
							?>
							<li id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-thumb="<?php echo $homeland_thumb_image_url[0]; ?>">
								<div class="slide-image">
									<?php if ( has_post_thumbnail() ) : the_post_thumbnail(array(923,9999)); endif; ?>
								</div>
								<?php
									if(empty( $homeland_hide_properties_details )) : ?>
										<div class="inside">
											<div class="slider-actions">
												<div class="portfolio-slide-desc">
													<?php 
														the_title( '<h2>', '</h2>' ); 
														the_excerpt(); 
													?>
												</div>	
												<div class="pactions clear">
													<?php 
														if(!empty($homeland_price)) : ?>
															<label>
																<i class="fa fa-tag"></i>
																<span>
																	<?php
																		echo $homeland_currency;
																		if($homeland_price_format == "Dot") :
																			echo number_format ( esc_attr ( $homeland_price ), 0, ".", "." );
																		elseif($homeland_price_format == "None") : echo $homeland_price;
																		else : echo number_format ( esc_attr ( $homeland_price ) );
																		endif;
																		if(!empty($homeland_price_per)) : echo "/" . $homeland_price_per; endif; 
																	?>
																</span>
															</label><?php
														endif;
													?>
													<a href="<?php echo $mlsLink ?>">
														<span>
															<?php 
																if(!empty( $homeland_slider_button )) : echo $homeland_slider_button;
																else : _e( 'More Details', CODEEX_THEME_NAME );
																endif;
															?>
														</span><i class="fa fa-plus-circle"></i>
													</a>
												</div>													
											</div>
										</div><?php
									endif;
								?>	
							</li><?php
						endwhile; ?>
					</ul>	
				</div>	
			</section><?php
		endif;	
	}


	/*---------------------------------------------
	5. ADVANCE SEARCH
	----------------------------------------------*/

	function homeland_advance_search() {
		$homeland_disable_advance_search = get_option('homeland_disable_advance_search');
		$homeland_hide_advance_search = get_option('homeland_hide_advance_search');	

		if(is_front_page()) : 
			if(empty($homeland_hide_advance_search)) : homeland_advance_search_divs(); endif;
		elseif(is_page() || is_single() || is_archive() || is_author() || is_404() || is_search() ) :
			if(empty($homeland_disable_advance_search)) : homeland_advance_search_divs(); endif;
		endif;
	}


	/*---------------------------------------------
	6. ADVANCE SEARCH DIV
	----------------------------------------------*/

	function homeland_advance_search_divs() {
		if(is_page_template('template-homepage.php') || is_page_template('template-homepage2.php') || is_page_template('template-homepage3.php') || is_page_template('template-homepage4.php') || is_page_template('template-homepage-video.php') || is_page_template('template-homepage-revslider.php') || is_page_template('template-homepage-gmap.php') || is_page_template('template-homepage-builder.php')) : 
			$homeland_search_class = "advance-search-block";
		else : $homeland_search_class = "advance-search-block advance-search-block-page";
		endif;

		echo '<section class="' . $homeland_search_class . '"><div class="inside">';
			if ( is_active_sidebar( 'homeland_search_type' ) ) : dynamic_sidebar( 'homeland_search_type' );
			else : homeland_advance_search_form();
			endif;
		echo '</div></section>';
	}


	/*---------------------------------------------
	7. ADVANCE SEARCH FORM
	----------------------------------------------*/

	function homeland_advance_search_form() {
		global $homeland_advance_search_page_url;

		$homeland_currency = get_option('homeland_property_currency'); 
		$homeland_location_label = get_option('homeland_location_label');
		$homeland_selectbox_label = get_option('homeland_selectbox_label');
		$homeland_pid_label = get_option('homeland_pid_label');
		$homeland_status_label = get_option('homeland_status_label');
		$homeland_selectbox_label = get_option('homeland_selectbox_label');
		$homeland_property_type_label = get_option('homeland_property_type_label');
		$homeland_bed_label = get_option('homeland_bed_label');
		$homeland_bath_label = get_option('homeland_bath_label');
		$homeland_min_price_label = get_option('homeland_min_price_label');
		$homeland_max_price_label = get_option('homeland_max_price_label');
		$homeland_search_button_label = get_option('homeland_search_button_label');
		$homeland_hide_location = get_option('homeland_hide_location');
		$homeland_hide_pid = get_option('homeland_hide_pid');
		$homeland_hide_status = get_option('homeland_hide_status');
		$homeland_hide_property_type = get_option('homeland_hide_property_type');
		$homeland_hide_bed = get_option('homeland_hide_bed');
		$homeland_hide_bath = get_option('homeland_hide_bath');
		$homeland_hide_min_price = get_option('homeland_hide_min_price');
		$homeland_hide_max_price = get_option('homeland_hide_max_price');
		$homeland_price_format = get_option('homeland_price_format');
		$homeland_prefix = "-- ";

		?>
		<form action="<?php echo $homeland_advance_search_page_url; ?>" method="get" id="searchform">
			<ul class="clear">
				<?php
					if(empty( $homeland_hide_pid )) : 
						$homeland_search_term = @$_GET['pid']; ?>
						<li>
							<label for="property_id">
								<?php
									if(!empty( $homeland_pid_label )) : echo $homeland_pid_label;
									else : esc_attr( _e( 'Property ID', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<input type="text" name="pid" class="property-id" value="<?php if($homeland_search_term) : echo $_GET['pid']; endif; ?>" />
						</li><?php
					endif;

					if(empty( $homeland_hide_location )) : ?>
						<li>
							<label for="location">
								<?php
									if(!empty( $homeland_location_label )) : echo $homeland_location_label;
									else : esc_attr( _e( 'Location', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<select name="location">
								<option value="" selected="selected">
									<?php
										if(!empty( $homeland_selectbox_label )) : echo $homeland_selectbox_label;
										else : esc_attr( _e( 'Select', CODEEX_THEME_NAME ) );
										endif;
									?>
								</option>
								<?php
									$homeland_search_term = @$_GET['location'];

									$args = array( 'hide_empty' => 1, 'hierarchical' => 0, 'parent' => 0 );
									$homeland_terms = get_terms('homeland_property_location', $args);

									foreach ($homeland_terms as $homeland_plocation) : ?>
									   <option value="<?php echo $homeland_plocation->slug; ?>" <?php if($homeland_search_term == $homeland_plocation->slug) : echo "selected='selected'"; endif; ?>>
									   	<?php echo $homeland_plocation->name; ?>
									   </option><?php

									   //Child

									   $args_child = array( 'hide_empty' => 0, 'hierarchical' => 0, 'parent' => $homeland_plocation->term_id );
										$homeland_terms_child = get_terms('homeland_property_location', $args_child);

										foreach ($homeland_terms_child as $homeland_plocation_child) : ?>
										   <option value="<?php echo $homeland_plocation_child->slug; ?>" <?php if($homeland_search_term == $homeland_plocation_child->slug) : echo "selected='selected'"; endif; ?>>
										   	<?php echo $homeland_prefix . $homeland_plocation_child->name; ?>
										   </option><?php
										endforeach;
									endforeach;
								?>						
							</select>									
						</li><?php
					endif;

					if(empty( $homeland_hide_property_type )) : ?>
						<li>
							<label>
								<?php
									if(!empty( $homeland_property_type_label )) : echo $homeland_property_type_label;
									else : esc_attr( _e( 'Type', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<select name="type">
								<option value="" selected="selected">
									<?php
										if(!empty( $homeland_selectbox_label )) : echo $homeland_selectbox_label; 
										else : esc_attr( _e( 'Select', CODEEX_THEME_NAME ) );
										endif;
									?>
								</option>
								<?php
									$homeland_search_term = @$_GET['type'];

									$args = array( 'hide_empty' => 1, 'hierarchical' => 0, 'parent' => 0 );
									$homeland_terms = get_terms('homeland_property_type', $args);

									if(!empty($homeland_terms)) :
										foreach ($homeland_terms as $homeland_ptype) : ?>
										   <option value="<?php echo $homeland_ptype->slug; ?>" <?php if($homeland_search_term == $homeland_ptype->slug) : echo "selected='selected'"; endif; ?>>
										   	<?php echo $homeland_ptype->name; ?>
										   </option><?php

										   //Child

										   $args_child = array( 'hide_empty' => 0, 'hierarchical' => 0, 'parent' => $homeland_ptype->term_id );
											$homeland_terms_child = get_terms('homeland_property_type', $args_child);

											foreach ($homeland_terms_child as $homeland_ptype_child) : ?>
											   <option value="<?php echo $homeland_ptype_child->slug; ?>" <?php if($homeland_search_term == $homeland_ptype_child->slug) : echo "selected='selected'"; endif; ?>>
											   	<?php echo $homeland_prefix . $homeland_ptype_child->name; ?>
											   </option><?php
											endforeach;
										endforeach;
									endif;
								?>
							</select>
						</li><?php
					endif;

					if(empty( $homeland_hide_status )) : ?>
						<li>
							<label>
								<?php
									if(!empty( $homeland_status_label )) : echo $homeland_status_label;
									else : esc_attr( _e( 'Status', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<select name="status">
								<option value="" selected="selected">
									<?php
										if(!empty( $homeland_selectbox_label )) : echo $homeland_selectbox_label;
										else : esc_attr( _e( 'Select', CODEEX_THEME_NAME ) );
										endif;
									?>
								</option>
								<?php
									$homeland_search_term = @$_GET['status'];

									$args = array( 'hide_empty' => 1, 'hierarchical' => 0, 'parent' => 0 );
									$homeland_terms = get_terms('homeland_property_status', $args);

									foreach ($homeland_terms as $homeland_pstatus) : ?>
									   <option value="<?php echo $homeland_pstatus->slug; ?>" <?php if($homeland_search_term == $homeland_pstatus->slug) : echo "selected='selected'"; endif; ?>>
									   	<?php echo $homeland_pstatus->name; ?>
									   </option><?php

									   //Child

									   $args_child = array( 'hide_empty' => 0, 'hierarchical' => 0, 'parent' => $homeland_pstatus->term_id );
										$homeland_terms_child = get_terms('homeland_property_status', $args_child);

										foreach ($homeland_terms_child as $homeland_pstatus_child) : ?>
										   <option value="<?php echo $homeland_pstatus_child->slug; ?>" <?php if($homeland_search_term == $homeland_pstatus_child->slug) : echo "selected='selected'"; endif; ?>>
										   	<?php echo $homeland_prefix . $homeland_pstatus_child->name; ?>
										   </option><?php
										endforeach;
									endforeach;
								?>						
							</select>
						</li><?php
					endif;

					if(empty( $homeland_hide_bed )) : ?>
						<li>
							<label>
								<?php
									if(!empty( $homeland_bed_label )) : echo $homeland_bed_label;
									else : esc_attr( _e( 'Bedrooms', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<select name="bed" class="small">
								<option value="" selected="selected">
									<?php
										if(!empty( $homeland_selectbox_label )) : echo $homeland_selectbox_label; 
										else : esc_attr( _e( 'Select', CODEEX_THEME_NAME ) );
										endif;
									?>
								</option>
								<?php
									$homeland_search_term = @$_GET['bed'];
									$homeland_bed_number = get_option('homeland_bed_number');
									$homeland_array = explode(", ", $homeland_bed_number);

									foreach($homeland_array as $homeland_number_option) : ?>
					               <option value="<?php echo $homeland_number_option; ?>" <?php if($homeland_search_term == $homeland_number_option) : echo "selected='selected'"; endif; ?>>
					               	<?php echo $homeland_number_option; ?>
					               </option><?php
					            endforeach;
								?>						
							</select>
						</li><?php
					endif;

					if(empty( $homeland_hide_bath )) : ?>
						<li>
							<label>
								<?php
									if(!empty( $homeland_bath_label )) : echo $homeland_bath_label;
									else : esc_attr( _e( 'Bathrooms', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<select name="bath" class="small">
								<option value="" selected="selected">
									<?php
										if(!empty( $homeland_selectbox_label )) : echo $homeland_selectbox_label;
										else : esc_attr( _e( 'Select', CODEEX_THEME_NAME ) );
										endif;
									?>
								</option>
								<?php
									$homeland_search_term = @$_GET['bath'];
									$homeland_bath_number = get_option('homeland_bath_number');
									$homeland_array = explode(", ", $homeland_bath_number);

									foreach($homeland_array as $homeland_number_option) : ?>
					               <option value="<?php echo $homeland_number_option; ?>" <?php if($homeland_search_term == $homeland_number_option) : echo "selected='selected'"; endif; ?>>
					               	<?php echo $homeland_number_option; ?>
					               </option><?php
					            endforeach;
								?>		
							</select>
						</li><?php
					endif;

					if(empty( $homeland_hide_min_price )) : ?>
						<li>
							<label>
								<?php  
									if(!empty( $homeland_min_price_label )) : echo $homeland_min_price_label;
									else : esc_attr( _e( 'Minimum Price', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<select name="min-price" class="small">
								<option value="" selected="selected">
									<?php
										if(!empty( $homeland_selectbox_label )) : echo $homeland_selectbox_label;
										else : esc_attr( _e( 'Select', CODEEX_THEME_NAME ) );
										endif;
									?>
								</option>			
								<?php
									$homeland_search_term = @$_GET['min-price'];
									$homeland_min_price_value = get_option('homeland_min_price_value');
									$homeland_array = explode(", ", $homeland_min_price_value);

									foreach($homeland_array as $homeland_number_option) : ?>
										<option value="<?php echo $homeland_number_option; ?>" <?php if($homeland_search_term == $homeland_number_option) : echo "selected='selected'"; endif; ?>>
											<?php 
												echo $homeland_currency;
												if($homeland_price_format == "Dot") :
													echo number_format ( $homeland_number_option, 0, ".", "." );
												elseif($homeland_price_format == "None") : echo $homeland_number_option;
												else : echo number_format ( $homeland_number_option );
												endif;
											?>
										</option><?php
					            endforeach;
								?>					
							</select>
						</li><?php
					endif;

					if(empty( $homeland_hide_max_price )) : ?>
						<li>
							<label>
								<?php  
									if(!empty( $homeland_max_price_label )) : echo $homeland_max_price_label;
									else : esc_attr( _e( 'Maximum Price', CODEEX_THEME_NAME ) );
									endif;
								?>
							</label>
							<select name="max-price" class="small">
								<option value="" selected="selected">
									<?php
										if(!empty( $homeland_selectbox_label )) : echo $homeland_selectbox_label;
										else : esc_attr( _e( 'Select', CODEEX_THEME_NAME ) );
										endif;
									?>
								</option>
								<?php
									$homeland_search_term = @$_GET['max-price'];
									$homeland_max_price_value = get_option('homeland_max_price_value');
									$homeland_array = explode(", ", $homeland_max_price_value);

									foreach($homeland_array as $homeland_number_option) : ?>
										<option value="<?php echo $homeland_number_option; ?>" <?php if($homeland_search_term == $homeland_number_option) : echo "selected='selected'"; endif; ?>>
											<?php 
												echo $homeland_currency;
												if($homeland_price_format == "Dot") :
													echo number_format ( $homeland_number_option, 0, ".", "." );
												elseif($homeland_price_format == "None") : echo $homeland_number_option;
												else : echo number_format ( $homeland_number_option );
												endif;
											?>
										</option><?php
					            endforeach;
								?>	
							</select>
						</li><?php
					endif;
				?>

				<li class="last">
					<label>&nbsp;</label>
					<input type="submit" value="<?php if(!empty( $homeland_search_button_label )) : echo $homeland_search_button_label; else : esc_attr( _e( 'Search', CODEEX_THEME_NAME ) ); endif; ?>" />
				</li>
			</ul>

		</form><?php
	}


	/*---------------------------------------------
	8. HOMEPAGE VIDEO
	----------------------------------------------*/

	function homeland_video_fullwidth() {
		echo '<section class="home-video-block">';
			echo '<iframe width="770" height="433" src="' . get_option('homeland_video_url') . '" frameborder="0" allowfullscreen class="sframe"></iframe>';
		echo '</section>';
	}


	/*---------------------------------------------
	9. SERVICES
	----------------------------------------------*/

	function homeland_services_list() {
		global $post;

		$homeland_services_order = esc_attr( get_option('homeland_services_order') );
		$homeland_services_orderby = esc_attr( get_option('homeland_services_orderby') );
		$homeland_services_limit = esc_attr( get_option('homeland_services_limit') );
		$homeland_services_button = get_option('homeland_services_button');
		
		$args = array( 
			'post_type' => 'homeland_services', 
			'orderby' => $homeland_services_orderby, 
			'order' => $homeland_services_order, 
			'posts_per_page' => $homeland_services_limit 
		);

		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--SERVICES-->
			<section class="services-block">
				<div class="inside services-list-box clear"><?php
					for($homeland_i = 1; $wp_query->have_posts(); $homeland_i++) {
						$wp_query->the_post();		

						$homeland_custom_link = get_post_meta( $post->ID, 'homeland_custom_link', true );	
						$homeland_icon = esc_html( get_post_meta( $post->ID, "homeland_icon", true ) );
						$homeland_custom_icon = esc_html( get_post_meta( $post->ID, "homeland_custom_icon", true ) );	

						$homeland_columns = 3;	
						$homeland_class = 'services-list clear ';
						$homeland_class .= ($homeland_i % $homeland_columns == 0) ? 'last' : ''; ?>
						
						<div id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class($homeland_class) ); ?>>
							<span class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a">
								<?php
									if(!empty($homeland_icon)) : ?><i class="hi-icon fa <?php echo $homeland_icon; ?>"></i><?php
									else : ?><img src="<?php echo $homeland_custom_icon; ?>" alt="" title="" /><?php
									endif;
								?>
							</span>
							<div class="services-desc">
								<?php 
									the_title( '<h5>', '</h5>' ); 
									the_excerpt();

									if(!empty($homeland_custom_link)) :
										?><a href="<?php echo $homeland_custom_link; ?>" class="more" target="_blank"><?php
									else :
										?><a href="<?php the_permalink(); ?>" class="more"><?php
									endif;

										if(!empty( $homeland_services_button )) : echo $homeland_services_button;
										else : esc_attr( _e( 'More Details', CODEEX_THEME_NAME ) ); 
										endif; 
									?>
								</a>
							</div>
						</div><?php
					} ?>				
				</div>
			</section><?php
		endif;
	}

	function homeland_services_list_two() {
		global $post;

		$homeland_services_order = esc_attr( get_option('homeland_services_order') );
		$homeland_services_orderby = esc_attr( get_option('homeland_services_orderby') );
		$homeland_services_limit = esc_attr( get_option('homeland_services_limit') );
		$homeland_services_button = get_option('homeland_services_button');
		
		$args = array( 
			'post_type' => 'homeland_services', 
			'orderby' => $homeland_services_orderby, 
			'order' => $homeland_services_order, 
			'posts_per_page' => $homeland_services_limit 
		);

		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--SERVICES-->
			<section class="services-block-two">
				<div class="inside services-list-box clear"><?php
					for($homeland_i = 1; $wp_query->have_posts(); $homeland_i++) {
						$wp_query->the_post();		

						$homeland_custom_link = get_post_meta( $post->ID, 'homeland_custom_link', true );	
						$homeland_icon = esc_html( get_post_meta( $post->ID, "homeland_icon", true ) );
						$homeland_custom_icon = esc_html( get_post_meta( $post->ID, "homeland_custom_icon", true ) );	

						$homeland_columns = 3;	
						$homeland_class = 'services-list clear ';
						$homeland_class .= ($homeland_i % $homeland_columns == 0) ? 'last' : ''; ?>
						
						<div id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class($homeland_class) ); ?>>
							<div class="services-icon">
								<?php
									if(!empty($homeland_icon)) : ?><i class="fa <?php echo $homeland_icon; ?> fa-4x"></i><?php
									else : ?><img src="<?php echo $homeland_custom_icon; ?>" alt="" title="" /><?php
									endif;
								?>
							</div>
							<div class="services-desc">
								<?php 
									the_title( '<h5>', '</h5>' ); 
									the_excerpt();

									if(!empty($homeland_custom_link)) :
										?><a href="<?php echo $homeland_custom_link; ?>" class="more" target="_blank"><?php
									else :
										?><a href="<?php the_permalink(); ?>" class="more"><?php
									endif;
										if(!empty( $homeland_services_button )) : echo $homeland_services_button;
										else : esc_attr( _e( 'More Details', CODEEX_THEME_NAME ) ); 
										endif; 
									?>
								</a>
							</div>
						</div><?php
					} ?>				
				</div>
			</section><?php
		endif;
	}

	function homeland_services_list_bg() {
		global $post;

		$homeland_services_order = esc_attr( get_option('homeland_services_order') );
		$homeland_services_orderby = esc_attr( get_option('homeland_services_orderby') );
		$homeland_services_limit = esc_attr( get_option('homeland_services_limit') );
		$homeland_services_button = get_option('homeland_services_button');
		
		$args = array( 
			'post_type' => 'homeland_services', 
			'orderby' => $homeland_services_orderby, 
			'order' => $homeland_services_order, 
			'posts_per_page' => $homeland_services_limit 
		);

		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--SERVICES-->
			<section class="services-block-bg">
				<div class="inside services-list-box clear"><?php
					for($homeland_i = 1; $wp_query->have_posts(); $homeland_i++) {
						$wp_query->the_post();		

						$homeland_custom_link = get_post_meta( $post->ID, 'homeland_custom_link', true );	
						$homeland_icon = esc_html( get_post_meta( $post->ID, "homeland_icon", true ) );
						$homeland_custom_icon = esc_html( get_post_meta( $post->ID, "homeland_custom_icon", true ) );	

						$homeland_columns = 3;	
						$homeland_class = 'services-list clear ';
						$homeland_class .= ($homeland_i % $homeland_columns == 0) ? 'last' : ''; ?>
						
						<div id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class($homeland_class) ); ?>>
							<span class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a">
								<?php
									if(!empty($homeland_icon)) : ?><i class="hi-icon fa <?php echo $homeland_icon; ?>"></i><?php
									else : ?><img src="<?php echo $homeland_custom_icon; ?>" alt="" title="" /><?php
									endif;
								?>
							</span>
							<div class="services-desc">
								<?php 
									the_title( '<h5>', '</h5>' ); 
									the_excerpt();

									if(!empty($homeland_custom_link)) :
										?><a href="<?php echo $homeland_custom_link; ?>" class="more" target="_blank"><?php
									else :
										?><a href="<?php the_permalink(); ?>" class="more"><?php
									endif;
										if(!empty( $homeland_services_button )) : echo $homeland_services_button;
										else : esc_attr( _e( 'More Details', CODEEX_THEME_NAME ) ); 
										endif; 
									?>
								</a>
							</div>
						</div><?php
					} ?>				
				</div>
			</section><?php
		endif;
	}


	/*---------------------------------------------
	10. PROPERTY LIST
	----------------------------------------------*/

	function homeland_property_list() {
		global $post, $homeland_class;

		$homeland_album_order = esc_attr( get_option('homeland_album_order') );
		$homeland_album_orderby = esc_attr( get_option('homeland_album_orderby') );
		$homeland_property_limit = esc_attr( get_option('homeland_property_limit') );
		$homeland_property_header = get_option('homeland_property_header');
		
		$args = array( 
			'post_type' => 'homeland_properties', 
			'orderby' => $homeland_album_orderby, 
			'order' => $homeland_album_order, 
			'posts_per_page' => $homeland_property_limit
		);

		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--PROPERTY-->
			<section class="property-block">
				<div class="inside property-list-box clear">
					<h2>
						<span>
							<?php 
								if(!empty( $homeland_property_header )) : echo $homeland_property_header;
								else : sanitize_title( _e( 'Latest Property', CODEEX_THEME_NAME ) ); 
								endif;
							?>
						</span>
					</h2>
					<div id="carousel" class="es-carousel-wrapper">
						<div class="es-carousel">
							<div class="grid cs-style-3">	
								<ul class="clear">
									<?php
										while ($wp_query->have_posts()) : $wp_query->the_post();
											$homeland_class = 'property-home';
											get_template_part( 'loop', 'property-home' );
										endwhile;								
									?>
								</ul>
							</div>
						</div>	
					</div>			
				</div>
			</section><?php	
		endif;
	}

	function homeland_property_list_grid() {
		global $post, $homeland_class;

		$homeland_album_order = esc_attr( get_option('homeland_album_order') );
		$homeland_album_orderby = esc_attr( get_option('homeland_album_orderby') );
		$homeland_property_limit = esc_attr( get_option('homeland_property_limit') );
		$homeland_property_header = get_option('homeland_property_header');
		
		$args = array( 
			'post_type' => 'homeland_properties', 
			'orderby' => $homeland_album_orderby, 
			'order' => $homeland_album_order, 
			'posts_per_page' => $homeland_property_limit 
		);

		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--PROPERTY-->
			<section class="property-block">
				<div class="inside property-list-box clear">
					<h2>
						<span>
							<?php 
								if(!empty( $homeland_property_header )) : echo $homeland_property_header;
								else : sanitize_title( _e( 'Latest Property', CODEEX_THEME_NAME ) ); 
								endif;
							?>
						</span>
					</h2>
					<div class="grid cs-style-3 masonry">	
						<ul class="clear">
							<?php
								for($homeland_i = 1; $wp_query->have_posts(); $homeland_i++) {
									$wp_query->the_post();			
									$homeland_columns = 3;	
									$homeland_class = 'property-home masonry-item ';
									$homeland_class .= ($homeland_i % $homeland_columns == 0) ? 'last' : '';
									
									get_template_part( 'loop', 'property-home' );
								}
							?>
						</ul>
					</div>		
				</div>
			</section><?php	
		endif;
	}


	/*---------------------------------------------
	11. BLOG
	----------------------------------------------*/

	function homeland_blog_latest() {
		global $post;

		$homeland_blog_limit = esc_attr( get_option('homeland_blog_limit') );
		$homeland_blog_header = get_option('homeland_blog_header');
		$homeland_blog_category = get_option('homeland_blog_category');
          				
		if($homeland_blog_category == "Choose a category") :
			$args = array( 'post_type' => 'post', 'posts_per_page' => $homeland_blog_limit );
		else :
			$args = array( 'post_type' => 'post', 'posts_per_page' => $homeland_blog_limit, 'category_name' => $homeland_blog_category );
		endif;					
			
		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--BLOG-->
			<div class="blog-block">
				<h3>
					<span>
						<?php
							if(!empty( $homeland_blog_header )) : echo $homeland_blog_header;
							else : sanitize_title( _e( 'Our Blog', CODEEX_THEME_NAME ) ); 
							endif; 
						?>
					</span>
				</h3>
				<div class="grid cs-style-3">	
					<ul>
						<?php
							while ($wp_query->have_posts()) : $wp_query->the_post(); 
								if ( ( function_exists( 'get_post_format' ) && 'audio' == get_post_format( $post->ID ) )  ) : 
									echo get_post_meta( $post->ID, 'homeland_audio', TRUE );
								else : ?>
									<li id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class('latest-list clear') ); ?>>
										<div class="bimage"><a href="<?php the_permalink(); ?>"><?php if ( has_post_thumbnail() ) { the_post_thumbnail('homeland_news_thumb'); } ?></a></div>
										<div class="bdesc">
											<?php the_title( '<h5><a href="' . get_permalink() . '">', '</a></h5>' );  ?>
											<label>
												<?php the_content(); ?>
											</label>
										</div>
									</li><?php	
								endif;						
							endwhile;								
						?>
					</ul>	
				</div>
			</div><?php
		else :
			_e( 'You have no blog post yet!', CODEEX_THEME_NAME );
		endif;
	}


	/*---------------------------------------------
	12. WELCOME TEXT
	----------------------------------------------*/

	function homeland_welcome_text() {
		$homeland_welcome_button = get_option('homeland_welcome_button');	
		$homeland_welcome_header = stripslashes( get_option('homeland_welcome_header') );
		$homeland_welcome_text = stripslashes( get_option('homeland_welcome_text') );
		$homeland_welcome_link = get_option('homeland_welcome_link');
		?>

			<section class="welcome-block">
				<div class="inside">
					<h2><?php echo $homeland_welcome_header; ?></h2>
					<label><?php echo $homeland_welcome_text; ?></label>
					<a href="<?php echo $homeland_welcome_link; ?>" class="view-property">
						<?php 
							if(!empty( $homeland_welcome_button )) : echo $homeland_welcome_button;
							else : esc_attr( _e( 'View Properties', CODEEX_THEME_NAME ) ); 
							endif;
						?>
					</a>
				</div>
			</section>
		<?php
	}

	function homeland_welcome_text_top() {
		$homeland_welcome_button = get_option('homeland_welcome_button');	
		$homeland_welcome_header = stripslashes( get_option('homeland_welcome_header') );
		$homeland_welcome_text = stripslashes( get_option('homeland_welcome_text') );
		$homeland_welcome_link = get_option('homeland_welcome_link');
		?>

			<section class="welcome-block-top">
				<div class="inside">
					<h2><?php echo $homeland_welcome_header; ?></h2>
					<label><?php echo $homeland_welcome_text; ?></label>
					<a href="<?php echo $homeland_welcome_link; ?>" class="view-property">
						<?php 
							if(!empty( $homeland_welcome_button )) : echo $homeland_welcome_button;
							else : esc_attr( _e( 'View Properties', CODEEX_THEME_NAME ) ); 
							endif;
						?>
					</a>
				</div>
			</section>
		<?php
	}


	/*---------------------------------------------
	13. AGENT LIST
	----------------------------------------------*/

	function homeland_agent_list() {
		global $post;

		$homeland_agent_limit = esc_attr( get_option('homeland_agent_limit') ); 
		$homeland_agents_header = get_option('homeland_agents_header');
		$homeland_agent_order = get_option('homeland_agent_order');
		$homeland_agent_orderby = get_option('homeland_agent_orderby');
        
		?>
		<div class="agent-block">
			<h3>
				<span>
					<?php 
						if(!empty( $homeland_agents_header )) : echo $homeland_agents_header;
						else : sanitize_title( _e( 'Agents', CODEEX_THEME_NAME ) ); 
						endif;
					?>
				</span>
			</h3>
			<ul>
				<?php
					$args = array( 
						'role' => 'contributor', 
						'order' => $homeland_agent_order, 
						'orderby' => $homeland_agent_orderby, 
						'number' => $homeland_agent_limit 
					);

				   $homeland_agents = new WP_User_Query( $args );

				   if (!empty( $homeland_agents->results )) :
						foreach ($homeland_agents->results as $homeland_user) :
							global $wpdb;

							$homeland_post_author = $homeland_user->ID;
							$homeland_custom_avatar = get_the_author_meta('homeland_custom_avatar', $homeland_post_author);

							$homeland_count = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = 'homeland_properties' AND post_status = 'publish' AND post_author = %d", $homeland_post_author ) );
							?>
								<li class="clear">
									<a href="<?php echo esc_url( get_author_posts_url( $homeland_post_author ) ); ?>">
										<?php 
			    							if(!empty($homeland_custom_avatar)) : 
			    								echo '<img src="' . $homeland_custom_avatar . '" class="avatar" style="width:70px; height:70px;" />';
				    						else : echo get_avatar( $homeland_post_author, 70 );
				    						endif;
			    						?>
									</a>
									<h4><a href="<?php echo esc_url( get_author_posts_url( $homeland_post_author ) ); ?>">
										<?php echo $homeland_user->display_name; ?></a></h4>
									<label>
										<i class="fa fa-home fa-lg"></i> <?php esc_attr( _e( 'Listed:', CODEEX_THEME_NAME ) ); ?>
										<span><?php echo intval($homeland_count); echo "&nbsp;"; esc_attr( _e( 'Properties', CODEEX_THEME_NAME ) ); ?></span>
									</label>
								</li>	
							<?php
						endforeach;
					else : _e( 'No Agents found!', CODEEX_THEME_NAME );
					endif;
				?>
			</ul>
		</div><?php	
	}


	/*---------------------------------------------
	14. FEATURED LIST
	----------------------------------------------*/

	function homeland_featured_list() {
		global $post;

		$homeland_album_order = esc_attr( get_option('homeland_album_order') );
		$homeland_album_orderby = esc_attr( get_option('homeland_album_orderby') );
		$homeland_featured_property_limit = esc_attr( get_option('homeland_featured_property_limit') );
		$homeland_featured_property_header = get_option('homeland_featured_property_header');
		$homeland_price_format = get_option('homeland_price_format');
		$homeland_currency = get_option('homeland_property_currency');
		?>
			<div class="featured-block">
				<h3>
					<span>
						<?php 
							if(!empty( $homeland_featured_property_header )) : echo $homeland_featured_property_header;
							else : sanitize_title( _e( 'Featured Property', CODEEX_THEME_NAME ) ); 
							endif;
						?>
					</span>
				</h3>
				<?php
					$args = array( 
						'post_type' => 'homeland_properties', 
						'orderby' => $homeland_album_orderby, 
						'order' => $homeland_album_order, 
						'posts_per_page' => $homeland_featured_property_limit, 
						'meta_query' => array( array( 
							'key' => 'homeland_featured', 
							'value' => 'on', 
							'compare' => '==' 
						)) 
					);		

					$wp_query = new WP_Query( $args );

					if ($wp_query->have_posts()) : ?>
						<div class="grid cs-style-3">	
							<ul>
								<?php
									while ($wp_query->have_posts()) : 
										$wp_query->the_post(); 
										$homeland_price_per = get_post_meta( $post->ID, 'homeland_price_per', true );
										$homeland_price = get_post_meta($post->ID, 'homeland_price', true );
										$homeland_area = esc_attr( get_post_meta($post->ID, 'homeland_area', true) );
										$homeland_area_unit = get_post_meta( $post->ID, 'homeland_area_unit', true );
										$homeland_bedroom = esc_attr( get_post_meta($post->ID, 'homeland_bedroom', true) );
										$homeland_bathroom = esc_attr( get_post_meta($post->ID, 'homeland_bathroom', true) );
										$homeland_garage = esc_attr( get_post_meta($post->ID, 'homeland_garage', true) );
										$homeland_property_status = get_the_term_list( $post->ID, 'homeland_property_status', ' ', ', ', '' );

										?>
										<li id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class('featured-list clear') ); ?>>
											<?php
												if ( post_password_required() ) : 
													echo '<div class="password-protect-thumb featured-pass-thumb">';
														echo '<i class="fa fa-lock fa-2x"></i>';
													echo '</div>';
												else : ?>
													<figure class="feat-thumb">
														<a href="<?php the_permalink(); ?>">
															<?php if ( has_post_thumbnail() ) : the_post_thumbnail(); endif; ?>
														</a>
														<figcaption>
															<a href="<?php the_permalink(); ?>"><i class="fa fa-link fa-lg"></i></a>
														</figcaption>
														<?php
															if(!empty( $homeland_property_status )) : 
																echo '<h4>' . $homeland_property_status . '</h4>';
															endif; 
														?>	
													</figure><?php	
												endif;
											?>
											<div class="feat-desc">
												<?php the_title( '<h5><a href="' . get_permalink() . '">', '</a></h5>' ); ?>
												<span>
													<?php 
														if(!empty($homeland_area)) :
															echo $homeland_area . "&nbsp;" . $homeland_area_unit . ", "; 
														endif;
														if(!empty($homeland_bedroom)) :
															echo $homeland_bedroom . "&nbsp;"; _e( 'Bedrooms', CODEEX_THEME_NAME ); echo ", "; 
														endif;
														if(!empty($homeland_bathroom)) :
															echo $homeland_bathroom . "&nbsp;"; _e( 'Bathrooms', CODEEX_THEME_NAME ); echo ", "; 
														endif;
														if(!empty($homeland_garage)) :
															echo $homeland_garage . "&nbsp;"; _e( 'Garage', CODEEX_THEME_NAME ); 
														endif;
													?>
												</span>
												<?php
													if( !empty($homeland_price) ) : 
														echo '<span class="price">';
															echo $homeland_currency; 
															if($homeland_price_format == "Dot") :
																echo number_format ( esc_attr ( $homeland_price ), 0, ".", "." );
															elseif($homeland_price_format == "None") : echo $homeland_price;
															else : echo number_format ( esc_attr ( $homeland_price ) );
															endif;
															if(!empty($homeland_price_per)) : echo "/" . $homeland_price_per; endif; 
														echo '</span>';
													endif;
												?>
											</div>
										</li><?php
									endwhile;
								?>							
							</ul>
						</div><?php
					endif;
				?>
			</div>
		<?php	
	}

	function homeland_featured_list_large() {
		global $post;

		$homeland_property_order = esc_attr( get_option('homeland_property_order') );
		$homeland_property_orderby = esc_attr( get_option('homeland_property_orderby') );
		$homeland_featured_property_limit = esc_attr( get_option('homeland_featured_property_limit') );
		$homeland_featured_property_header = get_option('homeland_featured_property_header');
		$homeland_price_format = get_option('homeland_price_format');
		$homeland_currency = get_option('homeland_property_currency');

		?>
			<div class="featured-block-two-cols">
				<h3>
					<span>
						<?php 
							if(!empty( $homeland_featured_property_header )) : echo $homeland_featured_property_header;
							else : sanitize_title( _e( 'Featured Property', CODEEX_THEME_NAME ) ); 
							endif;
						?>
					</span>
				</h3>
				<?php
					$args = array( 
						'post_type' => 'homeland_properties', 
						'orderby' => $homeland_property_orderby, 
						'order' => $homeland_property_order, 
						'posts_per_page' => $homeland_featured_property_limit, 
						'meta_query' => array( array( 
							'key' => 'homeland_featured', 
							'value' => 'on', 
							'compare' => '==' 
						) ) 
					);		

					$wp_query = new WP_Query( $args );

					if ($wp_query->have_posts()) : ?>
						<div class="grid cs-style-3">	
							<ul>
								<?php
									while ($wp_query->have_posts()) :
										$wp_query->the_post(); 
										$homeland_price_per = get_post_meta( $post->ID, 'homeland_price_per', true );
										$homeland_price = get_post_meta($post->ID, 'homeland_price', true );
										$homeland_area = esc_attr( get_post_meta($post->ID, 'homeland_area', true) );
										$homeland_area_unit = get_post_meta( $post->ID, 'homeland_area_unit', true );
										$homeland_bedroom = esc_attr( get_post_meta($post->ID, 'homeland_bedroom', true) );
										$homeland_bathroom = esc_attr( get_post_meta($post->ID, 'homeland_bathroom', true) );
										$homeland_garage = esc_attr( get_post_meta($post->ID, 'homeland_garage', true) );

										?>
										<li id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class('featured-list clear') ); ?>>
											<?php
												if ( post_password_required() ) : ?>
													<div class="password-protect-thumb featured-pass-thumb">
														<i class="fa fa-lock fa-2x"></i>
													</div><?php
												else : ?>
													<figure class="feat-medium">
														<a href="<?php the_permalink(); ?>">
															<?php 
																if ( has_post_thumbnail() ) :
																	the_post_thumbnail('homeland_property_medium'); 
																endif;
															?>
														</a>
														<figcaption>
															<a href="<?php the_permalink(); ?>"><i class="fa fa-link fa-lg"></i></a>
														</figcaption>
													</figure><?php	
												endif;
											?>
											<div class="feat-desc">
												<?php the_title( '<h5><a href="' . get_permalink() . '">', '</a></h5>' );  ?>
												<span>
													<?php 
														if(!empty($homeland_area)) :
															echo $homeland_area . "&nbsp;" . $homeland_area_unit . ", "; 
														endif;
														if(!empty($homeland_bedroom)) :
															echo $homeland_bedroom . "&nbsp;"; _e( 'Bedrooms', CODEEX_THEME_NAME ); echo ", "; 
														endif;
														if(!empty($homeland_bathroom)) :
															echo $homeland_bathroom . "&nbsp;"; _e( 'Bathrooms', CODEEX_THEME_NAME ); echo ", "; 
														endif;
														if(!empty($homeland_garage)) :
															echo $homeland_garage . "&nbsp;"; _e( 'Garage', CODEEX_THEME_NAME ); 
														endif;
													?>
												</span>
												<?php
													if( !empty($homeland_price) ) : ?>
														<span class="price">
															<?php 
																echo esc_attr( get_option('homeland_property_currency') ); 
																if($homeland_price_format == "Dot") :
																	echo number_format ( esc_attr ( $homeland_price ), 0, ".", "." );
																elseif($homeland_price_format == "None") : echo $homeland_price;
																else : echo number_format ( esc_attr ( $homeland_price ) );
																endif;
																if(!empty($homeland_price_per)) : echo "/" . $homeland_price_per; endif; 
															?>
														</span><?php
													endif;
												?>
											</div>
										</li><?php
									endwhile;
								?>							
							</ul>
						</div><?php
					endif;
				?>
			</div>
		<?php	
	}


	/*---------------------------------------------
	15. TESTIMONIALS
	----------------------------------------------*/

	function homeland_testimonials() {
		global $post;

		$homeland_testi_limit = esc_attr( get_option('homeland_testi_limit') );
		$homeland_testi_header = get_option('homeland_testi_header');
								
		$args = array( 
			'post_type' => 'homeland_testimonial', 
			'posts_per_page' => $homeland_testi_limit 
		);

		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--TESTIMONIALS-->
			<div class="testimonial-block">
				<div class="inside">
					<h3>
						&quot;<?php 
							if(!empty( $homeland_testi_header )) : echo $homeland_testi_header;
							else : sanitize_title( _e( 'Our Customer Says', CODEEX_THEME_NAME ) ); 
							endif;	
						?>&quot;
					</h3>
					<div class="testimonial-flexslider">	
						<ul class="slides">
							<?php
								while ($wp_query->have_posts()) : 
									$wp_query->the_post(); 
									$homeland_position = esc_attr( get_post_meta( $post->ID, 'homeland_position', true ) );

								?>
									<li id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class() ); ?>>
										<?php 
											the_content();
											if ( has_post_thumbnail() ) : the_post_thumbnail('homeland_theme_thumb'); endif;
											the_title( '<h4>', '</h4>' ); 
										?>	
										<h5><?php echo $homeland_position; ?></h5>
									</li><?php							
								endwhile;								
							?>
						</ul>	
					</div>
				</div>
			</div><?php
		endif;
	}


	/*---------------------------------------------
	16. SHARE ICONS
	----------------------------------------------*/

	function homeland_social_share() {
		?>
			<!--SHARE-->
			<div class="share clear">
				<span><?php esc_attr( _e( 'Share', CODEEX_THEME_NAME ) ); ?><i class="fa fa-share fa-lg"></i></span>
				<ul class="clear">	
					<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" target="_blank" title="Facebook"><i class="fa fa-facebook fa-lg"></i></a></li>
					<li><a href="http://twitter.com/share?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" target="_blank" title="Twitter"><i class="fa fa-twitter fa-lg"></i></a></li>
					<li><a href="https://plus.google.com/share?url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" target="_blank" title="Google+"><i class="fa fa-google-plus fa-lg"></i></a></li>
					<li><a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());" target="_blank" title="Pinterest"><i class="fa fa-pinterest fa-lg"></i></a></li>
					<li><a href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink();?>&amp;title=<?php the_title(); ?>" target="_blank" title="LinkedIn"><i class="fa fa-linkedin fa-lg"></i></a></li>
				</ul>
			</div>
		<?php
	}


	/*---------------------------------------------
	17. HEADER SOCIAL ICONS
	----------------------------------------------*/

	function homeland_social_share_header() {	
		$homeland_twitter = esc_attr( get_option('homeland_twitter') );
		$homeland_facebook = esc_attr( get_option('homeland_facebook') );
		$homeland_youtube = esc_attr( get_option('homeland_youtube') );
		$homeland_pinterest = esc_attr( get_option('homeland_pinterest') );
		$homeland_linkedin = esc_attr( get_option('homeland_linkedin') );
		$homeland_dribbble = esc_attr( get_option('homeland_dribbble') );
		$homeland_rss = esc_attr( get_option('homeland_rss') );
		$homeland_instagram = esc_attr( get_option('homeland_instagram') );
		$homeland_gplus = esc_attr( get_option('homeland_gplus') );
		$homeland_brand_color = get_option('homeland_brand_color');
		?>
			<!--SOCIAL-->
			<div class="<?php if(!empty($homeland_brand_color)) : echo 'social-colors'; endif; ?> social">
				<ul class="clear">
					<?php 
						if(!empty( $homeland_twitter )) : ?>	
							<li class="twitter"><a href="http://twitter.com/<?php echo $homeland_twitter; ?>" target="_blank"><i class="fa fa-twitter"></i></a></li><?php 
						endif; 
						if(!empty( $homeland_facebook )) : ?>	
							<li class="facebook"><a href="http://facebook.com/<?php echo $homeland_facebook; ?>" target="_blank"><i class="fa fa-facebook"></i></a></li><?php 
						endif; 
						if(!empty( $homeland_youtube )) : ?>	
							<li class="youtube"><a href="<?php echo $homeland_youtube; ?>" target="_blank"><i class="fa fa-youtube"></i></a></li><?php 
						endif; 
						if(!empty( $homeland_linkedin )) : ?>	
							<li class="linkedin"><a href="<?php echo $homeland_linkedin; ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li><?php 
						endif; 
						if(!empty( $homeland_pinterest )) : ?>	
							<li class="pinterest"><a href="http://pinterest.com/<?php echo $homeland_pinterest; ?>" target="_blank"><i class="fa fa-pinterest"></i></a></li><?php 
						endif; 
						if(!empty( $homeland_dribbble )) : ?>	
							<li class="dribbble"><a href="http://dribbble.com/<?php echo $homeland_dribbble; ?>" target="_blank"><i class="fa fa-dribbble"></i></a></li><?php 
						endif; 
						if(!empty( $homeland_gplus )) : ?>	
							<li class="gplus"><a href="<?php echo $homeland_gplus; ?>" target="_blank"><i class="fa fa-google-plus"></i></a></li><?php 
						endif;
						if(!empty( $homeland_instagram )) : ?>	
							<li class="instagram"><a href="http://instagram.com/<?php echo $homeland_instagram; ?>" target="_blank"><i class="fa fa-instagram"></i></a></li><?php 
						endif; 
						if(!empty( $homeland_rss )) : ?>	
							<li class="rss"><a href="<?php echo $homeland_rss; ?>" target="_blank"><i class="fa fa-rss"></i></a></li><?php 
						endif;  
					?>	
				</ul>
			</div>
		<?php
	}


	/*---------------------------------------------
	18. HEADER CALL INFORMATION
	----------------------------------------------*/

	function homeland_call_info_header() {
		$homeland_call_us_label = get_option('homeland_call_us_label');
		$homeland_login_label = get_option('homeland_login_label');
		$homeland_hide_login = get_option('homeland_hide_login');
		$homeland_login_link = get_option('homeland_login_link');
		$homeland_register_label = get_option('homeland_register_label');
		$homeland_hide_register = get_option('homeland_hide_register');
		$homeland_register_link = get_option('homeland_register_link');
		$homeland_search_label = get_option('homeland_search_label');
		$homeland_phone_number = esc_attr( get_option('homeland_phone_number') ); 

		?>
			<!--CALL INFO.-->
			<div class="call-info clear">
				<span class="call-us"><i class="fa fa-phone"></i>
					<?php 
						if(!empty( $homeland_call_us_label )) : echo $homeland_call_us_label . ": ";
						else : esc_attr( _e( 'Call us', CODEEX_THEME_NAME ) ); echo ": ";
						endif;
						echo $homeland_phone_number;
					?>
				</span>
				<?php
					if(empty( $homeland_hide_login )) : 
						echo '<a href="' . $homeland_login_link . '" class="login"><i class="fa fa-user"></i>';
							if(!empty( $homeland_login_label )) : echo $homeland_login_label;
							else : esc_attr( _e( 'Login', CODEEX_THEME_NAME ) ); 
							endif;
						echo '</a>';
					endif;

					if(empty( $homeland_hide_register )) : 
						echo '<a href="' . $homeland_register_link . '" class="register login"><i class="fa fa-pencil"></i>';
							if(!empty( $homeland_register_label )) : echo $homeland_register_label;
							else : esc_attr( _e( 'Register', CODEEX_THEME_NAME ) ); 
							endif;
						echo '</a>';
					endif;
				?>
			</div>
			<div id="sb-search" class="sb-search search-icon">
				<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" id="searchform">
					<input class="sb-search-input" placeholder="<?php if(!empty( $homeland_search_label )) : echo $homeland_search_label; else : esc_attr( _e( 'Enter Keyword and hit enter...', CODEEX_THEME_NAME ) ); endif; ?>" type="text" value="" id="s" name="s">
					<input class="sb-search-submit" type="submit" value="">
					<span class="sb-icon-search"></span>
				</form>
			</div>	
		<?php
	}


	/*---------------------------------------------
	19. PARTNERS LIST
	----------------------------------------------*/

	function homeland_partners_list() {
		global $post;

		$homeland_partners_limit = esc_attr( get_option('homeland_partners_limit') );
		$homeland_partners_header = get_option('homeland_partners_header');
		$homeland_partner_order = get_option('homeland_partner_order');
		$homeland_partner_orderby = get_option('homeland_partner_orderby');
								
		$args = array( 
			'post_type' => 'homeland_partners', 
			'order' => $homeland_partner_order,
			'orderby' => $homeland_partner_orderby,
			'posts_per_page' => $homeland_partners_limit 
		);

		$wp_query = new WP_Query( $args );	

		if ($wp_query->have_posts()) : ?>
			<!--PARTNERS-->
			<div class="partners-block">
				<div class="inside">
					<h3>
						<?php 
							if(!empty( $homeland_partners_header )) : echo $homeland_partners_header;
							else : sanitize_title( _e( 'Our Trusted Partners', CODEEX_THEME_NAME ) ); 
							endif;	
						?>
					</h3>
					<div class="partners-flexslider clear">	
						<ul class="slides">
							<?php
								while ($wp_query->have_posts()) : 
									$wp_query->the_post(); 
									$homeland_url = esc_attr( get_post_meta( $post->ID, 'homeland_url', true ) );

									?>
									<li id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class() ); ?>>
										<a href="<?php echo $homeland_url; ?>" target="_blank">
											<?php if ( has_post_thumbnail() ) : the_post_thumbnail('full'); endif; ?>	
										</a>
									</li><?php							
								endwhile;								
							?>
						</ul>	
					</div>
				</div>
			</div><?php
		endif;
	}
?>