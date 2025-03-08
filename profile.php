<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

// Access the user_id from the session
$user_id = $_SESSION['user_id'];


// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "resume_builder"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch personal info
$personal_info = [];
$education = [];
$work_experience = [];
$skills = [];
$projects = [];
$certificates = [];
$languages = [];
$profile_image = [];

$sql = "SELECT * FROM personal_info WHERE user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $personal_info = $result->fetch_assoc();
}

// Fetch education
$sql = "SELECT * FROM education WHERE user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $education[] = $row;
    }
}

// Fetch work experience
$sql = "SELECT * FROM work_experience WHERE user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $work_experience[] = $row;
    }
}

// Fetch skills
$sql = "SELECT * FROM skills WHERE user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $skills[] = $row;
    }
}

// Fetch projects
$sql = "SELECT * FROM projects WHERE user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $projects[] = $row;
    }
}

// Fetch certificates
$sql = "SELECT * FROM certificates WHERE user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $certificates[] = $row;
    }
}

// Fetch languages
$sql = "SELECT * FROM languages WHERE user_id = $user_id";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $languages[] = $row;
    }
}

// Fetch profile_image
$sql = "SELECT * FROM profile_images WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch the first row (assuming only one profile image per user)
    $profile_image = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internshala Resume</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="navbar">
        <div>Resume Builder</div>
        <div class="profile-dropdown">
            <a href="#"><i class="fas fa-bars"></i></a>
            <div class="profile-dropdown-content">
                <a href="profile.php">Profile</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </div>
    <div class="container">

        <a href="index.php" class="back-link">Back</a>

        <div class="header">
            <h1>Profile Details</h1>
        </div>

        <div class="alert">
            <span class="alert-icon">⚠</span>
            This is the data which the resume is generated upon. please ensure this is up to date.
        </div>

        <div class="resume-content">
            <!-- Personal Info Section -->
            <!-- Personal Info Section -->
            <div class="personal-info">

                <div class="name-section">
                    <div class="profile-pic" id="profile-<?php echo htmlspecialchars($profile_image['id'] ?? ''); ?>">
                        <img src="uploads/<?php echo htmlspecialchars($profile_image['image'] ?? 'user.jpeg'); ?>" alt="profile-pic">
                        <?php if (!empty($profile_image['user_id'])): ?>
                            <span class="image-btn edit-icon" data-type="profile" data-id="profile-<?php echo $profile_image['id']; ?>">Update Image</span>
                        <?php else: ?>
                            <!-- Display alternative code if $profile_image['user_id'] is empty -->
                            <a class="add-btn" data-type="profile">Upload Image</a>
                        <?php endif; ?>
                    </div>

                    <div id="personal-<?php echo $personal_info['id']; ?>">
                        <h2>
                            <?php echo !empty($personal_info['full_name']) ? htmlspecialchars($personal_info['full_name']) : 'Update your personal information'; ?>
                            <span class="edit-icon" data-type="personal" data-id="personal-<?php echo $personal_info['id']; ?>">✏️</span>
                        </h2>
                        <?php if (!empty($personal_info['designation'])): ?>
                            <div class="designation">
                                <?php echo htmlspecialchars($personal_info['designation']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($personal_info['email'])): ?>
                            <div class="contact-info">
                                <?php echo htmlspecialchars($personal_info['email']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($personal_info['phone'])): ?>
                            <div class="contact-info">
                                <?php echo htmlspecialchars($personal_info['phone']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($personal_info['location'])): ?>
                            <div class="location">
                                <?php echo htmlspecialchars($personal_info['location']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($personal_info['website'])): ?>
                            <div class="website">
                                <a href="<?php echo htmlspecialchars($personal_info['website']); ?>" target="_blank"><?php echo htmlspecialchars($personal_info['website']); ?></a>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($personal_info['github'])): ?>
                            <div class="github">
                                <a href="<?php echo htmlspecialchars($personal_info['github']); ?>" target="_blank">GitHub Profile</a>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($personal_info['linkedin'])): ?>
                            <div class="linkedin">
                                <a href="<?php echo htmlspecialchars($personal_info['linkedin']); ?>" target="_blank">LinkedIn Profile</a>
                            </div>
                        <?php endif; ?>
                    </div>

                </div>


                <!-- Reminder Message for Missing Recommended Fields -->
                <?php
                $missing_fields = [];
                if (empty($personal_info['full_name'])) $missing_fields[] = 'Full Name';
                if (empty($personal_info['email'])) $missing_fields[] = 'Email';
                if (empty($personal_info['phone'])) $missing_fields[] = 'Phone';
                if (empty($personal_info['location'])) $missing_fields[] = 'Location';
                if (empty($personal_info['designation'])) $missing_fields[] = 'Designation';

                if (!empty($missing_fields)): ?>
                    <div class="update-message">
                        <strong>Reminder:</strong> Please update the following fields: <?php echo implode(', ', $missing_fields); ?>.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Career Objective Section -->
            <div class="section">
                <div class="section-header">Career Objective <span class="edit-icon" data-type="objective" data-id="objective-<?php echo $personal_info['id']; ?>">✏️</span></div>
                <div class="section-content">
                    <div class="entry" id="career-objective-1">
                        <div class="entry-content">
                            <div class="entry-description">
                                <?php echo !empty($personal_info['career_objective']) ? htmlspecialchars($personal_info['career_objective']) : 'Update your career objective to showcase your goals and aspirations.'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Education Section -->
            <div class="section">
                <div class="section-header">Education</div>
                <div class="section-content" id="education-container">
                    <?php foreach ($education as $edu): ?>
                        <div class="entry" id="education-<?php echo $edu['id']; ?>">
                            <div class="entry-content">
                                <div class="entry-title"><?php echo htmlspecialchars($edu['degree']); ?></div>
                                <div class="entry-subtitle"><?php echo htmlspecialchars($edu['college']); ?></div>
                                <?php if (!empty($edu['stream'])): ?>
                                    <div class="entry-subtitle"><?php echo htmlspecialchars($edu['stream']); ?></div>
                                <?php endif; ?>
                                <div class="entry-date"><?php echo htmlspecialchars($edu['start_year']); ?> - <?php echo htmlspecialchars($edu['end_year']); ?></div>
                                <div class="percentage"><?php echo htmlspecialchars($edu['score_type'] === 'cgpa' ? 'CGPA' : 'Percentage'); ?>: <?php echo htmlspecialchars($edu['score']); ?></div>
                            </div>
                            <div class="entry-actions">
                                <span class="edit-icon" data-type="education" data-id="education-<?php echo $edu['id']; ?>">✏️</span>
                                <span class="delete-icon" data-table="education" data-id="<?php echo $edu['id']; ?>">🗑️</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="add-btn" data-type="education">Add education</a>
            </div>

            <!-- Work Experience Section -->
            <div class="section">
                <div class="section-header">Work Experience</div>
                <div class="section-content" id="experience-container">
                    <?php foreach ($work_experience as $exp): ?>
                        <div class="entry" id="experience-<?php echo $exp['id']; ?>">
                            <div class="entry-content">
                                <div class="entry-title"><?php echo htmlspecialchars($exp['profile']); ?></div>
                                <div class="entry-subtitle"><?php echo htmlspecialchars($exp['organization']); ?>, <?php echo htmlspecialchars($exp['location']); ?></div>
                                <div class="entry-date">
                                    <?php
                                    // Format start_date and end_date
                                    $start_date = date('d M Y', strtotime($exp['start_date']));
                                    $end_date = !empty($exp['end_date']) ? date('d M Y', strtotime($exp['end_date'])) : 'Present';
                                    echo htmlspecialchars("$start_date - $end_date");
                                    ?>
                                </div>
                                <div class="entry-description"><?php echo htmlspecialchars($exp['description']); ?></div>
                            </div>
                            <div class="entry-actions">
                                <span class="edit-icon" data-type="experience" data-id="experience-<?php echo $exp['id']; ?>">✏️</span>
                                <span class="delete-icon" data-table="work_experience" data-id="<?php echo $exp['id']; ?>">🗑️</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="add-btn" data-type="experience">Add experience</a>
            </div>

            <!-- Projects Section -->
            <div class="section">
                <div class="section-header">Advanced/ Personal Projects</div>
                <div class="section-content" id="projects-container">
                    <?php foreach ($projects as $project): ?>
                        <div class="entry" id="project-<?php echo $project['id']; ?>">
                            <div class="entry-content">
                                <div class="entry-title"><?php echo htmlspecialchars($project['title']); ?></div>
                                <div class="entry-date"><?php echo htmlspecialchars($project['start_month']); ?> <?php echo htmlspecialchars($project['start_year']); ?> - <?php echo htmlspecialchars($project['end_month']); ?> <?php echo htmlspecialchars($project['end_year']); ?></div>
                                <?php if (!empty($project['url'])): ?>
                                    <a href="<?php echo htmlspecialchars($project['url']); ?>" class="project-link"><?php echo htmlspecialchars($project['url']); ?></a>
                                <?php endif; ?>
                                <div class="entry-description"><?php echo htmlspecialchars($project['description']); ?></div>
                            </div>
                            <div class="entry-actions">
                                <span class="edit-icon" data-type="project" data-id="project-<?php echo $project['id']; ?>">✏️</span>
                                <span class="delete-icon" data-table="projects" data-id="<?php echo $project['id']; ?>">🗑️</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="add-btn" data-type="project">Add academic/ personal project</a>
            </div>


            <!-- Certificates Section -->
            <div class="section">
                <div class="section-header">Certificates</div>
                <div class="section-content" id="certificates-container">
                    <?php foreach ($certificates as $certificate): ?>
                        <div class="entry" id="certificate-<?php echo $certificate['id']; ?>">
                            <div class="entry-content">
                                <div class="certificate-title"><?php echo htmlspecialchars($certificate['name']); ?></div>
                                <div class="certificate-organisation"><?php echo htmlspecialchars($certificate['organization']); ?></div>
                                <?php if (!empty($certificate['certificate_url'])): ?>
                                    <a href="<?php echo htmlspecialchars($certificate['certificate_url']); ?>" class="certificate-link"><?php echo htmlspecialchars($certificate['certificate_url']); ?></a>
                                <?php endif; ?>
                                <div class="certificate-description"><?php echo htmlspecialchars($certificate['description']); ?></div>
                            </div>
                            <div class="entry-actions">
                                <span class="edit-icon" data-type="certificate" data-id="certificate-<?php echo $certificate['id']; ?>">✏️</span>
                                <span class="delete-icon" data-table="certificates" data-id="<?php echo $certificate['id']; ?>">🗑️</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="add-btn" data-type="certificate">Add Certificates</a>
            </div>


            <!-- Skills Section -->
            <div class="section">
                <div class="section-header">Skills</div>
                <div class="skills-grid" id="skills-container">
                    <?php foreach ($skills as $skill): ?>
                        <div class="skill-item" id="skill-<?php echo $skill['id']; ?>">
                            <span class="skill-text"><?php echo htmlspecialchars($skill['area_of_expertise']); ?> </span>- <span class="skill-acquired"> <?php echo htmlspecialchars($skill['skills_acquired']); ?></span>
                            <span class="edit-icon" data-type="skill" data-id="skill-<?php echo $skill['id']; ?>">✏️</span>
                            <span class="delete-icon" data-table="skills" data-id="<?php echo $skill['id']; ?>">🗑️</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="add-btn" data-type="skill">Add skill</a>
            </div>


            <!-- Languages Section -->
            <div class="section">
                <div class="section-header">Languages</div>
                <div class="skills-grid" id="languages-container">
                    <?php foreach ($languages as $language): ?>
                        <div class="skill-item" id="language-<?php echo $language['id']; ?>">
                            <span class="language-name"><?php echo htmlspecialchars($language['language']); ?> </span>- <span class="language-proficiency"> <?php echo htmlspecialchars($language['proficiency']); ?></span>
                            <span class="edit-icon" data-type="language" data-id="language-<?php echo $language['id']; ?>">✏️</span>
                            <span class="delete-icon" data-table="languages" data-id="<?php echo $language['id']; ?>">🗑️</span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <a class="add-btn" data-type="language">Add Language</a>
            </div>
        </div>
    </div>


    <!-- Modal Templates -->

    <!-- Profile Image Modal -->
    <div class="modal-overlay" id="profile-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Update Profile Image</h3>
                <button class="modal-close">&times;</button>
            </div>
            <!-- Wrap the content in a <form> element -->
            <form id="profile-image-form" data-table="profile_images" enctype="multipart/form-data">
                <input type="hidden" id="profile-id" name="id" value=""> <!-- Hidden field for user_id -->

                <div class="form-group">
                    <label class="form-label">Upload Profile Image</label>
                    <!-- File input for image upload -->
                    <input type="file" id="profile-file" name="image" accept="image/*" required>
                </div>
                <!-- Ensure the button is inside the form -->
                <button type="button" class="save-profile-btn" id="save-profile-image">Save</button>
            </form>
        </div>
    </div>

    <!-- Personal Info Modal -->
    <div class="modal-overlay" id="personal-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Personal Information</h3>
                <button class="modal-close">&times;</button>
            </div>
            <!-- Wrap the form inputs in a <form> element -->
            <form id="personal-form" data-table="personal_info">
                <input type="hidden" id="personal-id" name="id" value=""> <!-- Hidden field for ID -->

                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <input type="text" class="form-input" id="personal-name" name="full_name" placeholder="e.g. John Doe" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-input" id="personal-email" name="email" placeholder="e.g. john.doe@example.com" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-input" id="personal-phone" name="phone" placeholder="e.g. +91 9876543210" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-input" id="personal-location" name="location" placeholder="e.g. Mumbai" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Designation</label>
                    <input type="text" class="form-input" id="personal-designation" name="designation" placeholder="e.g. Web Developer" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="url" class="form-input" id="personal-website" name="website" placeholder="e.g. https://yourportfolio.com">
                </div>
                <div class="form-group">
                    <label class="form-label">GitHub Profile</label>
                    <input type="url" class="form-input" id="personal-github" name="github" placeholder="e.g. https://github.com/yourusername">
                </div>
                <div class="form-group">
                    <label class="form-label">LinkedIn Profile</label>
                    <input type="url" class="form-input" id="personal-linkedin" name="linkedin" placeholder="e.g. https://linkedin.com/in/yourusername">
                </div>
                <!-- Ensure the "Save" button is inside the <form> -->
                <button type="button" class="save-btn" id="save-personal">Save</button>
            </form>
        </div>
    </div>

    <!-- Career Objective Modal -->
    <div class="modal-overlay" id="objective-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Career Objective</h3>
                <button class="modal-close">&times;</button>
            </div>
            <!-- Wrap the content in a <form> element -->
            <form id="objective-form" data-table="personal_info">
                <input type="hidden" id="objective-id" name="id" value=""> <!-- Hidden field for ID -->

                <div class="form-group">
                    <label class="form-label">Career Objective</label>
                    <!-- Add a name attribute to the textarea -->
                    <textarea class="form-textarea" id="objective-text" name="career_objective" placeholder="Describe your career objective" required></textarea>
                </div>
                <!-- Ensure the button is inside the form -->
                <button type="button" class="save-btn" id="save-objective">Save</button>
            </form>
        </div>
    </div>

    <!-- Education Modal -->
    <div class="modal-overlay" id="education-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Graduation details/ Post graduation details</h3>
                <button class="modal-close">&times;</button>
            </div>
            <!-- Wrap the content in a <form> element -->
            <form id="education-form" data-table="education">
                <!-- Hidden input for the record ID -->
                <input type="hidden" id="education-id" name="id" value="">

                <!-- College -->
                <div class="form-group">
                    <label class="form-label">College</label>
                    <input type="text" class="form-input" id="education-college" name="college" placeholder="e.g. Hindu College" required>
                </div>

                <!-- Start Year and End Year -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Start year</label>
                            <input type="text" class="form-input" id="education-start-year" name="start_year" placeholder="Select start year" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">End year</label>
                            <input type="text" class="form-input" id="education-end-year" name="end_year" placeholder="Select end year" required>
                        </div>
                    </div>
                </div>

                <!-- Degree and Stream -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Degree</label>
                            <input type="text" class="form-input" id="education-degree" name="degree" placeholder="e.g. B.Sc (Hons.)" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Stream <span class="optional-text">(Optional)</span></label>
                            <input type="text" class="form-input" id="education-stream" name="stream" placeholder="e.g. Economics">
                        </div>
                    </div>
                </div>

                <!-- Performance Score -->
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Performance Score <span class="optional-text">(Recommended)</span></label>
                            <select class="form-select" id="education-score-type" name="score_type" required>
                                <option value="percentage">Percentage</option>
                                <option value="cgpa">CGPA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">&nbsp;</label>
                            <input type="text" class="form-input" id="education-score" name="score" placeholder="Out of 100" required>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <button type="submit" class="save-btn" id="save-education">Save</button>
            </form>
        </div>
    </div>

    <!-- Experience Modal (Job) -->
    <div class="modal-overlay" id="experience-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Add Experience</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form id="experience-form" data-table="work_experience">
                <input type="hidden" id="experience-id" name="id" value="">
                <div class="form-group">
                    <label class="form-label">Profile</label>
                    <input type="text" class="form-input" id="experience-profile" name="profile" placeholder="e.g. Software Developer" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Organization</label>
                    <input type="text" class="form-input" id="experience-organization" name="organization" placeholder="e.g. Google" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-input" id="experience-location" name="location" placeholder="e.g. Bangalore">
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-input" id="experience-start-date" name="start_date" required>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-input" id="experience-end-date" name="end_date" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea" id="experience-description" name="description" placeholder="Describe your work and responsibilities" required></textarea>
                </div>
                <button type="submit" class="save-btn" id="save-experience">Save</button>
            </form>
        </div>
    </div>


    <!-- Skill Modal -->
    <div class="modal-overlay" id="skill-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Add Skill</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form id="skill-form" data-table="skills">
                <input type="hidden" id="skill-id" name="id" value=""> <!-- Hidden field for ID -->
                <div class="form-group">
                    <label class="form-label">Area of Expertise</label>
                    <input type="text" class="form-input" id="area-of-expertise" name="area_of_expertise" placeholder="e.g. Web Development" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Skills Acquired</label>
                    <input type="text" class="form-input" id="skills-acquired" name="skills_acquired" placeholder="e.g. HTML, CSS, JavaScript" required>
                </div>
                <button type="submit" class="save-btn" id="save-skill">Save</button>
            </form>
        </div>
    </div>

    <!-- Projects Modal -->
    <div class="modal-overlay" id="project-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Add Academic/Personal Project</h3>
                <button class="modal-close">&times;</button>
            </div>
            <form id="project-form" data-table="projects">
                <input type="hidden" id="project-id" name="id" value=""> <!-- Hidden field for ID -->
                <div class="form-group">
                    <label class="form-label">Project Title</label>
                    <input type="text" class="form-input" id="project-title" name="title" placeholder="e.g. Resume Builder" required>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">Start Date</label>
                            <div class="form-row">
                                <div class="form-col">
                                    <select class="form-select" id="project-start-month" name="start_month" required>
                                        <option value="">Month</option>
                                        <option value="Jan">January</option>
                                        <option value="Feb">February</option>
                                        <option value="Mar">March</option>
                                        <option value="Apr">April</option>
                                        <option value="May">May</option>
                                        <option value="Jun">June</option>
                                        <option value="Jul">July</option>
                                        <option value="Aug">August</option>
                                        <option value="Sep">September</option>
                                        <option value="Oct">October</option>
                                        <option value="Nov">November</option>
                                        <option value="Dec">December</option>
                                    </select>
                                </div>
                                <div class="form-col">
                                    <input type="number" class="form-input" id="project-start-year" name="start_year" placeholder="Year" min="1900" max="2099" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-col">
                        <div class="form-group">
                            <label class="form-label">End Date</label>
                            <div class="form-row">
                                <div class="form-col">
                                    <select class="form-select" id="project-end-month" name="end_month" required>
                                        <option value="">Month</option>
                                        <option value="Jan">January</option>
                                        <option value="Feb">February</option>
                                        <option value="Mar">March</option>
                                        <option value="Apr">April</option>
                                        <option value="May">May</option>
                                        <option value="Jun">June</option>
                                        <option value="Jul">July</option>
                                        <option value="Aug">August</option>
                                        <option value="Sep">September</option>
                                        <option value="Oct">October</option>
                                        <option value="Nov">November</option>
                                        <option value="Dec">December</option>
                                    </select>
                                </div>
                                <div class="form-col">
                                    <input type="number" class="form-input" id="project-end-year" name="end_year" placeholder="Year" min="1900" max="2099" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Project URL (Optional)</label>
                    <input type="url" class="form-input" id="project-url" name="url" placeholder="e.g. https://example.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea" id="project-description" name="description" placeholder="Describe your project" required></textarea>
                </div>
                <button type="submit" class="save-btn" id="save-project">Save</button>
            </form>
        </div>
    </div>

    <!-- Languages Modal -->
    <div class="modal-overlay" id="language-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Add/Edit Language</h3>
                <button class="modal-close">&times;</button>
            </div>
            <!-- Wrap the content in a <form> element -->
            <form id="language-form" data-table="languages">
                <!-- Hidden input for the language ID (for editing) -->
                <input type="hidden" id="language-id" name="id" value="">

                <!-- Language Name -->
                <div class="form-group">
                    <label class="form-label">Language</label>
                    <input type="text" class="form-input" id="language-name" name="language" placeholder="e.g., English" required>
                </div>

                <!-- Proficiency Level -->
                <div class="form-group">
                    <label class="form-label">Proficiency</label>
                    <select class="form-select" id="language-proficiency" name="proficiency" required>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                        <option value="Fluent">Fluent</option>
                        <option value="Native">Native</option>
                    </select>
                </div>

                <!-- Save Button -->
                <button type="button" class="save-btn" id="save-language">Save</button>
            </form>
        </div>
    </div>

    <!-- Certificate Modal -->
    <div class="modal-overlay" id="certificate-modal">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Add/Edit Certificate</h3>
                <button class="modal-close">&times;</button>
            </div>
            <!-- Wrap the content in a <form> element -->
            <form id="certificate-form" data-table="certificates">
                <!-- Hidden input for the certificate ID (for editing) -->
                <input type="hidden" id="certificate-id" name="id" value="">

                <!-- Certificate Name -->
                <div class="form-group">
                    <label class="form-label">Certificate Name</label>
                    <input type="text" class="form-input" id="certificate-name" name="name" placeholder="e.g., AWS Certified Solutions Architect" required>
                </div>

                <!-- Organization -->
                <div class="form-group">
                    <label class="form-label">Organization</label>
                    <input type="text" class="form-input" id="certificate-organization" name="organization" placeholder="e.g., Amazon Web Services" required>
                </div>

                <!-- Certificate URL -->
                <div class="form-group">
                    <label class="form-label">Certificate URL</label>
                    <input type="url" class="form-input" id="certificate-url" name="certificate_url" placeholder="e.g., https://example.com/certificate">
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label class="form-label">Description</label>
                    <textarea class="form-textarea" id="certificate-description" name="description" placeholder="Describe the certificate"></textarea>
                </div>

                <!-- Save Button -->
                <button type="button" class="save-btn" id="save-certificate">Save</button>
            </form>
        </div>
    </div>

    <!-- Include JavaScript -->
    <script src="js/script.js"></script>
    <script>
        // Pass the user_id from PHP to JavaScript
        const user_id = <?php echo json_encode($user_id); ?>;

        // Function to hide a modal
        function hideModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'none'; // Hide the modal
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to the save button for profile image
            document.getElementById('save-profile-image').addEventListener('click', function(event) {
                event.preventDefault(); // Prevent default form submission

                const form = document.getElementById('profile-image-form');
                if (!form) {
                    console.error('Form element not found!');
                    return;
                }

                // Check if the form is valid
                if (!form.checkValidity()) {
                    form.reportValidity(); // Trigger browser validation messages
                    return; // Exit if the form is invalid
                }

                // Create FormData object from the form
                const formData = new FormData(form);
                formData.append('user_id', user_id); // Add user_id to the form data
                formData.append('table', 'profile_images'); // Add table name to the form data

                // Log FormData entries for debugging
                for (let [key, value] of formData.entries()) {
                    //console.log(key + ': ' + value);
                }

                // Send AJAX request to the PHP script
                fetch('components/update_data.php', {
                        method: 'POST',
                        body: formData // Send FormData directly (no need to set Content-Type header)
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json(); // Try to parse the response as JSON
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Profile image updated successfully!');
                            hideModal('profile-modal'); // Close the modal
                            window.location.reload(); // Reload the page to reflect changes
                        } else {
                            alert('Error updating profile image: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Log the raw response for debugging
                        fetch('components/update_data.php', {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.text()) // Get the raw response as text
                            .then(text => console.error('Raw response:', text)) // Log the raw response
                            .catch(err => console.error('Error fetching raw response:', err));
                    });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Add event listener to all save buttons
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('save-btn')) {
                    const form = event.target.closest('form');

                    if (!form) {
                        console.error('Form element not found!');
                        return; // Exit if the form is not found
                    }

                    // Check if the form is valid
                    if (!form.checkValidity()) {
                        // If the form is invalid, trigger the browser's validation messages
                        form.reportValidity();
                        return; // Exit and do not proceed with AJAX submission
                    }

                    // Prevent default form submission only if the form is valid
                    event.preventDefault();

                    // Get the table name from the form's data-type attribute
                    const table = form.getAttribute('data-table');
                    if (!table) {
                        console.error('Table name not specified in data-type attribute!');
                        return;
                    }

                    // Create FormData object from the form
                    const formData = new FormData(form);
                    formData.append('user_id', user_id); // Add user_id to the form data
                    formData.append('table', table); // Add table name to the form data

                    // Log FormData entries for debugging
                    for (let [key, value] of formData.entries()) {
                        //console.log(key + ': ' + value);
                    }

                    // Send AJAX request to the PHP script
                    fetch('components/update_data.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json(); // Try to parse the response as JSON
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Data saved successfully!');
                                hideModal('objective-modal'); // Close the modal (optional)
                                window.location.href = 'profile.php'; // Redirect to profile.php
                            } else {
                                alert('Error saving data: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            // Log the raw response for debugging
                            fetch('components/update_data.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => response.text()) // Get the raw response as text
                                .then(text => console.error('Raw response:', text)) // Log the raw response
                                .catch(err => console.error('Error fetching raw response:', err));
                        });
                }
            });
        });

        // Delete buttons event listeners
        document.querySelectorAll(".delete-icon").forEach((icon) => {
            icon.addEventListener("click", function() {
                const id = this.getAttribute("data-id"); // Get the full ID (e.g., "education-8" or "experience-1")
                const table = this.getAttribute("data-table"); // Get the table name (e.g., education, work_experience, etc.)
                const user_id = <?php echo json_encode($_SESSION['user_id']); ?>; // Get the user_id from the session

                //console.log(this);
                //console.log("ID:", id);
                //console.log("Table:", table);
                //console.log("User ID:", user_id);

                if (confirm("Are you sure you want to delete this item?")) {
                    // Send AJAX request to delete the record
                    fetch("components/delete_data.php", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                            },
                            body: JSON.stringify({
                                id: id,
                                table: table,
                                user_id: user_id,
                            }),
                        })
                        .then((response) => {
                            //console.log("Response received from server:", response);
                            return response.json();
                        })
                        .then((data) => {
                            //console.log("Response data:", data);
                            if (data.success) {
                                alert("Record deleted successfully!");
                                window.location.href = 'profile.php'; // Redirect to profile.php
                            } else {
                                alert("Error deleting record: " + data.message);
                            }
                        })
                        .catch((error) => {
                            console.error("Error:", error);
                            alert("An error occurred while deleting the record.");
                        });
                }
            });
        });
    </script>
</body>

</html>