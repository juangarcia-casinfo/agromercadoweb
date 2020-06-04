<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Report[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<div class="reports index content">
    <h3><?= __('Home') ?></h3>
    <div class="table-responsive">
       <?= $routers->cfg_data ?>
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
<script language="javascript" type="text/javascript">
ws.open();
wsp.open();

<?php 
if($routers->request_type=="post")
{
	?>
	setTimeout('startPublishMsgAction(\'<?= json_encode($routers->router_data); ?>\');', 2000);
	<?php
}
?>
</script>