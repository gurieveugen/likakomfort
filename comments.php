<?php

_deprecated_file( sprintf( __( 'Theme without %1$s' ), basename(__FILE__) ), '3.0', null, sprintf( __('Please include a %1$s template in your theme.'), basename(__FILE__) ) );

// Do not delete these lines
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.'); ?></p>
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() && comments_open() ) : ?>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<header>
		<b>Коментарі:</b>							
	</header>

	<ul class="comment-list">
	<?php 
	// wp_list_comments();
	$comments = get_comments(array(
		'post_id' => get_the_ID(),
		'status'  => 'approve',
		'order'   => 'ASC'
	));
	foreach ($comments as $key => $value) 
	{
		echo '<li>';
		echo '<b>'.$value->comment_author.'</b>';
		echo '<small>'.get_sng_date($value->comment_date).'</small>';
		echo '<span>'.$value->comment_content.'</span>';
		echo '</li>';
	}
	?>
	</ul>

	<div class="navigation">
		<div class="alignleft"><?php previous_comments_link() ?></div>
		<div class="alignright"><?php next_comments_link() ?></div>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		

	<?php endif; ?>
<?php endif; ?>

<?php if ( comments_open() ) : ?>

<div id="respond">

<div id="cancel-comment-reply">
	<small><?php cancel_comment_reply_link() ?></small>
</div>

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url( get_permalink() )); ?></p>
<?php else : ?>
<footer>
	<form action="<?php echo site_url(); ?>/wp-comments-post.php" method="post" id="commentform">

		<?php if ( is_user_logged_in() ) : ?>

		<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_edit_user_link(), $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php esc_attr_e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a></p>

		<?php else : ?>

		<p><input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
		<label for="author"><small><?php _e('Name'); ?> <?php if ($req) _e('(required)'); ?></small></label></p>

		<p><input type="text" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
		<label for="email"><small><?php _e('Mail (will not be published)'); ?> <?php if ($req) _e('(required)'); ?></small></label></p>

		<p><input type="text" name="url" id="url" value="<?php echo  esc_attr($comment_author_url); ?>" size="22" tabindex="3" />
		<label for="url"><small><?php _e('Website'); ?></small></label></p>

		<?php endif; ?>

		<!--<p><small><?php printf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>'), allowed_tags()); ?></small></p>-->

		<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>

		<p>
		<!-- <input name="submit" type="submit" id="submit" tabindex="5" value="Надіслати" /> -->
		<button type="submit">Надіслати</button>
		<?php comment_id_fields(); ?>
		</p>
		<?php do_action('comment_form', $post->ID); ?>

	</form>
</footer>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>