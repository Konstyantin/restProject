<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2017
 * Time: 13:24
 */

namespace Acme\Entity;

use PDO;
use App\Db;

/**
 * Class User
 *
 * Component for work with users
 */
class User
{
    /**
     * @var int $userId
     */
    private $userId;

    /**
     * UserEntity constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->userId = $id;
    }

    /**
     * Get property userId
     *
     * @return int
     */
    public function getId()
    {
        return $this->userId;
    }

    /**
     * Get user token by user id
     *
     * Return token and token expire
     *
     * @return mixed
     */
    public function getUserTokenData()
    {
        $db = Db::connect();
        $sql = "SELECT token, token_expire FROM user WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $this->userId, PDO::PARAM_INT);
        $result->execute();

        return $result->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Update user token
     *
     * Set new token for user
     *
     * @param string $token
     * @return bool
     */
    public function updateUserToken(string $token)
    {
        $db = Db::connect();
        $sql = "UPDATE user SET token = :token WHERE id = :id";

        $result = $db->prepare($sql);
        $result->bindParam(':id', $this->userId, PDO::PARAM_INT);
        $result->bindParam(':token', $token, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Get user by $token
     *
     * Return user data property username, name and id as assoc array
     *
     * @param string $token
     * @return array
     */
    public static function getUserByToken(string $token)
    {
        $db = Db::connect();
        $sql = "SELECT id, name, username FROM user WHERE token = :token";

        $result = $db->prepare($sql);
        $result->bindParam(':token', $token, PDO::PARAM_STR);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }
}