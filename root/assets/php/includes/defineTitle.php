<?php
if(isset($page['title']) && $page['title']!=''){
    $title = " - ".$page['title'];
} else {
    $title = "";
}