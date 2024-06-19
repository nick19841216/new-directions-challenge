<?php

namespace App\Models;

class Company
{
    public $company_id;
    public $company_name;

    public function findByApiKey($apiKey)
    {
        //loop through companies array to match a company to and apiKey and then return the company object or null if no match
        $companies = array(
            ["company_id"=>1, "company_name"=>"Checks Direct","api_key"=>"test1"],
            ["company_id"=>2, "company_name"=>"New Directions","api_key"=>"test2"],
            ["company_id"=>3, "company_name"=>"Test Company","api_key"=>"test3"],
            ["company_id"=>4, "company_name"=>"Demo Company","api_key"=>"test4"]
        );
        foreach($companies as $company){
            if($apiKey == $company['api_key']){
                $this->company_id = $company['company_id'];
                $this->company_name = $company['company_name'];
                return $this;
            }
        }
        return null;
    }
}

?>