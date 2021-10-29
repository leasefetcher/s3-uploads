<?php require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

/**
 * The name of the bucket - this will never change
 */
define('BUCKET_NAME', 'leasefetch');

/**
 * The region of the bucket - this will never change
 */
define('BUCKET_REGION', 'eu-west-2');

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


/*
|--------------------------------------------------------------------------
| Start Updating Variables
|--------------------------------------------------------------------------
| 
| Please update the following variables as appropriate
|
*/

/**
 *
 * Your S3 Access Key ID. This can be obtained from your 
 * LF dashboard on the Account Settings page in the 
 * S3 Bucket Connection Credentials section.
 * 
 * @var string
 */
$key = 'ACCESS_KEY_ID';


/**
 *
 * Your S3 Access Key Secret. This can be obtained from your 
 * LF dashboard on the Account Settings page in the 
 * S3 Bucket Connection Credentials section.
 * 
 * @var string
 */
$secret = 'SECRET_ACCESS_KEY';

/**
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
 * The name of the file which will be given to the uploaded
 * file in the bucket. Please note that if there is a file of the
 * same name already in the bucket it will be overwritten.
 * 
 * @var string
 */
$filename = 'filename.csv';

/**
 *
 * This is the path to the file on your server which
 * will be uploaded
 * 
 * @var string
 */
$pathToLocalFile = '/path/to/pricing.csv';

/*
|--------------------------------------------------------------------------
| End Updating Variables
|--------------------------------------------------------------------------
|
*/

try
{
	/**
	 * Create an S3 Client
	 * 
	 * @var S3Client
	 */
	$s3Client = new S3Client([
	    'version' => 'latest',
	    'region'  => BUCKET_REGION,
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
        'Key'        => sprintf('%d/%s', $directoryName, $filename),
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