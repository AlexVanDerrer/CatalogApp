<?php // backend для мобильного приложения каталога UTF-8
session_start();
require '../../conros_env.php';
require '../sys/system.php';
require '../sys/db.class.php';

//header('Content-type: multipart/form-data');
header("Access-Control-Allow-Origin: *"); //  для разрешения запросов извне (т.е. из мобильного приложения)  
header('Access-Control-Allow-Method: GET,POST');
header('Access-Control-Allow-Headers: X-Requested-With, content-type');

//if (empty($POST) ) die('bad POST request');
//if (empty($GET['book']) ) die('bad GET request');


try 
{
    $db = new database;
    $db->link->set_charset('utf8');
  
    $book_id = (int)$_REQUEST['book']; // советы - 10
    if ( empty($book_id) ) die('bad book');

    switch($_REQUEST['action'])
    {
     /*   case 'get_contents': // оглавление
            $sql = "SELECT chapter_id AS id, name, IFNULL(parent_chapter_id, 0) AS parent_id FROM typ_chapter WHERE book_id=$book_id ORDER BY chapter_id";
            $chapter = $db->sel($sql);
            break;*/
        
        case 'get_data': // получить данные таблицы

            switch ($_GET['tbl'])
            {
                case 'metal':
                    $sql = "SELECT metal_id AS id, me, name FROM metal ORDER BY sort";
                    break;
					
				case 'year':
					$sql = "SELECT DISTINCT god FROM catalog c 
								INNER JOIN typ t ON c.typ=t.typ_name
								INNER JOIN typ_chapter ch ON ch.chapter_id=t.typ_chapter_id
								WHERE ch.book_id=$book_id ORDER BY god DESC";
					break;

                case 'nominal':
                    $sql = "SELECT DISTINCT nominal FROM catalog c 
								INNER JOIN typ t ON c.typ=t.typ_name
								INNER JOIN typ_chapter ch ON ch.chapter_id=t.typ_chapter_id
								WHERE ch.book_id=$book_id ORDER BY nominal";
					break;
                    
                case 'condition': // состояния монет
                    $sql = "SELECT * FROM app_coin_condition ORDER BY id";
                    break;

                case 'contents': // содержание
                    $sql = "SELECT chapter_id AS id, name, IFNULL(parent_chapter_id, 0) AS parent_id, has_types FROM typ_chapter WHERE book_id=$book_id ORDER BY chapter_id";
                    break;

                case 'types': // типы
                    $chapter = (int)$_GET['param'];
                    $sql = "SELECT t.typ_id AS id, t.typ_name AS name, t.typ_chapter_id AS chapter_id, t.typ_label AS label, t.typ_title AS title "
                         . " FROM typ t"
                         . " INNER JOIN typ_chapter ch ON ch.chapter_id=t.typ_chapter_id"
                        . " WHERE ch.book_id=$book_id "
                        . ( empty($chapter) ? '' : " AND typ_chapter_id=$chapter " )
                        . " ORDER BY t.typ_id";
                    break;

                case 'kinds': // виды
                    $type = mb_substr($_GET['param'], 0, 10);
                    $kind = mb_substr($_GET['param2'], 0, 10);
                    
                    $sql = "SELECT c.vidsort, c.typ, c.vid, c.nominal, c.god,"
                         . " IFNULL(c.dvor, '') AS dvor, IFNULL(c.minz, '') AS minz, IFNULL(c.graver, '') AS graver,"
                         . " IFNULL(c.priznaki, '') AS priznaki, IFNULL(c.service_priz, '') AS service_priz, IFNULL(c.gurt, '') AS gurt,"
                         . " IFNULL(c.cena, '') AS cena, IFNULL(c.met, '') AS met, IFNULL(c.proba, '') AS proba, IFNULL(c.ves, '') AS ves,"
                         . " IFNULL(c.vid_img_avers, '') AS avers, IFNULL(c.vid_img_revers, '') AS revers"
                         . " FROM catalog c "
                        . " INNER JOIN typ t ON c.typ=t.typ_name"
                        . " INNER JOIN typ_chapter ch ON ch.chapter_id=t.typ_chapter_id"
                        . " WHERE ch.book_id=$book_id"
                        . ( empty($type) ? '' : " AND c.typ='" . $db->escape_str($type) . "' " )
                        . ( empty($kind) ? '' : " AND c.vid='" . $db->escape_str($kind) . "' " )    
                        . " ORDER BY c.vidsort";
                  //die($sql);
                    break;
                    
                case 'search': // поиск
                    $nominal = mb_substr($_GET['param'], 0, 50); 
                    $year = mb_substr($_GET['param2'], 0, 20);
                    $metall = mb_substr($_GET['param3'], 0, 15);
                    
                    $sql = "SELECT c.vidsort, c.typ, c.vid, c.nominal, c.god, t.typ_label, ch.name,"
                         . " IFNULL(c.dvor, '') AS dvor, IFNULL(c.minz, '') AS minz, IFNULL(c.graver, '') AS graver,"
                         . " IFNULL(c.priznaki, '') AS priznaki, IFNULL(c.service_priz, '') AS service_priz, IFNULL(c.gurt, '') AS gurt,"
                         . " IFNULL(c.cena, '') AS cena, IFNULL(c.met, '') AS met, IFNULL(c.proba, '') AS proba, IFNULL(c.ves, '') AS ves,"
                         . " IFNULL(c.vid_img_avers, '') AS avers, IFNULL(c.vid_img_revers, '') AS revers"
                         . " FROM catalog c"
                        . " INNER JOIN typ t ON c.typ=t.typ_name"
                        . " INNER JOIN typ_chapter ch ON ch.chapter_id=t.typ_chapter_id"
                        . " WHERE ch.book_id=$book_id"
                        . ( empty($nominal) ? '' : " AND c.nominal='" . $db->escape_str($nominal) . "' " )
                        . ( empty($year) ? '' : " AND c.god='" . $db->escape_str($year) . "' " )
                        . ( empty($metall) ? '' : " AND c.met='" . $db->escape_str($metall) . "' " )    
                        . " ORDER BY c.typ";
                  //die($sql);
                    break;
                    
                case 'check_email': // проверка email
                    $email = mb_substr($_GET['email'], 0, 50);
                    $sql = "SELECT COUNT(*) FROM app_customers WHERE email='".$db->escape_str($email)."'";
                    break;
                
                default:
                    die('bad table');  
            }

            $rows = $db->sel($sql);
            if (empty($rows)) die(false);
            
            print json_encode($rows);//backend_encode_response($rows);
           
            break;

		case 'get_pic_info': // получить информацию об изображении
			$pic_name = trim($_GET['pic_name']);
			$pic_name = str_replace('-', '+', $pic_name);
			$array = getimagesize(CAT_IMG_URI . $pic_name);
			$pic['width'] = $array[0];
			$pic['height'] = $array[1];
			print json_encode($pic);
			break;
            
        case 'request': // REST API
 
            $response = ['status' => true, 'message' => 'Good request'];
            print json_encode($response);
           
            break;
        /**  Регистрация нового пользователя приложения*/
        case 'registration':
            $email = mb_substr($_POST['email'], 0, 50);
            $hash = md5($_POST['email'].'conros'); // хэш с солью
            $pwd = md5(mb_substr($_POST['pwd'], 0, 50));
            
            $sql = "INSERT INTO app_customers (email, hash, pass) VALUES ('$email',  '$hash', '$pwd')";
            
            $res = $db->sql($sql);
            // if ($res == false) die('Ошибка записи');
            
            $response = ['status' => true, 'hash' => md5($email)];
            print json_encode($response);
            
            break;
            
        /** Авторизация пользователя*/
        case 'auth':
            $email = mb_substr($_POST['email'], 0, 50);
            $pwd = md5(mb_substr($_POST['pwd'], 0, 50));
            
            $sql = "SELECT email, pass FROM app_customers WHERE email = '$email' AND pass = '$pwd'";
            
            $rows = $db->sel($sql);
            if (empty($rows)) {
                $response = ['status' => false, 'message' => 'Не авторизован'];
                print json_encode($response);
            } else {
                $response = ['status' => true, 'hash' => md5($email.'conros')];
                print json_encode($response);
            }
            break;
            
        /** Выборка монет пользователя*/
        case 'get_customer_coins':
            $hash = $_GET['hash'];
            $id = @$_GET['id'];
            
            $sql = "SELECT  c.vidsort, c.typ, c.vid, c.nominal, c.god, t.typ_label, ch.name AS chapt_name, coins.id AS cust_coin_id,
                            IFNULL(c.dvor, '') AS dvor, IFNULL(c.minz, '') AS minz, IFNULL(c.graver, '') AS graver,
                            IFNULL(c.priznaki, '') AS priznaki, IFNULL(c.service_priz, '') AS service_priz, IFNULL(c.gurt, '') AS gurt,
                            IFNULL(c.cena, '') AS cena, IFNULL(c.met, '') AS met, IFNULL(c.proba, '') AS proba, IFNULL(c.ves, '') AS ves,
                            IFNULL(c.vid_img_avers, '') AS avers, IFNULL(c.vid_img_revers, '') AS revers
                    FROM catalog c 
                    INNER JOIN app_cust_coins coins ON c.typ=coins.coin_typ AND c.vid=coins.coin_vid 
                    INNER JOIN app_customers cust ON coins.cust_id=cust.id
                    INNER JOIN typ t ON c.typ=t.typ_name
                    INNER JOIN typ_chapter ch ON ch.chapter_id=t.typ_chapter_id
                    WHERE cust.hash='$hash'".( empty($id) ? '' : " AND coins.id=$id" );
                    
            $rows = $db->sel($sql);
            if (empty($rows)) die(false);
            
            print json_encode($rows);
           
            break;
        case 'add_cust_coin':
            $hash = $_POST['hash'];
            $typ =  $_POST['typ'];
            $vid = $_POST['vid'];
            
            $sql = "INSERT INTO app_cust_coins (cust_id, coin_typ, coin_vid) VALUES ((SELECT id FROM app_customers WHERE hash = '$hash' LIMIT 1), '$typ', '$vid');";
            $db->sql($sql);
            
            $response = ['status' => true];
            print json_encode($response);
            break;
           
        case 'del_cust_coin':
            $coin_id = $_POST['id'];
            $hash = $_POST['hash'];    
            
            $sql = "DELETE FROM app_cust_coins WHERE id = $coin_id AND cust_id = (SELECT id FROM app_customers WHERE hash = '$hash' LIMIT 1);";
            $db->sql($sql);
            
            $response = ['status' => true];
            print json_encode($response);
            break;

        default:
            die('bad action');
    }
    
} 
catch (Exception $ex) 
{
       if (DEBUG_MODE === true)
        exit( $ex->getFile() . ':' . $ex->getLine() . ': ' . $ex->getCode() . ' ' . win_2_utf( $ex->getMessage() ) );
    else {    
        log_exception($ex->getCode(), 'mobile/backend: ' . $ex->getMessage(), $ex->getFile(), $ex->getLine());
        exit('Unexpected error...');
    }    
}

$db->close();