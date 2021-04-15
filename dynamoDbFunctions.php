<?php
include_once "config.php";
require VENDOR_PATH;
date_default_timezone_set('Asia/Kolkata');

use Aws\DynamoDb\Exception\DynamoDbException;
use Aws\DynamoDb\Marshaler;

class DynamoDb
{

    private $dynamodb;

    function __construct()
    {
        try {
            $sdk = new Aws\Sdk([
                'endpoint'   => DYNAMODB_ENDPOINT,
                'region'   => DYNAMODB_REGION,
                'version'  => 'latest',
                'credentials' => [
                    'key' => DYNAMODB_KEY,
                    'secret' => DYNAMODB_SECRET,
                ]
            ]);

            $this->dynamodb = $sdk->createDynamoDb();
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function getItem($params)
    {
        try {
            $result = $this->dynamodb->getItem($params);
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function putItem($params)
    {
        try {
            $result = $this->dynamodb->putItem($params);
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function updateItem($params)
    {
        try {
            $result = $this->dynamodb->updateItem($params);
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function query($params)
    {
        try {
            $result = $this->dynamodb->query($params);
            return $result;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}

class MarshalerDynamo
{

    private $marshaler;

    function __construct()
    {
        try {
            $this->marshaler = new Marshaler();
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function marshalItem($params)
    {
        try {
            $item = $this->marshaler->marshalItem($params);
            return $item;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }

    function unmarshalItem($params)
    {
        try {
            $item = $this->marshaler->unmarshalItem($params);
            return $item;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw new Exception($e->getMessage());
        }
    }
}

function createEmailPK($userMail){
    return USER_EMAIL_PK."_".substr($userMail,0,2);
}

function getUserCount(){
    global $dynamoDb;
    global $marshaler;
    if(!isset($marshaler) && !isset($dynamoDb)){
        $dynamoDb = new DynamoDb();
        $marshaler = new MarshalerDynamo();
    }

    $key = ["id"=> USER_COUNT_PK, "value"=> USER_COUNT_SK];
    $params = [
        "TableName"=> TRACKING_TABLE,
        "Key" => $marshaler->marshalItem($key)
    ];
    try{
        $result = $dynamoDb->getItem($params);
        $item = $marshaler->unmarshalItem($result['Item']);
        return $item['count'];
    }
    catch(Exception $e){
        error_log($e->getMessage());
        error_log("Unable to fetch User Count value | Function Name getUserCount (dynamoDbFunctions)");
    }
}

function updateUserCount($userCount){
    global $dynamoDb;
    global $marshaler;
    if(!isset($marshaler) && !isset($dynamoDb)){
        $dynamoDb = new DynamoDb();
        $marshaler = new MarshalerDynamo();
    }

    $key = ["id"=> USER_COUNT_PK, "value"=> USER_COUNT_SK];
    $eav = [":userCount"=> $userCount];
    $params = [
        "TableName"=> TRACKING_TABLE,
        "Key" => $marshaler->marshalItem($key),
        "UpdateExpression"=> "set #count = :userCount",
        "ExpressionAttributeValues"=> $marshaler->marshalItem($eav),
        "ExpressionAttributeNames"=> ["#count"=> "count"]
    ];
    try{
        $result = $dynamoDb->updateItem($params);
    }
    catch(Exception $e){
        error_log($e->getMessage());
        error_log("Unable to update User Count value | Function Name updateUserCount (dynamoDbFunctions)");
    }    
}

function isUserExists($userMail){
    global $dynamoDb;
    global $marshaler;
    if(!isset($marshaler) && !isset($dynamoDb)){
        $dynamoDb = new DynamoDb();
        $marshaler = new MarshalerDynamo();
    }

    $eav = [":email"=> $userMail, ":emailKey"=> createEmailPK($userMail)];
    $params = [
        "TableName" => TRACKING_TABLE,
        "IndexName" => "key7-value7-index",
        "KeyConditionExpression" => "key7 = :emailKey and value7 = :email",
        "ExpressionAttributeValues" => $marshaler->marshalItem($eav)
    ];

    try{
        $result = $dynamoDb->query($params);
        if(@$result['Items']){
            $item = $marshaler->unmarshalItem($result['Items'][0]);
            return $item;
        }
    }
    catch(Exception $e){
        error_log($e->getMessage());
        error_log("Unable to check user existentce | Function Name : isUserExists (dynamoDbFunctions)");
    }
}

function createUserId($userCount){
    return USER_ID_PK."_".$userCount;
}

function createUserEntry($userDetails){
    global $dynamoDb;
    global $marshaler;
    if(!isset($marshaler) && !isset($dynamoDb)){
        $dynamoDb = new DynamoDb();
        $marshaler = new MarshalerDynamo();
    }

    $userCount = getUserCount();
    $userId = createUserId($userCount);
    $item = [
        "id"=> $userId,
        "value"=> USER_PK,
        "key6"=> USER_CREATED_TIME_PK,
        "value6"=> date("Y-m-d H:i:s"),
        "key7"=> createEmailPK($userDetails['email']),
        "value7"=> $userDetails['email'],
        "name"=> $userDetails['name'],
        "profile_pic"=> $userDetails['picture']
    ];
    $params = [
        "TableName"=> TRACKING_TABLE,
        "Item"=> $marshaler->marshalItem($item)
    ];
    try{
        $dynamoDb->putItem($params);
        updateUserCount($userCount+1);
    }
    catch(Exception $e){
        error_log($e->getMessage());
        error_log("Unable to create User Entry | Function Name : createUserEntry (dynamoDbFunctions)");
    }
    return $userId;
}