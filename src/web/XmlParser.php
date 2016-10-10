<?php
/**
 * @link http://www.tintsoft.com/
 * @copyright Copyright (c) 2012 TintSoft Technology Co. Ltd.
 * @license http://www.tintsoft.com/license/
 */
namespace yuncms\system\web;

use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\RequestParserInterface;

/**
 * Parses a raw HTTP request
 *
 * To enable parsing for Xml requests you can configure [[Request::parsers]] using this class:
 *
 * ```php
 * 'request' => [
 *     'parsers' => [
 *         'application/xml' => 'yii\web\XmlParser',
 *     ]
 * ]
 * ```
 *
 * @author Dan Schmidt <danschmidt5189@gmail.com>
 * @since 2.0
 */
class XmlParser implements RequestParserInterface
{
    /**
     * @var boolean whether to return objects in terms of associative arrays.
     */
    public $asArray = true;
    /**
     * @var boolean whether to throw a [[BadRequestHttpException]] if the body is invalid json
     */
    public $throwException = true;


    /**
     * Parses a HTTP request body.
     * @param string $rawBody the raw HTTP request body.
     * @param string $contentType the content type specified for the request body.
     * @return array parameters parsed from the request body
     * @throws BadRequestHttpException if the body contains invalid json and [[throwException]] is `true`.
     */
    public function parse($rawBody, $contentType)
    {
        try {
            $parameters = simplexml_load_string($rawBody, 'SimpleXMLElement', LIBXML_NOCDATA);
            $parameters = $this->asArray ? (array) $parameters : $parameters;
            return $parameters === null ? [] : $parameters;
        } catch (InvalidParamException $e) {
            if ($this->throwException) {
                throw new BadRequestHttpException('Invalid XML data in request body: ' . $e->getMessage());
            }
            return [];
        }
    }
}