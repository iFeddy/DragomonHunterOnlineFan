<?php
    session_start();
    $from = $_SERVER["HTTP_REFERER"];

    $_SESSION['iFilteredQ1'] = "";
    $_SESSION['iFilteredQ2'] = "";

    $_SESSION['iFilteredCat'] = $_POST['iCat'];

    //Grado
    $grade;
    $_SESSION['iFilteredGrade01'] = false;
    $_SESSION['iFilteredGrade02'] = false;
    $_SESSION['iFilteredGrade03'] = false;
    $_SESSION['iFilteredGrade04'] = false;
    $_SESSION['iFilteredGrade05'] = false;
    $_SESSION['iFilteredGrade06'] = false;

    if(isset($_POST['grade1'])){
        $grade .= ", 1";
        $_SESSION['iFilteredGrade01'] = true;
    }
    if(isset($_POST['grade2'])){
        $grade .= ", 2";
        $_SESSION['iFilteredGrade02'] = true;
    }
    if(isset($_POST['grade3'])){
        $grade .= ", 3";
        $_SESSION['iFilteredGrade03'] = true;
    }
    if(isset($_POST['grade4'])){
        $grade .= ", 4";
        $_SESSION['iFilteredGrade04'] = true;
    }
    if(isset($_POST['grade5'])){
        $grade .= ", 5";
        $_SESSION['iFilteredGrade05'] = true;
    }
    if(isset($_POST['grade6'])){
        $grade .= ", 6";
        $_SESSION['iFilteredGrade06'] = true;
    }

    //Orden Por
    $_SESSION['isFilteredSort01'] = false;
    $_SESSION['isFilteredSort02'] = false;
    $_SESSION['isFilteredSort03'] = false;
    $_SESSION['isFilteredSort04'] = false;
    $_SESSION['isFilteredSort05'] = false;
    $_SESSION['isFilteredSort06'] = false;
    $_SESSION['isFilteredSort07'] = false;
    $_SESSION['isFilteredSort08'] = false;
    $_SESSION['isFilteredSort09'] = false;

    if(isset($_POST['sortedby'])){
        $sort = $_POST['sortedby'];
        $_SESSION['iFilteredBy'] = $sort;
        if($sort == "ID"){
            $what = "c_items.ItemID";
            $_SESSION['isFilteredSort01'] = true;
        }
        if($sort == "Level"){
            $what = "c_items.ItemLevel";
            $_SESSION['isFilteredSort02'] = true;
        }
        if($sort == "HP"){
            $what = "c_items.HP";
            $_SESSION['isFilteredSort03'] = true;
        }
        if($sort == "SP"){
            $what = "c_items.SP";
            $_SESSION['isFilteredSort04'] = true;
        }
        if($sort == "Attack"){
            $what = "c_items.ATK";
            $_SESSION['isFilteredSort05'] = true;
        }
        if($sort == "Penetration"){
            $what = "c_items.PEN";
            $_SESSION['isFilteredSort06'] = true;
        }
        if($sort == "Defense"){
            $what = "c_items.DEF";
            $_SESSION['isFilteredSort07'] = true;
        }
        if($sort == "Critical"){
            $what = "c_items.CRIT";
            $_SESSION['isFilteredSort08'] = true;
        }
        if($sort == "Price"){
            $what = "c_items.ItemCost";
            $_SESSION['isFilteredSort09'] = true;
        }
    }

    //Manera Orden
    if(isset($_POST['order'])){
        $order = $_POST['order'];
        $_SESSION['iFilteredOrder'] = $order;
       
        switch($order){
            case "ASC":
                $how = "ASC";
                break;
            case "DESC":
                $how = "DESC";
                break;
            default:
                $how = "ASC";
                break;
        }
    }

    $_SESSION['iFilteredQ2'] = "SELECT
                                    c_items.ItemID,
                                    c_items.ItemIndex,
                                    c_items.ItemGrade,
                                    c_items.ItemLevel,
                                    t_items.ItemName,
                                    t_items.ItemDesc,
                                    t_items.ItemURL
                                FROM
                                    c_items
                                INNER JOIN t_items ON t_items.ItemID = c_items.ItemID
                                WHERE
                                    c_items.ItemType = ?
                                AND
                                    c_items.ItemGrade in (0 $grade)
                                ORDER BY
	                                $what $how 
                                LIMIT ?, ?";

    $_SESSION['iFilteredQ1'] = str_replace("LIMIT ?, ?", "", $_SESSION['iFilteredQ2']);

    header('Location: '.$from);
?>