<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');

if(isset($_FILES['csv'])){
    $errors= array();
		$file_size =$_FILES['csv']['size'];
        $file =$_FILES['csv']['tmp_name'];
        
		if($file_size > 10000000){
			$errors[]='File size must be less than 10 MB';
        }
        $handle = fopen($file,"r");
        do{		
        $query="INSERT into upload_data (`USER_ID`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`) VALUES('$user_id','$file_name','$file_size','$file_type'); ";
        mysql_query($query);			
        
    
	if(empty($error)){
		echo "Success";
	}
}
?>
<form action="" method="POST" enctype="multipart/form-data">
	<input type="file" name="csv" id="csv"/>
	<button type="submit">
				<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
</form>

