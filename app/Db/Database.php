<?php


namespace App\Db;

use \PDO;
use \PDOException;

class Database{
    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    private static $host;

    /**
     * Nome do banco de dados
     * @var string
     */
    private static $name;

    /**
     * Usuário do banco
     * @var string
     */
    private static $user;

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    private static $pass;

    /**
     * Porta de acesso ao banco
     * @var integer
     */
    private static $port;

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Variavel que armazena os dados de uma imagem
     * @var array
     */
    private $image;




    /**
     * Método responsável por configurar a classe
     * @param  string  $host
     * @param  string  $name
     * @param  string  $user
     * @param  string  $pass
     * @param  integer $port
     */
    public static function config($host,$name,$user,$pass,$port = 3306)
    {
        self::$host = $host;
        self::$name = $name;
        self::$user = $user;
        self::$pass = $pass;
        self::$port = $port;
    }




    /**
     * Define a tabela e instancia e conexão
     * @param string $table
     */
    public function __construct($table = null){
        $this->table = $table;
        $this->setConnection();
    }




    /**
     * Método responsável por criar uma conexão com o banco de dados
     */
    private function setConnection()
    {
        try{
            $this->connection = new PDO('mysql:host='.self::$host.';dbname='.self::$name, self::$user,self::$pass);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }



    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param  string $query
     * @param  array  $params
     * @return PDOStatement
     */
    public function execute($query,$params = [])
    {
        try{
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        }catch(PDOException $e){
            die('ERROR: '.$e->getMessage());
        }
    }




    /**
     * Método responsável por inserir dados no banco
     * @param  array $values [ field => value ]
     * @return integer ID inserido
     */
    public function insert($values)
    {
        //DADOS DA QUERY
        $fields = array_keys($values);
        $binds  = array_pad([],count($fields),'?');

        //MONTA A QUERY
        $query = 'INSERT INTO '.$this->table.' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';
        //EXECUTA O INSERT
        $this->execute($query,array_values($values));

        //RETORNA O ID INSERIDO
        return $this->connection->lastInsertId();
    }




    /**
     * Método responsável por fazer o upload das imagens
     * @param  array $values [ field => value ]
     * @return integer ID inserido
     */
    public function upLoadFiles($values)
    {
        $id = $values['id'];
        $files = $values['files'];
        $qtd_imagens = count($files['name']);
        for ($i=0; $i < $qtd_imagens; $i++)
        { 
            // variaveis
            $this->image['type'] = $files['type'][$i];
            $this->image['name'] = $files['name'][$i];
            $this->image['uniqid_name'] = uniqid().$this->image['name'];
            $this->image['tmp_name'] = $files['tmp_name'][$i];




            switch ($this->image['type']) {
                case 'image/jpeg':
                case 'image/pjpeg':
                    $this->image['img_type'] = 'jpeg';
                    $this->image['tmp_image'] = imagecreatefromjpeg($this->image['tmp_name']);
                    break;

                case 'image/png':
                case 'image/x-png':
                    $this->image['img_type'] = 'png';
                    $this->image['tmp_image'] = imagecreatefrompng($this->image['tmp_name']);
                    break;

                case 'image/gif':
                    $img_type = 'gif';
                    $this->image['tmp_image'] = imagecreatefromgif($this->image['tmp_name']);
                    break;
            }

            // gerar imagens do tamanho correto para serem usadas no app
            $this->resize();
        }
    }

    public function resize()
    {


        //ARRAY QUE CONTEM AS DIMENSÃO DAS ALTURAS DAS IMAGENS QUE DEVEM SER GERADAS
        $resizes=[470,360,220,100];

        


        // GERANDO IMAGENS
        foreach($resizes as $key => $newHeight)
        {
            $this->updateImage($newHeight);   
        }
    }




    public function updateImage($newHeight)
    {

        // calculo de redimencionamento
        $tmp_image = $this->image['tmp_image'];
        $originalHeight = imagesy($tmp_image);
        $originalWidth = imagesx($tmp_image);


        // CALCULO DA LARGURA
        $percentageCalc = $newHeight*100/$originalHeight;
        $newWidth = floor($percentageCalc * $originalWidth/100);


        // GERANDO IMAGEM
        $resize_image = imagecreatetruecolor($newWidth,$newHeight);
        imagealphablending($resize_image, false);
        imagesavealpha($resize_image, true);
        $transparent = imagecolorallocatealpha($resize_image, 255, 255, 255, 127);
        imagefilledrectangle($resize_image, 0, 0, $newWidth, $newHeight, $transparent);
        imagecopyresampled($resize_image, $tmp_image,0,0,0,0,$newWidth,$newHeight,$originalWidth,$originalHeight);


        
        // SE O DIRETÓRIO NÃO EXISTE CRIAR
        $directory = __DIR__."/../../public/img/products/";
        if (!file_exists($directory))
        {
            mkdir($directory, 0777, true);
        }
        $directory = $directory."h-".$newHeight."px-";


        
        // UPLOAD DA IMAGEM PARA O DIRETÓRIO
        switch ($this->image['img_type'])
        {
            case 'jpeg':
                return imagejpeg($resize_image, $directory.$this->image['uniqid_name']);
                break;
            case 'png':
                return imagepng($resize_image, $directory.$this->image['uniqid_name']);
                break;
            case 'gif':
                return imagegif($resize_image, $directory.$this->image['uniqid_name']);
                break;
        }
    
    }



    /**
     * Método responsável por executar uma consulta no banco
     * @param  string $where
     * @param  string $order
     * @param  string $limit
     * @param  string $fields
     * @return PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //DADOS DA QUERY
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $limit = strlen($limit) ? 'LIMIT '.$limit : '';

        //MONTA A QUERY
        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where.' '.$order.' '.$limit;

        //EXECUTA A QUERY
        return $this->execute($query);
    }




    /**
     * Método responsável por executar atualizações no banco de dados
     * @param  string $where
     * @param  array $values [ field => value ]
     * @return boolean
     */
    public function update($where,$values)
    {
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA A QUERY
        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

        //EXECUTAR A QUERY
        $this->execute($query,array_values($values));

        //RETORNA SUCESSO
        return true;
    }

    /**
     * Método responsável por excluir dados do banco
     * @param  string $where
     * @return boolean
     */
    public function delete($where){
    //MONTA A QUERY
    $query = 'DELETE FROM '.$this->table.' WHERE '.$where;

    //EXECUTA A QUERY
    $this->execute($query);

    //RETORNA SUCESSO
    return true;
    }
}