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
use App\DateTime;

/**
 * Class CRUD
 *
 * Component for work with posts
 */
class Post
{
    /**
     * @var int $postCount stored count post into database
     */
    private $postCount;

    /**
     * Get post count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->postCount;
    }

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

    public function getPostCount()
    {
        $db = Db::connect();

        $sql = 'SELECT id FROM post';

        $query = $db->prepare($sql);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        return count($result);
    }

    /**
     * Get list post by limit count
     *
     * @param $offset
     * @return array
     */
    public function getListPost($offset = null)
    {
        $db = Db::connect();

        $this->postCount = $this->getPostCount();

        $sql = 'SELECT post.id, post.title, post.content, user.name as author, post.created_at FROM post INNER JOIN user ON post.author = user.id LIMIT 20';

        if ($offset) {
            $sql = 'SELECT post.id, post.title, post.content, user.name as author, post.created_at FROM post INNER JOIN user ON post.author = user.id LIMIT 20 OFFSET ' . $offset;
        }

        $query = $db->prepare($sql);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $result = $this->convertDate($result);

        return $result;
    }

    /**
     * Calculate time after created post
     *
     * @param $post
     * @return false|string
     */
    public function calculatePostCreated($post)
    {
        $diffTime = TIME - $post->created_at;

        if ($diffTime > DateTime::MONTH) {
            return gmdate("m-d H:i:s", $diffTime);
        }

        if ($diffTime > DateTime::DAY) {
            return gmdate("d H:i:s", $diffTime);
        }

        if ($diffTime > DateTime::HOUR) {
            return gmdate("H:i:s", $diffTime);
        }

        if ($diffTime > DateTime::MINUTE) {
            return gmdate("i:s", $diffTime);
        }

        if ($diffTime > DateTime::SECOND) {
            return gmdate("s", $diffTime);
        }
    }

    /**
     * Converted Date
     *
     * Converted created_at date value from unix time to datetime
     *
     * @param $postList
     * @return mixed
     */
    public function convertDate($postList)
    {
        foreach ($postList as $post) {
            $this->calculatePostCreated($post);
            $post->created_at = $this->calculatePostCreated($post);
        }

        return $postList;
    }

    /**
     * Concatenate post id list
     *
     * Concatenate post id list for use into sql query
     *
     * @param $list
     * @return string
     */
    public function concatPostIdList($list)
    {
        $param = null;

        foreach ($list as $item) {
            $param = $param . ', ' . $item;
        }

        return trim($param, ', ');
    }

    /**
     * Get post list by list id posts
     *
     * @param $list
     * @return array|mixed
     */
    public function getPostsByIdList($list)
    {
        $db = Db::connect();

        $param = $this->concatPostIdList($list);

        $sql = "SELECT post.id, post.created_at FROM post WHERE post.id IN ($param)";

        $query = $db->prepare($sql);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $result = $this->convertDate($result);

        return $result;
    }

    /**
     * Order post by params
     *
     * @param $column
     * @param $param
     * @param $limit
     * @return array|mixed
     */
    public function orderPostByParams($column, $param, $limit)
    {
        $db = Db::connect();

        $sql = "SELECT post.id, post.title, post.content, user.name as author, post.created_at FROM post INNER JOIN user ON post.author = user.id ORDER BY $column $param LIMIT $limit";

        $query = $db->prepare($sql);

        $query->execute();

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $result = $this->convertDate($result);

        return $result;
    }
}