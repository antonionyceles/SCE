<div class="span9">
	<h2>Questionário de Avaliação Socieconômica de <?php echo $anoSelecionado['AnoQuestionario']['descricao'];?></h2>
	<ol>
		<?php
		$i = 0;
		echo $this->Form->create('Aluno',array('class'=>'formError'));
		echo $this->Form->input('Aluno.id', array('value' => $this->params->named['aluno_id'], 'type' => 'hidden'));
			foreach ($perguntas as $pergunta) :
				$value = null;
				foreach ($alunoRespostas as $alunoResposta) {
					if ($alunoResposta['Resposta']['pergunta_id'] == $pergunta['Pergunta']['id']) {
						$value = $alunoResposta['AlunoResposta']['resposta_id'];
					}
				}
				$options = array();
				foreach ($pergunta['Resposta'] as $resposta) {
					$options += array(
						$resposta['id'] => $resposta['descricao']
					);
				}
		?>
				<li>
					<?php
					$i++;
					echo $this->Form->input('AlunoResposta.' .$i. '.id');
					echo $this->Form->input('AlunoResposta.' .$i. '.pergunta_id', array('type' => 'hidden', 'value' => $pergunta['Pergunta']['id']));
					echo $this->Form->input('AlunoResposta.' .$i. '.resposta_id' , array(
						'legend' => $pergunta['Pergunta']['descricao'].'*',
						'type' => 'radio',
						'options' => $options,
						'hiddenField' => false,
						'value' => $value,
					));
					?>
				</li>
		<?php
			endforeach;
		echo $this->Form->end(__('Próximo'));
		?>
	</ol>
</div>
