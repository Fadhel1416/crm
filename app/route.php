<?php
     $page1 = basename($_SERVER['REQUEST_URI']);
     //var_dump($page1);

if($_REQUEST["page"]== "compagne"){
    include ('app/components/pages/contact_app.php');
}
else if($_REQUEST["page"]== "leads"){
        include ('app/components/pages/leads.php');
    
}
else if($_REQUEST["page"]== "lead"){
    include ('app/components/pages/lead.php');
}
else if($_REQUEST["page"]== "add-campagne"){
    include ('app/components/pages/add-campagne.php');   
}
else if($_REQUEST["page"]== "delete_lead"){
    include ('app/components/pages/delete_lead.php');   
}
else if($_REQUEST["page"]== "leadtest"){
    include ('app/components/pages/leadtest.php');   
}
else if($_REQUEST["page"]== "componySession"){
    include ('app/components/pages/componySession.php');   
}
else if($_REQUEST["page"]== "test-campagne"){
    include ('app/components/pages/test-campagne.php');   
}
else if($_REQUEST["page"]== "SeeAllNotification"){
    include ('app/components/pages/SeeAllNotification.php');   
}
else if($_REQUEST["page"]== "rapport"){
    include ('app/components/pages/rapport.php');   
}
else if($_REQUEST["page"]== "logout"){
    include ('app/components/pages/logout.php');   
}
else if($_REQUEST["page"]== "profile"){
    include ('app/components/pages/profile.php');   
}

else if($_REQUEST["page"]== "LogDetail"){
    include ('app/components/pages/detail_log.php');   
}

else if($_REQUEST["page"]== "User_Invits"){
    include ('app/components/pages/User_Invits.php');   
}
else if($_REQUEST["page"]== "documentation"){
    include ('app/components/pages/documentation.php');   
}
else if($_REQUEST["page"]== "CleApi"){
    include ('app/components/pages/CleApi.php');   
}
else if($_REQUEST["page"]== "task"){
    include ('app/components/pages/task.php');   
    }
else if($_REQUEST["page"]== "tickets"){
    include ('app/components/pages/ticket.php');   
    }
else if($_REQUEST["page"]== "details_ticket"){
    include ('app/components/pages/details_ticket.php');   
    }
else if($_REQUEST["page"]== "Emails"){
    include ('app/components/pages/emails.php');   
    }

 else if($_REQUEST["page"]=="ticketSettings")
 {
     include('app/components/pages/ticketSettings.php');
 }   
 else if($_REQUEST["page"]=="chat")
 {
     include('app/components/pages/chat.php');
 }  

    
    else{
        switch ($page) {
            // Section : Dashboard
        
            case 'dashboard' :
                include ('app/components/pages/index-2.php');
            break; 
                
        
            default:      
                include ('app/components/pages/index-2.php');
            break;
        }
    

        }
?>