<?php
$searchForm = $user->hasPermission('page-edit') ? $modules->get('ProcessPageSearch')->renderSearchForm() : '';
$bodyClass = $input->get->modal ? 'modal' : '';
if(!isset($content)) $content = '';
$config->styles->prepend($config->urls->adminTemplates . "styles/jqueryui/jqui.css");
$config->styles->prepend($config->urls->adminTemplates . "styles/style.css");
$config->scripts->append($config->urls->adminTemplates . "scripts/main.js");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<title><?php echo strip_tags($page->get("browser_title|headline|title|name")); ?> &rsaquo; ProcessWire</title>
	<script type="text/javascript">
	<?php
	$jsConfig = $config->js();
	$jsConfig['debug'] = $config->debug;
	$jsConfig['urls'] = array(
		'root' => $config->urls->root,
		'admin' => $config->urls->admin,
		'modules' => $config->urls->modules,
		'core' => $config->urls->core,
		'files' => $config->urls->files,
		'templates' => $config->urls->templates,
		'adminTemplates' => $config->urls->adminTemplates,
		);
	?>
	var config = <?php echo json_encode($jsConfig); ?>;
	</script>
	<?php foreach($config->styles->unique() as $file) echo "\n\t<link type='text/css' href='$file' rel='stylesheet' />"; ?>
	<!--[if lt IE 9 ]>
	<link rel="stylesheet" type="text/css" href="<? echo $config->urls->adminTemplates ?>styles/ie.css" />
	<![endif]-->	
	<?php foreach($config->scripts->unique() as $file) echo "\n\t<script type='text/javascript' src='$file'></script>"; ?>
</head>

<?php if($user->isGuest()):?>


<body id="metro_pw" class="login">
	<?php if(count($notices)) include("notices.inc"); ?>
	<div id="login">

		<div id="logo">
        	<img src="<?php echo $config->urls->adminTemplates ?>styles/images/logo.png">
        </div>
	    <?php echo $content?>
	</div>
	<script>
	$(document).ready(function() {
		$(".Inputfields > .Inputfield > .ui-widget-header").unbind('click');
	});
	</script>
</body>


<?php else: ?>


<body id="metro_pw"<?php if($bodyClass) echo " class='$bodyClass'"; ?> >
	<div id="header">
		<div class="container">
			<?php include("topnav.inc"); ?>
			<?php echo $searchForm; ?>
			<h1><?php echo strip_tags($this->fuel->processHeadline ? $this->fuel->processHeadline : $page->get("title|name")); ?></h1>
	    	<?php if(trim($page->summary)) echo "<h2>{$page->summary}</h2>"; ?>
		</div>
	</div>
	<div id="bread">
		<div class="container">
			<ul id="breadcrumbs">
			<?php
				foreach($this->fuel('breadcrumbs') as $breadcrumb) {
					$class = strpos($page->path, $breadcrumb->path) === 0 ? " class='active'" : '';
					$title = htmlspecialchars(strip_tags($breadcrumb->title));
					echo "<li $class><a href='{$breadcrumb->url}'>{$title}</a></li>";
				}
			?>
			<li class="fright"><a target="_blank" id="view-site" href="<?php echo $config->urls->root; ?>">View Site</a></li>
			</ul>
		</div>
	</div>
	<div id="main">
		<div class="container">
			<?php if(count($notices)) include("notices.inc"); ?>
		    <div id="content">
				<div class="container">
					<?php if($page->body) echo $page->body; ?>
					<?php echo $content?>
					<?php if($config->debug && $this->user->isSuperuser()) include($config->paths->adminTemplates . "debug.inc"); ?>
				</div>
			</div>
		</div>
	</div>
	<div id="footer">
		<div class="container">
			<?php include('updates.inc') ?>
		</div>
		<div class="container">
			<p class="copy fright"><a href="http://processwire.com/">ProcessWire</a> <?php echo $config->version; ?> - Copyright &copy; <?php echo date("Y"); ?> by Ryan Cramer</p>
			<img class="fleft" src="<?php echo $config->urls->adminTemplates ?>styles/images/logo.png">
		</div>
	</div>


</body>
<?php endif; ?>
</html>