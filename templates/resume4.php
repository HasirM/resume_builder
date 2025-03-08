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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    .resume-container {
      width: 792px;
      height: auto;
      font-family: "montserrat", sans-serif;
      margin: 1rem auto;
      text-align: justify;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      line-height: 1.15;
    }

    /* Nested styles under .resume-container */
    .resume-container header {
      display: flex;
      padding: 20px 30px 15px 30px;
      background-color: #f8f8f8;
      border-bottom: 1px solid #eaeaea;
    }

    .resume-container .initials {
      background-color: #333;
      color: white;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      font-weight: bold;
      margin-right: 20px;
    }

    .resume-container .header-content {
      flex: 1;
      width: 50%;
    }

    .resume-container h1 {
      font-size: 28px;
      font-weight: 700;
      text-transform: uppercase;
      color: #333;
    }

    .resume-container h2 {
      font-size: 16px;
      font-weight: 500;
      color: #666;
      margin-bottom: 10px;
    }

    .resume-container .contact-info {
      text-align: left;
      font-size: 14px;
      line-height: 1.3;
      color: #666;
      width: 70%;
    }

    .resume-container .resume-content {
      display: flex;
      padding: 0 30px 20px 30px;
    }

    .resume-container main {
      flex: 2;
      padding-right: 30px;
    }

    .resume-container aside {
      flex: 1;
      border-left: 1px solid #eaeaea;
      padding-left: 30px;
      text-align: left;
    }

    .resume-container section {
      margin-bottom: 15px;
    }

    .resume-container h3 {
      font-size: 16px;
      font-weight: 600;
      margin-bottom: 7px;
      color: #333;
      border-bottom: 2px solid #eaeaea;
      padding-bottom: 5px;
    }

    .resume-container h4 {
      font-size: 14px;
      font-weight: 600;
      color: #444;
      margin-bottom: 3px;
    }

    .resume-container p {
      margin-bottom: 7px;
      font-size: 14px;
    }

    .resume-container .header-profile {
    width: 17%;
    aspect-ratio: 1;
    height: 100%;
    overflow: hidden;
    border: 3px solid #e5e7eb;
    display: flex
;
    align-items: center;
    justify-content: center;
    background-color: #f3f4f6;
}

    .resume-container .header-profile img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .resume-container .job,
    .resume-container .project {
      margin-bottom: 10px;
    }

    .resume-container .job-header,
    .resume-container .project-header {
      margin-bottom: 5px;
    }

    .resume-container .job-info,
    .resume-container .project-info,
    .resume-container .edu-date-location {
      display: flex;
      gap: 7px;
      font-size: 14px;
      justify-content: space-between;
      color: #666;
      margin-bottom: 10px;
    }

    .resume-container .company {
      font-weight: 500;
    }

    .resume-container .school {
      font-weight: 500;
      font-size: 14px;
      color: #666;
    }

    .resume-container ul {
      padding-left: 20px;
    }

    .resume-container li {
      font-size: 14px;
    }

    .resume-container .skills-container {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }

    .resume-container .skill {
      background-color: #f0f0f0;
      padding: 5px 10px;
      border-radius: 4px;
      font-size: 13px;
    }

    .resume-container .achievement {
      margin-bottom: 20px;
    }

    .resume-container .achievement h4 {
      color: #333;
      margin-bottom: 5px;
    }

    .resume-container .achievement p {
      font-size: 13px;
    }

    .resume-container .cert {
      margin-bottom: 10px;
    }

    .resume-container .cert p {
      font-size: 13px;
    }

    .resume-container .edu {
      margin-bottom: 10px;
    }

    .edu .date {
      margin-top: 3px;
    }

    .job-details {
      display: flex;
      gap: 4px;
    }

    .summary {
      padding: 15px 30px;
      margin: 0 !important;
    }

    .skill-name {
      margin-bottom: 5px;
      font-size: 16px;
      color: #000;
      text-transform: capitalize;
    }

    .skill-details {
      color: #4b5563;
      font-size: 15px;
    }

    .language-category {
      margin-bottom: 2px;
    }
  </style>
</head>

