<?php

class BookingConfig extends tableDataObject{


    const TABLENAME = 'bookconfig';

    public static  function getbooking(){
        global $realestatedb;
        $getrecords = "select * from bookconfig";
    
        $realestatedb->prepare($getrecords);
        $realestatedb->execute();
        return $realestatedb->resultSet();
    }


}

?>