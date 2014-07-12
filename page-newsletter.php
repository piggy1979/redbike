<?php 
get_template_part('templates/page', 'header'); 

$form = new Impact_Get_Response();
$form->createGetResponseForm();

get_template_part('templates/content', 'page'); ?>


