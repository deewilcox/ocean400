<?php 
	global $homeland_class; 

	$homeland_property_status = get_the_term_list ( $post->ID, 'homeland_property_status', ' ', ', ', '' );
	$homeland_price_per = get_post_meta( $post->ID, 'homeland_price_per', true );
	$homeland_price = get_post_meta($post->ID, 'homeland_price', true);
	$homeland_price_format = get_option('homeland_price_format');
	$homeland_area = esc_attr( get_post_meta($post->ID, 'homeland_area', true) );
	$homeland_area_unit = get_post_meta( $post->ID, 'homeland_area_unit', true );
	$homeland_bedroom = esc_attr( get_post_meta($post->ID, 'homeland_bedroom', true) );
	$homeland_bathroom = esc_attr( get_post_meta($post->ID, 'homeland_bathroom', true) );
	$homeland_property_excerpt = get_option('homeland_property_excerpt');
	$homeland_currency = esc_attr( get_option('homeland_property_currency') ); 
	$mlsLink = get_post_meta( $post->ID, 'mls_link', true );
?>

<li id="post-<?php the_ID(); ?>" <?php sanitize_html_class( post_class($homeland_class) ); ?>>
	<div class="property-mask">
		<?php 
			if ( post_password_required() ) :
				?><div class="password-protect-thumb"><i class="fa fa-lock fa-2x"></i></div><?php
			else :
				?>
					<figure class="pimage">
						<a href="<?php echo $mlsLink; ?>">
							<?php if ( has_post_thumbnail() ) { the_post_thumbnail('homeland_property_medium'); } ?>
						</a>
						<figcaption><a href="<?php echo $mlsLink; ?>"><i class="fa fa-link fa-lg"></i></a></figcaption>
						<?php
							if(!empty( $homeland_property_status )) : ?><h4><?php echo $homeland_property_status; ?></h4><?php
							endif; 
						?>
						<div class="property-price clear">
							<div class="cat-price">
								<span class="pcategory">
									<?php echo get_the_term_list( $post->ID, 'homeland_property_type', ' ', ', ', '' ); ?>
								</span>
								<?php
									if( !empty($homeland_price) ) : ?>
										<span class="price">
											<?php 
												echo $homeland_currency;
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
							<span class="picon"><i class="fa fa-tag"></i></span>
						</div>
					</figure>
				<?php
			endif;
		?>			
	</div>
	<div class="property-info">
		<?php
			if(!empty($homeland_area)) :
				?><span><i class="fa fa-home"></i><?php echo $homeland_area; echo "&nbsp;" . $homeland_area_unit; ?></span><?php
			endif;
			if(!empty($homeland_bedroom)) : ?>
				<span>
					<i class="fa fa-inbox"></i>
					<?php echo $homeland_bedroom; ?>
					<?php echo esc_attr( _e( 'Bedrooms', CODEEX_THEME_NAME ) ); ?>
				</span><?php
			endif;
			if(!empty($homeland_bathroom)) : ?>
				<span>
					<i class="fa fa-male"></i>
					<?php echo $homeland_bathroom; ?> 
					<?php esc_attr( _e( 'Bathrooms', CODEEX_THEME_NAME ) ); ?>
				</span><?php
			endif;
		?>
	</div>
	<div class="property-desc">
		<?php 
			the_title( '<h4><a href="' . $mlsLink . '">', '</a></h4>' ); 
			if(empty($homeland_property_excerpt)) : the_excerpt(); endif;
		?>	
	</div>
</li>