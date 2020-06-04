<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="reports index content">
    <h3><?= __('Reports') ?></h3>
    <div class="table-responsive">
       <? //debug($pins); ?>
       <?=$mains->router_data; ?>
    </div>
    <div class="column-responsive column-80">
        <div class="reports form content">
		<?= $this->Form->postButton('Sus Contratos', ['controller' => 'Routers', 'action' => 'index'], ['data'=>['sub_topic'=>'.00000.my_contracts', 'other_data'=>'test']]) ?>
        </div>
    </div>
</div>
