
<?php

class Tasks extends tableDataObject {

    const TABLENAME = 'task';

    //public static  function getallTask($uid)
    //public static  function getuncompeletedTask($uid)
    //getcompeletedTask($uid)



    public static  function individualtaskstatictics($uid, $status){
        global $payrolldb;

        if($status == 'All'){
          $getrecords = "Select count(*) as ct  from task where uid = $uid ";
        }elseif($status == 'Incomplete'){
          $getrecords = "select COUNT(DISTINCT task.id) as ct  from taskassignment left outer join task
                         ON task.id = taskassignment.taskid where task.uid = $uid and
                         (taskassignment.taskstatus = 2 or taskassignment.taskstatus = 0 or taskassignment.taskstatus is null)  ";
        }elseif($status == 'Complete'){
          $getrecords = "select COUNT(DISTINCT task.id) as ct  from taskassignment left outer join task
                         ON task.id = taskassignment.taskid where task.uid = $uid and  taskassignment.taskstatus = 1 ";
        }

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->fetchColumn();
     }

    public static  function mastertaskstatictics($status = null){
        global $payrolldb;

        if($status == 'All'){
          $getrecords = "select count(*) as ct  from taskassignment ";
        }elseif($status == 'Incomplete'){
          $getrecords = "Select COUNT(DISTINCT task.id) as ct  from taskassignment inner join task
                        ON task.id = taskassignment.taskid where taskassignment.taskstatus = 2 ";
        }elseif($status == 'Complete'){
          $getrecords = "Select COUNT(DISTINCT task.id) as ct  from taskassignment inner join task
                        ON task.id = taskassignment.taskid where taskassignment.taskstatus = 1 ";
        }

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->fetchColumn();
    }

    public static  function gettotaltask($status, $uid = null){
        global $payrolldb;
         if($status == 'User'){
           $getrecords = "select count(*) as ct  from task where  uid = $uid  ";
         }elseif($status == 'Master'){
           $getrecords = "select count(*) as ct  from task ";
         }
        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->fetchColumn();
    }


    public static  function getmasterTasklist($status){
        global $payrolldb;
      if($status == 'All'){
        $getrecords = "Select * from task";
      }elseif($status == 'Complete'){
          $getrecords = "SELECT task.*, taskassignment.dateassigned, taskassignment.dateassigned,
          taskassignment.taskstatus, taskassignment.taskid, taskassignment.uid, taskassignment.review,
          taskassignment.assignee, taskassignment.rating FROM taskassignment LEFT OUTER JOIN task
                   ON task.id = taskassignment.taskid where taskstatus = '1' ";
      }
      elseif($status == 'Incomplete'){
          $getrecords = "SELECT task.*,  taskassignment.dateassigned, taskassignment.dateassigned,
          taskassignment.taskstatus, taskassignment.taskid, taskassignment.uid, taskassignment.review,
          taskassignment.assignee, taskassignment.rating FROM taskassignment LEFT OUTER JOIN task
                   ON task.id = taskassignment.taskid where taskstatus = '2' ";
      }
      elseif($status == 'Notassigned'){
          $getrecords = "SELECT task.*,  taskassignment.dateassigned, taskassignment.dateassigned,
          taskassignment.taskstatus, taskassignment.taskid, taskassignment.uid, taskassignment.review,
          taskassignment.assignee, taskassignment.rating FROM taskassignment LEFT OUTER JOIN task
                   ON task.id = taskassignment.taskid where taskstatus = 0 or  taskstatus is null ";
      }

      elseif($status == 'Assigned'){
          $getrecords = "SELECT task.*, taskassignment.dateassigned, taskassignment.dateassigned,
          taskassignment.taskstatus, taskassignment.taskid, taskassignment.uid, taskassignment.review,
          taskassignment.assignee, taskassignment.rating FROM taskassignment LEFT OUTER JOIN task
          ON task.id = taskassignment.taskid";
      }

        $payrolldb->prepare($getrecords);
        $payrolldb->execute();
        return $payrolldb->resultSet();
    }


