<?php




/**
 * Get the base path
 * @param string $path
 * @return string
 */

function basePath($path = "")
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a View
 * @param string $name
 * @return void
 *
 */
function loadView($name , $data = [])
{

    $viewPath = basePath("App/views/{$name}.view.php");
    if (file_exists($viewPath)) {
        extract($data);

        require $viewPath;
    } else {
        echo 'view ' . $name . 'not Found';
    }
}
/**
 * Load a Partial
 * @param string $name
 * @return void
 *
 */
function loadPartial($name , $data = [])
{
    $partialPath = basePath("App/views/partials/{$name}.php");
    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo 'partial ' . $name . 'not Found';
    }
}

/**
 * Inspect a value(s)
 *
 * @param mixed $value
 * @return void
 */

function inspect($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

/**
 * Inspect a value(s) and die
 *
 * @param mixed $value
 * @return void
 */

function inspectAndDie($value)
{
    echo "<pre>";
    die(var_dump($value));
    echo "</pre>";
}

/**
 * Format salary
 *
 * @param string $salary
 * @return string Formatted Salary
 *
 */
function formatSalary($salary){
    return '$' . number_format(floatval($salary));
}

/**
 * @param string $dirty
 * @return string
 */
function sanitize($dirty){
    return filter_var($dirty , FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * @param $url
 * @return void
 */
function redirect($url){
    header("Location:{$url}" );
    exit;
}