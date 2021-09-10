<?php

use Carbon\Carbon;

/*
 * A helper file, creating global functions to assist in common goals
 * 
 * https://laracasts.com/discuss/channels/general-discussion/best-practices-for-custom-helpers-on-laravel-5
 */


/**
 *
 * @param type $row_id
 * @return type
 */
function formatEditorPrimaryKey($row_id) {
    $id = null;
    switch (true) {
        case (is_numeric($row_id)):
            $id = $row_id;
            break;
        case (is_array($row_id)):
            $id = explode(',', $row_id);
            break;
        case (str_contains($row_id, ',')):
            $row_ids = explode(',', $row_id);
            $id = array_map(function ($row_id) {
                return substr($row_id, 4);
            }, $row_ids);
            break;
        case (is_string($row_id)):
            $id = substr($row_id, 4);
            break;
    }
    return $id;
}

/**
 * Helper method to create lists for the in: validation
 *
 * @param mixed $query_results
 * @param boolean - return an array of ids or string
 * @return type
 */
function createValidateList($query_results, $array = false, $quotes = false) {
    $list = ($array ? [] : "");
    foreach ($query_results as $key => $query_result) {
        ($array ? array_push($list, (is_array($query_results) ? $query_result : $query_result->id)) : $list .= ($key == count($query_results) - 1 ? ($quotes ? "'" : "") . (is_array($query_results) ? $query_result : $query_result->id) . ($quotes ? "'" : "") : ($quotes ? "'" : "") . (is_array($query_results) ? $query_result : $query_result->id) . ($quotes ? "'" : "") . ", "));
    }
    return $list;
}

/**
 * Newer than the editorOptions function, to allow for more dynamic keys/values 
 * $key = "value", $value = "label" parameters replaced with an $options array
 * 
 * @param type $results
 * @param array $default
 * @param type $key
 * @param type $value
 * @param array $extras = [['attribute-name' => 'product-ids', 'query-name' => 'product_ids', 'type' => 'json']]
 * @return type
 */
function editorOptionsUpdated($results, array $default = null, $config = [], array $extras = []) {
    $options = [];
    if (!is_null($default)) {
        $options[] = $default;
    }
    $config_opts = array_merge(['RESULT_KEY' => 'id', 'RESULT_VALUE' => 'description', 'OPTION_KEY' => 'value', 'OPTION_VALUE' => 'label'], $config);
    $result_key = $config_opts['RESULT_KEY'];
    $result_value = $config_opts['RESULT_VALUE'];
    $option_key = $config_opts['OPTION_KEY'];
    $option_value = $config_opts['OPTION_VALUE'];
    foreach ($results AS $result) {
        $id = (is_array($result) ? $result[$result_key] : $result->$result_key);
        $description = (is_array($result) ? $result[$result_value] : $result->$result_value);
        $option = [(is_null($option_key) ? "value" : $option_key) => $id, (is_null($option_value) ? "label" : $option_value) => $description];
        if (count($extras) > 0) {
            $attributes = [];
            foreach ($extras AS $extra) {
                $query_field = $extra['query-field'];
                //dd($extra, $query_field, $result->$query_field);
                if (is_null($result->$query_field)) {
                    $attributes[$extra['attribute-name']] = $query_field;
                } else {
                    if (!key_exists('type', $extra) || $extra['type'] == 'normal') {
                        $attributes['data-' . $extra['attribute-name']] = $result->$query_field;
                    }
                    if (key_exists('type', $extra) && $extra['type'] == 'json') {
                        $query_field_array = explode(',', $result->$query_field);
                        $query_field_json = json_encode($query_field_array, JSON_FORCE_OBJECT);
                        $attributes['data-' . $extra['attribute-name']] = $query_field_json;
                    }
                }
            }
            $option['attr'] = $attributes;
        }
        $options[] = $option;
    }
    return $options;
}

/**
 * TODO-low-prio: Tweak this method to enable it to return select2 for Editor or Select2
 *  -> i.e. value vs id && label vs text
 * This method is not currently being used, but will be in the future once code is refactored
 *
 * Allows for HTML5 data-global attributes?
 *
 * @return type
 */
