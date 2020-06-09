<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
 //Processing the received data into local placeholders
 $placeHolder = ['produced_dt'=>'', 
  			    'buttons'=>'',
  			    'by_participant'=>''
    			   ];
    		   

 
?>
<div class="reports index content">
    <h3><?= __('Contrato') ?></h3>
    <div class="table-responsive">
       <? //debug($contrato->response_data); ?>
    </div>
    <div class="column-responsive column-80">
        <div class="reports form content">
            <?= $this->Form->create(null, ['url'=>'/contratos']) ?>
            <fieldset>
                <legend><?= __('Contrato #'.$contrato->response_data->processed->contract_id.'('.$contrato->response_data->processed->type.')') ?></legend>
                <h5>Fecha de generacion: <?= $contrato->response_data->processed->produced_dt; ?></h5>
                <?php
                    	echo $this->Form->control('mydata', ['label'=>'Location', 'value'=>$contrato->response_data->location, 'readonly'=>true]);
			echo $this->Form->control('sub_topic', ['type'=>'hidden', 'value'=>$contrato->response_data->sub_topic]);
                ?>
            </fieldset>
            <? //$this->Form->button(__('Submit', ['type'=>'submit'])) ?>
            <?= $this->Form->end() ?>
            

		Para: <?=$contrato->response_data->processed->product; ?>(<?= $contrato->response_data->processed->delivery_amount; ?> <?=$contrato->response_data->processed->delivery_unit; ?> <?= $contrato->response_data->processed->ship_dt;?>)
		<br />
		(INEN 2005 50% 2Kg 50% 4Kg Grado 1 Caja)<br />
		Entregas: (4)30% 2020-05-30 (Mar) (5)40% 06-13 (6)30% 06-20<br />
		Depositados: (1) $80 20-05-15 (2) $100 2020-05-25<br />
		Por Depositar: (3) $60 2020-05-28<br />
		Pago x Entega: (4) $260<br />
		Comprador: [ SuperMega ] --> Lista de Contratos con Comprador<br />
		Precio Original $300.00<br />
		Montos:<br />
		Precio Actual: $500.00 Futuro<br />
		<h5>Depositos</h5>
		 <?php
		//Printing the Buttons
		foreach((array)$contrato->response_data->processed->deposits as $button=>$buttonData)
		{
			debug($buttonData[$button]->amt_paid);
			//echo $this->Form->postButton($buttonData[$button]->amt_paid, ['controller' => 'Contratos', 'action' => 'details'], ['data'=>json_decode('{ "location": "'.$contrato->response_data->location.'", "sub_topic": "'.($contrato->response_data->sub_topic).'", "participant_access_code": "2DFWE4", "pov": "seller"  }', true)]);
		}            
            ?>		
		<br />
		<h5>Comprometidos</h5>
		 <?php
		//Printing the Buttons
		//foreach((array)$contrato->response_data->processed->deliveries as $button=>$buttonData)
		//{
			//echo $this->Form->postButton($buttonData[$button]->amt_paid, ['controller' => 'Contratos', 'action' => 'details'], ['data'=>json_decode('{ "location": "'.$contrato->response_data->location.'", "sub_topic": "'.($contrato->response_data->sub_topic).'", "participant_access_code": "2DFWE4", "pov": "seller"  }', true)]);
		//}            
            ?>		
		<br />
		<?= $this->Form->postButton('Ver Estapas del Contrato', ['controller' => 'Mains', 'action' => 'index']); ?>
		
		Fees: ???
		<hr />
		<?= $this->Form->postButton('Sus Contratos', ['controller' => 'Mains', 'action' => 'index'], ['data'=>json_decode('{ "location": "'.$contratos->response_data->location.'", "sub_topic": "my_contracts", "participant_access_code": "2DFWE4", "pov": "seller"  }', true)]); ?>
		<?= $this->Form->postButton('Pantalla Principal', ['controller' => 'Mains', 'action' => 'index']); ?>
        </div>
    </div>
</div>
