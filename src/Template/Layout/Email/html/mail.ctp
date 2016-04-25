
<!DOCTYPE html>
<html>
<head>
<?= $this->Html->charset() ?>

<style>
 h1
{
color:red;
border:1px solid black;
background-color:yellow;
}
header{
	width:100%;
	background-color:black;
	
}

fieldset
{
	border-color:#58c4ee;
	margin-top:8px;
	
	padding-top:5px;
}
legend
{
	color:blue;
	margin-top:5px;
}
ul li{
	display:inline;
}
</style>

<?= $this->fetch('css') ?>
</head>
<body>
<header>
<?php echo $this->element('mail_header'); ?>
	
</header>
   <section class="container">
        <?= $this->fetch('content') ?>
    </section>
    
<footer>
<?php echo $this->element('mail_footer'); ?>
	
</footer>

</body>
</html>
