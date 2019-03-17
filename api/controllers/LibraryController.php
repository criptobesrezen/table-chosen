<?php
//PHP код таблицы
class library
{
    private $db;
    public function __construct()
    {
        // Подключение к базе данных таблица Библиотеки
        include 'api/controllers/ConnectionController.php';
        $this->db = (new connection())->open();

        switch ( $_GET["action"] )
        {
            case "addform":
                $this->add_form();    // Форма для добавления новой записи
                break;
            case "add":
                $this->add();             // Добавить новую запись в таблицу БД
                break;
            case "editform":
                $this->edit_form();   // Форма для редактирования записи
                break;
            case "update":
                $this->update();          // Обновить запись в таблице БД
                break;
            case "delete":
                $this->delete();          // Удалить запись в таблице БД
                break;
            default:
                $this->show_list();             // Список всех записей в таблице БД
        }
    }

    /**
     * Функция выводит список всех записей в таблице БД
     */
    public function show_list()
    {
        $query = 'SELECT id, book, author FROM library WHERE 1';
        $res = $this->db->query($query);
        ?>
        <h2>Библиотека</h2>
        <table cellpadding="2" cellspacing="0">
            <thead>
            <tr>
                <th>Книга</th>
                <th>Автор</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <?php
            while ($item = mysqli_fetch_array($res)) {
                ?>
                <tbody>
                <tr>
                    <td><?= $item['book'] ?></td>
                    <td><?= $item['author'] ?></td>
                    <td>
                        <a href="<?=$_SERVER['PHP_SELF']?>?action=editform&id=<?=$item['id']?>">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true">Ред.</span>
                        </a>
                    </td>
                    <td>
                        <a href="<?=$_SERVER['PHP_SELF']?>?action=delete&id=<?=$item['id']?>">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true">Удл.</span>
                        </a>
                    </td>
                </tr>
                </tbody>
                <?php
            }
            ?>
            <tfoot>
            <tr>
                <td><a href="addauthors.php"><span class="glyphicon glyphicon-plus" aria-hidden="true">Автора</span></a>
                </td>
                <td></td>
                <td></td>
                <td>
                    <p>
                        <a href="<?=$_SERVER['PHP_SELF']?>?action=addform">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true">Доб.</span>
                        </a>
                    </p>
                </td>
            </tr>
            </tfoot>
        </table>
        <?php
    }


    /**
     * Функция формирует форму для добавления записи в таблице БД
     */
    public function add_form()
    {
        ?>
        <h2>Добавить</h2>
        <form name="addform" action="<?=$_SERVER['PHP_SELF']?>?action=add" method="POST">
            <table>
                <tr>
                    <td>Книга</td>
                    <td><input name="book" type="text" data-placeholder="Название книги"/></td>
                </tr>
                <tr>
                    <td>Автор</td>
                    <td><select name="author" type="text" data-placeholder="Автор" multiple class="chosen-select">
                            <?php
                            $query = "SELECT * FROM `authors`";
                            $aut = $this->db->query($query);
                            if (!$aut) {
                                echo "ошибка запроса";
                            }
                            if (mysqli_num_rows($aut) > 0) {
                                while ($authors = mysqli_fetch_array($aut)) {
                                    echo "<option value='" . $authors['author'] . "'>" . $authors['author'] . "</option>";
                                }
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Сохранить"></td>
                    <td>
                        <button type="button" onClick="history.back();">Отменить</button>
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }


    /**
     * Функция добавляет новую запись в таблицу БД
     */
    public function add()
    {
        $book = mysqli_escape_string( $_POST['book'] );
        $author = mysqli_escape_string( $_POST['author'] );
        $query = "INSERT INTO library (book, author) VALUES ('".$book."', '".$author."');";
        $this->db->query ( $query );
        header( 'Location: '.$_SERVER['PHP_SELF'] );
        die;
    }


    /**
     * Функция формирует форму для редактирования записи в таблице БД
     */
    public function edit_form()
    {
        $query = 'SELECT book, author FROM library WHERE id=' . $_GET['id'];
        $res = $this->db->query($query);
        $item = mysqli_fetch_array($res);
        ?>
        <h2>Редактировать</h2>
        <form name="editform" action="<?=$_SERVER['PHP_SELF']?>?action=update&id=<?=$_GET['id']?>" method="POST">
            <table>
                <tr>
                    <td>Книга</td>
                    <td><input name="book" type="text" value="<?=$item['book']?>" placeholder="Название книги"/></td>
                </tr>
                <tr>
                    <td>Автор</td>
                    <td><select name="author" type="text" data-placeholder="Автор" multiple class="chosen-select">
                            <?php
                            $query = "SELECT * FROM `authors`";
                            $aut = $this->db->query($query);
                            if (!$aut) {
                                echo "ошибка запроса";
                            }
                            if (mysqli_num_rows($aut) > 0) {
                                while ($authors = mysqli_fetch_array($aut)) {
                                    ?>
                                    <option value="<?= $authors['author'] ?>"><?= $authors['author'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td><input type="submit" value="Сохранить"></td>
                    <td>
                        <button type="button" onClick="history.back();">Отменить</button>
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }

    /**
     * Функция обновляет запись в таблице БД
     */
    public function update()
    {
        $book = mysqli_escape_string( $this->db, $_POST['book'] );
        $author = mysqli_escape_string( $this->db, $_POST['author'] );
        $id = $_GET['id'];
        $query = "UPDATE library SET book=".$book.", author=".$author." WHERE id=".$id;
        $this->db->query ( $query );
        header('Location: '.$_SERVER['PHP_SELF']);
        die;
    }

    /**
     * Функция удаляет запись в таблице БД
     */
    public function delete()
    {
        $query = "DELETE FROM library WHERE id=".$_GET['id'];
        $this->db->query ( $query );
        header( 'Location: '.$_SERVER['PHP_SELF'] );
        die();
    }

}