<body>
  <div class="resume-container">
    <header>
      <div class="header-content">
        <h1><?php echo htmlspecialchars($personal_info['full_name'] ?? 'Your Name'); ?></h1>
        <h2><?php echo htmlspecialchars($personal_info['designation'] ?? 'Your Designation'); ?></h2>
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
    </header>

    <!-- Summary Section -->
    <section class="summary">
      <h3>SUMMARY</h3>
      <p><?php echo htmlspecialchars($personal_info['career_objective'] ?? 'A brief summary about yourself.'); ?></p>
    </section>

    <div class="resume-content">
      <main>
        <!-- Experience Section -->
        <?php if (!empty($work_experience)): ?>
          <section class="experience">
            <h3>EXPERIENCE</h3>
            <?php foreach ($work_experience as $job): ?>
              <div class="job">
                <div class="job-header">
                  <h4><?php echo htmlspecialchars($job['profile'] ?? 'Job Title'); ?></h4>
                  <div class="job-info">
                    <div class="job-details">
                      <div class="company"><?php echo htmlspecialchars($job['organization'] ?? 'Company Name'); ?>,</div>
                      <div class="location"><?php echo htmlspecialchars($job['location'] ?? 'Location'); ?></div>
                    </div>
                    <div class="date-location"><?php echo htmlspecialchars($job['start_date'] ?? 'Start Date'); ?> – <?php echo htmlspecialchars($job['end_date'] ?? 'End Date'); ?></div>
                  </div>
                </div>
                <ul>
                  <li><?php echo htmlspecialchars($job['description'] ?? 'Job description goes here.'); ?></li>
                </ul>
              </div>
            <?php endforeach; ?>
          </section>
        <?php endif; ?>

        <!-- Projects Section -->
        <?php if (!empty($projects)): ?>
          <section class="projects">
            <h3>PROJECTS</h3>
            <?php foreach ($projects as $project): ?>
              <div class="project">
                <div class="project-header">
                  <h4><?php echo htmlspecialchars($project['title'] ?? 'Project Title'); ?></h4>
                  <div class="project-info">
                    <div class="date-location"><?php echo htmlspecialchars($project['start_month'] ?? 'Start Month'); ?> <?php echo htmlspecialchars($project['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($project['end_month'] ?? 'End Month'); ?> <?php echo htmlspecialchars($project['end_year'] ?? 'End Year'); ?></div>
                    <div class="date-location"><?php echo htmlspecialchars($project['url'] ?? ''); ?></div>
                  </div>
                </div>
                <ul>
                  <li><?php echo htmlspecialchars($project['description'] ?? 'Project description goes here.'); ?></li>
                </ul>
              </div>
            <?php endforeach; ?>
          </section>
        <?php endif; ?>
      </main>

      <aside>
        <!-- Education Section -->
        <?php if (!empty($education)): ?>
          <section class="education">
            <h3>EDUCATION</h3>
            <?php foreach ($education as $edu): ?>
              <div class="edu">
                <h4><?php echo htmlspecialchars($edu['degree'] ?? 'Degree Name'); ?></h4>
                <div class="school"><?php echo htmlspecialchars($edu['college'] ?? 'University Name'); ?></div>
                <div class="edu-date-location">
                  <div class="date"><?php echo htmlspecialchars($edu['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($edu['end_year'] ?? 'End Year'); ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </section>
        <?php endif; ?>

        <!-- Certification Section -->
        <?php if (!empty($certificates)): ?>
          <section>
            <h3>CERTIFICATION</h3>
            <?php foreach ($certificates as $certificate): ?>
              <div class="cert">
                <h4><?php echo htmlspecialchars($certificate['name'] ?? 'Certificate Name'); ?>, <span class="certificate-issuer"><?php echo htmlspecialchars($certificate['organization'] ?? ''); ?></span></h4>
                <p><span class="certificate-url"><?php echo htmlspecialchars($certificate['certificate_url'] ?? ''); ?></span></p>
                <p><span class="certificate-description"><?php echo htmlspecialchars($certificate['description'] ?? ''); ?></span></p>
              </div>
            <?php endforeach; ?>
          </section>
        <?php endif; ?>

        <!-- Skills Section -->
        <?php if (!empty($skills)): ?>
          <section class="skills">
            <h3>SKILLS</h3>
            <div class="skills-container">
              <?php
              $skills_list = [];
              foreach ($skills as $skill) {
                $skills_list[] = htmlspecialchars($skill['skills_acquired'] ?? '');
              }
              echo implode(', ', array_filter($skills_list)); // Remove empty values and join with commas
              ?>
            </div>
          </section>
        <?php endif; ?>

        <!-- Languages Section -->
        <?php if (!empty($languages)): ?>
          <section>
            <h3>LANGUAGES</h3>
            <div class="language-grid">
              <?php foreach ($languages as $language): ?>
                <div class="language-category">
                  <span class="skill-name"><?php echo htmlspecialchars($language['language'] ?? 'Language Name'); ?>:</span>
                  <span class="skill-details"><?php echo htmlspecialchars($language['proficiency'] ?? 'Language Proficiency'); ?>,</span>
                </div>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endif; ?>
      </aside>
    </div>
  </div>
</body>

</html>