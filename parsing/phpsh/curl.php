<?php
    $execute_path = "/var/services/web/sugartv-test/phpsh";
    $url = "http://phpschool.com/gnuboard4/bbs/board.php?bo_table=old_job&page=1";
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   
    $output = curl_exec($ch);
    $pattern = '/<td>[0-9]{2},{1}[0-9]{3}<\/td>/';
    preg_match($pattern, $output, $matches, PREG_OFFSET_CAPTURE);
    $filted_output = $matches[0][0];
                
    $pattern = '/[0-9]{2},{1}[0-9]{3}/';
    preg_match($pattern, $filted_output, $matches, PREG_OFFSET_CAPTURE);
                        
    $recent_number = intval(str_replace(",", "", $matches[0][0]));
                            
    $file_name = $execute_path."/last";
                                
    $last_number = file_get_contents($file_name);
                                    
    if ($recent_number > $last_number) {
    	$count_thread = $recent_number - $last_number;
    	include $execute_path."/sendMail.html";
    	file_put_contents($file_name, $recent_number);
    } else if($recent_number < $last_number) {
    	file_put_contents($file_name, $recent_number);
    } 
    
    echo date("Y-m-d H:i:s") . " $recent_number > $last_number \n";
?>