        public static  function getindividualTasklist($status, $uid){
            global $payrolldb;
            if($status == 'All'){
            $getrecords = "Select * from task where uid  = $uid ";
          }elseif($status == 'Complete'){
              $getrecords = "SELECT task.*,taskassignment.dateassigned, taskassignment.dateassigned,
              taskassignment.taskstatus, taskassignment.taskid, taskassignment.uid, taskassignment.review,
              taskassignment.assignee, taskassignment.rating FROM taskassignment LEFT OUTER JOIN task
                       ON task.id = taskassignment.taskid where taskassignment.taskstatus = '1' and task.uid  = $uid ";
          }
          elseif($status == 'Incomplete'){
              $getrecords = "SELECT task.*, taskassignment.dateassigned, taskassignment.dateassigned,
              taskassignment.taskstatus, taskassignment.taskid, taskassignment.uid, taskassignment.review,
              taskassignment.assignee, taskassignment.rating  FROM taskassignment LEFT OUTER JOIN task
                       ON task.id = taskassignment.taskid where taskassignment.taskstatus = '2' and task.uid = $uid ";
          }
          elseif($status == 'Notassigned'){
              $getrecords = "Select * from task where uid  = $uid and  (taskstatus = 0 or  taskstatus is null) ";
          }
          elseif($status == 'Assigned'){
              $getrecords = "SELECT task.*, taskassignment.dateassigned, taskassignment.dateassigned,
              taskassignment.taskstatus, taskassignment.taskid, taskassignment.uid, taskassignment.review,
              taskassignment.assignee, taskassignment.ratingFROM taskassignment INNER JOIN task
                       ON task.id = taskassignment.taskid where assignee = $uid ";
          }

            $payrolldb->prepare($getrecords);
            $payrolldb->execute();
            return $payrolldb->resultSet();
        }

        public static  function getUserAssignedTask($status, $uid){
            global $payrolldb;

            if($status == 'All'){
            $getrecords = "SELECT taskassignment.*, taskusers.*,  task.*, users.*  FROM taskassignment INNER JOIN taskusers
            ON taskusers.taskid = taskassignment.taskid INNER JOIN task on task.id = taskassignment.taskid
            inner join users on task.uid = users.uid  where taskusers.uid = $uid ";

          }elseif($status == 'Complete'){
              $getrecords = "SELECT taskassignment.*, taskusers.*,  task.*, users.*  FROM taskassignment INNER JOIN taskusers
              ON taskusers.taskid = taskassignment.taskid INNER JOIN task on task.id = taskassignment.taskid
              inner join users on task.uid = users.uid  where taskusers.uid = $uid and  taskassignment.taskstatus = '1' ";
            }
            elseif($status == 'Incomplete'){
              $getrecords = "SELECT taskassignment.*, taskusers.*,  task.*, users.*  FROM taskassignment INNER JOIN taskusers
              ON taskusers.taskid = taskassignment.taskid INNER JOIN task on task.id = taskassignment.taskid
              inner join users on task.uid = users.uid  where taskusers.uid = $uid and  taskassignment.taskstatus = '2'";
            }

            $payrolldb->prepare($getrecords);
            $payrolldb->execute();
            return $payrolldb->resultSet();
        }


        public static  function getUserAssignedTaskcount($status, $uid){
            global $payrolldb;

            if($status == 'All'){
            $getrecords = "SELECT count(*) as ct  FROM taskassignment INNER JOIN taskusers
            ON taskusers.taskid = taskassignment.taskid INNER JOIN task on task.id = taskassignment.taskid
            inner join users on task.uid = users.uid  where taskusers.uid = $uid ";

          }elseif($status == 'Complete'){
              $getrecords = "SELECT COUNT(DISTINCT taskusers.taskid) as ct FROM taskassignment INNER JOIN taskusers
              ON taskusers.taskid = taskassignment.taskid where taskusers.uid = $uid and  taskassignment.taskstatus = '1' ";
            }
            elseif($status == 'Incomplete'){
              $getrecords = "SELECT COUNT(DISTINCT taskusers.taskid) as ct  FROM taskassignment INNER JOIN taskusers
              ON taskusers.taskid = taskassignment.taskid where taskusers.uid = $uid and  taskassignment.taskstatus = '2'";
            }

            $payrolldb->prepare($getrecords);
            $payrolldb->execute();
            return $payrolldb->fetchColumn();
        }




    /////////////////// Getting Records list //////////////////////////////////////////////////////////////////////////






}


 ?>
