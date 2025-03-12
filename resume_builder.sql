-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 12, 2025 at 07:15 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `resume_builder`
--

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

DROP TABLE IF EXISTS `certificates`;
CREATE TABLE IF NOT EXISTS `certificates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `certificate_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `user_id`, `name`, `organization`, `description`, `certificate_url`) VALUES
(5, 3, 'AWS Certified Solutions Architect', 'Amazon Web Services', 'Certified in designing distributed systems on AWS.', 'https://aws.certificate.com'),
(6, 3, 'Google Cloud Professional Data Engineer', 'Google Cloud', 'Certified in building data processing systems on Google Cloud.', 'https://gcp.certificate.com');

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `degree` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stream` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `college` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_year` int DEFAULT NULL,
  `end_year` int DEFAULT NULL,
  `score_type` enum('percentage','cgpa') COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `education`
--

INSERT INTO `education` (`id`, `user_id`, `degree`, `stream`, `college`, `start_year`, `end_year`, `score_type`, `score`) VALUES
(18, 3, 'Master of Science', 'Data Science', 'Stanford University', 2019, 2021, 'cgpa', '3.9'),
(15, 3, 'Bachelor of Science', 'Computer Science', 'Harvard University', 2015, 2019, 'cgpa', '3.8');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `language` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `proficiency` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `user_id`, `language`, `proficiency`) VALUES
(8, 3, 'English', 'Fluent'),
(9, 3, 'Spanish', 'Intermediate');

-- --------------------------------------------------------

--
-- Table structure for table `personal_info`
--

DROP TABLE IF EXISTS `personal_info`;
CREATE TABLE IF NOT EXISTS `personal_info` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `career_objective` text COLLATE utf8mb4_unicode_ci,
  `designation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `linkedin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_info`
--

INSERT INTO `personal_info` (`id`, `user_id`, `full_name`, `email`, `phone`, `location`, `career_objective`, `designation`, `website`, `github`, `linkedin`) VALUES
(8, 3, 'Benny Bilson', 'john.doe@example.com', '9876543210', '                                New York, USA                            ', 'Experienced software developer with a passion for building scalable web applications.', '                                Senior Software Engineer                            ', '', 'https://github.com/johndoe', 'https://linkedin.com/in/johndoe');

-- --------------------------------------------------------

--
-- Table structure for table `profile_images`
--

DROP TABLE IF EXISTS `profile_images`;
CREATE TABLE IF NOT EXISTS `profile_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profile_images`
--

INSERT INTO `profile_images` (`id`, `user_id`, `image`) VALUES
(2, 3, 'johndoe.png');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
CREATE TABLE IF NOT EXISTS `projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_month` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `start_year` int DEFAULT NULL,
  `end_month` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `end_year` int DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `user_id`, `title`, `start_month`, `start_year`, `end_month`, `end_year`, `url`, `description`) VALUES
(7, 3, 'Resume Builder App', 'Jan', 2023, 'Mar', 2023, 'https://resumebuilder.com', 'Designed and developed a full-stack web application using React and Node.js to help users create professional resumes. Implemented features like real-time preview, PDF export, and template customization. Deployed the application on AWS, ensuring high availability and scalability.'),
(9, 3, 'AI-Powered Chatbot', 'Sep', 2021, 'Dec', 2021, 'https://aichatbot.com', 'Developed an AI-powered chatbot using Python and TensorFlow to automate customer support for an e-commerce website. Trained the model on a dataset of 100,000 customer queries, achieving an accuracy of 92%. Integrated the chatbot with the website’s backend, reducing response time by 50%.');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
CREATE TABLE IF NOT EXISTS `skills` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `area_of_expertise` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `skills_acquired` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `user_id`, `area_of_expertise`, `skills_acquired`) VALUES
(6, 3, 'Programming Languages', 'Python, JavaScript, Java, C++'),
(7, 3, 'Web Development', 'React, Node.js, Django, Flask'),
(8, 3, 'Cloud Computing', 'AWS, Azure, Google Cloud');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `created_at`, `first_name`, `last_name`) VALUES
(3, 'test@gmail.com', '$2y$10$G6GEdyMCfvjxJiYaV7K7/.uHa3SMfyDCIdr9aaA01GRigoLwfarzC', '2025-03-03 17:25:34', 'Test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `work_experience`
--

DROP TABLE IF EXISTS `work_experience`;
CREATE TABLE IF NOT EXISTS `work_experience` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `profile` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `organization` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `type` enum('job','internship') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_experience`
--

INSERT INTO `work_experience` (`id`, `user_id`, `profile`, `organization`, `location`, `description`, `type`, `start_date`, `end_date`) VALUES
(7, 3, 'Software Developer', 'Google', 'Mountain View, USA', 'Developed scalable backend systems for Google Search, optimizing search algorithms to improve response time by 20%. Collaborated with cross-functional teams to design and implement new features, ensuring high availability and fault tolerance.', '', '2019-06-01', '2021-05-31'),
(8, 3, 'Senior Software Engineer', 'Microsoft', 'Redmond, USA', 'Led a team of 10 engineers to build cloud-based solutions using Azure, including a microservices architecture for enterprise clients. Spearheaded the migration of legacy systems to the cloud, reducing operational costs by 30%. Conducted code reviews and mentored junior developers to improve code quality and team productivity.', '', '2021-06-01', NULL),
(9, 3, 'Software Engineering Intern', 'Facebook', 'Menlo Park, USA', 'Worked on the development of Facebook’s newsfeed algorithm, implementing machine learning models to personalize content for users. Assisted in debugging and optimizing backend services, improving system performance by 15%. Gained hands-on experience with large-scale distributed systems.', 'internship', '2018-06-01', '2018-08-31');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
