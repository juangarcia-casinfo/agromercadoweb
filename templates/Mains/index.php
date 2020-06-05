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
		<?= $this->Form->button('Click me', ['Label'=>'Sus Contratos', 'id'=>'btnContratos', 'type'=>'button', 'onClick'=>'startPublishMsgAction(\'{"test": "data"}\', \'.00000.my_contracts\')']); ?>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
ws.open();
wsp.open();
</script>