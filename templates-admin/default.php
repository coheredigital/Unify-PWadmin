<?php

/**
 * ProcessWire 2.x Admin Markup Template
 *
 * Copyright 2012 by Ryan Cramer
 *
 *
 */
$config->versionInt = str_replace(".", "", $config->version);

$searchForm = $user->hasPermission('page-edit') ? $modules->get('ProcessPageSearch')->renderSearchForm() : '';
$bodyClass = $input->get->modal ? 'modal' : '';
if(!isset($content)) $content = '';
$config->styles->prepend($config->urls->adminTemplates . "styles/jqueryui/jqui.css");
$config->styles->prepend($config->urls->adminTemplates . "styles/style.css");
$config->scripts->append($config->urls->adminTemplates . "scripts/main.js");
$config->scripts->append($config->urls->adminTemplates . "scripts/jquery.collagePlus.min.js");
$config->scripts->append($config->urls->root . "wire/templates-admin/scripts/inputfields.js");

if ($config->versionInt > 230){
	$config->styles->append($config->urls->root . "wire/templates-admin/styles/font-awesome/css/font-awesome.min.css");
}
	
$browserTitle = wire('processBrowserTitle'); 
if(!$browserTitle) $browserTitle = __(strip_tags($page->get('title|name')), __FILE__) . ' &bull; ProcessWire';

/*
 * Dynamic phrases that we want to be automatically translated
 *
 * These are in a comment so that they register with the parser, in place of the dynamic __() function calls with page titles. 
 * 
 * __("Pages"); 
 * __("Setup"); 
 * __("Modules"); 
 * __("Access"); 
 * __("Admin"); 
 * 
 */

?>
<!DOCTYPE html>
<html lang="<?php echo __('en', __FILE__); // HTML tag lang attribute
	/* this intentionally on a separate line */ ?>"> 
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex, nofollow" />
	<title><?php echo $browserTitle; ?></title>
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


<body id="Unify" class="login">
	
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


<body id="Unify" <?php if($bodyClass) echo " class='$bodyClass'"; ?> >
	<div id="wrapper">
		<div class="nav-wrap">
			<div class="container">
				<?php echo $searchForm; ?>
				<img width="170" class="fleft logo" src="<?php echo $config->urls->adminTemplates ?>styles/images/logo.png">
				<?php include("topnav.inc"); ?>
			</div>

		</div>
		<div id="header">
			<div class="container">
				<h1 id='title'><?php echo __(strip_tags($this->fuel->processHeadline ? $this->fuel->processHeadline : $page->get("title|name")), __FILE__); ?></h1>
		    	<?php if(trim($page->summary)) echo "<h2>{$page->summary}</h2>"; ?>
			</div>
		</div>
		<div id="bread">
			<div class="container">

				<ul id="breadcrumbs">

				<?php
					foreach($this->fuel('breadcrumbs') as $breadcrumb) {
						$class = strpos($page->path, $breadcrumb->path) === 0 ? " class='active'" : '';
						$title = __($breadcrumb->title, __FILE__);
						echo "<li $class><a href='{$breadcrumb->url}'>{$title}</a></li>";
					}
				?>
					<li class="fright"><a target="_blank"  href="<?php echo $config->urls->root; ?>"><?php echo __('View Site', __FILE__); ?></a></li>
					
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
	</div>
	<div id="footer">
		<div id="skyline"></div>
		<div class="container">
			<div id="user-menu" class="fleft">
				
				<?php $gravatar = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) ) . "?d=mm&s=50"; ?>
				<?php if ($gravatar): ?>
					<?php $edit = __('profile', __FILE__); ?>
					<?php if ($user->hasPermission('profile-edit')) echo "<a title='{$edit}' class='tooltip' href='{$config->urls->admin}profile/'>" ?>
					<img class="gravatar" src="<?php echo $gravatar; ?>" alt="">
					<?php if ($user->hasPermission('profile-edit')) echo "</a>" ?>
				<?php endif ?>
									
				<div class="user-menu">
					<?php if ($user->hasPermission('profile-edit')) echo "<a title='{$edit}' class='user-name tooltip' href='{$config->urls->admin}profile/'>{$user->name}</a>" ?><br>
					<a class="user-logout" href='<?php echo $config->urls->admin; ?>login/logout/'><?php echo __('logout', __FILE__); ?></a>
				</div>
			</div>
			
			<p class="copy fright"><a href="http://processwire.com/">ProcessWire</a> <?php echo $config->version; ?> - Copyright &copy; <?php echo date("Y"); ?> by Ryan Cramer</p>
		</div>
	</div>


</body>
<?php endif; ?>
</html>