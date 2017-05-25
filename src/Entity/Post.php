<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2017
 * Time: 13:20
 */
namespace Acme\Entity;

use PDO;
use App\Db;

/**
 * Class CRUD
 *
 * Component for work with posts
 */
class Post
{
    /**
     * Create new Post with passed params
     *
     * @param string $title
     * @param string $content
     * @param string $author
     * @return \PDOStatement
     */
    public function create(string $title, string $content, string $author)
    {
        $db = Db::connect();

        $sql = "INSERT INTO post (title, content, author, created_at) VALUES (:title, :content, :author, UNIX_TIMESTAMP())";

        $result = $db->prepare($sql);
        $result->bindParam(':title', $title, PDO::PARAM_STR);
        $result->bindParam(':content', $content, PDO::PARAM_STR);
        $result->bindParam(':author', $author, PDO::PARAM_STR);

        $result->execute();

        return $result;
    }

    /**
     * Get one post by passed id
     *
     * @param int $id
     * @return mixed
     */
    public function getOne(int $id)
    {
        $db = Db::connect();
        $sql = "SELECT * FROM post WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get List exist posts
     *
     * @return array
     */
    public function getList()
    {
        $db = Db::connect();

        $sql = 'SELECT post.id,
                       post.title,
                       post.content,
                       post.created_at,
                       user.name AS author FROM post
                  INNER JOIN user ON post.author = user.id';

        $result = $db->query($sql);

        $postList = [];
        $i = 0;

        while ($row = $result->fetch()) {
            $postList[$i]['id'] = $row['id'];
            $postList[$i]['title'] = $row['title'];
            $postList[$i]['content'] = $row['content'];
            $postList[$i]['author'] = $row['author'];
            $postList[$i]['created_at'] = gmdate("Y-m-d H:i:s", $row['created_at']);
            $i++;
        }
        return $postList;
    }

    /**
     * Update exist post by id
     *
     * @param int $id
     * @param string $title
     * @param string $content
     * @return bool
     */
    public function changePost(int $id, string $title, string $content)
    {
        $db = Db::connect();
        $sql = "UPDATE post SET title = :title, content = :content WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':title', $title, PDO::PARAM_INT);
        $result->bindParam(':content', $content, PDO::PARAM_INT);

        return $result->execute();
    }


    /**
     * Update post by id
     *
     * @param int $id
     * @param string|null $title
     * @param string|null $content
     * @return bool
     */
    public function updatePost(int $id, string $title = null, string $content = null)
    {

        /**
         * Check what parameters are passed
         */
        if ($title != null && $content != null) {            /* if passed $title and $content */

            return $this->changePost($id, $title, $content);

        } elseif ($title) {                                  /* if passed only title */

            return $this->changePostTitle($id, $title);

        } elseif ($content) {                                /* if passed only content*/

            return $this->changePostContent($id, $content);
        }
    }

    /**
     * Delete post by id
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id)
    {
        $db = Db::connect();
        $sql = "DELETE FROM post WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Change title of post
     *
     * @param int $id
     * @param string $title
     * @return bool
     */
    public function changePostTitle(int $id, string $title)
    {
        $db = Db::connect();
        $sql = "UPDATE post SET title = :title WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':title', $title, PDO::PARAM_INT);

        return $result->execute();

    }

    /**
     * Change content of post
     *
     * @param int $id
     * @param string $content
     * @return bool
     */
    public function changePostContent(int $id, string $content)
    {
        $db = Db::connect();
        $sql = "UPDATE post SET content = :content WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':content', $content, PDO::PARAM_INT);

        return $result->execute();
    }

    /**
     * Get posts by params
     *
     * Get post list by sender params
     *
     * @param string|null $column
     * @param string|null $param ASC|DESC
     * @return array
     */
    public function getListOrderBy(string $column = null, string $param = null)
    {
        $db = Db::connect();

        $sql = $this->buildOrderByParams($column, $param);

        $result = $db->query($sql);

        $postList = [];
        $i = 0;

        while ($row = $result->fetch()) {
            $postList[$i]['id'] = $row['id'];
            $postList[$i]['title'] = $row['title'];
            $postList[$i]['content'] = $row['content'];
            $postList[$i]['author'] = $row['author'];
            $postList[$i]['created_at'] = gmdate("Y-m-d H:i:s", $row['created_at']);
            $i++;
        }

        return $postList;
    }

    /**
     * Build SQL query for get list
     *
     * Get Post list by table column and sort param
     *
     * @param string|null $column
     * @param string|null $param ASC|DESC
     * @return string
     */
    public function buildOrderByParams(string $column = null, string $param = null)
    {
        $param = $param ?? 'ASC';

        if ($column) {
            return "SELECT post.id AS id,
                           post.title,
                           post.content,
                           post.created_at,
                           user.name AS author FROM post
                            INNER JOIN user ON post.author = user.id
                           ORDER BY " . $column . " " . $param;
        }

        return "SELECT post.id AS id,
                       post.title,
                       post.content,
                       post.created_at,
                       user.name AS author FROM post
                        INNER JOIN user ON post.author = user.id
                       ORDER BY id" . " $param";
    }

    /**
     * Get count steps pagination
     *
     * @param int $count
     * @return float|int
     */
    public function getStepCount(int $count)
    {
        $db = Db::connect();

        $sql = 'SELECT * FROM post';

        $query = $db->prepare($sql);

        $query->execute();

        $result = $query->fetchAll(\PDO::FETCH_OBJ);

        return count($result)/$count;
    }

    /**
     * Get pagination list
     *
     * Get pagination post list by send parama
     *
     * @param $range
     * @param $pageRange
     * @param $shift
     * @param null $order
     * @param string $orderParam
     * @return array
     */
    public function getPaginationList($range, $pageRange, $shift, $order = null, $orderParam = 'ASC')
    {
        $db = Db::connect();

        $sql = 'SELECT post.id,
                       post.title,
                       post.content,
                       user.name as author,
                       post.created_at FROM post
                        INNER JOIN user ON post.author = user.id LIMIT ' . $pageRange . ' OFFSET ' .  $shift * $range;

        if ($order) {
            $sql = 'SELECT post.id,
                       post.title,
                       post.content,
                       user.name as author,
                       post.created_at FROM post
                        INNER JOIN user ON post.author = user.id ORDER BY ' . $order . ' ' . $orderParam . ' LIMIT ' . $pageRange . ' OFFSET ' .  $shift * $range;
        }
        $query = $db->prepare($sql);

        $query->execute();

        return $query->fetchAll(\PDO::FETCH_OBJ);

    }
}