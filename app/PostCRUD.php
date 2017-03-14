<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 14.03.2017
 * Time: 14:23
 */

namespace App;

use PDO;

/**
 * Class CRUD
 * @package App
 */
class PostCRUD
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

        $sql = "INSERT INTO post (title, content, author) VALUES (:title, :content, :author)";

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
        $sql = 'SELECT * FROM post';
        $result = $db->query($sql);
        $postList = [];
        $i = 0;

        while ($row = $result->fetch()) {
            $postList[$i]['id'] = $row['id'];
            $postList[$i]['title'] = $row['title'];
            $postList[$i]['content'] = $row['content'];
            $postList[$i]['author'] = $row['author'];
            $postList[$i]['created_at'] = $row['created_at'];
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
        if ($title != null && $content != null) {           /* if passed $title and $content */

            return $this->changePost($id, $title, $content);

        } elseif($title) {                                  /* if passed only title */

            return $this->changePostTitle($id, $title);

        } elseif ($content) {                               /* if passed only content*/

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
        $db  = Db::connect();
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

    public function test()
    {
        echo 'test';
    }
}