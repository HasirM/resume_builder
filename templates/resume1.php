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
    <title>Professional Resume</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Resume container */
        .resume-container {
            width: 792px;
            height: auto; /* A4 height at 96 DPI */
            padding: 1.5rem;
            font-family: 'Roboto', sans-serif;
            margin: 1rem auto;
            text-align: justify;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Resume header */
        .resume-header h1 {
            color: #4169e1;
            font-size: 28px;
            text-align: center;
            line-height: 0.8;
        }

        .resume-header h2 {
            color: #555;
            font-weight: 500;
            margin-bottom: 0.25rem;
            font-size: 20px;
            text-align: center;
        }

        .contact-info {
            color: #666;
            margin-bottom: 0.5rem;
            font-size: 14px;
            text-align: center;
            line-height: 1.5;
        }

        .summary {
            color: #555;
            font-size: 14px;
            line-height: 1.6;
        }

        /* Section styles */
        .section-title {
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 1rem 0 0.5rem 0;
            font-weight: 600;
            font-size: 16px;
            border-bottom: 1px solid #80808099;
            padding-bottom: 0.3rem;
        }

        .job {
            margin-bottom: 0.5rem;
        }

        .job-header {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .job-title {
            font-weight: 600;
            color: #333;
            font-size: 14px;
            margin-bottom: 0.25rem;
        }

        .job-date {
            color: #333;
            font-weight: 500;
            font-size: 13px;
            text-align: right;
        }

        .company {
            color: #555;
            text-transform: capitalize;
            margin-bottom: 0.1rem;
            margin-bottom: 0.25rem;
            font-size: 13px;
        }

        .url {
            color: #555;
            text-transform: lowercase;
            font-size: 13px;
        }

        .job-description {
            margin-bottom: 0.5rem;
            color: #555;
            font-size: 13px;
            line-height: 1.5;
        }

        /* List styles */
        .resume-container ul {
            padding-left: 1.2rem;
            margin-bottom: 1rem;
        }

        .resume-container li {
            margin-bottom: 0.4rem;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Skills section */
        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 10px;
        }

        .skill-category {
    border: 1px solid #ccc;
    padding: 7px;
    border-radius: 8px;
    background-color: #f9f9f9;
    text-align: center;
}

        .skill-name {
            font-weight: bold;
            font-size: 14px;
            text-transform: capitalize;
        }

        .skill-details {
            color: #555;
            font-size: 13px;
        }

        .language-grid {
            display: flex;
            gap: 5px;
        }
    </style>
</head>

<body>
    <!-- Resume container -->
    <div class="resume-container">
        <!-- Resume header -->
        <div class="resume-header">
            <h1><?php echo htmlspecialchars($personal_info['full_name'] ?? 'Your Name'); ?></h1>
            <h2><?php echo htmlspecialchars($personal_info['designation'] ?? 'Job Title'); ?></h2>
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
            <p class="summary">
                <?php echo htmlspecialchars($personal_info['career_objective'] ?? 'A brief summary about yourself.'); ?>
            </p>
        </div>

        <!-- Work Experience Section -->
        <?php if (!empty($work_experience)): ?>
            <h3 class="section-title">Work Experience</h3>
            <?php foreach ($work_experience as $job): ?>
                <div class="job">
                    <div class="job-header">
                        <div class="job-title"><?php echo htmlspecialchars($job['profile'] ?? 'Job Title'); ?></div>
                        <div class="job-date">
                            <?php echo htmlspecialchars($job['start_date'] ?? ''); ?> –
                            <?php echo htmlspecialchars($job['end_date'] ?? 'Present'); ?>
                        </div>
                    </div>
                    <div class="company"><?php echo htmlspecialchars($job['organization'] ?? 'Company Name'); ?></div>
                    <p class="job-description">
                        <?php echo htmlspecialchars($job['description'] ?? 'Job description goes here.'); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Projects Section -->
        <?php if (!empty($projects)): ?>
            <h3 class="section-title">Projects</h3>
            <?php foreach ($projects as $project): ?>
                <div class="job">
                    <div class="job-header">
                        <div class="job-title"><?php echo htmlspecialchars($project['title'] ?? 'Project Title'); ?></div>
                        <div class="job-date">
                            <?php echo htmlspecialchars($project['start_month'] ?? ''); ?> <?php echo htmlspecialchars($project['start_year'] ?? ''); ?> –
                            <?php echo htmlspecialchars($project['end_month'] ?? ''); ?> <?php echo htmlspecialchars($project['end_year'] ?? ''); ?>
                        </div>
                    </div>
                    <div class="url"><?php echo htmlspecialchars($project['url'] ?? ''); ?></div>
                    <p class="job-description">
                        <?php echo htmlspecialchars($project['description'] ?? 'Project description goes here.'); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Education Section -->
        <?php if (!empty($education)): ?>
            <h3 class="section-title">Education</h3>
            <?php foreach ($education as $edu): ?>
                <div class="job">
                    <div class="job-header">
                        <div class="job-title"><?php echo htmlspecialchars($edu['college'] ?? 'University Name'); ?></div>
                        <div class="job-date">
                            <?php echo htmlspecialchars($edu['start_year'] ?? 'Start Date'); ?> –
                            <?php echo htmlspecialchars($edu['end_year'] ?? 'End Date'); ?>
                        </div>
                    </div>
                    <div class="company">
                        <?php echo htmlspecialchars($edu['degree'] ?? 'Degree Name'); ?> in <?php echo htmlspecialchars($edu['stream'] ?? 'Stream Name'); ?>
                    </div>
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
</body>

</html>