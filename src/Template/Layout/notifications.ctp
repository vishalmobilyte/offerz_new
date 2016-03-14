<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>
	
    <?= $this->Html->script('notifications/jquery.mi.js') ?>
    <?= $this->Html->script('notifications/sol.js') ?>
	
	
	<?= $this->Html->css('client_new/custom.css') ?>
    <?= $this->Html->css('clients/bootstrap.min.css') ?>
    <?= $this->Html->css('clients/style.css') ?>
    <?= $this->Html->css('notifications/sol.css') ?>
    <?= $this->Html->css('notifications/custom_notify.css') ?>
    <?= $this->Html->css('clients/font-awesome.min.css') ?>
	
	
    
    	<script type="text/javascript">
    $(function() {
        // initialize sol
        $('#my-select').searchableOptionList();
    });
	</script>
    
   
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>

</head>
<body>
    	
		<?php echo $this->element('notification_header'); ?>
		<?= $this->Flash->render() ?>
    <section class="container clearfix">
        <?= $this->fetch('content') ?>
    </section>
    <footer>
    </footer>
</body>
</html>