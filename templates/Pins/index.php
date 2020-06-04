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
       <?=$pins->router_data->scene; ?>
    </div>
    <div class="column-responsive column-80">
        <div class="reports form content">
            <?= $this->Form->create(null, ['url'=>'/routers']) ?>
            <fieldset>
                <legend><?= __('Enter Pin') ?></legend>
                <?php
                    echo $this->Form->control('mydata', ['label'=>'My Data Here']);
                    echo $this->Form->control('pin', ['label'=>'Password', 'type'=>'password']);
                    echo $this->Form->control('tag', ['label'=>'Tag', 'type'=>'select', 'options'=>['value1'=>'Value 1']]);                    
                    echo $this->Form->button('Im a Normal Button', ['type'=>'button']);
                    //echo $this->Form->control('description');
                    //echo $this->Form->control('parameters');
                    //echo $this->Form->control('dt_inactivated');
                   // echo $this->Form->control('function_to_call');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit', ['type'=>'submit'])) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
