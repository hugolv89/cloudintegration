<?php
/**
 * Shares Widget
 */

$paramsNumber = array(
	'name' => 'params[share_number]',
	'value' => $vars['entity']->share_number,
	'options' => array(5,10,15,20,25,30,35,40,45,50),
);
$number_dropdown = elgg_view('input/select', $paramsNumber);

?>
<div>
	<?php 
		echo elgg_echo('cloudintegration:widgets:metashares:number:label').': ';
 		echo $number_dropdown; 
	?>
</br>
</div>