function editorOptions($results, array $default = null, $key = "value", $value = "label", array $extras = []) {
    $options = [];
    if (!is_null($default)) {
        $options[] = $default;
    }
    foreach ($results AS $result) {
        $id = (is_array($result) ? $result['id'] : $result->id);
        $description = (is_array($result) ? $result['description'] : $result->description);
        $option = [(is_null($key) ? "value" : $key) => $id, (is_null($value) ? "label" : $value) => $description];
        if (count($extras) > 0) {
            $attributes = [];
            foreach ($extras AS $k => $v) {
                //$option['data-' . $k] = $result->$v;
                if (is_null($result->$v)) {
                    $attributes[$k] = $v;
                } else {
                    $attributes['data-' . $k] = $result->$v;
                }
            }
            $option['attr'] = $attributes;
        }
        $options[] = $option;
    }
    return $options;
}

/**
 * Pass a collection in from a query, where you query the parent first then leftJoin the children in.
 *
 * @param $collection
 * @param string $parent_id
 * @param string $parent
 * @param string $child_key
 * @param string $child_value
 * @return array
 */
function editorSelectTwoGroupOptions($collection, $parent_id = 'parent_id', $parent = 'select_group', $child_key = 'id', $first_option = null) {
    $options = [];
    $groups = $collection->where($child_key, null)->unique($parent)->pluck($parent, $parent_id)->all();
    if (!is_null($first_option)) {
        $options[] = $first_option;
    }
    //Only has the groups
    foreach ($groups AS $index => $group) {
        $child_options = [];
        $children = $collection->where($child_key, $index)->all();
        ;
        if (count($children) > 0) {
            $option = ['text' => $group];
            $child_options[] = ['id' => $index, 'text' => $group];
        } else {
            $option = ['id' => $index, 'text' => $group];
        }
        foreach ($children AS $child) {
            $child_options[] = ['id' => $child->$parent_id, 'text' => $child->$parent];
        }
        $option['children'] = $child_options;
        $options[] = $option;
    }
    return $options;
}

/**
 *
 * @return type
 */
function normalOptions($results = null, array $default = null, $key = "value", $value = "label") { //, $key = 'id', $value = 'description'
    $options = [];
    if (!is_null($default)) {
        $options[] = $default;
    }
    foreach ($results AS $result) {
        $options[] = [$key => $result->id, $value => $result->description];
        //$options[$result->$key] = $result->$value;
    }
    return $options;
}

/**
 *
 * @param type $collection
 * @param type $first_option
 * @param type $title
 * @param type $key
 * @param type $value
 * @return type
 */
function normalGroupOptions($collection, $first_option = null, $title = 'select_group', $key = 'id', $value = 'description') {
    $options = [];
    if (!is_null($first_option)) {
        $options[] = $first_option;
    }
    $groups = $collection->unique($title)->pluck($title)->all();
    foreach ($groups AS $index => $group) {
        $children = $collection->where($title, $group)->all();
        foreach ($children AS $child) {
            $child_options[$child->$key] = $child->$value;
        }
        $options[$group] = $child_options;
    }
    return $options;
}

/**
 *
 * @param type $results
 * @param type $first_option
 * @param type $key
 * @param type $value
 * @return type
 */
function selectTwoOptions($results, $first_option = null, $key = 'id', $value = 'description') {
    $options = [];
    if (!is_null($first_option)) {
        $options[0] = $first_option;
    }
    foreach ($results AS $index => $result) {
        $options[(is_array($results) ? $index : $result->$key)] = (is_array($results) ? $result : $result->$value);
    }
    return $options;
}

/**
 *
 * @param type $collection
 * @param type $title
 * @param type $key
 * @param type $value
 * @return type
 */
function selectTwoGroupOptions($collection, $title = 'select_group', $key = 'id', $value = 'description') {
    $options = [];
    $groups = $collection->unique($title)->pluck($title)->all();
    foreach ($groups AS $index => $group) {
        $child_options = [];
        $option = [$key => $index, $value => $group];
        $children = $collection->where($title, $group)->all();
        foreach ($children AS $child) {
            $child_options[$child->$key] = $child->$value;
        }
        $option['children'] = $child_options;
        $options[] = $option;
    }
    return $options;
}

/**
 *
 * @param type $results
 * @param type $first_option
 * @param type $key
 * @param type $value
 * @param array $extras
 * @return type
 */
function updateSelectTwo($results, $first_option = null, $key = 'id', $value = 'description', array $extras = []) {
    $options = [];
    if (!is_null($first_option)) {
        array_push($options, ["id" => 0, "text" => $first_option]);
    }
    foreach ($results as $result) {
        $option = ["id" => $result->$key, "text" => $result->$value];
        foreach ($extras AS $k => $v) {
            $option[$k] = $result->$v;
        }
        $options[] = $option;
    }
    return $options;
}

/**
 *
 * @param Carbon $date
 * @param type $format
 * @return type
 */
