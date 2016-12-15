<?php
/**
 * File for IdToPath class
 */

namespace common\components;

/**
 * Class IdToPath
 * @package common\components
 * @author Yurii Gugnin <yurii.gugnin@p-product.com>
 */
class IdToPath
{
    /**
     * Get full name of path
     *
     * @param $id
     * @param null $basePath
     * @param bool $createIfNotExists
     * @param bool $fullName
     * @return bool|string
     */
    public static function get($id, $basePath = null, $createIfNotExists = true, $fullName = false, $toUrl = false)
    {
        if (!$basePath) {
            $basePath = \Yii::getAlias(\Yii::$app->params['imagePath']);

        }
        if (!file_exists($basePath)) {
            $pathToCreate = '';
            if($createIfNotExists){
                $way = explode(DIRECTORY_SEPARATOR, $basePath);

                foreach ($way as $k => $path) {
                    if(!$k && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'){
                        $pathToCreate .= $path;
                    } else {
                        $pathToCreate .= DIRECTORY_SEPARATOR . $path;
                    }
                    if (file_exists($pathToCreate)) {
                        continue;
                    }
                    if (!mkdir($pathToCreate)) {
                        return false;
                    }
                }
            }
            if (!file_exists($basePath)) {
                return false;
            }
        }
        $way = str_split((string)$id);
        $fullPath = $basePath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $way);
        if (file_exists($fullPath) || !$createIfNotExists) {
            return $fullName ? $fullPath : implode($toUrl ? '/' : DIRECTORY_SEPARATOR, $way);
        }
        $pathToCreate = $basePath;
        foreach ($way as $k => $path) {
            $pathToCreate .= DIRECTORY_SEPARATOR . $path;
            if (file_exists($pathToCreate)) {
                continue;
            }
            if (!mkdir($pathToCreate)) {
                return false;
            }
        }
        return $fullName ? $fullPath : implode($toUrl ? '/' : DIRECTORY_SEPARATOR, $way);
    }

    /**
     * Remove path
     *
     * @param $id
     * @param $basePath
     * @return bool
     */
    public static function removePath($id, $basePath)
    {
        if (!$id) {
            return false;
        }
        if (!file_exists($basePath)) {
            return false;
        }
        $way = str_split((string)$id);
        while ($way) {
            $pathToRemove = $basePath . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $way);
            if (file_exists($pathToRemove) && self::isDirEmpty($pathToRemove)) {
                rmdir($pathToRemove);
                array_pop($way);
            } else {
                break;
            }
        }
        return true;
    }

    /**
     * Check weather is dir is empty
     *
     * @param $dir
     * @return bool|null
     */
    public static function isDirEmpty($dir)
    {
        if (!is_readable($dir)) return NULL;
        return (count(scandir($dir)) == 2);
    }
}