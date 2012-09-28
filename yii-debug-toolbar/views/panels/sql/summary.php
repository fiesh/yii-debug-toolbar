<?php if (!empty($summary)) :?>
<table id="yii-debug-toolbar-sql-summary" class="tabscontent">
    <thead>
        <tr>
            <th><?php echo Yii::t('yii-debug-toolbar','Query')?></th>
            <th style="white-spaces: no-wrap;"><?php echo Yii::t('yii-debug-toolbar','Count')?></th>
            <th style="white-spaces: no-wrap;"><?php echo Yii::t('yii-debug-toolbar','Total (s)')?></th>
            <th style="white-spaces: no-wrap;"><?php echo Yii::t('yii-debug-toolbar','Avg. (s)')?></th>
            <th style="white-spaces: no-wrap;"><?php echo Yii::t('yii-debug-toolbar','Min. (s)')?></th>
            <th style="white-spaces: no-wrap;"><?php echo Yii::t('yii-debug-toolbar','Max. (s)')?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($summary as $id=>$entry):?>
        <tr class="<?php echo ($id%2?'odd':'even') ?><?php echo ($entry[1]>$this->countLimit || ($entry[4]/$entry[1] > $this->timeLimit) ?' warning':'') ?>">
            <td style="width: 100%;"><?php echo $entry[0]; ?></td>
            <td style="text-align: center; white-space: no-wrap"><?php echo number_format($entry[1]); ?></td>
            <td style="white-space: no-wrap"><?php echo sprintf('%0.6F',$entry[4]); ?></td>
            <td style="white-space: no-wrap"><?php echo sprintf('%0.6F',$entry[4]/$entry[1]); ?></td>
            <td style="white-space: no-wrap"><?php echo sprintf('%0.6F',$entry[2]); ?></td>
            <td style="white-space: no-wrap"><?php echo sprintf('%0.6F',$entry[3]);?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php else : ?>
<p id="yii-debug-toolbar-sql-summary" class="tabscontent">
    <?php echo Yii::t('yii-debug-toolbar','No SQL queries were recorded during this request or profiling the SQL is DISABLED.')?>
</p>
<?php endif; ?>