function toDateString($date, $format = null) {
    $carbon = ($date instanceof Carbon ? $date : getCarbon($date, $format));
    return $carbon->toDateString();
}

/**
 *
 * @param Carbon $date
 * @param type $format
 * @return type
 */
function toCarbon($date, $format = null) {
    if (is_null($date)) {
        return Carbon::now();
    }
    $carbon = ($date instanceof Carbon ? $date : getCarbon($date, $format));
    return $carbon;
}

/**
 *
 * @param type $date
 * @param type $format
 * @return type
 */
function getCarbon($date, $format = null) {
    //For now just return carbon::parse 
    return is_null($format) ? Carbon::parse($date) : Carbon::createFromFormat($format, $date);
}

/**
 * 
 * @param Carbon $date
 * @param int $start
 * @param int $end
 */
function getYearSelect($date, $start, $end) {
    $years = [];
    for ($i = -5; $i <= 5; $i++) {
        //$years .= "{label: '" . ($currentyear + $i) . "', value: '" . ($currentyear + $i) . "'},";
        $years[] = ['label' => ($date + $i), 'value' => ($date + $i)];
    }
    return $years;
}

/**
 * @param int $length
 * @return bool|string
 */
function str_quick_random($length = 16) {
    $pool = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
}

/**
 * https://stackoverflow.com/questions/4133859/round-up-to-nearest-multiple-of-five-in-php
 * 1: Round to the next multiple of 5, exclude the current number
 *  -> return round(($n+$x/2)/$x)*$x;
 * 2: Round to the nearest multiple of 5, include the current number
 *  -> return (round($n)%$x === 0) ? round($n) : round(($n+$x/2)/$x)*$x;
 * 3: Round up to an integer, then to the nearest multiple of 5
 *  -> return (ceil($n)%$x === 0) ? ceil($n) : round(($n+$x/2)/$x)*$x;
 * 
 * @param type $n
 * @param type $x
 * @return type
 */
function roundUpToAny($n, $x = 5) {
    return (round($n) % $x === 0) ? round($n) : round(($n + $x / 2) / $x) * $x;
}

/**
 *
 * http://php.net/manual/en/exception.gettraceasstring.php
 * ernest at vogelsinger dot at
 *
 * @param $e
 * @param null $seen
 * @return array|string
 */
function jTraceEx($e, $seen = null) {
    $starter = $seen ? 'Caused by: ' : '';
    $result = array();
    if (!$seen)
        $seen = array();
    $trace = $e->getTrace();
    $prev = $e->getPrevious();
    $result[] = sprintf('%s%s: %s', $starter, get_class($e), $e->getMessage());
    $file = $e->getFile();
    $line = $e->getLine();
    while (true) {
        $current = "$file:$line";
        if (is_array($seen) && in_array($current, $seen)) {
            $result[] = sprintf(' ... %d more', count($trace) + 1);
            break;
        }
        $result[] = sprintf(' at %s%s%s(%s%s%s)', count($trace) && array_key_exists('class', $trace[0]) ? str_replace('\\', '.', $trace[0]['class']) : '', count($trace) && array_key_exists('class', $trace[0]) && array_key_exists('function', $trace[0]) ? '.' : '', count($trace) && array_key_exists('function', $trace[0]) ? str_replace('\\', '.', $trace[0]['function']) : '(main)', $line === null ? $file : basename($file), $line === null ? '' : ':', $line === null ? '' : $line);
        if (is_array($seen))
            $seen[] = "$file:$line";
        if (!count($trace))
            break;
        $file = array_key_exists('file', $trace[0]) ? $trace[0]['file'] : 'Unknown Source';
        $line = array_key_exists('file', $trace[0]) && array_key_exists('line', $trace[0]) && $trace[0]['line'] ? $trace[0]['line'] : null;
        array_shift($trace);
    }
    $result = join("\n", $result);
    if ($prev)
        $result .= "\n" . jTraceEx($prev, $seen);

    return $result;
}

/**
 * https://stackoverflow.com/questions/2510434/format-bytes-to-kilobytes-megabytes-gigabytes 
 * 
 * @param type $bytes
 * @param type $precision
 * @return type
 */
function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    //$bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * https://www.php.net/manual/en/function.memory-get-peak-usage.php
 * Returns used memory (either in percent (without percent sign) or free and overall in bytes)
 * 
 * @param type $getPercentage
 * @return type
 */
