<?php 

class Conect_DB{

    protected $dbname;
    protected $dbuser;
    protected $dbpass;
    protected $db;
    
    function __construct($db__name,$db__user,$db__pass){
        //コンストラクタ
        //データベース名、ユーザー名、パスワードを保持する
        $this->dbname=$db__name;
        $this->dbuser=$db__user;
        $this->dbpass=$db__pass;
    }
    public function conect(){
        //データベースとの接続
        $this->db = new PDO('mysql:host=localhost;dbname='. $this->dbname .';charset=utf8', $this->dbuser, $this->dbpass);
    }
    public function get($dbtable){       
        //テーブルの全データを抜き出す
        $get = $this->db->query('SELECT * FROM '.$dbtable);
        return $get;
    }
    public function add($dbtable,$ad_data){
        //テーブルにデータを追加する
        $str_data='';
        //データが配列の場合複数データを追加できるように文字列の結合を行う
        if(is_array($ad_data)){
            
            foreach($ad_data as $data){
                //データが数字か文字かの判定を行う
                if(ctype_digit($data)){
            
                    $str_data = $str_data . $data . ', ';                    
            
                }else{
                    //文字の場合''でかこむ
                    $str_data = $str_data ."'". $data ."'". ', ';                            
            
                }
            }
            //最後に末尾から余分な結合文字を取り除く
            $str_data = rtrim($str_data, ', ');

        }else{
        //データが1つだけの場合
            $str_data=$ad_data;  
        
        }
        $add = $this->db->query('INSERT INTO '. $dbtable .' values('. $str_data .')');            
    }
    public function delete($db_table,$del_calam,$del_data){
        //カラム1に対して該当したものを削除する
        $del = $this->db ->prepare('DELETE FROM :dbtable WHERE :delcalam=:deldata');
        $del ->bindParam(':dbtable',$db_table);
        $del ->bindParam(':delcalam',$del_calam);
        $del ->bindParam(':deldata',$del_data);        
        $del ->execute();
        }
    public function drop_table($dbtable){
        //テーブルの削除
        $dro = $this->db ->query('DROP TABLE '.$dbtable);
    }
}

