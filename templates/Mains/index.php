<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="reports index content">
    <h3><?= __('Main Menu') ?></h3>
    <div class="column-responsive column-80">
	<?if($mains->response_data=="")
	{
	?>
		<div class="mains form content">
		<?= $this->Form->postButton('Sus contratos (Seller)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "2DFWE4", "pov": "seller"  }']]) ?>
		<?= $this->Form->postButton('Informacion Contable (Seller)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>json_decode('{ "location": "10001", "sub_topic": "my_accounting", "participant_access_code": "2DFWE4", "pov": "seller" }', true)]) ?>
		<?= $this->Form->postButton('Sus contratos (Buyer)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "WEF239", "pov": "buyer"  }']]) ?>
		<?= $this->Form->postButton('Informacion Contable (Buyer)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>json_decode('{ "location": "10001", "sub_topic": "my_accounting", "participant_access_code": "2DFWE4", "pov": "buyer" }', true)]) ?>
		</div>
	<?
	}
	else
	{
	?>
		<div class="table-responsive">
		   <? //debug($mains); ?>
		   <?= $mains->response_data->html;?>
		   
		   <span style="display: none;">
		   <?=$this->Form->create();?>
		   <?=$this->Form->control('request_data', ['type'=>'hidden', 'id'=>'request_data']);?>
		   <?=$this->Form->button('Send Data', ['type'=>'submit', 'id'=>'btn_send_data']); ?>
		   <?=$this->Form->end();?>
		   </span>
		</div>
	<?
	}
	?>		
    </div>
    <script language="javascript" type="text/javascript">
    	function sendData(rcvDataStr)
    	{
    		var translateData = rcvDataStr.replace(new RegExp(/\|+\|+DBLQT+\|+\|/, 'g'), '"');
    		console.log(translateData);
    		
    		$('#request_data').val(translateData);
    		$('#btn_send_data').click();
    	}
    </script>
</div>
