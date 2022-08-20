<?php
require 'vendor/autoload.php';

use Google\Cloud\Storage\StorageClient;

$storage = new StorageClient([
    'keyFilePath' => 'firebase-Service-Key.json',
    'projectId' => 'firebase-project-id'
]);

$bucketURL = 'rahul7aj.appspot.com';

$bucket = $storage->bucket($bucketURL);

// Upload a file to the bucket.
$bucket->upload(
    fopen('extra.txt', 'r')
);

// Using Predefined ACLs to manage object permissions, you may
// upload a file and give read access to anyone with the URL.
$success = $bucket->upload(
    fopen('extra.txt', 'r'),
    [
        'predefinedAcl' => 'publicRead',
        'name' => 'GeneratedPDF/extra.txt'
    ]
);

//Generating SignedURL to share or download content
//Remove 'responseDisposition'=>'attachment' option, if you want to open the content in browser
echo $success->signedURL(new \DateTime('tomorrow'),['responseDisposition'=>'attachment']);

// Download and store an object from the bucket locally.
$object = $bucket->object('GeneratedPDF/extra.txt');
$object->downloadToFile('file_backup.txt');

//if you want to access the content then below is for that (need rules - allow read;)
echo '<br/><br/>https://firebasestorage.googleapis.com/v0/b/'.$bucketURL.'/o/GeneratedPDF%2Fextra.txt?alt=media';

?>