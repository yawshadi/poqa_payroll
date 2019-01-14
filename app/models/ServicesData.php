<?php

class ServicesData extends tableDataObject{


    const TABLENAME = 'services';

    public static  function getServices(){
        global $realestatedb;
        $getrecords = "select * from services";
    
        $realestatedb->prepare($getrecords);
        $realestatedb->execute();
        return $realestatedb->resultSet();
    }


}

?>