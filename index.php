<?php require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/**
 * The name of the bucket - this will never change
 */
define('BUCKET_NAME', 'leasefetcher');

/*
 ******************************************************
 ******************** IMPORTANT ***********************
 ******************************************************
 *
 * You should never hard code credentials in your code.
 * This is purely for example purposes. For more secure
 * ways of authenticating the S3 Client please look here
 * https://docs.aws.amazon.com/aws-sdk-php/v3/guide/getting-started/basic-usage.html
 */

/**
 *************** UPDATE THIS VARIABLE **************
 *
 * Your S3 Access Key ID. This can be obtained from your 
 * LF dashboard on the Account Settings page in the 
 * S3 Bucket Connection Credentials section.
 * 
 * @var string
 */
$key = 'ACCESS_KEY_ID';

/**
 ************** UPDATE THIS VARIABLE **************
 *
 * Your S3 Access Key Secret. This can be obtained from your 
 * LF dashboard on the Account Settings page in the 
 * S3 Bucket Connection Credentials section.
 * 
 * @var string
 */
$secret = 'SECRET_ACCESS_KEY';

/**
 ************** UPDATE THIS VARIABLE **************
 * 
 * The directory to which your sheet will be uploaded.
 * This can be obtained from your LF dashboard on the
 * Account Settings page in the S3 Bucket Connection 
 * Credentials section
 * 
 * @var integer
 */
$directoryName = 1;

/**
 ***************************************************
 ************** UPDATE THIS VARIABLE **************
 **************************************************
 *
 * The name of the file which will be given to the uploaded
 * file in the bucket. Please note that if there is a file of the
 * same name already in the bucket it will be overwritten.
 * 
 * @var string
 */
$filename = 'filename.csv';

/**
 **************************************************
 ************** UPDATE THIS VARIABLE **************
 **************************************************
 *
 * This is the path to the file on your server which
 * will be uploaded
 * 
 * @var string
 */
$pathToLocalFile = 'pricing.csv';

/**
 * The path to which the file will be uploaded e.g.
 * 1/filename.csv. You do not need to update this 
 * variable
 * 
 * @var string
 */
$uploadPath = sprintf('%d/%s', $providerId, $filename);

try
{
	/**
	 * Create an S3 Client
	 * 
	 * @var S3Client
	 */
	$s3Client = new S3Client([
	    'version' => 'latest',
	    'region'  => 'eu-west-2',
	    'credentials' => [
	        'key'    => $key,
	        'secret' => $secret,
	    ]
	]);

	/**
	 * Upload the file to the leasefetcher bucket
	 */
	$result = $s3Client->putObject([
        'Bucket'     => BUCKET_NAME,
        'Key'        => $uploadPath,
        'SourceFile' => $pathToLocalFile,
    ]);

	/**
	 * View the results
	 */
    var_dump($result);
}

catch( AwsException $e )
{
	/**
	 * View details of the error if any are thrown
	 */
    echo $e->getMessage() . "\n";
}