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
    <h3><?= __('Sus Contratos') ?></h3>
    <div class="table-responsive">
       <? //debug($contratos->request_data); ?>
    </div>
    <div class="column-responsive column-80">
        <div class="reports form content">
            <?= $this->Form->create(null, ['url'=>'/contratos']) ?>
            <fieldset>
                <legend><?= __('Listado de Contratos') ?></legend>
                <h5>Fecha de generacion: <?= $contratos->request_data->processed->produced_dt; ?></h5>
                <?php
                    	echo $this->Form->control('location', ['label'=>'Location', 'value'=>$contratos->request_data->location, 'readonly'=>true]);
			echo $this->Form->control('sub_topic', ['type'=>'hidden', 'value'=>$contratos->request_data->sub_topic]);
                ?>
            </fieldset>
            <? //$this->Form->button(__('Submit', ['type'=>'submit'])) ?>
            <?= $this->Form->end() ?>
            <h5>Contratos</h5>
            <?php
		//Printing the Buttons
		foreach((array)$contratos->request_data->processed->buttons as $button)
		{
			echo $this->Form->postButton($button->product, ['controller' => 'Contratos', 'action' => 'details'], ['data'=>json_decode('{ "location": "'.$contratos->request_data->location.'", "sub_topic": "'.($button->reply_sub_topic.".".$button->contract_id).'", "participant_access_code": "2DFWE4", "pov": "seller"  }', true)]);
		}            
            ?>
            <hr />
            <?= $this->Form->postButton('Pantalla Principal', ['controller' => 'Mains', 'action' => 'index']); ?>
        </div>
    </div>
</div>
