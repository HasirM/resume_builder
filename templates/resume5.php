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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <style>
    /* Reset and base styles */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    /* Resume container */
    .resume-container {
      width: 792px;
      height: auto;
      font-family: "montserrat", sans-serif;
      margin: 1rem auto;
      text-align: justify;
      background-color: white;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      line-height: 1.15;
      display: flex;
      flex-direction: row;
      gap: 1.5rem;
    }

    /* Main content */
    .resume-container .main-content {
      flex: 2.5;
      padding: 1.5rem 1.5rem 1.5rem 0;
    }

    /* Sidebar */
    .resume-container .sidebar {
      flex: 1.3;
      background-color: #f9fafb;
      border-radius: 0.5rem;
      text-align: left;
    }

    .sidebar-content {
      padding: 1.5rem;
    }

    /* Header section */
    .resume-container header {
      margin-bottom: 1rem;
    }

    .resume-container h1 {
      font-size: 28px;
      font-weight: 700;
      color: #333;
      margin-bottom: 0.25rem;
      text-transform: uppercase;
    }

    .resume-container h2 {
      font-size: 16px;
      font-weight: 500;
      color: #000;
      text-transform: uppercase;
    }

    .resume-container .contact-info {
      display: flex;
      flex-wrap: wrap;
      gap: 0.5rem;
      font-size: 14px;
      color: #000;
      font-weight: 500;
    }

    /* Section styles */
    .resume-container section {
      margin-bottom: 1rem;
    }

    .resume-container h3 {
      font-size: 18px;
      font-weight: 600;
      color: #333;
      margin-bottom: 0.5rem;
      border-bottom: 2px solid #eaeaea;
      padding-bottom: 0.25rem;
    }

    .resume-container p {
      font-size: 14px;
      color: #000;
    }

    .resume-container ul {
      padding-left: 1.25rem;
      list-style-type: disc;
    }

    .resume-container li {
      font-size: 14px;
      color: #000;
    }

    /* Job and project styles */
    .resume-container .job,
    .resume-container .project,
    .resume-container .edu {
      margin-bottom: 1rem;
    }

    .resume-container .job-header,
    .resume-container .project-header,
    .resume-container .edu-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.25rem;
    }

    .resume-container .job-header h4,
    .resume-container .project-header h4,
    .resume-container .edu-header h4 {
      font-size: 16px;
      font-weight: 600;
      color: #333;
    }

    p.subhead {
      font-weight: 600;
      margin-bottom: 0.25rem;
      color: #666;
    }

    .profile-pic img {
      width: 100%;
      padding: 1.5rem 1.5rem 0 1.5rem;
    }

    .resume-container .job-header p,
    .resume-container .project-header p,
    .resume-container .edu-header p {
      font-size: 14px;
      color: #000;
    }

    span.certificate-issuer {
      font-weight: 500;
    }

    /* Skills section */
    .resume-container .skills-grid {
      font-size: 14px;
    }

    .skill-name,
    .language {
      font-weight: 500;
      text-transform: capitalize;
    }

    .resume-container li {
      margin-bottom: 0.25rem;
    }

    /* Certification section */
    .resume-container .cert {
      margin-bottom: 1rem;
    }

    .resume-container .cert h4 {
      font-weight: 600;
      margin-bottom: 0.25rem;
    }

    /* Languages section */
    .resume-container .languages {
      margin-bottom: 1rem;
      text-transform: capitalize;
    }

    .resume-container .languages h4 {
      font-size: 14px;
      font-weight: 600;
      color: #333;
    }

    .resume-container .languages p {}
  </style>
</head>

