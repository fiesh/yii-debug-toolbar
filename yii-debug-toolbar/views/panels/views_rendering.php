<?php
/**
 * application file.
 * 
 * Description of application file
 *
 * @author Sergey Malyshev <malyshev.php@gmail.com>
 * @version $Id$
 * @package
 * @since 1.1.7
 */


$index = 1;
?>

<?php foreach ($data as $id=>$item) : ?>
<h4><?php echo YiiDebug::t('Context')?>&nbsp;<?php echo CHtml::encode(get_class($item['context']))?></h4>
<p class="collapsible collapsed">
    <?php echo $this->getFileAlias($item['sourceFile']) ?>
</p>

<div>
    <table>
    <tbody>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Context class</th>
            <td><?php echo CHtml::encode(get_class($item['context']))?></td>
        </tr>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Inheritance</th>
            <td><?php echo $this->getInheritance($item['reflection'])?></td>
        </tr>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Defined in file</th>
            <td><?php echo $this->getFilePath($item['reflection']->getFileName()) ?></td>
        </tr>

        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Context properties</th>
            <td>
                <?php YiiDebug::dump($item['contextProperties']); ?>
            </td>
        </tr>

        <?php if(null!==$item['action']): ?>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Route</th>
            <td><?php echo $item['route'] ?></td>
        </tr>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Action</th>
            <td><?php echo get_class($item['action']) , '&nbsp;(' , $item['action']->getId() , ')'  ?></td>
        </tr>

	<?php if(isset($item['actionParams']) && !empty($item['actionParams'])): ?>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Action params</th>
	    <td>
                <?php YiiDebug::dump($item['actionParams']); ?>
            </td>
        </tr>
        <?php endif; ?>
	<?php endif; ?>

        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">Render method</th>
            <td><?php echo $item['backTrace']['function'] ?></td>
        </tr>

        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">View file</th>
            <td><?php echo $this->getFilePath($item['sourceFile']) ?></td>
        </tr>

        <?php if(!(1===count($item['data']) && isset($item['data']['content']))): ?>
        <tr class="<?php echo $index%2?'even':'odd';$index++; ?>">
            <th style="white-spaces: no-wrap;">View data</th>
	    <td>
                <?php YiiDebug::dump($item['data']); ?>
            </td>
        </tr>
        <?php endif; ?>

    </tbody>
</table>
</div>
<?php endforeach; ?>

