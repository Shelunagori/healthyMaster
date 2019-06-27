<?php
namespace App\Controller\Component;
use App\Controller\AppController;
use Cake\Controller\Component;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
class AwsFileComponent extends Component
{
	function initialize(array $config) 
	{
		parent::initialize($config);
	}
	
	/*     Connect to AWS S3   */
	function awsAccess()
	{
		$this->AwsFiles = TableRegistry::get('AwsFiles');
		$AwsFiles=$this->AwsFiles->find()->first();
		$this->bucketName=$AwsFiles->bucket_name;  // Bucket Name
		$this->cdn_path=$AwsFiles->cdn_path;  // CDN Path
		$this->awsAccessKey=$AwsFiles->access_key; // Access Key
		$this->awsSecretAccessKey=$AwsFiles->secret_access_key;  // Secret Access key
	}
	function configuration()
	{
		$this->awsAccess();
	}
	
	/*  Store Image on s3             */
	function putObjectFile($keyname,$sourceFile,$contentType)
	{		
		$this->configuration();
		$fullpath=dirname(WWW_ROOT.$this->bucketName.$keyname);
        $res1 = is_dir($fullpath);
        if($res1 != 1) {
            new Folder($fullpath, true, 0777);
        }
		//echo $sourceFile;
		//echo $this->bucketName.$keyname; exit;
		//move_uploaded_file($sourceFile,$this->bucketName.$keyname);
		rename($sourceFile,$this->bucketName.$keyname);
	}
	
	function putObjectBase64($keyname,$body,$contentType)
	{			
		$this->configuration();	
		$fullpath= dirname(WWW_ROOT.$this->bucketName.$keyname);
        $res1 = is_dir($fullpath);
        if($res1 != 1) {
            new Folder($fullpath, true, 0777);
        }
        file_put_contents($this->bucketName.$keyname, $body);
	}
	/*  Store PDF on s3             */
	function putObjectPdf($keyname,$body,$contentType)
	{			
		$this->configuration();	
		$fullpath= dirname(WWW_ROOT.$this->bucketName.$keyname);
        $res1 = is_dir($fullpath);
        if($res1 != 1) {
            new Folder($fullpath, true, 0777);
        }
		move_uploaded_file($body,$this->bucketName.$keyname);
	}
	
	/*  Delete file on s3             */
	function deleteObjectFile($keyname)
	{		
		$this->configuration();
		@unlink($this->bucketName.$keyname);
	}
	
	/*  Delete Folder on s3             */
	function deleteMatchingObjects($keyname)
	{		
		//$this->configuration();
		//$this->s3Client->deleteMatchingObjects($this->bucketName,$keyname);
	}
	
	
	/*  File exist or not on s3             */
	function doesObjectExistFile($keyname)
	{
		$this->configuration();
		if (file_exists($this->bucketName.$keyname))
		{    
		    return 'true';
		} 
		else
		{     
		    return 'false';
		} 
	}
	function cdnPath()
	{
		$this->configuration();
		return $this->cdn_path;
	}
	function currentSession()
	{
		$this->SessionYears = TableRegistry::get('SessionYears');
		$SessionYear=$this->SessionYears->find()->where(['status'=>'Active'])->first();
        return $CurrentSession=$SessionYear->id;
	}
}
?>