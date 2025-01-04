<?php
/** 
 * @package    HaruTheme/Haru TeeSpace
 * @version    1.0.0
 * @author     Administrator <admin@harutheme.com>
 * @copyright  Copyright 2022, HaruTheme
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       http://harutheme.com
*/

$target = $settings['link']['is_external'] ? ' target="_blank"' : '';
$nofollow = $settings['link']['nofollow'] ? ' rel="nofollow"' : '';
?>

<?php if ( 'style-0' == $settings['pre_style'] ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( 'style-1' == $settings['pre_style'] ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
	<div class="haru-banner__content">
		<div class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?></div>
		<h6 class="haru-banner__title">
			<?php if ( $settings['link']['url'] ) : ?>
				<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
			<?php endif; ?>
				<?php echo $settings['title']; ?>
			<?php if ( $settings['link']['url'] ) : ?>
				</a>
			<?php endif; ?>
		</h6>
		<div class="haru-banner__description"><?php echo $settings['description']; ?></div>
	</div>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-2', 'style-12' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
			<div class="haru-banner__content">
				<h6 class="haru-banner__title">
					<?php echo $settings['title']; ?>
				</h6>
				<div class="haru-banner__description"><?php echo $settings['description']; ?></div>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-11', 'style-24' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>

			<div class="haru-banner__content">
				<?php if ( 'style-11' == $settings['pre_style'] ) : ?>
					<?php if ( $settings['sub_title'] ) : ?>
					<div class="haru-banner__sub-title font__secondary"><?php echo $settings['sub_title']; ?>
			        </div>
			    	<?php endif; ?>
		    	<?php endif; ?>

				<h6 class="haru-banner__title"><?php echo $settings['title']; ?></h6>

				<?php if ( 'style-24' == $settings['pre_style'] ) : ?>
					<?php if ( $settings['sub_title'] ) : ?>
					<div class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?>
			        </div>
			    	<?php endif; ?>
		    	<?php endif; ?>

				<?php if ( $settings['link']['url'] ) : ?>
					<?php if ( 'style-11' == $settings['pre_style'] ) : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-white haru-button--shadow-white haru-button--round-normal haru-button--size-large"><?php echo $settings['button_text']; ?></div>
					<?php elseif ( 'style-24' == $settings['pre_style'] ) : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-white haru-button--shadow-white haru-button--round-normal haru-button--size-large"><?php echo $settings['button_text']; ?></div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-3', 'style-6' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>

			<div class="haru-banner__content">
				<h6 class="haru-banner__title"><?php echo $settings['title']; ?></h6>

				<?php if ( $settings['description'] ) : ?>
				<div class="haru-banner__description"><?php echo $settings['description']; ?>
		        </div>
		    	<?php endif; ?>

				<?php if ( $settings['link']['url'] ) : ?>
					<?php if ( $settings['pre_style'] == 'style-3' ) : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-primary haru-button--shadow-no haru-button--round-normal haru-button--size-medium haru-button--has-icon"><?php echo $settings['button_text']; ?></div>
					<?php else : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-primary haru-button--shadow-no haru-button--round-normal haru-button--size-large"><?php echo $settings['button_text']; ?></div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( 'style-4' == $settings['pre_style'] ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" class="haru-banner__image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
			<div class="haru-banner__content">
				<div class="haru-banner__title"><?php echo $settings['title']; ?><span class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?></span></div>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-5', 'style-16', 'style-19' ) ) ) : ?>
	<div class="haru-banner__image">
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
	</div>

	<div class="haru-banner__content">
		<h6 class="haru-banner__title">
			<?php if ( $settings['link']['url'] ) : ?>
				<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
			<?php endif; ?>
			<?php echo $settings['title']; ?>
			<?php if ( $settings['link']['url'] ) : ?>
				</a>
			<?php endif; ?>
		</h6>

		<?php if ( 'style-5' == $settings['pre_style'] ) : ?>
		<?php if ( $settings['description'] ) : ?>
		<div class="haru-banner__description"><?php echo $settings['description']; ?>
        </div>
    	<?php endif; ?>
    	<?php endif; ?>

		<?php if ( $settings['link']['url'] ) : ?>
		<a class="haru-banner__btn haru-button haru-button--text-primary" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>><?php echo $settings['button_text']; ?>
		</a>
	<?php endif; ?>
	</div>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-7' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>

			<div class="haru-banner__content">
				<h6 class="haru-banner__title"><?php echo $settings['title']; ?></h6>

				<?php if ( $settings['description'] ) : ?>
				<div class="haru-banner__description"><?php echo $settings['description']; ?>
		        </div>
		    	<?php endif; ?>

			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-8', 'style-9', 'style-10', 'style-17', 'style-18', 'style-23' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>

			<div class="haru-banner__content">
				<?php if ( in_array( $settings['pre_style'], array( 'style-9', 'style-10', 'style-23' ) ) ) : ?>
				<div class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?></div>
				<?php endif; ?>

				<h6 class="haru-banner__title"><?php echo $settings['title']; ?></h6>

				<?php if ( $settings['description'] ) : ?>
					<?php if ( !in_array( $settings['pre_style'], array( 'style-23' ) ) ) : ?>
					<div class="haru-banner__description"><?php echo $settings['description']; ?>
			        </div>
			        <?php endif; ?>
		    	<?php endif; ?>

				<?php if ( $settings['link']['url'] ) : ?>
					<?php if ( 'style-8' == $settings['pre_style'] ) : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-primary haru-button--round-normal haru-button--size-large"><?php echo $settings['button_text']; ?>
					<?php elseif ( 'style-9' == $settings['pre_style'] ) : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-primary haru-button--shadow-black haru-button--round-normal haru-button--size-medium"><?php echo $settings['button_text']; ?>
					<?php elseif ( 'style-17' == $settings['pre_style'] ) : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-white haru-button--round-normal haru-button--size-medium"><?php echo $settings['button_text']; ?>
					<?php elseif ( 'style-18' == $settings['pre_style'] ) : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-gray haru-button--round-normal haru-button--size-large"><?php echo $settings['button_text']; ?>
					<?php elseif ( 'style-23' == $settings['pre_style'] ) : ?>
						<div class="haru-banner__btn haru-button haru-button--text-black haru-button--size-normal"><?php echo $settings['button_text']; ?>
					<?php else : ?>
						<div class="haru-banner__btn haru-button haru-button--bg-white haru-button--shadow-white haru-button--round-normal haru-button--size-medium"><?php echo $settings['button_text']; ?>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-13' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
			<div class="haru-banner__content">
				<h6 class="haru-banner__title"><?php echo $settings['title']; ?>
					<?php if ( $settings['sub_title'] ) : ?>
						<span class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?></span>
					<?php endif; ?>
				</h6>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-14', 'style-15' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
			<div class="haru-banner__content">
				<h6 class="haru-banner__title"><?php echo $settings['title']; ?></h6>
				<?php if ( $settings['sub_title'] ) : ?>
					<span class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?></span>
				<?php endif; ?>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-20', 'style-21', 'style-22', 'style-28' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
			<div class="haru-banner__content">
				<h6 class="haru-banner__title"><?php echo $settings['title']; ?></h6>
				<?php if ( $settings['sub_title'] ) : ?>
					<h6 class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?></h6>
				<?php endif; ?>	
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-25' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>
			<div class="haru-banner__content">
				<div class="haru-banner__btn haru-button haru-button--bg-primary haru-button--shadow-black haru-button--round-normal haru-button--size-large"><?php echo $settings['button_text']; ?></div>
			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-26' ) ) ) : ?>
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<div class="haru-banner__image">
				<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			</div>

			<div class="haru-banner__content">
				<h6 class="haru-banner__title"><?php echo $settings['title']; ?></h6>

				<?php if ( $settings['sub_title'] ) : ?>
				<div class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?>
		        </div>
		    	<?php endif; ?>

			</div>
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
<?php endif; ?>

<?php if ( in_array( $settings['pre_style'], array( 'style-27' ) ) ) : ?>
	<div class="haru-banner__image">
	<?php if ( $settings['link']['url'] ) : ?>
		<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
	<?php endif; ?>
			<img src="<?php echo esc_url( $settings['image']['url'] ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
	<?php if ( $settings['link']['url'] ) : ?>
		</a>
	<?php endif; ?>
	</div>

	<div class="haru-banner__content">
		<?php if ( $settings['sub_title'] ) : ?>
		<h6 class="haru-banner__sub-title"><?php echo $settings['sub_title']; ?></h6>
		<?php endif; ?>
		<h6 class="haru-banner__title">
			<?php if ( $settings['link']['url'] ) : ?>
				<a class="" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>>
			<?php endif; ?>
			<?php echo $settings['title']; ?>
			<?php if ( $settings['link']['url'] ) : ?>
				</a>
			<?php endif; ?>
		</h6>

		<?php if ( $settings['description'] ) : ?>
		<div class="haru-banner__description"><?php echo $settings['description']; ?>
        </div>
    	<?php endif; ?>

		<?php if ( $settings['link']['url'] ) : ?>
		<a class="haru-banner__btn haru-button haru-button--size-normal haru-button--round-normal haru-button--bg-primary" href="<?php echo esc_url( $settings['link']['url'] ); ?>" <?php echo $target . $nofollow; ?>><?php echo $settings['button_text']; ?>
		</a>
	<?php endif; ?>
	</div>
<?php endif; ?>