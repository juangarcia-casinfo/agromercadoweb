<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="reports index content">
    <h3><?= __('Home') ?></h3>
    <div class="table-responsive">
       <? //debug($routers->router_data->sub_topic) ?>
    </div>
    <br />
    <div class="column-responsive column-80">
        <div class="reports form content">
     		The request received is <?=$routers->request_type; ?>
     		
            <?= $this->Form->create(null, ['id'=>'router_form', 'url'=>'/routers']) ?>
            <fieldset>
                <?php
                    echo $this->Form->control('router_data', ['id'=>'router_data', 'type'=>'hidden', 'value'=>'']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Route Me', ['class'=>'router_send', 'type'=>'submit'])) ?>
            <?= $this->Form->end() ?>     		
        </div>
    </div>
</div>
