<?php
$t_now=time();
 
$this_month =date('Y-m-01');
for($i=1;$i<6;$i++){
echo date("Y-m-d", strtotime("-".$i." months", strtotime($this_month)));
}
 
?>