function getServerMemoryUsage($getPercentage = true) {
    $memoryTotal = null;
    $memoryFree = null;

    if (stristr(PHP_OS, "win")) {
        // Get total physical memory (this is in bytes)
        $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
        @exec($cmd, $outputTotalPhysicalMemory);

        // Get free physical memory (this is in kibibytes!)
        $cmd = "wmic OS get FreePhysicalMemory";
        @exec($cmd, $outputFreePhysicalMemory);

        if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
            // Find total value
            foreach ($outputTotalPhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryTotal = $line;
                    break;
                }
            }

            // Find free value
            foreach ($outputFreePhysicalMemory as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $memoryFree = $line;
                    $memoryFree *= 1024;  // convert from kibibytes to bytes
                    break;
                }
            }
        }
    } else {
        if (is_readable("/proc/meminfo")) {
            $stats = @file_get_contents("/proc/meminfo");

            if ($stats !== false) {
                // Separate lines
                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                $stats = explode("\n", $stats);

                // Separate values and find correct lines for total and free mem
                foreach ($stats as $statLine) {
                    $statLineData = explode(":", trim($statLine));

                    //
                    // Extract size (NOTE: It seems that (at least) the two values for total and free memory have the unit "kB" always. Is this correct?
                    //

                        // Total memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                        $memoryTotal = trim($statLineData[1]);
                        $memoryTotal = explode(" ", $memoryTotal);
                        $memoryTotal = $memoryTotal[0];
                        $memoryTotal *= 1024;  // convert from kibibytes to bytes
                    }

                    // Free memory
                    if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                        $memoryFree = trim($statLineData[1]);
                        $memoryFree = explode(" ", $memoryFree);
                        $memoryFree = $memoryFree[0];
                        $memoryFree *= 1024;  // convert from kibibytes to bytes
                    }
                }
            }
        }
    }

    if (is_null($memoryTotal) || is_null($memoryFree)) {
        return null;
    } else {
        if ($getPercentage) {
            return (100 - ($memoryFree * 100 / $memoryTotal));
        } else {
            return array(
                "total" => $memoryTotal,
                "free" => $memoryFree,
            );
        }
    }
}

function getNiceFileSize($bytes, $binaryPrefix = true) {
    if ($binaryPrefix) {
        $unit = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
        if ($bytes == 0)
            return '0 ' . $unit[0];
        return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
    } else {
        $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
        if ($bytes == 0)
            return '0 ' . $unit[0];
        return @round($bytes / pow(1000, ($i = floor(log($bytes, 1000)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
    }
}

/**
 * https://www.php.net/manual/en/function.sys-getloadavg.php#118673 
 * @return type
 */
function _getServerLoadLinuxData() {
    if (is_readable("/proc/stat")) {
        $stats = @file_get_contents("/proc/stat");

        if ($stats !== false) {
            // Remove double spaces to make it easier to extract values with explode()
            $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

            // Separate lines
            $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
            $stats = explode("\n", $stats);

            // Separate values and find line for main CPU load
            foreach ($stats as $statLine) {
                $statLineData = explode(" ", trim($statLine));

                // Found!
                if
                (
                        (count($statLineData) >= 5) &&
                        ($statLineData[0] == "cpu")
                ) {
                    return array(
                        $statLineData[1],
                        $statLineData[2],
                        $statLineData[3],
                        $statLineData[4],
                    );
                }
            }
        }
    }

    return null;
}

// Returns server load in percent (just number, without percent sign)
function getServerLoad() {
    $load = null;

    if (stristr(PHP_OS, "win")) {
        $cmd = "wmic cpu get loadpercentage /all";
        @exec($cmd, $output);

        if ($output) {
            foreach ($output as $line) {
                if ($line && preg_match("/^[0-9]+\$/", $line)) {
                    $load = $line;
                    break;
                }
            }
        }
    } else {
        if (is_readable("/proc/stat")) {
            // Collect 2 samples - each with 1 second period
            // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
            $statData1 = _getServerLoadLinuxData();
            sleep(1);
            $statData2 = _getServerLoadLinuxData();

            if
            (
                    (!is_null($statData1)) &&
                    (!is_null($statData2))
            ) {
                // Get difference
                $statData2[0] -= $statData1[0];
                $statData2[1] -= $statData1[1];
                $statData2[2] -= $statData1[2];
                $statData2[3] -= $statData1[3];

                // Sum up the 4 values for User, Nice, System and Idle and calculate
                // the percentage of idle time (which is part of the 4 values!)
                $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                // Invert percentage to get CPU time, not idle time
                $load = 100 - ($statData2[3] * 100 / $cpuTime);
            }
        }
    }

    return $load;
}
