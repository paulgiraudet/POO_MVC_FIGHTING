<?php
declare(strict_types = 1);

class CharacterManager{
    private $_db;

    public function __construct($db){
        $this->setDb($db);
    }

    public function getDb(){
        return $this->_db;
    }

    /**
     * our db setter
     *
     * @param PDO $db
     * @return void
     */
    public function setDb(PDO $db){
        $this->_db = $db;

        return $this;
    }

    public function getChars(){
        $query = $this->getDb()->query('SELECT * FROM characters');
        $chars = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($chars as $char) {
            $arrayOfChars[] = new Character($char);
        }

        return $arrayOfChars;
    }
    public function exists($name){
        $query = $this->getDb()->prepare('SELECT * FROM characters WHERE name = :name');
        $query->bindValue(':name', $name, PDO::PARAM_STR);
        $query->execute();
        $existName = $query->fetch();
        if ($existName) {
            return true; 
        }
        else{
            return false;
        }
    }
    /**
     * insert new char in our database
     *
     * @param Character $char
     * @return void
     */
    public function addChar(Character $char){

        $req = $this->getDb()->prepare('INSERT INTO characters(name, damage) VALUES(:name, :damage)');

        $req->bindValue('name', $char->getName(), PDO::PARAM_STR);
        $req->bindValue('damage', $char->getDamage(), PDO::PARAM_INT);
    
        $req->execute();

    }
    /**
     * select a special char with a define id
     *
     * @param [type] $id
     * @return void
     */
    public function selectChar(string $name){
        // $req = $this->getDb()->query('SELECT * FROM characters WHERE name = '. $name);
        $req = $this->getDb()->prepare('SELECT * FROM characters WHERE name = :name');
        $req->bindValue('name', $name, PDO::PARAM_STR);
        $req->execute();

        $data = $req->fetch(PDO::FETCH_ASSOC);
        return new Character($data);
    }
    /**
     * update a special char with a define id
     *
     * @param Character $char
     * @return void
     */
    public function updateChar(Character $char){

        $req = $this->getDb()->prepare('UPDATE characters SET damage = :damage WHERE id = :id');

        $req->bindValue(':damage', $char->getDamage(), PDO::PARAM_INT);
        $req->bindValue(':id', $char->getId(), PDO::PARAM_INT);

        $req->execute();
    }
    /**
     * deleter a special char with a define id
     *
     * @param Character $char
     * @return void
     */
    public function deleteChar(Character $char){
        $req = $this->getDb()->prepare('DELETE FROM characters WHERE id = :id');
        $req->bindValue('id', $char->getId(), PDO::PARAM_INT);
        $req->execute();
    }
}