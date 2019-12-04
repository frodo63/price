<?php
include_once 'pdo_auto_kp_connect.php';

if(isset($_POST['mail_array'])){

    $result=array();

    try{
    foreach($_POST['mail_array'] as $res){
        $pos = strpos($res, '_');
        $table=substr($res, 0,$pos);

        switch($table)
        {
            case 1:
                $table = 'hydraulics';
                break;
            case 2:
                $table = 'soges';
                break;
            case 9:
                $table = 'tails';
                break;
        }

        $brand=substr($res, $pos+1);

        $brand_table = ($table == "tails") ? "name" : "brand";

        $query=$pdo->prepare("SELECT * FROM $table WHERE $brand_table = ?");


            $query->execute(array($brand));
            $query_fetched = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach($query_fetched as $kp_entry){

                //ТУТ РИСУЕМ ТАБЛИЦУ
                $result;
            }
    }
    echo json_encode($result);
    }catch( PDOException $Exception ) {
        $pdo->rollback();
        // Note The Typecast To An Integer!
        print "Error!: " . $Exception->getMessage() . "<br/>" . (int)$Exception->getCode( );
    }

};