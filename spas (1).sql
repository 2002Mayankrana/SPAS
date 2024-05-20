-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 04:53 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spas`
--

-- --------------------------------------------------------

--
-- Table structure for table `approved_projects`
--

CREATE TABLE `approved_projects` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_projects`
--

INSERT INTO `approved_projects` (`id`, `student_id`, `mentor_id`) VALUES
(56, 38, 14),
(57, 47, 14),
(58, 48, 14);

-- --------------------------------------------------------

--
-- Table structure for table `assigned_tasks`
--

CREATE TABLE `assigned_tasks` (
  `task_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `task_description` text DEFAULT NULL,
  `task_status` enum('pending','in_progress','completed') DEFAULT NULL,
  `uploads` varchar(255) DEFAULT NULL,
  `task_deadline` date DEFAULT NULL,
  `completion_time` date DEFAULT NULL,
  `acknowledge` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned_tasks`
--

INSERT INTO `assigned_tasks` (`task_id`, `student_id`, `mentor_id`, `task_description`, `task_status`, `uploads`, `task_deadline`, `completion_time`, `acknowledge`) VALUES
(26, 38, 14, 'fdbgnfnfmn', 'completed', 'uploads/2.png', '2024-05-21', '2024-05-20', 1),
(27, 38, 14, 'fdbbvbbbbbbbbbbbb', 'completed', 'uploads/2.png', '2024-05-13', '2024-05-19', 1),
(28, 38, 14, 'ankncnbcvbhg vjuhxc', 'completed', 'uploads/3.png', '2024-05-21', '2024-05-20', 1),
(30, 48, 14, 'complet your modul 1', 'in_progress', NULL, '2024-05-19', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `declined_projects`
--

CREATE TABLE `declined_projects` (
  `id` int(50) NOT NULL,
  `mentor_id` int(50) NOT NULL,
  `student_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `declined_projects`
--

INSERT INTO `declined_projects` (`id`, `mentor_id`, `student_id`) VALUES
(37, 14, 1),
(38, 14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `mentors`
--

CREATE TABLE `mentors` (
  `mentor_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `expertise_in` varchar(255) NOT NULL,
  `contact` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mentors`
--

INSERT INTO `mentors` (`mentor_id`, `username`, `email`, `password`, `designation`, `expertise_in`, `contact`) VALUES
(14, 'jaipal', '2002mayank.rana@gmail.com', '202cb962ac59075b964b07152d234b70', 'professor', 'Cyber Security based', 1234),
(23, 'kashish', 'caml20065@glbitm.ac.in', '202cb962ac59075b964b07152d234b70', 'professor', 'Block Chain based', 1234),
(24, 'priya singh', 'p@gmail.com', '202cb962ac59075b964b07152d234b70', 'professor', 'AI & ML based, Cyber Security based, Block Chain based, Web Development based', 1234),
(26, 'Gaurav', 'caiml20065@gmail.com', '202cb962ac59075b964b07152d234b70', 'professor', 'AI & ML based, API development', 1234);

-- --------------------------------------------------------

--
-- Table structure for table `mentor_student_relationships`
--

CREATE TABLE `mentor_student_relationships` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL,
  `status` enum('Pending','Accepted','Declined','Requested','Idea Suggested') DEFAULT 'Pending',
  `suggested_idea` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `student_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `grp` varchar(100) NOT NULL,
  `project_name` varchar(255) NOT NULL,
  `tech` varchar(255) NOT NULL,
  `idea` varchar(10000) NOT NULL,
  `summarized_text` varchar(1000) DEFAULT NULL,
  `mentor_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`student_id`, `username`, `email`, `password`, `grp`, `project_name`, `tech`, `idea`, `summarized_text`, `mentor_id`) VALUES
(1, 'mayank', 'caml20065@gmail.com', '202cb962ac59075b964b07152d234b70', 'i21', 'spas', 'AI & ML based, Web Development based', 'The term women empowerment is used to refer to the empowerment of women by providing them education and equal growth and employment opportunities equivalent to the men in society. In a broader perspective, women empowerment includes every step taken in different walks of life, with the intention of making the women more empowered.\r\n\r\nThe Need for Women Empowerment\r\n\r\nSince centuries women around the world are subjected to various kinds of discrimination and atrocities at the hands of the men. They are more susceptible to domestic violence and considered inferior to the men.\r\n\r\nGirls in rural areas are not sent to the school as spending on the education of a girl is considered a failed investment and not necessary. On the other hand, boys are provided complete primary and elementary education and are seen as the backbone of the family and society.\r\n\r\nEconomic Empowerment of Women\r\n\r\nEconomic empowerment of women refers to making the women economically independent by developing their skills and making them employable. Policymakers work together with NGOs and other relevant organizations to arrange programs for women education and skill improvement, so that they can be either gainfully employed or do a business of their own.\r\n\r\nThe financial independence of women is the first step towards improving their social status and self-esteem. Unless women become independent in fending for themselves and their families, all talks of women empowerment are useless.\r\n\r\nPolitical Empowerment of Women\r\n\r\nPolitical empowerment refers to the involvement of women in parliamentary positions and policymaking. As per 2017 estimates, women constitute around 23.6% of parliamentary positions, globally.\r\n\r\nSome methods of political empowerment of women are providing them the right to vote and allowing them to run high offices. Making reservations for the women in parliaments and other constitutional positions will help increase their stake in the political and administrative sphere.', 'Women empowerment includes education, equal growth, and employment opportunities for women equivalent to the men in society. Economic empowerment of women involves making women economically independent by developing their skills and employing them. Political empowerment of women involves their participation in parliamentary positions and policymaking.', 14),
(4, 'manan', 'manan@gmail.com', '202cb962ac59075b964b07152d234b70', 'i21', 'cas', 'AI & ML based, Web Development based', 'Women Empowerment is a term used to indicate steps taken for improving the status of women in society. It refers to their social, political, educational, medical, economical and other forms of improvement. It is very essential for women to be provided equal and opportunities as that of men.\r\n\r\nEducation and Women Empowerment\r\n\r\nThe role of education is very essential when it comes to women empowerment. It is only through education that women gain access to better opportunities and income. Without education, they are forced to take up low paying jobs and always remain dependent on the men for their needs.\r\n\r\nEducation is the only tool to make women financially independent and able to make financial decisions of their own. An educated woman is able to pursue her own dream and decide about her life and career.\r\n\r\nWomen Empowerment and Sustainable Development\r\n\r\nWomen empowerment is a key factor in achieving the 2030 Sustainable Development Goals. SDG goal number 5 targets gender equality and women empowerment as the fundamental requirements for an equitable society and bringing sustainable development.\r\n\r\nWomen around the world share the primary responsibilities of nutrition of the children, their education, and the management of the household. The presence of women in areas like environment, health and other vital sectors is also increasing.\r\n\r\nSDG 2030 aims for gender equality by eliminating all the root causes that curtail women’s rights in every sphere of life. Women are less paid for the same work than men in several developing as well as developed nations.\r\n\r\nUnless gender equality is achieved and women enjoy equal rights and opportunities as men, sustainable development would still be a distant dream. Educating women and bringing them on the forefront is the first thing to do if we ever want to achieve SDG goals by 2030.', 'Women empowerment is crucial for achieving the 2030 Sustainable Development Goals, as it ensures equal opportunities for women and promotes sustainable development. Education is crucial for women, as it gives them access to better opportunities and income and allows them to make financial decisions independently.', 14),
(9, 'shivam', 'shiva2002@gmail.com', '202cb962ac59075b964b07152d234b70', 'f2', 'w', 'AI & ML based', 'T', 'The Internet of Things (IoT) is a network of physical objects embedded with sensors, software, and other technologies, connecting devices and systems over the internet to solve complex problems. In India, IoT is being integrated into various sectors to improve efficiency and solve complex problems, including education.', 24),
(16, 'bhoomi', 'b@gmail.com', '202cb962ac59075b964b07152d234b70', 't4', 'ww', 'AI & ML based', 'T', 'The The Internet of Things, commonly abbreviated as IoT, is a network of physical objects embedded with sensors, software, and other technologies for the purpose of connecting and exchanging data with other devices and systems over the internet.', 24),
(17, 'Rakesh', 'r@gmail.com', '202cb962ac59075b964b07152d234b70', 'r21', 'sss', 'AI & ML based, Block Chain based', 'W', ' Women constitute half of the population however her contribution to the economy of India is very low . This depicts that there are not equal opportunities available for women in society . Empowerment of women would mean encouraging them for their socio-economic development . The Indian government is also working to make India more suitable for women so they can also get equal opportunities .', 23),
(38, 'yunus', '2002mayank.rana@gmail.com', '202cb962ac59075b964b07152d234b70', 't', 'd', 'AI & ML based', 'The Collaborative Task Management Web Application is a dynamic online platform designed to streamline team collaboration, task assignment, and project\'s management. In today fast-paced work environment, effective coordination among team members is crucial. This web application provides an intuitive and efficient solution to enhance teamwork, increase productivity, and meet project deadlines. Users can create projects, break them down into tasks, and assign responsibilities to team members. The platform supports real-time collaboration, allowing users to discuss tasks, share files, and provide updates within the application. The interface is user-friendly, featuring drag-and-drop functionality for task organization and priority setting. Key features include a centralized dashboard displaying project timelines, task progress, and upcoming deadlines. The application also integrates notifications and email alerts to keep team members informed about important updates and approaching deadlines. To enhance project tracking, the platform incorporates customizable reporting tools, enabling users to generate insights into team performance and project completion rates. Security measures, such as user authentication and encrypted communication, ensure the protection of sensitive project information. The Collaborative Task Management Web Application aims to enhance team communication, streamline project workflows, and ultimately contribute to the success of collaborative endeavors in various professional settings.', 'The Collaborative Task Management Web Application is a dynamic online platform designed to streamline team collaboration, task assignment, and project\'s management. It features a centralized dashboard displaying project timelines, task progress, and upcoming deadlines, as well as customizable reporting tools to enhance project tracking.', 14),
(46, 'tanuja', 't@gmail.com', '202cb962ac59075b964b07152d234b70', 't31', 'spas', 'AI & ML based, Web Development based', 'T', 'The Internet of Things (IoT) is a network of physical objects embedded with sensors, software, and other technologies, connecting devices and systems over the internet to solve complex problems. In India, IoT is being integrated into various sectors to improve efficiency and solve complex problems, including education.', 24),
(47, 'apalak', 'apalakrajesh@gmail.com', '202cb962ac59075b964b07152d234b70', 'r20', 'haas', 'Cyber Security based, Web Development based', 'Women Empowerment is a term used to indicate steps taken for improving the status of women in society. It refers to their social, political, educational, medical, economical and other forms of improvement. It is very essential for women to be provided equal and opportunities as that of men.\r\n\r\nEducation and Women Empowerment\r\n\r\nThe role of education is very essential when it comes to women empowerment. It is only through education that women gain access to better opportunities and income. Without education, they are forced to take up low paying jobs and always remain dependent on the men for their needs.\r\n\r\nEducation is the only tool to make women financially independent and able to make financial decisions of their own. An educated woman is able to pursue her own dream and decide about her life and career.\r\n\r\nWomen Empowerment and Sustainable Development\r\n\r\nWomen empowerment is a key factor in achieving the 2030 Sustainable Development Goals. SDG goal number 5 targets gender equality and women empowerment as the fundamental requirements for an equitable society and bringing sustainable development.\r\n\r\nWomen around the world share the primary responsibilities of nutrition of the children, their education, and the management of the household. The presence of women in areas like environment, health and other vital sectors is also increasing.\r\n\r\nSDG 2030 aims for gender equality by eliminating all the root causes that curtail women’s rights in every sphere of life. Women are less paid for the same work than men in several developing as well as developed nations.\r\n\r\nUnless gender equality is achieved and women enjoy equal rights and opportunities as men, sustainable development would still be a distant dream. Educating women and bringing them on the forefront is the first thing to do if we ever want to achieve SDG goals by 2030.', 'Women empowerment is crucial for achieving the 2030 Sustainable Development Goals, as it ensures equal opportunities for women and promotes sustainable development. Education is crucial for women, as it gives them access to better opportunities and income and allows them to make financial decisions independently.', 14),
(48, 'abc', 's@gmail.com', '202cb962ac59075b964b07152d234b70', 'i23', 'haas', 'AI & ML based', 'Women Empowerment is a term used to indicate steps taken for improving the status of women in society. It refers to their social, political, educational, medical, economical and other forms of improvement. It is very essential for women to be provided equal and opportunities as that of men.\r\n\r\nEducation and Women Empowerment\r\n\r\nThe role of education is very essential when it comes to women empowerment. It is only through education that women gain access to better opportunities and income. Without education, they are forced to take up low paying jobs and always remain dependent on the men for their needs.\r\n\r\nEducation is the only tool to make women financially independent and able to make financial decisions of their own. An educated woman is able to pursue her own dream and decide about her life and career.\r\n\r\nWomen Empowerment and Sustainable Development\r\n\r\nWomen empowerment is a key factor in achieving the 2030 Sustainable Development Goals. SDG goal number 5 targets gender equality and women empowerment as the fundamental requirements for an equitable society and bringing sustainable development.\r\n\r\nWomen around the world share the primary responsibilities of nutrition of the children, their education, and the management of the household. The presence of women in areas like environment, health and other vital sectors is also increasing.\r\n\r\nSDG 2030 aims for gender equality by eliminating all the root causes that curtail women’s rights in every sphere of life. Women are less paid for the same work than men in several developing as well as developed nations.\r\n\r\nUnless gender equality is achieved and women enjoy equal rights and opportunities as men, sustainable development would still be a distant dream. Educating women and bringing them on the forefront is the first thing to do if we ever want to achieve SDG goals by 2030.', 'Women empowerment is crucial for achieving the 2030 Sustainable Development Goals, as it ensures equal opportunities for women and promotes sustainable development. Education is crucial for women, as it gives them access to better opportunities and income and allows them to make financial decisions independently.', 14);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `approved_projects`
--
ALTER TABLE `approved_projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD KEY `mentor_id` (`mentor_id`);

--
-- Indexes for table `assigned_tasks`
--
ALTER TABLE `assigned_tasks`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `mentor_id` (`mentor_id`);

--
-- Indexes for table `declined_projects`
--
ALTER TABLE `declined_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`mentor_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `mentor_student_relationships`
--
ALTER TABLE `mentor_student_relationships`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `mentor_id` (`mentor_id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `mentor_id` (`mentor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `approved_projects`
--
ALTER TABLE `approved_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `assigned_tasks`
--
ALTER TABLE `assigned_tasks`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `declined_projects`
--
ALTER TABLE `declined_projects`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `mentors`
--
ALTER TABLE `mentors`
  MODIFY `mentor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `mentor_student_relationships`
--
ALTER TABLE `mentor_student_relationships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `approved_projects`
--
ALTER TABLE `approved_projects`
  ADD CONSTRAINT `approved_projects_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`),
  ADD CONSTRAINT `approved_projects_ibfk_2` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`);

--
-- Constraints for table `assigned_tasks`
--
ALTER TABLE `assigned_tasks`
  ADD CONSTRAINT `assigned_tasks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`),
  ADD CONSTRAINT `assigned_tasks_ibfk_2` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`);

--
-- Constraints for table `mentor_student_relationships`
--
ALTER TABLE `mentor_student_relationships`
  ADD CONSTRAINT `mentor_student_relationships_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `student_info` (`student_id`),
  ADD CONSTRAINT `mentor_student_relationships_ibfk_2` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`);

--
-- Constraints for table `student_info`
--
ALTER TABLE `student_info`
  ADD CONSTRAINT `student_info_ibfk_1` FOREIGN KEY (`mentor_id`) REFERENCES `mentors` (`mentor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
