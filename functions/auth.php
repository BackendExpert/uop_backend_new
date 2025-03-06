<?php 

    require_once '../db.php';
    require_once '../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    const JWT_SECRET = "your_secret_key"; 
    const JWT_ALGO = "HS256"; 
    const TOKEN_EXPIRY = 3600; 

    function sanitizeInput($input) {
        return htmlspecialchars(trim($input));
    }

    function generateJWT($payload) {
        $payload['iat'] = time(); // Issued at
        $payload['exp'] = time() + TOKEN_EXPIRY; // Expiry
        return JWT::encode($payload, JWT_SECRET, JWT_ALGO);
    }

    function loginuser($data){
        global $conn;

        $email = htmlspecialchars(trim($data['email']));
        $password = $data['password'];

        if (empty($email) || empty($password)) {
            return ['status' => 'error', 'message' => 'Email and password are required.'];
        }
    }

    function signupuser($data){
        global $conn;
    }
    

?>