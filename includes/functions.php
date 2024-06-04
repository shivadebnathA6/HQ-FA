<?php  
class Route {
    public static function get($uri, $action) {
        $url = str_replace('/smm', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)); // Adjust base path
       // $url = rtrim($url, '/'); // Remove trailing slashes
        //$uri = rtrim($uri, '/'); // Remove trailing slashes from the route URI

        if ($url === $uri) {
            $segments = explode('@', $action);
            $controllerName = 'App\\Controllers\\' . $segments[0]; // Adjust namespace
            $methodName = $segments[1];
            // dd(class_exists($controllerName));
            // Check if the controller class exists
            if (class_exists($controllerName)) {
                $controller = new $controllerName();

                // Check if the method exists in the controller
                if (method_exists($controller, $methodName)) {
                    // Call the controller method and get the view name
                    $viewName = $controller->$methodName();

                    // If the controller method returns a view name, render the view
                    if (is_string($viewName)) {
                        self::view($viewName);
                    }
                    exit(); // Stop further execution
                }
            } else {
                echo "Controller class $controllerName not found.";
            }
        }
    }

    public static function view($viewFile) {
        include '../public/' . $viewFile . '.php';
        exit(); 
    }
}

function dd(...$vars) {
    foreach ($vars as $var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    die;
}

function view($viewFile) {
    include '../public/' . $viewFile . '.php';
    exit(); 
}

// form validation
function validate($data, $rules) {
    $errors = [];

    foreach ($rules as $field => $rule) {
        $rulesArray = explode('|', $rule);
        foreach ($rulesArray as $singleRule) {
            // Extract rule parameters if any
            $params = explode(':', $singleRule);
            $ruleName = array_shift($params);
            
            switch ($ruleName) {
                case 'required':
                    if (!isset($data[$field]) || empty($data[$field])) {
                        $errors[$field][] = ucfirst($field) . ' is required.';
                    }
                    break;
                case 'email':
                    if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                        $errors[$field][] = ucfirst($field) . ' must be a valid email address.';
                    }
                    break;
                case 'min':
                    if (strlen($data[$field]) < $params[0]) {
                        $errors[$field][] = ucfirst($field) . ' must be at least ' . $params[0] . ' characters.';
                    }
                    break;
                // Add more validation rules as needed
            }
        }
    }

    return $errors;
}