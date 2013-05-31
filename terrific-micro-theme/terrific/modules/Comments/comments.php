<?php
global $post;

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { 
?>
	<p>This post is password protected. Enter the password to view comments.</p>
<?php
	return;
}
?>

<?php if (have_comments()) : ?>
	<h3 class="responses"><?php comments_number('No responses', 'One response', '% responses' );?> to &quot;<?php the_title(); ?>&quot;:</h3>
	
	<div>
		<div><?php paginate_comments_links(); ?></div>
	</div>
	
	<ol>
		<?php wp_list_comments(); ?>
	</ol>
	
	<div>
		<div><?php paginate_comments_links(); ?></div>
	</div>
<?php else : // no comments ?>
	<?php if ('open' == $post->comment_status) : ?>
		
		<!-- If comments are open, but there are no comments. -->
	<?php else : // comments are closed ?>
		<p>Comments are closed.</p>
	<?php endif; ?>
<?php endif; ?>

<?php if ('open' == $post->comment_status) : ?>
	<div class="respond">
		<h3 class="replytitle"><?php comment_form_title( 'Reply', 'Reply to %s' ); ?></h3>
		<div class="cancelreply">
			<?php cancel_comment_reply_link(); ?>
		</div>
		<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
			<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
		<?php else : ?>
			<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
		
				<?php if ( $user_ID ) : ?>
					<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account">Log out &raquo;</a></p>
				<?php else : ?>
		
					<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
					<label for="author">Name <?php if ($req) echo "(required)"; ?></label></p>
			
					<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
					<label for="email">Mail (will not be published) <?php if ($req) echo "(required)"; ?></label></p>
				
					<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
					<label for="url">Website</label></p>
					
				<?php endif; ?>
				
				<p><textarea name="comment" id="comment" rows="3" tabindex="4"></textarea></p>
				
				<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
					<?php comment_id_fields(); ?>
				</p>
				<?php do_action('comment_form', $post->ID); ?>
				
			</form>
		
		<?php endif; ?>
	</div>
<?php endif; ?>