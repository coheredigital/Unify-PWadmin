<?php
$searchForm = $user->hasPermission('page-edit') ? $modules->get('ProcessPageSearch')->renderSearchForm() : '';
$bodyClass = $input->get->modal ? 'modal' : '';
if(!isset($content)) $content = '';
$config->styles->prepend($config->urls->adminTemplates . "styles/jqueryui/jqui.css");
$config->styles->prepend($config->urls->adminTemplates . "styles/style.css");
$config->scripts->append($config->urls->adminTemplates . "scripts/main.js");
$config->scripts->append($config->urls->adminTemplates . "scripts/jquery.collagePlus.min.js");
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


<body id="branded" class="login">
	
	<div class="login-box">
		<div id="logo">
        	<img src="<?php echo $config->urls->adminTemplates ?>styles/images/pw-logo.png">
        </div>
        <div class="login-form">
        	<?php echo $content?>
        </div>
	    <?php if(count($notices)) include("notices.inc"); ?>
	    <div id="skyline"></div>
	</div>
	<script>
	$(document).ready(function() {
		$(".Inputfields > .Inputfield > .ui-widget-header").unbind('click');
	});
	</script>
</body>


<?php else: ?>


<body id="branded" <?php if($bodyClass) echo " class='$bodyClass'"; ?> >
	<div class="nav-wrap">
		<div class="container">
			<?php echo $searchForm; ?>
			<img width="170" class="fleft logo" src="<?php echo $config->urls->adminTemplates ?>styles/images/logo.png">
			<?php include("topnav.inc"); ?>
		</div>

	</div>
	<div id="header">
		<div class="container">
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
			<li class="fright"><a href='<?php echo $config->urls->admin; ?>login/logout/'>Logout</a></li>
			<li class="fright">

				<?php if ($user->hasPermission('profile-edit')): ?>
					<a class='action' href='<?php echo $config->urls->admin; ?>profile/'><?php echo $user->name; ?></a>
				<?php endif ?>

			</li>

			</ul>
		</div>
	</div>
	<div id="main">
		<div class="container">
			<?php if(count($notices)) include("notices.inc"); ?>
		    <div id="content" class="fouc_fix">
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


		</div>
		<div class="container">
			<p class="copy fright"><a href="http://processwire.com/">ProcessWire</a> <?php echo $config->version; ?> - Copyright &copy; <?php echo date("Y"); ?> by Ryan Cramer</p>
		</div>
	</div>


</body>
<?php endif; ?>
</html>