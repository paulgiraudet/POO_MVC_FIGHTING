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
        $query = $this->getDb()->query('SELECT * from characters');
        $chars = $query->fetchAll(PDO::FETCH_ASSOC);

        foreach ($chars as $char) {
            $arrayOfChars[] = new Char($char);
        }

        return $arrayOfChars;
    }
    /**
     * insert new char in our database
     *
     * @param Character $char
     * @return void
     */
    public function addChar(Character $char){
        $req = $this->getDb()->prepare('INSERT INTO characters(id, name, damage) VALUES(:name, :damage');

        $req->bindValue(':name', $char->getName(), PDO::PARAM_STR);
        $req->bindValue(':damage', $char->getDamage(), PDO::PARAM_INT);
    
        $req->execute();
    }
    /**
     * select a special char with a define id
     *
     * @param [type] $id
     * @return void
     */
    public function selectChar(int $id){
        $id = (int) $id;
        $req = $this->_db->query('SELECT id, name, damage FROM characters WHERE id = '. $id);
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

        $req = $this->_db->prepare('UPDATE characters SET damage = :damage WHERE id = :id');

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
        $this->_db->exec('DELETE FROM characters WHERE id = ' . $char->getId());
    }
}