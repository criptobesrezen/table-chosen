<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Добавить автора</title>
      
    <!-- Подключение Chosen -->
    <link href="css/chosen.css" type="text/css" rel="stylesheet">
    <link href="chosen/docsupport/style.css" rel="stylesheet">
    <link href="chosen/docsupport/prism.css" rel="stylesheet">
    <!-- <script src="js/chosen.jquery.js" type="text/javascript"></script> -->
    <script src="js/chosen.proto.js" type="text/javascript"></script>
    <script type="text/javascript">$(".chosen-select").chosen();</script>
    
    <style type="text/css" media="all">
        /* fix rtl for demo */
        .chosen-rtl .chosen-drop { left: -9000px; }
    </style>  
    
    <!-- Подключение Bootstrap -->
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.js" type="text/javascript"></script>

    <!-- Файл стилей -->
    <link href="css/style.css" type="text/css" rel="stylesheet">

    <!-- JQuery -->
    <script src="js/jquery-3.1.1.js" type="text/javascript"></script>
      
    <!-- Подключение шрифтов -->
    <link href="https://fonts.googleapis.com/css?family=Marck+Script" rel="stylesheet">

    <!-- Favicon -->
    <link href="/images/favicon.png" type="image/png" rel="shortcut icon">
    
    </head>
    <body>
        
        <!-- Меню навигации на сайте -->

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Библиотека</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Главная</a></li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>      
        
<?php    
    include 'connection.php';
    $MySQLConnection = mysql_connect($host, $user, $password);
    $MySQLSelectedDB = mysql_select_db($datebase, $MySQLConnection);
    mysql_query('SET NAMES utf8');
    $MySQLRecordSet = mysql_query('SELECT * FROM authors');
    
if ( !isset( $_GET["action"] ) ) $_GET["action"] = "showlist";  
  
switch ( $_GET["action"] ) 
{ 
  case "showlist":    // Список всех записей в таблице БД
    show_list();
        break; 
  case "addform":     // Форма для добавления новой записи 
    get_add_item_form();
        break; 
  case "add":         // Добавить новую запись в таблицу БД
    add_item();
        break;
  case "editform":    // Форма для редактирования записи 
    get_edit_item_form();
        break; 
  case "update":      // Обновить запись в таблице БД
    update_item();
        break; 
  case "delete":      // Удалить запись в таблице БД
    delete_item();
        break;
  default: 
    show_list(); 
}

// Функция выводит список всех записей в таблице БД
function show_list() 
{ 
  $query = 'SELECT id, author FROM authors WHERE 1'; 
  $res = mysql_query( $query ); 
  echo '<h2>Добавление Авторов</h2>'; 
  echo '<table cellpadding="2" cellspacing="0">'; 
  echo '<thead>
            <tr>
                <th>Автор</th>
                <th></th>
                <th></th>
            </tr>
        </thead>';
  while ( $item = mysql_fetch_array( $res ) ) 
  { 
    echo '<tbody>';
    echo '<tr>'; 
    echo '<td>'.$item['author'].'</td>'; 
    echo '<td>
            <a href="'.$_SERVER['PHP_SELF'].'?action=editform&id='.$item['id'].'">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true">Ред.</span>
            </a>
          </td>'; 
    echo '<td>
            <a href="'.$_SERVER['PHP_SELF'].'?action=delete&id='.$item['id'].'">
                <span class="glyphicon glyphicon-remove" aria-hidden="true">Удл.</span>
            </a>
          </td>'; 
    echo '</tr>'; 
    echo '</tbody>';
  } 
    echo '<tfoot>
            <tr>
                <td><p><a href="index.php"><span class="glyphicon glyphicon-arrow-left" aria-hidden="true">Назад</span></a></p></td>
                <td></td>
                <td>
                    <p>
                        <a href="'.$_SERVER['PHP_SELF'].'?action=addform">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true">Доб.</span>
                        </a>
                    </p>
                </td>
                </tr></tfoot>';  
    echo '</table>';
} 

// Функция формирует форму для добавления записи в таблице БД 
function get_add_item_form() 
{ 
  echo '<h2>Добавить</h2>';  
  echo '<form name="addform" action="'.$_SERVER['PHP_SELF'].'?action=add" method="POST">'; 
  echo '<table>'; 
  echo '<tr>'; 
  echo '<td>Автор</td>'; 
  echo '<td><input name="author" type="text" data-placeholder="Автор" /></td>'; 
  echo '</tr>'; 
  echo '<tr>'; 
  echo '<td><input type="submit" value="Сохранить"></td>'; 
  echo '<td><button type="button" onClick="history.back();">Отменить</button></td>'; 
  echo '</tr>'; 
  echo '</table>'; 
  echo '</form>'; 
}

// Функция добавляет новую запись в таблицу БД  
function add_item() 
{ 
  $author = mysql_escape_string( $_POST['author'] ); 
  $query = "INSERT INTO authors (author) VALUES ('".$author."');"; 
  mysql_query ( $query ); 
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
}

    
// Функция формирует форму для редактирования записи в таблице БД 
function get_edit_item_form() 
{ 
  echo '<h2>Редактировать</h2>';
  $query = 'SELECT author FROM authors WHERE id='.$_GET['id']; 
  $res = mysql_query( $query ); 
  $item = mysql_fetch_array( $res ); 
  echo '<form name="editform" action="'.$_SERVER['PHP_SELF'].'?action=update&id='.$_GET['id'].'" method="POST">';
  echo '<table>'; 
  echo '<tr>'; 
  echo '<td>Автор</td>'; 
  echo '<td><input name="author" type="text" value="'.$item['author'].'" data-placeholder="Имя автора"></input></td>'; 
  echo '</tr>'; 
  echo '<tr>'; 
  echo '<td><input type="submit" value="Внести"></td>'; 
  echo '<td><button type="button" onClick="history.back();">Отменить</button></td>'; 
  echo '</tr>'; 
  echo '</table>'; 
  echo '</form>';
} 

// Функция обновляет запись в таблице БД  
function update_item() 
{ 
  $author = mysql_escape_string( $_POST['author'] ); 
  $query = "UPDATE authors SET author='".$author."' 
            WHERE id=".$_GET['id']; 
  mysql_query ( $query ); 
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 

// Функция удаляет запись в таблице БД 
function delete_item() 
{ 
  $query = "DELETE FROM authors WHERE id=".$_GET['id']; 
  mysql_query ( $query ); 
  header( 'Location: '.$_SERVER['PHP_SELF'] );
  die();
} 
  

?>
    </body>
</html>

