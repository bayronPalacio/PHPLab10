<?php

class CustomerMapper    {

    private static $db;

    static function initialize()    {

        //Initialize the database connection
        self::$db = new PDOAgent('Customer');
    
    }

    //CREATE a single Customer
    static function createCustomer(Customer $newCustomer): int   {

        //Generate the INSERT STATEMENT for the customer;
        $sql = "INSERT INTO customers (Name, Address, City) VALUES (:name, :address, :city);";

        //prepare the query
        self::$db->query($sql);

        //Setup the bind parameters
        self::$db->bind(":name",$newCustomer->getName());
        self::$db->bind(":address",$newCustomer->getAddress());
        self::$db->bind(":city",$newCustomer->getCity());
        
        //Execute the query
        self::$db->execute();

        //Return the last inserted ID!!
        return self::$db->lastInsertedId();       

    }

    //READ a single Customer
    static function getCustomer(int $id){
        $sql = "SELECT * FROM customers WHERE CustomerID = :id;";
        //Prepare the query
        self::$db->query($sql);
        //Set the bind parameters
        self::$db->bind(":id",$id);
        //Execute the query
        self::$db->execute();
        //Get the row
        return self::$db->singleResult();
    
    }
    
    //READ a list of Customers
    static function getCustomers(){
        $sql = "SELECT * FROM customers ORDER BY Name Asc;";
        // //Prepare the query
        self::$db->query($sql);
        // //Execute the query
        self::$db->execute();
        // //Get the row
        return self::$db->getResultSet();
    }

    //UPDATE 
    static function updateCustomer(Customer $updatedCustomer): int   {
       
        //Create the query
        $updateQuery = "UPDATE customers SET Name=:name, Address=:address, City=:city WHERE CustomerID =:id;";
        //Query...
        self::$db->query($updateQuery);
            // //Bind
        self::$db->bind("id",$updatedCustomer->getCustomerID());
        self::$db->bind("name",$updatedCustomer->getName());
        self::$db->bind("address",$updatedCustomer->getAddress());
        self::$db->bind("city",$updatedCustomer->getCity());
            //Execute the query
        self::$db->execute();

        //Get the number of affected rows
        return self::$db->rowCount();
    }

    //DELETE
    static function deleteCustomer(int $id): int {

        // try {
            $sql = "DELETE FROM customers WHERE CustomerID = :id;";
            //Create the delete query
            self::$db->query($sql);
            //Bind the id
            self::$db->bind(":id",$id);
            //Execute the query
            self::$db->execute();

        //Return the amount of affected rows.
        return self::$db->rowCount();
    
    }

}

?>