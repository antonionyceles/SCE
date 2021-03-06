<div class="span9">
	<h2><?php  echo __('Pergunta');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pergunta['Pergunta']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Descrição'); ?></dt>
		<dd>
			<?php echo h($pergunta['Pergunta']['descricao']); ?>
			&nbsp;
		</dd>
	</dl>
	<div class="related">
		<h3><?php echo __('Respostas');?></h3>
			<ul class="actions actions-horizontal">
		<li><?php echo $this->Html->link(__('Adicionar Resposta'), array('controller' => 'respostas', 'action' => 'add', 'pergunta_id' => $pergunta['Pergunta']['id'])); ?></li>
	</ul>
		<?php if (!empty($pergunta['Resposta'])):?>
		<table cellpadding = "0" cellspacing = "0">
		<tr>
			<th><?php echo __('Id'); ?></th>
			<th><?php echo __('Descrição'); ?></th>
			<th class="actions"><?php echo __('Actions');?></th>
		</tr>
		<?php
			$i = 0;
			foreach ($pergunta['Resposta'] as $resposta): ?>
			<tr>
				<td><?php echo $resposta['id'];?></td>
				<td><?php echo $resposta['descricao'];?></td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('controller' => 'respostas', 'action' => 'view', $resposta['id'])); ?>
					<?php echo $this->Html->link(__('Edit'), array('controller' => 'respostas', 'action' => 'edit', $resposta['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'respostas', 'action' => 'delete', $resposta['id']), null, __('Are you sure you want to delete # %s?', $resposta['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>