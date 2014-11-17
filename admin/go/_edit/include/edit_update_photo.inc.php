<?php
/**
* Wstaw zalaczone zdjecie do katalogu photo
*
* \@global int $id
*
* @author  m@sote.pl
* @version $Id: edit_update_photo.inc.php,v 2.9 2005/09/13 12:08:48 krzys Exp $
*
* \@verified 2004-03-16 m@sote.pl
* @package    edit
*/

if ($global_secure_test!=true) {
    die ("Forbidden");
}

// nadaj automatyczna nazwe do zdjecia wg id, jesli djecia robione sa aparatem cyfrowym
if (($config->cyfra_photo==1) && (! empty($_FILES['item_photo_upload']['name']))) {
    $orig_name=$_FILES['item_photo_upload']['name'];
    preg_match("/^(.)+.([a-zA-Z]{3})$/",$orig_name,$matches);
    $ext=$matches[2];
    $ext=strtolower($ext);
    $_FILES['item_photo_upload']['name']=$id.".$ext";
}

// dodaj obsluge FTP
require_once ("include/ftp.inc.php");

// sprawdz czy wczesniej trzeba usunac jakies zdjecie
$delete_1=false;$delete_2=false;
if (! empty($_REQUEST['del'])) {
    $del=$_REQUEST['del'];
    if (! empty($del['photo'])) {
        $delete_1=true;
    }
    if (! empty($del['m_photo'])) {
        $delete_2=true;
    }
}

$upload_1=false;$upload_2=false;
// sprawdz czy zdjecie zostalo zalaczone
if (! empty($_FILES['item_photo_upload']['name'])) {
    // sprawdz wielkosc pliku
    $size=$_FILES['item_photo_upload']['size'];
    $photo_tmp=$_FILES['item_photo_upload']['tmp_name'];
    $photo=$_FILES['item_photo_upload']['name'];
    if ($size>$config->max_file_size) {
        $debug->error("upload_size","Photo upload",1);
    } else {
        $upload_1=true; // zalacz duze zdjecie
    }
}

// sprawdz czy male zdjecie zostalo zalaczone
if (! empty($_FILES['item_m_photo_upload']['name'])) {
    // sprawdz wielkosc pliku
    $size=$_FILES['item_m_photo_upload']['size'];
    $m_photo_tmp=$_FILES['item_m_photo_upload']['tmp_name'];
    
    $m_photo=$_FILES['item_m_photo_upload']['name'];
    if ($size>$config->max_file_size) {
        $debug->error("upload_size","Photo upload",1);
    } else {
        $upload_2=true; // zalacz duze zdjecie
    }
}

// usun duze zdjecie
if ($delete_1==true) {
    if (! empty($del['photo'])) {
        // otworz polaczenie FTP
        $ftp->connect();
        $photo_delete=$del['photo'];
        $ftp->delete($config->ftp_dir."/htdocs/photo",$photo_delete);
        // ustawienie skasowania wartosci photo z bazy
        $_REQUEST['item']['photo']="";
    } else {
        $status->info("photo_upload_empty");
    }
}

// usun male zdjecie
if ($delete_2==true) {
    if (! empty($del['m_photo'])) {
        // otworz polaczenie FTP jesli nie jest jeszzcze otwarte
        $ftp->connect();
        $photo_delete=$del['m_photo'];
        $ftp->delete($config->ftp_dir."/htdocs/photo",$photo_delete);
    } else {
        $status->info("photo_upload_empty");
    }
}



if (($upload_1==true) || ($upload_2==true)) {
    // otworz polaczenie FTP jesli nie jest jeszzcze otwarte
    $ftp->connect();
    
    // zalaczono duze zdjecie
    $photo_exsists=false;
    if ($upload_1==true) {
        $ftp->put($photo_tmp,$config->ftp_dir."/htdocs/photo",$photo);
        $photo_exists=true;
    }
    
    // zalaczono tylko male zdjecie
    if (($upload_2==true) && ($upload_1!=true)) {
        // odczytaj nazwe zdjecia z bazy danych
        $query="SELECT photo FROM main WHERE id=?";
        $prepared_query=$db->PrepareQuery($query);
        if ($prepared_query) {
            $db->QuerySetText($prepared_query,1,$id);
            $result=$db->ExecuteQuery($prepared_query);
            if ($result!=0) {
                $num_rows=$db->NumberOfRows($result);
                if ($num_rows>0) {
                    $photo=$db->FetchResult($result,0,"photo");
                    // sprawdz czy plik jest zapisany w bazie i czy istnieje
                    if ((! empty($photo)) && (file_exists("$DOCUMENT_ROOT/photo/$photo")))
                    $photo_exists=true;
                    else $photo_exists=false;
                }
            }
        } else {
            $debug->error("db","Photo upload",-1);
        }
    }
    
    
    // zalaczono male zdjecie
    if ($upload_2==true) {
        if ($photo_exists==true) {
            $m_photo="m_".$photo;
            $ftp->put($m_photo_tmp,$config->ftp_dir."/htdocs/photo",$m_photo);
        } else {
            $photo=$m_photo;
            $m_photo="m_".$photo;
            $ftp->put($m_photo_tmp,$config->ftp_dir."/htdocs/photo",$photo);
            $theme->photo_upload_ok($photo);
            $ftp->put($m_photo_tmp,$config->ftp_dir."/htdocs/photo",$m_photo);
        }
    }
    
    $item_upload=array();
    $item_upload['photo']=$photo;
}


