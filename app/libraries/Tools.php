<?php

class Tools extends tableDataObject{

   public static  function limit_text($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
      }

      public static function Pagination($per_page,$page,$sql){

        global $payrolldb;
        //TODO new way to accomodate the frameworks url parsing. the above method is the old way 
        
        $output = explode('&',$_SERVER['QUERY_STRING']);
        unset($output[0]);
        $newstring = implode('&',$output);

        if ($newstring==""){
            $page_url="?";
        }elseif(isset($_GET['page']) && sizeof($output)==1){
            $page_url="?";
        }else{
            $page_url="?".str_replace("&page=".$page,"",$newstring).'&';
        }
         $payrolldb->prepare($sql);
         $payrolldb->execute();
         $result=$payrolldb->rowCount();
         $total = $result;
         $adjacents = "2"; 
    
         $page = ($page == 0 ? 1 : $page);  
         $start = ($page - 1) * $per_page;								
         
         $prev = $page - 1;							
         $next = $page + 1;
         $setLastpage = ceil($total/$per_page);
         $lpm1 = $setLastpage - 1;
         
         $setPaginate = "";
         if($setLastpage > 1)
         {	
             $setPaginate .= "<ul class='setPagninate blog-pagination ptb-20'>";
                     $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
             if ($setLastpage < 7 + ($adjacents * 2))
             {	
                 for ($counter = 1; $counter <= $setLastpage; $counter++)
                 {
                     if ($counter == $page)
                         $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                     else
                         $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                 }
             }
             elseif($setLastpage > 5 + ($adjacents * 2))
             {
                 if($page < 1 + ($adjacents * 2))		
                 {
                     for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                     {
                         if ($counter == $page)
                             $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                         else
                             $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                     }
                     $setPaginate.= "<li class='blank'>...</li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
                 }
                 elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
                 {
                     $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                     $setPaginate.= "<li class='blank'>...</li>";
                     for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
                     {
                         if ($counter == $page)
                             $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                         else
                             $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                     }
                     $setPaginate.= "<li class='blank'>..</li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";		
                 }
                 else
                 {
                     $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                     $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                     $setPaginate.= "<li class='blank'>..</li>";
                     for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)
                     {
                         if ($counter == $page)
                             $setPaginate.= "<li class='active'><a class='current-page active'>$counter</a></li>";
                         else
                             $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";					
                     }
                 }
             }
             
             if ($page < $counter - 1){ 
                 $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";
                 $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
             }else{
                 $setPaginate.= "<li class='active'><a class='current-page active'>Next</a></li>";
                 $setPaginate.= "<li class='active'><a class='current-page active'>Last</a></li>";
             }
    
             $setPaginate.= "</ul>\n";		
         }
     
     
         return $setPaginate;
     } 

     public static function lock($item){
        return base64_encode(base64_encode(base64_encode(base64_encode($item))));

     }

     public static function unlock($item){
        return base64_decode(base64_decode(base64_decode(base64_decode($item))));

     }

     public static function clean ($string){
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }
    
     public static function timeago($datetime){
        $then = new DateTime($datetime);
        $now = new DateTime();
        $delta = $now->diff($then);
        
        $quantities = array(
            'year' => $delta->y,
            'month' => $delta->m,
            'day' => $delta->d
           );
        
        $str = '';
        foreach($quantities as $unit => $value) {
            if($value == 0) continue;
            $str .= $value . ' ' . $unit;
            if($value != 1) {
                $str .= 's';
            }
            $str .=  ', ';
        }
        $str = $str == '' ? 'a moment ' : substr($str, 0, -2);
        
        echo $str."  ago";
     }

     
     public static function datediff($startdate,$enddate){
       
        $start = new DateTime($startdate);
        $end = new DateTime($enddate);
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

        // total days
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        // best stored as array, so you can add more than one
        $holidays =  Holiday::holidays();
       
        foreach($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }

            // (optional) for the updated question
            elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                $days--;
            }
        }


        return $days;
     }

     public static function plusOneDay($date){
       
        $date1 = str_replace('-', '/', $date);
        $tomorrow = date('Y-m-d',strtotime($date1 . "+1 days"));
        
        return $tomorrow;
     }
     
    }