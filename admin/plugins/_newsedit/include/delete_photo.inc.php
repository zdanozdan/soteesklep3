<?PHP

global $_FILES, $DOCUMENT_ROOT;
require_once ("include/ftp.inc.php");

$photo_name=$_REQUEST['photo_name'];


$ftp->connect();
$ftp->delete($config->ftp['ftp_dir']."/htdocs/plugins/_newsedit/news/$id/",$photo_name);			
$ftp->close();

//1. rzopoznac jakie zhdjecie jest usuwane,m tn 1,2,3,45, czy small
$column='';
for ($i=1;$i<=8;$i++) {
switch ($_REQUEST['type']) {
    case "small": $column="photo_small"; 
    break;
    case "big$i": $column="photo$i";
    break; 
    
}
}

if (! empty($column)) {
    $mdbd->update("newsedit","$column=''","id=?",array($id=>"int"));
}
		
?>