<?php $gravatar = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=mm&s=50"; ?>
<?php if ($gravatar): ?>
	<?php if ($user->hasPermission('profile-edit')) echo "<a class='user-name' href='{$config->urls->admin}profile/'>" ?>
	<img class="gravatar" src="<?php echo $gravatar; ?>" alt="">
	<?php if ($user->hasPermission('profile-edit')) echo "</a>" ?>
<?php endif ?>