<?php

namespace GOODWILLRUN\GridBundle\Controller;


use DieSchittigs\ContaoContentApiBundle\ContaoJson;

class ApiEnhancer
{
    private static function resolveRSCEData($cte)
    {
        if ($cte->rsce_data) {
            if ($cte->rsce_data && substr($cte->rsce_data, 0, 1) === '{') {
                $data = json_decode($cte->rsce_data);
            }
            $data = self::deserializeDataRecursive($data);

            foreach ($data as $key => $value) {
                $cte->$key = $value;
            }
            $cte->rsce_data = null;
            unset($cte->rsce_data);
        }
    }

    public static function apiContaoJson(ContaoJson $contaoJson, $data)
    {
        self::resolveRSCEData($data);
        return true;
    }

    public static function apiResponse($page)
    {
        $startElements = $GLOBALS['TL_WRAPPERS']['start'];
        $stopElements = $GLOBALS['TL_WRAPPERS']['stop'];
        $singleElements = $GLOBALS['TL_WRAPPERS']['single'];
        $separatorElements = $GLOBALS['TL_WRAPPERS']['separator'];
        if ($page->articles)
            foreach ($page->articles as $columns) {
                foreach ($columns as $article) {
                    foreach ($article->content as $cte) {
                        $type = $cte->type;
                        if (in_array($type, $startElements)) {
                            $cte->wrapper = "start";
                        } else if (in_array($type, $stopElements)) {
                            $cte->wrapper = "stop";
                        } else if (in_array($type, $singleElements)) {
                            $cte->wrapper = "single";
                        } else if (in_array($type, $separatorElements)) {
                            $cte->wrapper = "separator";
                        } else {
                            $cte->wrapper = null;
                        }
                        //self::resolveRSCEData($cte);
                    }
                }
            }

        return $page;
    }

    /**
     * Deserialize all data recursively
     *
     * @param array|object $data data array or object
     * @return array|object       data passed in with deserialized values
     */
    protected static function deserializeDataRecursive($data)
    {
        foreach ($data as $key => $value) {
            if (is_string($value) && trim($value)) {
                if (is_object($data)) {
                    $data->$key = \StringUtil::deserialize($value);
                } else {
                    $data[$key] = \StringUtil::deserialize($value);
                }
            } else if (is_array($value) || is_object($value)) {
                if (is_object($data)) {
                    $data->$key = self::deserializeDataRecursive($value);
                } else {
                    $data[$key] = self::deserializeDataRecursive($value);
                }
            }
        }

        return $data;
    }
}
