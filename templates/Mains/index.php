<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="reports index content">
    <div class="column-responsive column-80">
	<?if($mains->response_data=="")
	{
	?>
		<div class="mains form content">
		<?= $this->Form->postButton('Vendedor', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "2DFWE4", "pov": "seller"  }']]) ?>
		<?= $this->Form->postButton('Comprador', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "create_contract", "participant_access_code": "2DFWE4", "pov": "seller"  }']]) ?>


		<?= $this->Form->postButton('Sus contratos (Seller)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "2DFWE4", "pov": "seller"  }']]) ?>
		<?= $this->Form->postButton('Crear Contrato', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "create_contract", "participant_access_code": "2DFWE4", "pov": "seller"  }']]) ?>
		<?= $this->Form->postButton('Informacion Contable (Seller)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>json_decode('{ "location": "10001", "sub_topic": "my_accounting", "participant_access_code": "2DFWE4", "pov": "seller" }', true)]) ?>



		<?= $this->Form->postButton('Buscar Productos (Buyer)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "find_product_classes", "participant_access_code": "WEF239", "pov": "browser"  }']]) ?>
		<?= $this->Form->postButton('Sus contratos (Buyer)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "WEF239", "pov": "buyer"  }']]) ?>
		<?= $this->Form->postButton('Recibir (Buyer)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "receive_shipment", "participant_access_code": "WEF239", "pov": "buyer"  }']]) ?>
		<?= $this->Form->postButton('Aprobar (Buyer)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>['request_data'=>'{ "location": "10001", "sub_topic": "approve_receipt", "participant_access_code": "WEF239", "pov": "buyer"  }']]) ?>
		<?= $this->Form->postButton('Informacion Contable (Buyer)', ['controller' => 'Mains', 'action' => 'index'], ['data'=>json_decode('{ "location": "10001", "sub_topic": "my_accounting", "participant_access_code": "WEF239", "pov": "buyer" }', true)]) ?>
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
</div>
<div id="modal-container"></div>
