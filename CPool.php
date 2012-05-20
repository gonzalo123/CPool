<?php
class CPoolStatement
{
    private $stmt;
    function __construct($sql=null)
    {
        if (!is_null($sql)) {
            $url = "http://" . NODEPHP . "?" . http_build_query(array(
                    'action' => 'prepare',
                    'sql'    => $sql
                 ));
            $this->stmt = file_get_contents($url);
        }
    }

    public function getId()
    {
        return $this->stmt;
    }

    public function setId($id)
    {
        $this->stmt = $id;
    }

    public function execute($values=array())
    {
        $url = "http://" . NODEPHP . "?" . http_build_query(array(
                'action' => 'execute',
                'smtId'  => $this->stmt,
                'values' => $values
             ));
        $this->stmt = file_get_contents($url);
    }

    public function fetchAll()
    {
        $url = "http://" . NODEPHP . "?" . http_build_query(array(
                'action' => 'fetchAll',
                'smtId'  => $this->stmt
             ));
        return (file_get_contents($url));
    }

    public function closeCursor()
    {
        $url = "http://" . NODEPHP . "?" . http_build_query(array(
                'action' => 'closeCursor',
                'smtId'  => $this->stmt
             ));
        return (file_get_contents($url));
    }
}

class CPool
{
    function prepare($sql)
    {
        return new CPoolStatement($sql);
    }
}