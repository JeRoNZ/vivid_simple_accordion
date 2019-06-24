<?php  defined('C5_EXECUTE') or die(_("Access Denied.")); 
if(count($items)<1){ ?>
    <div class="well"><?php echo t('You did not add any items to the accordion.')?></div>
<?php  } else { 
$i=1; ?>
<div class="panel-group" id="vivid-simple-accordion-<?php echo $bID?>" role="tablist" aria-multiselectable="true">
    <?php  foreach($items as $item){ 
        if($item['state']=="open"){ $state= " in"; }
        else { $state=""; }
    ?>
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading<?php echo $bID.$i?>">
            <?php echo $openTag?>
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $bID.$i?>" aria-expanded="true" aria-controls="collapse<?php echo $bID.$i?>">
                    <?php echo $item['title']?>
                </a>
            <?php echo $closeTag?>
        </div>
        <div id="collapse<?php echo $bID.$i?>" class="panel-collapse collapse<?php echo $state?>" role="tabpanel" aria-labelledby="heading<?php echo $bID.$i?>">
            <div class="panel-body">
                <?php echo $item['description']?>
            </div>
        </div>
    </div>
    <?php  $i++; } ?>
</div>
<?php  } ?>