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
	
    <?= $this->Html->css('client_new/font-awesome.min.css') ?>
 <?= $this->Html->css('client_new/nanoscroller.css') ?>

  <?= $this->Html->css('client_new/sol.css') ?>
    <?= $this->Html->css('client_new/custom_notify.css') ?>

    <?= $this->Html->css('admin/custom_admin.css') ?>

    <?= $this->Html->css('client_new/fancybox/jquery.fancybox.css') ?>

    <?= $this->Html->css('datatable.css') ?>
	<!--
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	-->
	
	<style>
.nano { background: white; width: 737px; height: 386px; }
.nano .nano-content { padding: 10px; }
.nano .nano-pane   { background: #d9d9d9; }
.nano .nano-slider { background: #cccccc; }
</style>

   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


     <?= $this->Html->script('datatable.js') ?>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <?= $this->Html->script('clients/validation.js') ?>
    <?= $this->Html->script('clients/main.js') ?>
    <?= $this->Html->script('clients/scripts.js') ?>
    <?= $this->Html->script('clients/offers.js') ?>
    <?= $this->Html->script('clients/push.js') ?>
    <?= $this->Html->script('validate.js') ?>
 
   
   
    <?= $this->Html->script('clients/source/jquery.fancybox.js') ?>
	 <?= $this->Html->script('clients/bootstrap.min.js') ?>
    
     <?= $this->Html->script('clients/sol.js') ?>
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
    	
	<?php 

	echo $this->element('header'); 
	if($this->request->session()->check('Client.id')){ 
	
	 echo $this->element('profile'); 
	 }
	 ?>
	
	
    <?= $this->Flash->render() ?>
   
        <?= $this->fetch('content') ?>
   
    <footer class="foot-wrap">
	<?php echo $this->element('footer'); ?>
    </footer>
	<?= $this->Html->script('clients/jquery_upload_multiple.js') ?>
	<?= $this->Html->script('clients/ajax_image.js') ?>
	
</body>
</html>