// start zalacz flasha:
if (! empty($_FILES['item_flash_upload']['name'])) {
    // otworz polaczenie FTP jesli nie jest jeszzcze otwarte
    $ftp->connect();
    
    // sprawdz wielkosc pliku
    $size=$_FILES['item_flash_upload']['size'];
    $file_tmp=$_FILES['item_flash_upload']['tmp_name'];
    $flash=$_FILES['item_flash_upload']['name'];
    if (eregi(".swf$",$flash)) {
        if ($size>$config->max_file_size) {
            $debug->error("upload_size","Flash upload",1);
        } else {
            $ftp->put($file_tmp,$config->ftp_dir."/htdocs/photo/_flash",$flash);
            $item_upload['flash']=$flash;
        }
    }
}
if (! empty($del['flash'])) {
    $ftp->connect();
    $flash=$del['flash'];
    $ftp->delete($config->ftp_dir."/htdocs/photo/_flash",$flash);
    $item_upload['flash']='';
    $iten_upload['flash_html']='';
} else {
    
    // przeksztalc sciezke flasha na /photo/_flash/nazwa.swf
    if (! empty($_REQUEST['item']['flash_html'])) {
        preg_match_all("/\"(.*\.swf)/",$_REQUEST['item']['flash_html'],$matches);
        if (! empty($matches)) {
            foreach ($matches as $match) {
                if (! empty($match[1])) {
                    $file_swf=basename($match[1]);
                    $x=strlen($file_swf);
                    $dir_swf=substr($match[1],0,strlen($match[1])-$x-1);
                    $item_upload['flash_html']=ereg_replace($dir_swf,$config->url_prefix."/photo/_flash",$_REQUEST['item']['flash_html']);
                }
            }
            $_REQUEST['item']['flash_html']=&$item_upload['flash_html'];
        }
    }
}
// end zalacz flasha:

// start zalacz PDFa:
if (! empty($_FILES['item_pdf_upload']['name'])) {
    // otworz polaczenie FTP jesli nie jest jeszzcze otwarte
    $ftp->connect();
    
    // sprawdz wielkosc pliku
    $size=$_FILES['item_pdf_upload']['size'];
    $file_tmp=$_FILES['item_pdf_upload']['tmp_name'];
    $pdf=$_FILES['item_pdf_upload']['name'];
    if (eregi(".pdf$",$pdf)) {
        if ($size>$config->max_file_size) {
            $debug->error("upload_size","PDF upload",1);
        } else {
            $ftp->put($file_tmp,$config->ftp_dir."/htdocs/photo/_pdf",$pdf);
            $item_upload['pdf']=$pdf;
        }
    }
}

// usun
if (! empty($del['pdf'])) {
    $ftp->connect();
    $pdf=$del['pdf'];
    $ftp->delete($config->ftp_dir."/htdocs/photo/_pdf",$pdf);
    $item_upload['pdf']='';
}
// end start zalacz PDFa:


// start zalacz DOCa:
if (! empty($_FILES['item_doc_upload']['name'])) {
    // otworz polaczenie FTP jesli nie jest jeszzcze otwarte
    $ftp->connect();
    
    // sprawdz wielkosc pliku
    $size=$_FILES['item_doc_upload']['size'];
    $file_tmp=$_FILES['item_doc_upload']['tmp_name'];
    $doc=$_FILES['item_doc_upload']['name'];
    if (eregi(".doc$",$doc)) {
        if ($size>$config->max_file_size) {
            $debug->error("upload_size","DOC upload",1);
        } else {
            $ftp->put($file_tmp,$config->ftp_dir."/htdocs/photo/_doc",$doc);
            $item_upload['doc']=$doc;
        }
    }
}
// usun
if (! empty($del['doc'])) {
    $ftp->connect();
    $pdf=$del['doc'];
    $ftp->delete($config->ftp_dir."/htdocs/photo/_doc",$pdf);
    $item_upload['doc']='';
}
//end zalacz DOCa

if (@$__add==true) {
    $mdbd->update("main","photo=?,pdf=?,flash=?,flash_html=?,doc=?","id=?",array("1,".@$photo=>"text",
    "2,".@$pdf=>"text",
    "3,".@$flash=>"text",
    "4,".@$item['flash_html']=>"text",
    "5,".@$doc['doc']=>"text",
    "6,$id"=>"int"));
}

$ftp->close();

?>
