<?php
session_start(); // Start the session

// Database connection
$host = 'localhost';
$dbname = 'resume_builder';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Fetch personal info (with default values)
$personal_info = [
    'full_name' => 'Your Name',
    'designation' => 'Your Designation',
    'location' => 'City, State, Country',
    'phone' => '+1-234-567-890',
    'email' => 'your.email@example.com',
    'linkedin' => 'linkedin.com/in/username',
    'website' => 'www.yourwebsite.com',
    'career_objective' => 'A brief summary about yourself.',
];

try {
    $stmt = $conn->prepare("SELECT * FROM personal_info WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $fetched_personal_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fetched_personal_info) {
        $personal_info = array_merge($personal_info, $fetched_personal_info);
    }
} catch (PDOException $e) {
    // Log error and continue with default values
    error_log("Error fetching personal info: " . $e->getMessage());
}


// Fetch certificates (with default empty array)
$certificates = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            user_id, 
            COALESCE(name, 'Certificate Name') AS name, 
            COALESCE(organization, 'Issuing Organization') AS organization, 
            COALESCE(description, 'Certificate description goes here.') AS description, 
            certificate_url
        FROM certificates 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $certificates = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and continue with empty array
    error_log("Error fetching certificates: " . $e->getMessage());
}

// Fetch work experience (with default empty array)
$work_experience = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            user_id, 
            COALESCE(profile, 'Job Title') AS profile, 
            COALESCE(organization, 'Company Name') AS organization, 
            COALESCE(location, 'Location') AS location, 
            COALESCE(description, 'Job description goes here.') AS description, 
            type, 
            start_date, 
            end_date 
        FROM work_experience 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $work_experience = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and continue with empty array
    error_log("Error fetching work experience: " . $e->getMessage());
}

// Fetch education (with default empty array)
$education = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            user_id, 
            COALESCE(college, 'University Name') AS college, 
            COALESCE(degree, 'Degree Name') AS degree, 
            COALESCE(stream, 'Stream Name') AS stream, 
            start_year, 
            end_year 
        FROM education 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $education = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and continue with empty array
    error_log("Error fetching education: " . $e->getMessage());
}

// Fetch languages (with default empty array)
$languages = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            user_id, 
            COALESCE(language, 'Language') AS language, 
            COALESCE(proficiency, 'Proficiency') AS proficiency 
        FROM languages 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and continue with empty array
    error_log("Error fetching languages: " . $e->getMessage());
}

// Fetch skills (with default empty array)
$skills = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            user_id, 
            COALESCE(area_of_expertise, 'Skill Category') AS area_of_expertise, 
            COALESCE(skills_acquired, 'Skill Details') AS skills_acquired 
        FROM skills 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and continue with empty array
    error_log("Error fetching skills: " . $e->getMessage());
}

// Fetch projects (with default empty array)
$projects = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            user_id, 
            COALESCE(title, 'Project Title') AS title, 
            COALESCE(description, 'Project description goes here.') AS description, 
            url,
            start_month, 
            start_year, 
            end_month, 
            end_year 
        FROM projects 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Log error and continue with empty array
    error_log("Error fetching projects: " . $e->getMessage());
}

// Fetch profile image (with default empty array)
$profile_image = [];
try {
    $stmt = $conn->prepare("
        SELECT 
            id, 
            user_id, 
            COALESCE(image, 'user.jpeg') AS image -- Default image if none is set
        FROM profile_images 
        WHERE user_id = :user_id
    ");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $profile_image = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch a single row
} catch (PDOException $e) {
    // Log error and continue with default image
    error_log("Error fetching profile image: " . $e->getMessage());
    $profile_image = ['image' => 'default-profile.jpg']; // Fallback to default image
}
?>