<body>
  <div class="resume-container">
    <!-- Sidebar Section -->
    <div class="sidebar">
      <div class="profile-pic">
        <img src="uploads/<?php echo htmlspecialchars($profile_image['image'] ?? 'user.jpeg'); ?>" alt="profile-pic">
      </div>
      <div class="sidebar-content">
        <!-- Contact Section -->
        <section class="contact-info">
          <span><?php echo htmlspecialchars($personal_info['email'] ?? 'your.email@example.com'); ?></span>
          <span><?php echo htmlspecialchars($personal_info['phone'] ?? 'your phone'); ?></span>
          <span><?php echo htmlspecialchars($personal_info['website'] ?? ''); ?></span>
          <span><?php echo htmlspecialchars($personal_info['linkedin'] ?? ''); ?></span>
          <span><?php echo htmlspecialchars($personal_info['github'] ?? ''); ?></span>
          <span><?php echo htmlspecialchars($personal_info['location'] ?? 'City, State, Country'); ?></span>
        </section>

        <!-- Certification Section -->
        <?php if (!empty($certificates)): ?>
          <section>
            <h3>CERTIFICATION</h3>
            <?php foreach ($certificates as $certificate): ?>
              <div class="cert">
                <h4><?php echo htmlspecialchars($certificate['name'] ?? 'certificate name'); ?>, <span class="certificate-issuer"><?php echo htmlspecialchars($certificate['organization'] ?? ''); ?></span></h4>
                <p><span class="certificate-description"><?php echo htmlspecialchars($certificate['description'] ?? ''); ?></span></p>
              </div>
            <?php endforeach; ?>
          </section>
        <?php endif; ?>

        <!-- Skills Section -->
        <?php if (!empty($skills)): ?>
          <section>
            <h3 class="section-title">Skills</h3>
            <div class="skills-grid">
              <?php foreach ($skills as $skill): ?>
                <ul>
                  <li class="skill-category">
                    <span class="skill-name"><?php echo htmlspecialchars($skill['area_of_expertise'] ?? 'Skill Category'); ?>:</span>
                    <span class="skill-details"><?php echo htmlspecialchars($skill['skills_acquired'] ?? 'Skill Details'); ?></span>
                  </li>
                </ul>
              <?php endforeach; ?>
            </div>
          </section>
        <?php endif; ?>

        <!-- Languages Section -->
        <?php if (!empty($languages)): ?>
          <section>
            <h3>LANGUAGES</h3>
            <div class="languages">
              <ul>
                <?php foreach ($languages as $language): ?>
                  <li><span class="language"><?php echo htmlspecialchars($language['language'] ?? 'language'); ?></span> - <span class="language-proficiency"><?php echo htmlspecialchars($language['proficiency'] ?? ''); ?></span></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </section>
        <?php endif; ?>
      </div>
    </div>

    <!-- Main Content Section -->
    <div class="main-content">
      <!-- Header Section -->
      <header>
        <h1><?php echo htmlspecialchars($personal_info['full_name'] ?? 'Your Name'); ?></h1>
        <h2><?php echo htmlspecialchars($personal_info['designation'] ?? 'Your Designation'); ?></h2>
      </header>

      <!-- Summary Section -->
      <section>
        <h3>SUMMARY</h3>
        <p><?php echo htmlspecialchars($personal_info['career_objective'] ?? 'A brief summary about yourself.'); ?></p>
      </section>

      <!-- Experience Section -->
      <?php if (!empty($work_experience)): ?>
        <section>
          <h3>EXPERIENCE</h3>
          <?php foreach ($work_experience as $job): ?>
            <div class="job">
              <div class="job-header">
                <h4><?php echo htmlspecialchars($job['profile'] ?? 'Job Title'); ?></h4>
                <p><?php echo htmlspecialchars($job['start_date'] ?? 'Start Date'); ?> to <?php echo htmlspecialchars($job['end_date'] ?? 'End Date'); ?></p>
              </div>
              <p class="subhead"><?php echo htmlspecialchars($job['organization'] ?? 'Company Name'); ?>, <?php echo htmlspecialchars($job['location'] ?? 'Location'); ?></p>
              <p><?php echo htmlspecialchars($job['description'] ?? 'Job description goes here.'); ?></p>
            </div>
          <?php endforeach; ?>
        </section>
      <?php endif; ?>

      <!-- Project Section -->
      <?php if (!empty($projects)): ?>
        <section>
          <h3>PROJECT</h3>
          <?php foreach ($projects as $project): ?>
            <div class="job">
              <div class="job-header">
                <h4><?php echo htmlspecialchars($project['title'] ?? 'Project Title'); ?></h4>
                <p><?php echo htmlspecialchars($project['start_month'] ?? 'Start Month'); ?> <?php echo htmlspecialchars($project['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($project['end_month'] ?? 'End Month'); ?> <?php echo htmlspecialchars($project['end_year'] ?? 'End Year'); ?></p>
              </div>
              <p><?php echo htmlspecialchars($project['description'] ?? 'Project description goes here.'); ?></p>
            </div>
          <?php endforeach; ?>
        </section>
      <?php endif; ?>

      <!-- Education Section -->
      <?php if (!empty($education)): ?>
        <section>
          <h3>EDUCATION</h3>
          <?php foreach ($education as $edu): ?>
            <div class="edu">
              <div class="edu-header">
                <h4><?php echo htmlspecialchars($edu['degree'] ?? 'Degree Name'); ?></h4>
                <p><?php echo htmlspecialchars($edu['start_year'] ?? 'Start Year'); ?> – <?php echo htmlspecialchars($edu['end_year'] ?? 'End Year'); ?></p>
              </div>
              <p><?php echo htmlspecialchars($edu['college'] ?? 'University Name'); ?></p>
            </div>
          <?php endforeach; ?>
        </section>
      <?php endif; ?>
    </div>
  </div>
</body>

</html>