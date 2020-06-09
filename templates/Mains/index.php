<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="reports index content">
    <h3><?= __('Main Menu') ?></h3>
    <div class="table-responsive">
       <?debug($mains); ?>
    </div>
    <div class="column-responsive column-80">
        <div class="mains form content">
		<?= $this->Form->postButton('Sus contratos', ['controller' => 'Mains', 'action' => 'index'], ['data'=>json_decode('{ "location": "10001", "sub_topic": "my_contracts", "participant_access_code": "2DFWE4", "pov": "seller"  }', true)]) ?>
		<?= $this->Form->postButton('Informacion Contable', ['controller' => 'Mains', 'action' => 'index'], ['data'=>json_decode('{ "location": "10001", "sub_topic": "my_accounting", "participant_access_code": "2DFWE4", "pov": "seller" }', true)]) ?>
        </div>
    </div>
</div>
