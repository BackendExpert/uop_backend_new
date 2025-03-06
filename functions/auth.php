<?php 

    require_once '../config.php';
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
        $payload['iat'] = time();
        $payload['exp'] = time() + TOKEN_EXPIRY; 
        return JWT::encode($payload, JWT_SECRET, JWT_ALGO);
    }

    function loginuser($data){
        global $conn;

        $email = htmlspecialchars(trim($data['email']));
        $password = $data['password'];

        if (empty($email) || empty($password)) {
            return ['status' => 'error', 'message' => 'Email and password are required.'];
        }

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            if($user['is_active'] === 0){
                return [
                    'status' => 'error',
                    'message' => 'Account is not activated by Admin'
                ];
            }
            else{
                $token = generateJWT($user);

                return [
                    'status' => 'success',
                    'message' => 'Login successful.',
                    'user' => $user,
                    'token' => $token
                ];
            }
        }

        else {
            return [
                'status' => 'error',
                'message' => 'Invalid email or password.'
            ];
        }

    }

    function signupuser($data){
        global $conn;
    }
    

?>