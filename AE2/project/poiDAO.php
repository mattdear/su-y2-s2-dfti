<?php
include("poiDTO.php");

class poiDAO {

    private $table, $conn;

    public function __construct($conn, $t) {
        $this->conn = $conn;
        $this->table = $t;
    }

    public function findRegions($regionIn) {
      $stmt = $this->conn->prepare("SELECT region FROM " . $this->table);
      $stmt->execute();
      while($row = $stmt->fetch()) {
        $region = $row["region"];
        $regions[] = $region;
      }

    return $regions;
    }

    public function findByRegion($regionIn) {
      $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE region=:region");
      $stmt->execute([":region"=>$regionIn]);
      while($row = $stmt->fetch()) {
        $poi = new poiDTO($row["ID"], $row["name"], $row["type"], $row["country"], $row["region"], $row["description"], $row["recommended"], $row["username"]);
        $pois[] = $poi;
      }

    return $pois;
    }

    public function addRecommendation($idIn, $regionIn) {
      $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET recommended=recommended+1 WHERE ID=:id");
      $stmt->execute([":id"=>$idIn]);
      header ("location: searchResults.php?region=$regionIn");
    }

    public function add(poiDAO $poiObj){
      $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (ID, name, type, country, region, description, recommended, username) VALUES (:ID, :name, :type, :country, :region, :description, :recommended, :username");
      $stmt->execute([":ID"=>$poiObj->getId()],[":name"=>$poiObj->getName()],[":type"=>$poiObj->getType()],[":country"=>$poiObj->getCountry()],[":region"=>$poiObj->getRegion()],[":description"=>$poiObj->getDescription()],[":recommended"=>$poiObj->getRecommended()],[":username"=>$poiObj->getUsername()]);
      while($row = $stmt->fetch()) {
        $poi = new poiDTO($row["ID"], $row["name"], $row["type"], $row["country"], $row["region"], $row["description"], $row["recommended"], $row["username"]);
        $pois[] = $poi;
      }
    }

}
?>
