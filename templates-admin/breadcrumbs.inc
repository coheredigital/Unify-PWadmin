<ul id="breadcrumbs">
	<?php foreach($this->fuel('breadcrumbs') as $breadcrumb) {
		$class = strpos($page->path, $breadcrumb->path) === 0 ? " class='active'" : '';
		$title = htmlspecialchars(strip_tags($breadcrumb->title));
		echo "<li $class><a href='{$breadcrumb->url}'>{$title}</a></li>";
	}?>
</ul>