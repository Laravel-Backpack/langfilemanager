<?php

namespace Backpack\LangFileManager\app\Services;

class LangFiles
{
    private $lang;

    private $file = 'crud';

    public function __construct()
    {
        $this->lang = config('app.locale');
    }

    public function setLanguage($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * get the content of a language file as an array sorted ascending.
     * @return	array|false
     */
    public function getFileContent()
    {
        $filepath = $this->getFilePath();

        if (is_file($filepath)) {
            $wordsArray = include $filepath;
            asort($wordsArray);

            return $wordsArray;
        }

        return false;
    }

    /**
     * rewrite the file with the modified texts.
     * @param	array 		$postArray	the data received from the form
     * @return  int
     */
    public function setFileContent($postArray)
    {
        $postArray = $this->prepareContent($postArray);

        $return = (int) file_put_contents(
                $this->getFilePath(),
                print_r("<?php \n\n return ".$this->var_export54($postArray).';', true)
            );

        return $return;
    }

    /**
     * get the language files that can be edited, to ignore a file add it in the config/admin file to language_ignore key.
     * @return	array
     */
    public function getlangFiles()
    {
        $fileList = [];

        foreach (scandir($this->getLangPath(), SCANDIR_SORT_DESCENDING) as $file) {
            $fileName = str_replace('.php', '', $file);

            if (! in_array($fileName, array_merge(['.', '..'], config('backpack.langfilemanager.language_ignore')))) {
                $fileList[] = [
                    'name' => ucfirst(str_replace('_', ' ', $fileName)),
                    'url' => url(config('backpack.base.route_prefix', 'admin')."/language/texts/{$this->lang}/{$fileName}"),
                    'active' => $fileName == $this->file,
                ];
            }
        }

        // Sort files by name for better readability
        usort($fileList, function ($a, $b) {
            return strnatcmp($a['name'], $b['name']);
        });

        return $fileList;
    }

    /**
     * check if all the fields were completed.
     * @param 	array		$postArray		the array containing the data
     * @return	array
     */
    public function testFields($postArray)
    {
        $returnArray = [];

        foreach ($postArray as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $item) {
                    foreach ($item as $j => $it) {
                        if (trim($it) == '') {
                            $returnArray[] = ['parent' => $key, 'child' => $j];
                        }
                    }
                }
            } else {
                if (trim($value) == '') {
                    $returnArray[] = $key;
                }
            }
        }

        return $returnArray;
    }

    /**
     * display the form that permits the editing.
     * @param 	array  		$fileArray		the array with all the texts
     * @param 	array  		$parents  		all the ancestor keys of the current key
     * @param 	string 		$parent   		the parent key of the current key
     * @param 	int		$level    		the current level
     * @return	void
     */
    public function displayInputs($fileArray, $parents = [], $parent = '', $level = 0)
    {
        $level++;
        if ($parent) {
            $parents[] = $parent;
        }
        foreach ($fileArray as $key => $item) {
            if (is_array($item)) {
                echo view()->make('langfilemanager::language_headers', ['header' => $key, 'parents' => $parents, 'level' => $level, 'item' => $item, 'langfile' => $this, 'lang_file_name' => $this->file])->render();
            } else {
                echo view()->make('langfilemanager::language_inputs', ['key' => $key, 'item' => $item, 'parents' => $parents, 'lang_file_name' => $this->file])->render();
            }
        }
    }

    /**
     * create the array that will be saved in the file.
     * @param  array		$postArray		the array to be transformed
     * @return array
     */
    private function prepareContent($postArray)
    {
        $returnArray = [];

        unset($postArray['_token']);

        foreach ($postArray as $key => $item) {
            $keys = explode('__', $key);

            if (is_array($item)) {
                if (isset($item['before'])) {
                    $items_arr = array_map(
                            function ($item1, $item2) {
                                return $item1.$item2;
                            },
                            str_replace('|', '&#124;', $item['before']), str_replace('|', '&#124;', $item['after'])
                        );
                    $value = $this->sanitize(implode('|', $items_arr));
                } else {
                    $value = $this->sanitize(implode('|', str_replace('|', '&#124;', $item['after'])));
                }
            } else {
                $value = $this->sanitize(str_replace('|', '&#124;', $item));
            }

            $this->setArrayValue($returnArray, $keys, $value);
        }

        return $returnArray;
    }

    /**
     * add filters to the values inserted by the user.
     * @param 	string		$str		the string to be sanitized
     * @return	string
     */
    private function sanitize($str)
    {
        return trim($str);
    }

    /**
     * set a value in a multidimensional array when knowing the keys.
     * @param 	array 		$data 		the array that will be modified
     * @param 	array 		$keys 		the keys (path)
     * @param 	string		$value		the value to be added
     * @return	array
     */
    private function setArrayValue(&$data, $keys, $value)
    {
        foreach ($keys as $key) {
            $data = &$data[$key];
        }

        return $data = $value;
    }

    private function getFilePath()
    {
        return base_path("resources/lang/{$this->lang}/{$this->file}.php");
    }

    private function getLangPath()
    {
        return base_path("resources/lang/{$this->lang}/");
    }

    private function var_export54($var, $indent = '')
    {
        switch (gettype($var)) {
            case 'string':
                return '"'.addcslashes($var, "\\\$\"\r\n\t\v\f").'"';
            case 'array':
                $indexed = array_keys($var) === range(0, count($var) - 1);
                $r = [];
                foreach ($var as $key => $value) {
                    $r[] = "$indent    "
                         .($indexed ? '' : $this->var_export54($key).' => ')
                         .$this->var_export54($value, "$indent    ");
                }

                return "[\n".implode(",\n", $r)."\n".$indent.']';
            case 'boolean':
                return $var ? 'TRUE' : 'FALSE';
            default:
                return var_export($var, true);
        }
    }
}
