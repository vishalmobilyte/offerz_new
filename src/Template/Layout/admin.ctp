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

//$cakeDescription = 'CakePHP: the rapid development php framework';
$cakeDescription = 'Offerz';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
	
        <?= $cakeDescription ?>:
        <?=  $this->fetch('title') ?>
		
    </title>  
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('client_new/bootstrap.min.css') ?>
    <?= $this->Html->css('client_new/style.css') ?>
    <?= $this->Html->css('client_new/custom.css') ?>
    <?= $this->Html->css('admin/custom_admin.css') ?>
    <?= $this->Html->css('client_new/font-awesome.min.css') ?>
    <?= $this->Html->css('datatable.css') ?>
	
    <?= $this->Html->script('datatable.js') ?>
    <?= $this->Html->script('clients/validation.js') ?>
    <?= $this->Html->script('admin/main.js') ?>
    <?= $this->Html->script('admin/admin.js') ?>
    <?= $this->Html->script('clients/scripts.js') ?>
   
    
   
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    	
	<?php echo $this->element('admin_header');
	if($this->request->session()->check('Admin.id'))
	{ 
	
	 echo $this->element('admin_profile'); 
	 }
		?>
	
		<?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
   
    <footer class="foot-wrap">
	<?php echo $this->element('footer'); ?>
    </footer>
</body>
</html>