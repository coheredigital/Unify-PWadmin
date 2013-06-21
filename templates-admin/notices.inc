<div id="notices">
	<ul>
	<?php
		foreach($notices as $notice) {
			$text = $notice->text;
			if($notice->class && $config->debug) $text = $notice->class." : ".$text;
			if($notice instanceof NoticeError) {
				$class = "error";
			}
			else{
				$class = 'success';
			}
			echo "<li class='".$class."'>".$text."</li>";
		}
	?>
	</ul>	
</div>