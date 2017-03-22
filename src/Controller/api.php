<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 23.03.2017
 * Time: 11:56
 */

/**
 * @SWG\Swagger(
 *      @SWG\Info(
 *          version="1.0.0",
 *          title="Swagger Posts",
 *          @SWG\Contact(
 *              email="kostya_nagula@mail.ua"
 *          )
 *      ),
 *      host="dcodeit.net",
 *      basePath="/kostya.nagula/project/restProject",
 *      schemes={"http"},
 *      produces={"application/json"},
 *      consumes={"application/json"},
 *      @SWG\ExternalDocumentation(
 *          description="Find more information",
 *          url="https://swagger.io/about"
 *      ),
 *      @SWG\Definition(
 *          definition="ErrorModel",
 *          type="object",
 *          required={"code", "message"},
 *          @SWG\Property(
 *              property="code",
 *              type="integer",
 *              format="int32"
 *          ),
 *          @SWG\Property(
 *              property="message",
 *              type="string"
 *          )
 *      ),
 *     @SWG\Definition(
 *          definition="Post",
 *          type="object",
 *          allOf={
 *              @SWG\Schema(
 *                  required={"title", "content"},
 *                  @SWG\Property(property="title", type="string"),
 *                  @SWG\Property(property="content", type="string")
 *              ),
 *          }
 *     )
 * )
 */