<?php
/**
 * Generujemy linki dla wybranego partnera badz wszystkich partnerow 
 *
 * $author: piotrek@sote.pl
 * $Id: links.inc.php,v 1.3 2004/12/20 18:00:24 maroslaw Exp $
* @version    $Id: links.inc.php,v 1.3 2004/12/20 18:00:24 maroslaw Exp $
* @package    partners
 */

class GenLinks {
  
    /**
     * Generuj link dla danego partnera lub dla wszystkich
     *
     * @param $all - czy generowac linki dla wszystkich (on) czy tez dla wybranego partnera (nazwa partnera) 
     */
    function link4partner($all){
        global $db;
        global $config;
        global $lang;
        
        if($all!="on") {         // generuje link dla wybranego partnera
            $query="SELECT partner_id,name,email FROM partners WHERE name='$all'";                    
        } elseif ($all=="on") {  // generuje linki dla wszystkich partnerow
            $query="SELECT partner_id,name,email FROM partners";   
        }
        
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                
                if ($num_rows>0) {
                    for ($i=0;$i<$num_rows;$i++) {
                        $partner_id=$db->FetchResult($result,$i,"partner_id");             // pobranie identyfikatora partnera
                        $name=$db->FetchResult($result,$i,"name");
                        $email=$db->FetchResult($result,$i,"email");
                        $code=md5("partner_id.$partner_id.$config->salt");                 // wygenerowanie kodu kontrolnego
                        $link="http://$config->www/?partner_id=$partner_id&code=$code";    // budowanie linku
                        $links[$i]['link']=$link;   // do tablicy link przypisujemy kolejne wygenerowane linki
                        $links[$i]['name']=$name;
                        $links[$i]['email']=$email;
                    }
                }
            } else die ($db->Error());
        } else die ($db->Error());

        print "<div align=center>";
        print "<b>$lang->partners_links_info<b><BR><BR>";
        print "</div>";
        
        print "<table border=0 cellspacing=4 align=center><tr bgcolor=#d5e6ed><th>$lang->partners_partner</th><th>$lang->partners_link</th><th>$lang->partners_email</th></tr>";
        
        foreach($links as $key=>$value) {
            foreach ($value as $key1=>$value1) {
                if ($key1=="name") {
                    $name=$value1;
                }
                
                if ($key1=="email") {
                    $email=$value1;
                }
                
                if ($key1=="link") {
                    $link=$value1;
                }
            }
            print "<tr><td>$name</td><td>$link</td><td align=center><a href='mailto:$email'><u>$email</u></a></td></tr>";
        }
        
        print "</table>";
        
        return $links;
    } // end link4partner()
    
} // end class GenLinks

?>
