<?php 

include '../components/fetch_resume_data.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($personal_info['full_name'] ?? 'Resume'); ?> - Resume</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .resume-container {
            width: 792px;
            height: auto;
            font-family: 'Roboto', sans-serif;
            margin: 1rem auto;
            color: #333;
            text-align: justify;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            line-height: 1.5;
        }

        .resume {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .header {
            background-color: #eeeeee;
            padding: 1.5rem 1.5rem 1rem 1.5rem;
        }

        .header-content {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .name-title {
            margin-bottom: 0.5rem;
            width: 50%;
        }

        .name {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
        }

        .designation {
            font-size: 20px !important;
            color: #4b5563 !important;
            margin-top: -0.25rem !important;
            font-family: 'Arial', sans-serif !important;
        }

        .contact-info {
    text-align: left;
    margin-top: 0;
    font-size: 13px;
    color: #666;
}

        .summary {
            margin-top: 0.5rem;
            color: #4b5563;
            font-size: 14px;
            line-height: 1.6;
        }

        .content {
            padding: 1rem 1.5rem 1.5rem 1.5rem;
        }

        .section {
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            border-bottom: 1px solid rgba(31, 41, 55, 0.37);
            margin-bottom: 0.5rem;
        }

        .job {
            margin-bottom: 0.5rem;
        }

        .job-header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: baseline;
        }

        .job-title {
            font-size: 14px;
            font-weight: 600;
            color: #1f2937;
        }

        .job-date {
            font-size: 13px;
            color: #4b5563;
        }

        .job-company {
            font-size: 13px;
            font-style: italic;
            color: #4b5563;
            margin-bottom: 0.2rem;
        }

        .job-description {
            font-size: 13px;
            margin-bottom: 0.2rem;
        }

        .project-description {
            margin-top: 0.2rem;
            font-size: 13px;
        }

        .skills {
            font-size: 13px;
            color:rgb(0, 0, 0);
        }

        .education-degree {
            font-size: 13px;
            color: #4b5563;
        }

        .header-profile {
            width: 17%;
        }

        .header-profile img {
            width: 100%;
            border: 1px solid #999;
        }

        .skill-name {
            margin-bottom: 5px;
            font-size: 14px;
            color: #000;
            text-transform: capitalize;
        }

        .skill-details {
            color: #4b5563;
            font-size: 13px;
        }

        .language-grid {
            display: flex;
            gap: 5px;
        }
    </style>
</head>

<body>
    <div class="resume-container">
        <div class="resume">
            <!-- Header Section -->
            <div class="header">
                <div class="header-content">
                    <div class="name-title">
                        <h1 class="name"><?php echo htmlspecialchars($personal_info['full_name'] ?? 'Your Name'); ?></h1>
                        <h2 class="designation"><?php echo htmlspecialchars($personal_info['designation'] ?? 'Your Designation'); ?></h2>
                        <div class="contact-info">
                            <?php
                            // Define the personal info array with default values
                            $personal_details = [
                                'email' => $personal_info['email'] ?? 'your.email@example.com',
                                'phone' => $personal_info['phone'] ?? '+1-234-567-890',
                                'website' => $personal_info['website'] ?? '',
                                'linkedin' => $personal_info['linkedin'] ?? '',
                                'github' => $personal_info['github'] ?? '',
                                'location' => $personal_info['location'] ?? 'City, State, Country'
                            ];

                            // Filter out empty values
                            $filtered_info = array_filter($personal_details, function($value) {
                                return !empty($value);
                            });

                            // Join the non-empty values with a bullet separator
                            $output = implode(' • ', $filtered_info);

                            // Output the result
                            echo htmlspecialchars($output);
                            ?>
                        </div>
                    </div>
                    <div class="header-profile">
                        <img src="uploads/<?php echo htmlspecialchars($profile_image['image'] ?? 'user.jpeg'); ?>" alt="profile-pic">
                    </div>
                </div>
                <div class="summary">
                    <p><?php echo htmlspecialchars($personal_info['career_objective'] ?? 'A brief summary about yourself.'); ?></p>
                </div>
            </div>

            <!-- Content Section -->
            <div class="content">
                <!-- Work Experience -->
                <?php if (!empty($work_experience)): ?>
                    <div class="section">
                        <h2 class="section-title">Work Experience</h2>
                        <?php foreach ($work_experience as $job): ?>
                            <div class="job">
                                <div class="job-header">
                                    <h3 class="job-title"><?php echo htmlspecialchars($job['profile'] ?? 'Job Title'); ?></h3>
                                    <span class="job-date"><?php echo htmlspecialchars($job['start_date'] ?? 'Start Date'); ?> – <?php echo htmlspecialchars($job['end_date'] ?? 'End Date'); ?></span>
                                </div>
                                <p class="job-company"><?php echo htmlspecialchars($job['organization'] ?? 'Company Name'); ?> | <?php echo htmlspecialchars($job['location'] ?? 'Location'); ?></p>
                                <div class="job-description">
                                    <p><?php echo htmlspecialchars($job['description'] ?? 'Job description goes here.'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Projects -->
                <?php if (!empty($projects)): ?>
                    <div class="section">
                        <h2 class="section-title">Projects</h2>
                        <?php foreach ($projects as $project): ?>
                            <div class="job">
                                <div class="job-header">
                                    <h3 class="job-title"><?php echo htmlspecialchars($project['title'] ?? 'Project Title'); ?></h3>
                                    <span class="job-date"><?php echo htmlspecialchars($project['start_month'] ?? 'Start Month'); ?> <?php echo htmlspecialchars($project['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($project['end_month'] ?? 'End Month'); ?> <?php echo htmlspecialchars($project['end_year'] ?? 'End Year'); ?></span>
                                </div>
                                <p class="project-description"><?php echo htmlspecialchars($project['description'] ?? 'Project description goes here.'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Education -->
                <?php if (!empty($education)): ?>
                    <div class="section">
                        <h2 class="section-title">Education</h2>
                        <?php foreach ($education as $edu): ?>
                            <div class="job">
                                <div class="job-header">
                                    <h3 class="job-title"><?php echo htmlspecialchars($edu['college'] ?? 'University Name'); ?></h3>
                                    <span class="job-date"><?php echo htmlspecialchars($edu['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($edu['end_year'] ?? 'End Year'); ?></span>
                                </div>
                                <p class="education-degree"><?php echo htmlspecialchars($edu['degree'] ?? 'Degree Name'); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Core Skills -->
                <?php if (!empty($skills)): ?>
                    <div class="section">
                        <h2 class="section-title">Core Skills</h2>
                        <p class="skills">
                            <?php
                            $skills_list = [];
                            foreach ($skills as $skill) {
                                $skills_list[] = htmlspecialchars($skill['skills_acquired'] ?? '');
                            }
                            echo implode(', ', array_filter($skills_list)); // Remove empty values and join with commas
                            ?>
                        </p>
                    </div>
                <?php endif; ?>

                <!-- Languages Section -->
        <?php if (!empty($languages)): ?>
            <h3 class="section-title">Languages</h3>
            <div class="language-grid">
                <?php foreach ($languages as $language): ?>
                    <div class="language-category">
                        <span class="skill-name"><?php echo htmlspecialchars($language['language'] ?? 'Language Name'); ?>:</span>
                        <span class="skill-details"><?php echo htmlspecialchars($language['proficiency'] ?? 'Language Proficiency'); ?>,</span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>