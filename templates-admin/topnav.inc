<ul id="nav">
<?php
foreach($pages->get($wire->config->adminRootPageID)->children("check_access=0") as $p) {

	if(!$p->viewable()) continue;

	$show = $user->isSuperuser() ? true : false;
	$info = array();
	$subnav = '';

	if(!$show) {
		$checkPages = $p->numChildren ? $p->children("check_access=0") : array($p);
		foreach($checkPages as $child) {
			if($child->viewable()) {
				$show = true;
				break;
			}
		}
	}

	if($show) {
		$class = strpos($page->path, $p->path) === 0 ? " class='active'" : "";

		echo "<li><a href='{$p->url}' $class>".strip_tags($p->get('title|name'));

		if(count($p->children()) > 0 && $p->id != 3){
			$parentClass = '';
			foreach($p->children as $child){
				if($child->viewable()) {

					$class = strpos($page->path, $child->path) === 0 ? " class='active'" : '';

					if (strpos($page->path, $child->path) === 0 ) {
						$parentClass = "open";
					}

					$child_title = strip_tags((string)$child->get('title|name'));
					$child_title = __($child_title, dirname(__FILE__) . '/default.php');
					$subnav .= "<li><a href='{$child->url}' $class>$child_title</a></li>";
				}
			}
			$subnav = "<ul class='subpages $parentClass'>".$subnav."</ul>";
		}

		echo "</a>".$subnav."</li>";
	}
}
?>	
	<li class="fright"><a href='<?php echo $config->urls->admin; ?>login/logout/'>Logout</a></li>
	<li class="fright">
		<strong>You are logged in as <?php echo $user->name; ?></strong>:
		<?php if ($user->hasPermission('profile-edit')): ?>
			<a class='action' href='<?php echo $config->urls->admin; ?>profile/'><?php echo __('profile', __FILE__); ?></a>
		<?php endif ?>
	</li>
</ul>

