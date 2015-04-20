<?php global $textdomain; ?>
<!-- search -->
<form class="search" method="get" action="<?php echo home_url(); ?>" role="search">
	<input class="search-input" type="search" name="s" placeholder="<?php _e('To search, type and hit enter.', $textdomain); ?>">
	<button class="search-submit" type="submit" role="button"><?php _e('Search', $textdomain); ?></button>
</form>
<!-- /search -->
