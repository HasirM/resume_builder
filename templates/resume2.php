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
    <title>Resume</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        .resume-container {
            width: 792px;
            height: auto; 
            padding: 1.5rem;
            font-family: 'Roboto', sans-serif;
            margin: 1rem auto;
            text-align: justify;
            background-color: white;
            line-height: 1.2;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header section */
        .resume-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .resume-header .name-title {
            text-align: left;

        }

        .resume-header h1 {
            margin: 0;
            font-size: 28px;
            color: #333;
            line-height: 1;
        }

        .resume-header h3 {
            margin: 5px 0 0 0;
            font-weight: 400;
            font-size: 20px;
            line-height: 1;
            color: #666;
        }

        .resume-header .contact-info {
    text-align: right;
    width: 50%;
    font-size: 14px;
}

        .resume-header .contact-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        /* Section titles */
        .section-title {
    border-bottom: 2px solid #ccc;
    padding-bottom: 0.25rem;
    margin-bottom: 0.25rem;
    margin-top: 1rem;
    font-size: 16px;
    color: #333;
}

        .contact-info {
            text-align: right;
        }

        .contact-line {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .contact-line p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        /* Lists */
        .resume-container ul {
            list-style: none;
            padding: 0;
        }

        .resume-container ul li::before {
            content: "\2022";
            color: #333;
            font-weight: bold;
            display: inline-block;
            width: 1em;
            margin-left: -1em;
        }

        .resume-container p,
        .resume-container li {
            line-height: 1.6;
            font-size: 14px;
        }

        /* Work experience */
        .job {
            margin-bottom: 0.5rem;
        }

        .job h3 {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .job p {
            font-size: 14px;
            color: #666;
        }

        .job ul {
            padding-left: 1rem;
        }

        .job ul li {
            margin-bottom: 5px;
        }

        /* Projects */
        .project {
            margin-bottom: 0.5rem;
        }

        .project h3, .job-title {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .project p {
            font-size: 14px;
            color: #666;
        }

        .company {
            font-size: 14px;
            color: #666;
            font-weight: 600;
        }

        /* Skills section */
        .skills-grid {
    display: flex
;
    flex-wrap: wrap;
}

        .skill-category {
            text-align: center;
            margin-right: 0.7rem;
        }

        .skill-name {
            font-weight: bold;
            margin-bottom: 0.25rem;
            font-size: 14px;
        }

        .skill-details {
            color: #555;
            font-size: 14px;
        }

        /* Education section */
        .education-item {
            margin-bottom: 1rem;
        }

        .education-item h4 {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .education-item p {
            font-size: 14px;
            line-height: 1.1;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="resume-container">
        <!-- Header Section -->
        <div class="resume-header">
            <div class="name-title">
                <h1><?php echo htmlspecialchars($personal_info['full_name'] ?? 'Your Name'); ?></h1>
                <h3><?php echo htmlspecialchars($personal_info['designation'] ?? 'Your Designation'); ?></h3>
            </div>
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

        <!-- Summary Section -->
        <p><?php echo htmlspecialchars($personal_info['career_objective'] ?? 'A brief summary about yourself.'); ?></p>

        <!-- Work Experience Section -->
        <?php if (!empty($work_experience)): ?>
            <h2 class="section-title">Work Experience</h2>
            <?php foreach ($work_experience as $job): ?>
                <div class="job">
                    <div class="job-header">
                        <div class="job-title"><h3><?php echo htmlspecialchars($job['profile'] ?? 'Job Title'); ?></h3></div>
                        <div class="company"><?php echo htmlspecialchars($job['organization'] ?? 'Company Name'); ?></div>
                        <div class="job-date">
                            <p><?php echo htmlspecialchars($job['start_date'] ?? 'Start Date'); ?> –
                            <?php echo htmlspecialchars($job['end_date'] ?? 'End Date'); ?></p>
                        </div>
                    </div>
                    <p class="job-description">
                        <?php echo htmlspecialchars($job['description'] ?? 'Job description goes here.'); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Projects Section -->
        <?php if (!empty($projects)): ?>
            <h2 class="section-title">Projects</h2>
            <?php foreach ($projects as $project): ?>
                <div class="project">
                    <h3><?php echo htmlspecialchars($project['title'] ?? 'Project Title'); ?></h3>
                    <p><?php echo htmlspecialchars($project['start_month'] ?? 'Start Month'); ?> <?php echo htmlspecialchars($project['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($project['end_month'] ?? 'End Month'); ?> <?php echo htmlspecialchars($project['end_year'] ?? 'End Year'); ?></p>
                    <p><?php echo htmlspecialchars($project['description'] ?? 'Project description goes here.'); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Certificates Section -->
        <!-- <?php if (!empty($certificates)): ?>
            <h2 class="section-title">Certificates</h2>
            <?php foreach ($certificates as $certificate): ?>
                <div class="project">
                    <h3><?php echo htmlspecialchars($certificate['name'] ?? 'Certificate Name'); ?></h3>
                    <p><?php echo htmlspecialchars($certificate['organization'] ?? ''); ?></p>
                    <p><?php echo htmlspecialchars($certificate['certificate_url'] ?? ''); ?></p>
                    <p><?php echo htmlspecialchars($certificate['description'] ?? 'Project description goes here.'); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?> -->

        <!-- Education Section -->
        <?php if (!empty($education)): ?>
            <h2 class="section-title">Education</h2>
            <?php foreach ($education as $edu): ?>
                <div class="education-item">
                    <h4><?php echo htmlspecialchars($edu['degree'] ?? 'Degree Name'); ?></h4>
                    <p><?php echo htmlspecialchars($edu['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($edu['end_year'] ?? 'End Year'); ?></p>
                    <p><?php echo htmlspecialchars($edu['college'] ?? 'University Name'); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Skills Section -->
        <?php if (!empty($skills)): ?>
            <h3 class="section-title">Skills</h3>
            <div class="skills-grid">
                <?php foreach ($skills as $skill): ?>
                    <div class="skill-category">
                        <span class="skill-name"><?php echo htmlspecialchars($skill['area_of_expertise'] ?? 'Skill Category'); ?>:</span>
                        <span class="skill-details"><?php echo htmlspecialchars($skill['skills_acquired'] ?? 'Skill Details'); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>