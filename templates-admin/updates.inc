

	<div class="half">
		<h2>Newly Added</h2>
		<?php $last_modified = $pages->find('limit=12, sort=-created'); ?>
		<table class="AdminDataTable">
			<thead>
				<tr>
					<th>Who?</th>
					<th>What?</th>
					<th>When?</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($last_modified as $p):?>
					<?php if ( $p->editable() ):?>
						<tr>
							<td><?php echo $p->modifiedUser->name ?></td>
							<td><a href='<?php echo $config->urls->admin."page/edit/?id={$p->id}" ?>'><?php echo $p->get('title|name|id') ?></a></td>
							<td><?php echo date('M jS - g:iA', $p->modified) ?></td>
						</tr>
					<?php endif;?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

	<div class="half">
		<h2>Latest updates</h2>
		<?php $last_modified = $pages->find('limit=12, sort=-modified'); ?>
		<table class="AdminDataTable">
			<thead>
				<tr>
					<th>Who?</th>
					<th>What?</th>
					<th>When?</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($last_modified as $p):?>
					<?php if ( $p->editable() ):?>
						<tr>
							<td><?php echo $p->modifiedUser->name ?></td>
							<td><a href='<?php echo $config->urls->admin."page/edit/?id={$p->id}" ?>'><?php echo $p->get('title|name|id') ?></a></td>
							<td><?php echo date('M jS - g:iA', $p->modified) ?></td>
						</tr>
					<?php endif;?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
