 <?php
$colors=array(
    CLogger::LEVEL_PROFILE=>'#DFFFE0',
    CLogger::LEVEL_INFO=>'#FFFFDF',
    CLogger::LEVEL_WARNING=>'#FFDFE5',
    CLogger::LEVEL_ERROR=>'#FFC0CB',
);
?>
<?php if(!empty($logs)): ?>
<table id="yii-debug-toolbar-log">
    <thead>
        <tr>
	    <th class="collapsible collapsed al-l" id="yii-debug-toolbar-log_.details">
                <?php echo YiiDebug::t('Message (details)')?></th>
            <th style="white-spaces: no-wrap;"><?php echo YiiDebug::t('Level')?></th>
            <th style="white-spaces: no-wrap;" class="al-l"><?php echo YiiDebug::t('Category')?></th>
            <th style="white-spaces: no-wrap;"><?php echo YiiDebug::t('Time')?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($logs as $id=>$entry): ?>
        <tr class="<?php echo ($id%2?'odd':'even') ?>"
            <?php if(isset($colors[$entry[1]])) : ?>style=" background:<?php echo $colors[$entry[1]]?>"<?php endif;?>>
            <td style="width: 100%;" onclick="jQuery('.details', this).toggleClass('hidden');">
                <?php echo YiiDebugViewHelper::splitLinesInBlocks($entry[0]) ?></td>
            <td style="white-spaces: no-wrap;" class="al-c"><?php echo $entry[1]?></td>
            <td style="white-spaces: no-wrap;"><?php echo $entry[2] ?></td>
            <td style="white-spaces: no-wrap;" class="al-c"><?php echo date('H:i:s.',$entry[3]).sprintf('%06d',(int)(($entry[3]-(int)$entry[3])*1000000));?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
