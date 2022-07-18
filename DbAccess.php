<?php

use MongoDB\Client;

class DbAccess
{
    private $db;
    private $user;
    private $traffic;

    public function __construct()
    {
        $this->db = new \MongoDB\Client("mongodb://127.0.0.1/");
        $this->traffic = $this->db->traffic->traffic;
        $this->user = $this->db->traffic->user;
    }

    public function client(): void
    {
        $statement = $this->user->distinct("login");
        echo "<div id='set'>";
        foreach ($statement as $data) {
            echo "<option value='$data'>$data</option>";
        }
        echo "</div>";
    }

    public function messages($client): void
    {
        $statement = $this->user->distinct("messages", ["login"=>$client]);
        echo "<div id='set'>Client: $client<br>";
        foreach ($statement as $data) {
            echo "Message: $data<br>";
        }
        echo "</div>";
    }


    public function traffic(): void
    {
        $statement = $this->traffic->aggregate([['$group'=>["_id"=>null, "totalAmount"=>['$sum'=>'$traffic_in']]]]);
        echo "<div id='set'>Traffic In: {$statement->toArray()[0]['totalAmount']}<br>";
        $statement = $this->traffic->aggregate([['$group'=>["_id"=>null, "totalAmount"=>['$sum'=>'$traffic_out']]]]);
        echo "Traffic Out: {$statement->toArray()[0]['totalAmount']}<br></div>";
    }


    public function balance(): void
    {
        $statement = $this->user->find(["balance" => ['$lt' => 0]]);
        echo "<div id='set'>";
        foreach ($statement as $data) {
            echo "Должник: {$data['login']}<br>";
        }
        echo "</div>";
    }
}