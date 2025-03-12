<?php
session_start(); // Start the session

include '../db.php';

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
    $stmt = $conn->prepare("SELECT * FROM personal_info WHERE user_id = ?");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $fetched_personal_info = $result->fetch_assoc();

    if ($fetched_personal_info) {
        $personal_info = array_merge($personal_info, $fetched_personal_info);
    }
} catch (mysqli_sql_exception $e) {
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
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $certificates = $result->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
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
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $work_experience = $result->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
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
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $education = $result->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
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
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $languages = $result->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
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
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $skills = $result->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
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
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $projects = $result->fetch_all(MYSQLI_ASSOC);
} catch (mysqli_sql_exception $e) {
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
        WHERE user_id = ?
    ");
    $stmt->bind_param("i", $user_id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();
    $profile_image = $result->fetch_assoc(); // Fetch a single row
} catch (mysqli_sql_exception $e) {
    // Log error and continue with default image
    error_log("Error fetching profile image: " . $e->getMessage());
    $profile_image = ['image' => 'default-profile.jpg']; // Fallback to default image
}
?>