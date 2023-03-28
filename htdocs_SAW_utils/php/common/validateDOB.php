<?php
    //funzione per validare la data del compleanno
    function validateDOB($birthday)
        {
            $minAge = strtotime("-18 YEAR");
            $entrantAge = strtotime($birthday);
        
            if ($entrantAge < $minAge && $entrantAge > strtotime("-120 YEAR"))
            {
                return true;
            }
        
           return false;
        }

?>