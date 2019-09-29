<?php
class Database {
    private $host  = 'localhost';
    private $user  = 'id10080061_ray_of_hope_admin';
    private $password  = '3RbrLkk2VX9EipG';
    private $BD  = 'id10080061_ray_of_hope';
    private $mysqli = null;
    
    private function close(){
        if (isset($this->mysqli)){
            $this->mysqli->close();
        }
    }
    
    private function connect(){
        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->BD);
    }
    
    public function email2id($email_or_inn){
        $this->connect();
        $result = ($this->mysqli->query("SELECT user.id FROM user JOIN email ON user.email=email.id JOIN organization ON user.id=organization.user_id WHERE email.email='$email_or_inn' OR organization.INN='$email_or_inn'"));
        $id=mysqli_fetch_assoc($result)['id'];
        $this->close();
        return $id;
    }
    
    public function orgInfo($id){
        $this->connect();
        $errors=array();
        $result = ($this->mysqli->query("SELECT user.id, user.avatar, user.description, organization.docs AS docs, organization.name , organization.number_phone AS number_phone, type_of_activity.name AS type_of_activity, (SELECT city.name FROM city WHERE city.id=organization.city) AS city_name, (SELECT region.name  FROM region, city WHERE city.id=organization.city AND region.code=city.region) AS region_name, (SELECT organization.address FROM organization WHERE organization.user_id=user.id AND organization.address IS NOT NULL) AS address_id, (SELECT address.organization FROM address WHERE address.id=address_id) AS address_organization, (SELECT city.name  FROM city, address WHERE address.id=address_id AND city.id=address.id) AS address_city, (SELECT region.name  FROM region, city, address WHERE address.id=address_id AND city.id=address.id AND region.code=city.region) AS address_region, (SELECT address.street FROM address WHERE address.id=address_id) AS address_street, (SELECT address.house FROM address WHERE address.id=address_id) AS address_house, (SELECT address.housing FROM address WHERE address.id=address_id) AS address_housing, (SELECT address.building FROM address WHERE address.id=address_id) AS address_building, (SELECT address.office FROM address WHERE address.id=address_id) AS address_office FROM user INNER JOIN organization ON user.id = organization.user_id INNER JOIN type_of_activity ON organization.type_of_activity=type_of_activity.id WHERE user.id='$id'"));
        
        if ($result!=false && mysqli_num_rows($result)>0){
            $orgInfo=mysqli_fetch_assoc($result);
            $org_info=array();
            $orgInfo['avatar'] = is_null($orgInfo['avatar']) ?  "https://rayofhope-opensource.000webhostapp.com/user_data/avatar/noavatar.jpg" : "https://rayofhope-opensource.000webhostapp.com/user_data/avatar/".$orgInfo['avatar'].".jpg"; 
            $city_id=$orgInfo['city_name'];
            $docs_links=array();
            $docs_preview=array();
            if (isset($orgInfo['docs'])){
                $dir  = '../user_data/docs/'.$orgInfo['docs'];
                $catalog=opendir($dir);
                $list=array();
                while($file=readdir($catalog)){
                    if ($file != '.' && $file!='..' && $file[strlen($file)-1]!='~'){
                        $ctime=filectime("$dir/$file").','.$file;
                        $list[$ctime]=$file;
                    }
                }        
                closedir($catalog);
                ksort($list); //сортированный по дате массив файлов
                for ($i=0;$i<count($list);$i++){
                    if (!is_dir("../user_data/docs/".$id."/".array_values($list)[$i])){
                        $path_parts = pathinfo("../user_data/docs/".$id."/".array_values($list)[$i]); 
                        if (isset($path_parts['extension']) && ($path_parts['extension']=="pdf" || $path_parts['extension']=="docx")){
                            $docs_links[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/".array_values($list)[$i];
                            $docs_preview[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/preview/".$path_parts['filename'].".png";
                            continue;
                        }
                        if (isset($path_parts['extension']) &&  $path_parts['extension']=="jpg"){
                            $docs_links[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/".array_values($list)[$i];
                            $docs_preview[$i]="https://rayofhope-opensource.000webhostapp.com/user_data/docs/".$id."/".array_values($list)[$i];
                            continue;
                        }
                    }
                }
            }
            $orgInfo['docs_links']=$docs_links;
            $orgInfo['docs_preview']=$docs_preview;
            $this->close($this->mysqli);
            return $orgInfo;
        }
        else{
            $errors['not_found_org']=1;
            $this->close($this->mysqli);
            return $errors;
        }
    }
    
}
?>