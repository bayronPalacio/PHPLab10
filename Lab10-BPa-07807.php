<?php

//Require configuration
require_once('inc/config.inc.php');

//Require Entities
require_once('inc/Entities/Customer.class.php');

require_once('inc/Utilities/RestClient.class.php');
require_once('inc/Utilities/Page.class.php');

//Check if there was get data, perofrm the action
if (isset($_GET["action"])){
    // //Perform the Action

    if ($_GET["action"] == "delete"){
    //     //Call the rest client with DELETE
        RestClient::call("DELETE",array('id'=>$_GET['id']));
    }
    //Was there an edit?
    else if ($_GET["action"] == "edit"){
        //Call the rest client with GET, encode the result into a typed Customer
        $editCustomer = RestClient::call("GET",array('id'=>$_GET['id']));
    }
}

//Check for post data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["action"]) && $_POST["action"] == "edit")    {
        //Assemble the the postData
        $newCustomer = new Customer();
        $newCustomer->setCustomerID($_POST["customerID"]);
        $newCustomer->setName($_POST["name"]);
        $newCustomer->setAddress($_POST["address"]);
        $newCustomer->setCity($_POST["city"]);
        $postData = (array)$newCustomer->jsonSerialize();
        //Call the RestClient with PUT
        RestClient::call("PUT",$postData);
    //Was probably a create
    } else {
        //Assemble the Customer
        $newCustomer = new Customer();
        $newCustomer->setName($_POST["name"]);
        $newCustomer->setAddress($_POST["address"]);
        $newCustomer->setCity($_POST["city"]);
        // var_dump($newCustomer);
        $postData = (array)$newCustomer->jsonSerialize();
        // //Add the data 
        RestClient::call("POST", $postData);
    }
}

//Get all the customers from the web service via the REST client
$jCustomers = RestClient::call("GET");
// Store the customer objects 
$customers = array();
// Iterate through the customers and convert them back to Customer objects
foreach($jCustomers as $jCustomer)   {
    $newCustomer = new Customer();
    $newCustomer->setCustomerID($jCustomer->CustomerID);
    $newCustomer->setName($jCustomer->Name);
    $newCustomer->setAddress($jCustomer->Address);
    $newCustomer->setCity($jCustomer->City);
    $customers [] = $newCustomer;
}

Page::$title = "Lab 10_BPa-07807";
Page::header();
Page::listCustomers($customers);
//Check the action, edit?  show edit page? get?  show create form
    if (!empty($_GET) && $_GET["action"] == "edit") {       
        $ec = new Customer();
        $ec->setCustomerID($editCustomer->CustomerID);
        $ec->setName($editCustomer->Name);
        $ec->setAddress($editCustomer->Address);
        $ec->setCity($editCustomer->City);
        Page::editCustomer($ec);
    } else {
        Page::addCustomer();
    }
Page::footer();