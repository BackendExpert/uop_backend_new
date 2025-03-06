<?php 
    require_once '../functions/auth.php';
    require_once '../functions/PaymentData.php';
    require_once '../functions/users.php';
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type");

    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = json_decode(file_get_contents('php://input'), true);

        if (!isset($input['action'])) {
            echo json_encode(['status' => 'error', 'message' => 'Action not specified.']);
            exit;
        }

        switch ($input['action']) {
            case 'login':
                $response = loginuser($input);
                echo json_encode($response);
                break;
            
            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
                break;
        }

    } 
    elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    }
    else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }

?>