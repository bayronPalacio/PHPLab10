<?php

// mysql> DESC Customers;
// +------------+------------------+------+-----+---------+----------------+
// | Field      | Type             | Null | Key | Default | Extra          |
// +------------+------------------+------+-----+---------+----------------+
// | CustomerID | int(10) unsigned | NO   | PRI | NULL    | auto_increment |
// | Name       | char(50)         | NO   |     | NULL    |                |
// | Address    | char(100)        | NO   |     | NULL    |                |
// | City       | char(30)         | NO   |     | NULL    |                |
// +------------+------------------+------+-----+---------+----------------+
// 4 rows in set (0.01 sec)

class Customer implements JsonSerializable {

    //Attributes for our POPO
    private $CustomerID;
    private $Name;
    private $Address;
    private $City;

    //Getters
    public function getCustomerID() : string {
        return $this->CustomerID;
    }

    public function getName() : string {
        return $this->Name;
    }
    
    public function getAddress() : string {
        return $this->Address;
    }

    public function getCity() : string {
        return $this->City;
    }
    //Setters
    public function setCustomerID(string $_customerID){
        $this->CustomerID = $_customerID;
    }

    public function setName(string $_name){
        $this->Name = $_name;
    }

    public function setAddress(string $_address){
        $this->Address = $_address;
    }

    public function setCity(string $_city){
        $this->City = $_city;
    }


    //Serialize the object to JSON.
    public function jsonSerialize(){   

        //Or you can specify a new object of stdClass and add the attributes you want to return.
        $obj = new stdClass;
        //Add all the attributes you want.
        $obj->CustomerID = $this->CustomerID;
        $obj->Name = $this->Name;
        $obj->Address = $this->Address;
        $obj->City = $this->City;
        return $obj;
    }
}

?>