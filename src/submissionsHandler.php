<?php
declare(strict_types=1);
// Start the session
session_start();
error_reporting(E_ALL);

// Only process POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "⛔ No data submitted. Please return to the <a href='index.php'>form</a>.";
    exit;
}

// Sanitize and Collect Data
$name = htmlspecialchars($_POST['fname'] ?? '');
$lastName = htmlspecialchars($_POST['lname'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');

$entryData = [
    'name' => $name,
    'lastName' => $lastName,
    'email' => $email
];

// Validate Data with Try-Catch
$validation_success = false;
$error_message = '';

try {
    isValidEntryData($entryData);
    isValidName($name);
    isValidLastName($lastName);
    isValidEmail($email);
    $validation_success = true;
    
} catch (Exception $e) {
    // If ANY validation function throws an exception, catch it here
    $error_message = $e->getMessage();
}

// Validation failed - display error and exit
if (!$validation_success) {
    echo "⚠️ " . $error_message . "<br>";
    echo "Please return to the <a href='index.php'>form</a>.";
    exit;
}

// Store date in $_SESSION
// Store user data
$_SESSION['user_name'] = $name;
$_SESSION['user_lastName'] = $lastName;
$_SESSION['user_email'] = $email;

// Store submission metadata
$_SESSION['end_timestamp'] = date('Y-m-d H:i:s');
$_SESSION['submission_count'] = ($_SESSION['submission_count'] ?? 0) + 1;
$_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

// Where is this processing file located? (Magic Constants)
$_SESSION['handler_filepath'] = __FILE__;
$_SESSION['handler_directory'] = __DIR__;

// Validation Passed - Success Message 
echo "✅ <strong>Validation Successful!</strong> The submitted data is valid.<br><br>";

// --- Validation Functions ---
function isValidEntryData(array $data): bool 
{
    foreach ($data as $key => $value) {
        // Check if the value is a string and not empty after trimming
        if (!is_string($value) || trim($value) === '') {
            throw new Exception('<strong>Submission Failed:</strong> All fields are required. Please fill in Name, Last Name, and Email.');
        }
    }
    return true;
}
function isValidName(string $name): void 
{
    if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
       throw new \Exception("<strong>Invalid Name:</strong> Name fields can only contain letters and spaces.");
    }
}
function isValidLastName(string $lastName): void 
{
    if (!preg_match("/^[a-zA-Z ]+$/", $lastName)) {
       throw new \Exception("<strong>Invalid Last Name:</strong> Name fields can only contain letters and spaces.");
    }
}
function isValidEmail(string $email): void
{
    if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new \Exception("<strong>Invalid Email:</strong> Please enter a valid email address (e.g., user@example.com)<br>. Please return to the <a href='index.php'>form</a>.");
    }
}
?>