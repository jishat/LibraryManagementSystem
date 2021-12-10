-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 01, 2020 at 02:45 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ciu`
--

-- --------------------------------------------------------

--
-- Table structure for table `brand`
--

CREATE TABLE `brand` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `brand_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `brand`
--

INSERT INTO `brand` (`id`, `logo`, `brand_name`) VALUES
(1, '5d5fc73610c65.png', 'Chittagong Independent University');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `headline` varchar(255) DEFAULT NULL,
  `news_image` varchar(255) DEFAULT NULL,
  `news_description` text,
  `is_disable` varchar(3) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `headline`, `news_image`, `news_description`, `is_disable`, `create_at`) VALUES
(11, 'This is a test news', '5d5c3b0a150b2.jpg', 'Lorem Ipsum dummy text. Lorem Ipsum dummy text. Lorem Ipsum dummy text. Lorem Ipsum dummy text.', 'no', '2019-08-21 00:25:14'),
(12, 'Test News Three', '5d5dc9fcc7ada.jpg', 'Lorem Ipsum dummy text', 'no', '2019-08-22 04:47:24'),
(13, 'Test News Four', '5d5dca223c893.jpg', 'Lorem Ipsum dummy text', 'no', '2019-08-22 04:48:02'),
(14, 'I love bangladesh', '5d5dca4660188.jpg', 'Lorem Ipsum dummy Text. fgdfgdf dfgdfdf', 'no', '2019-08-22 04:48:38');

-- --------------------------------------------------------

--
-- Table structure for table `notice`
--

CREATE TABLE `notice` (
  `id` int(11) NOT NULL,
  `notice_headline` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `is_disable` varchar(3) DEFAULT NULL,
  `create_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notice`
--

INSERT INTO `notice` (`id`, `notice_headline`, `file`, `is_disable`, `create_at`) VALUES
(5, 'five heading', 'Brochure-Richardoring---Income-taxation-U5-(1)-5d54489914f71.pdf', 'no', '2019-08-14 23:44:57'),
(6, 'six heading', 'ChittagongIndependentUniversitylogo-5d54490189845.png', 'no', '2019-08-14 23:46:41'),
(7, 'seven heading', 'Workforcediversityandorganizationalperformance_Published-5d54491f4d6f9.pdf', 'no', '2019-08-14 23:47:11'),
(9, 'Final terms', 'action-adventure-bike-2519374-5d552734d3fdc.jpg', 'no', '2019-08-15 00:10:48'),
(10, 'Ten heading', 'facial-hair-fine-looking-guy-614810-5d5522161ce49.jpg', 'no', '2019-08-15 15:12:54');

-- --------------------------------------------------------

--
-- Table structure for table `social_link`
--

CREATE TABLE `social_link` (
  `id` int(11) NOT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `twitter` varchar(255) DEFAULT NULL,
  `youtube` varchar(255) DEFAULT NULL,
  `linkdin` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `social_link`
--

INSERT INTO `social_link` (`id`, `facebook`, `twitter`, `youtube`, `linkdin`) VALUES
(1, 'https://www.testfromfb.com', 'https://www.twitter.com', 'https://www.testfromyoutube.com', 'https://www.testfromlinkdin.com');

-- --------------------------------------------------------

--
-- Table structure for table `tj_admin_pages`
--

CREATE TABLE `tj_admin_pages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_admin_pages`
--

INSERT INTO `tj_admin_pages` (`id`, `name`) VALUES
(1, 'user'),
(2, 'student'),
(3, 'borrow'),
(4, 'book');

-- --------------------------------------------------------

--
-- Table structure for table `tj_books`
--

CREATE TABLE `tj_books` (
  `id` bigint(20) NOT NULL,
  `book_name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `writer` varchar(255) DEFAULT NULL,
  `book_id` varchar(255) DEFAULT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `category` varchar(60) DEFAULT NULL,
  `total_stock` int(255) DEFAULT NULL,
  `description` text,
  `book_shelf` varchar(20) NOT NULL,
  `total_borrowed` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_books`
--

INSERT INTO `tj_books` (`id`, `book_name`, `slug`, `writer`, `book_id`, `picture`, `category`, `total_stock`, `description`, `book_shelf`, `total_borrowed`, `status`, `create_at`, `update_at`) VALUES
(1, 'Jumping into c++', 'jumping-into-c++', 'ARJ', '#584302', '5f36c5050d9ef.jpg', ',3', 8, '<p><strong>C++</strong> is a middle-level programming language developed by Bjarne Stroustrup starting in 1979 at Bell Labs. <strong>C++</strong> runs on a variety of platforms, such as Windows, Mac OS, and the various versions of UNIX. This <strong>C++</strong> tutorial adopts a simple and practical approach to describe the concepts of <strong>C++</strong> for beginners to advanded software engineers..</p><h2><strong>Why to Learn C++</strong></h2><p>C++ is a MUST for students and working professionals to become a great Software Engineer. I will list down some of the key advantages of learning C++:</p><p>C++ is very close to hardware, so you get a chance to work at a low level which gives you lot of control in terms of memory management, better performance and finally a robust software development.</p><p>C++ programming gives you a clear understanding about Object Oriented Programming. You will understand low level implementation of polymorphism when you will implement virtual tables and virtual table pointers, or dynamic type identification.</p><p>C++ is one of the every green programming languages and loved by millions of software developers. If you are a great C++ programmer then you will never sit without work and more importantly you will get highly paid for your work.</p><p>C++ is the most widely used programming languages in application and system programming. So you can choose your area of interest of software development.</p><p>C++ really teaches you the difference between compiler, linker and loader, different data types, storage classes, variable types their scopes etc.</p><p>There are 1000s of good reasons to learn C++ Programming. But one thing for sure, to learn any programming language, not only C++, you just need to code, and code and finally code until you become expert.</p>', 'A1', '0', 1, '2020-08-14 23:08:21', '2020-08-17 15:38:14'),
(2, 'Python Pogramming', 'python-pogramming', 'XYZ', '#248912', '5f3a6c34ce769.jpg', ',1,5', 7, '<p><strong>Python</strong> is a general-purpose interpreted, interactive, object-oriented, and high-level programming language. It was created by Guido van Rossum during 1985- 1990. Like Perl, Python source code is also available under the GNU General Public License (GPL). This <strong>tutorial</strong> gives enough understanding on <strong>Python programming</strong> language.</p><h2><strong>Why to Learn Python?</strong></h2><p><strong>Python</strong> is a high-level, interpreted, interactive and object-oriented scripting language. Python is designed to be highly readable. It uses English keywords frequently where as other languages use punctuation, and it has fewer syntactical constructions than other languages.</p><p><strong>Python</strong> is a MUST for students and working professionals to become a great Software Engineer specially when they are working in Web Development Domain. I will list down some of the key advantages of learning Python:</p><p><strong>Python is Interpreted</strong> âˆ’ Python is processed at runtime by the interpreter. You do not need to compile your program before executing it. This is similar to PERL and PHP.</p><p><strong>Python is Interactive</strong> âˆ’ You can actually sit at a Python prompt and interact with the interpreter directly to write your programs.</p><p><strong>Python is Object-Oriented</strong> âˆ’ Python supports Object-Oriented style or technique of programming that encapsulates code within objects.</p><p><strong>Python is a Beginner\'s Language</strong> âˆ’ Python is a great language for the beginner-level programmers and supports the development of a wide range of applications from simple text processing to WWW browsers to games.</p><h2><strong>Characteristics of Python</strong></h2><p>Following are important characteristics of <strong>Python Programming</strong> âˆ’</p><p>It supports functional and structured programming methods as well as OOP.</p><p>It can be used as a scripting language or can be compiled to byte-code for building large applications.</p><p>It provides very high-level dynamic data types and supports dynamic type checking.</p><p>It supports automatic garbage collection.</p><p>It can be easily integrated with C, C++, COM, ActiveX, CORBA, and Java.</p>', 'B1', '1', 1, '2020-08-17 17:38:29', NULL),
(3, 'Compilers', 'compilers', 'Jeffrey D. Ullman', '#949718', '5f3a6d9dd7854.jpg', ',6,9', 10, '<h2>Introduction of Compiler Design</h2><p>Last Updated: 21-11-2019</p><p><strong>Compiler</strong> is a software which converts a program written in high level language (Source Language) to low level language (Object/Target/Machine Language).</p><figure class=\"image\"><img src=\"https://media.geeksforgeeks.org/wp-content/uploads/compileProcess.jpg\" alt=\"\"></figure><ul><li><strong>Cross Compiler</strong> that runs on a machine â€˜Aâ€™ and produces a code for another machine â€˜Bâ€™. It is capable of creating code for a platform other than the one on which the compiler is running.</li><li><strong>Source-to-source Compiler</strong> or transcompiler or transpiler is a compiler that translates source code written in one programming language into source code of another programming language.</li></ul><p><strong>Language processing systems (using Compiler) â€“</strong><br>We know a computer is a logical assembly of Software and Hardware. The hardware knows a language, that is hard for us to grasp, consequently we tend to write programs in high-level language, that is much less complicated for us to comprehend and maintain in thoughts. Now these programs go through a series of transformation so that they can readily be used machines. This is where language procedure systems come handy.</p>', 'A1', '1', 1, '2020-08-17 17:44:30', NULL),
(4, 'Artificial Intelligence', 'artificial-intelligence', 'Dr B. Kolabathi', '#797689', '5f3a7749c28b3.jpg', ',6', 9, '<h2><strong>Artificial Intelligence History</strong><br>&nbsp;</h2><p>The term artificial intelligence was coined in 1956, but AI has become more popular today thanks to increased data volumes, advanced algorithms, and improvements in computing power and storage.</p><p>Early AI research in the 1950s explored topics like problem solving and symbolic methods. In the 1960s, the US Department of Defense took interest in this type of work and began training computers to mimic basic human reasoning. For example, the Defense Advanced Research Projects Agency (DARPA) completed street mapping projects in the 1970s. And DARPA produced intelligent personal assistants in 2003, long before Siri, Alexa or Cortana were household names.</p>', 'C1', '0', 1, '2020-08-17 18:25:46', NULL),
(5, 'Computer Science', 'computer-science', 'Robert Sedgui', '#370244', '5f3a77a481b68.jpg', ',6', 20, '', 'B1', '1', 1, '2020-08-17 18:27:16', NULL),
(6, 'Java Programming', 'java-programming', 'Jonathon', '#651379', '5f3a783b9e635.jpg', ',6,1,10', 20, '<h2><strong>What is Java?</strong></h2><p>Java is a popular programming language, created in 1995.</p><p>It is owned by Oracle, and more than <strong>3 billion</strong> devices run Java.</p><p>It is used for:</p><ul><li>Mobile applications (specially Android apps)</li><li>Desktop applications</li><li>Web applications</li><li>Web servers and application servers</li><li>Games</li><li>Database connection</li><li>And much, much more!</li></ul><h2><strong>Why Use Java?</strong></h2><ul><li>Java works on different platforms (Windows, Mac, Linux, Raspberry Pi, etc.)</li><li>It is one of the most popular programming language in the world</li><li>It is easy to learn and simple to use</li><li>It is open-source and free</li><li>It is secure, fast and powerful</li><li>It has a huge community support (tens of millions of developers)</li><li>Java is an object oriented language which gives a clear structure to programs and allows code to be reused, lowering development costs</li><li>As Java is close to C++ and c#, it makes it easy for programmers to switch to Java or vice versa</li></ul>', 'A1', '1', 1, '2020-08-17 18:29:47', NULL),
(7, 'Business Mathematics', 'business-mathematics-1', 'K.K. Shretha', '#340339', '5f3a788972afa.jpg', ',8', 10, '', 'B1', '0', 1, '2020-08-17 18:31:05', '2020-08-17 18:31:56'),
(8, 'Probability &amp; Statistics for Economists', 'probability-&amp;-statistics-for-economists', 'Yongmiao Hong', '#670157', '5f3d3d7d38221.jpg', ',8', 20, '', 'B1', '1', 1, '2020-08-19 20:55:59', NULL),
(9, 'Tell Me No Lies', 'tell-me-no-lies', 'John Pilger', '#795785', '5f3d3f937577e.jpg', ',11', 20, '', 'A1', '1', 1, '2020-08-19 21:04:51', NULL),
(10, 'Encyclopedia of Journalism', 'encyclopedia-of-journalism', 'Christoper H. Sterling', '#911465', '5f3d3ffaeb3cb.jpg', ',11', 30, '', 'A1', '1', 1, '2020-08-19 21:06:35', NULL),
(11, 'Law &amp; Economics', 'law-&amp;-economics', 'Roobert Cooter', '#983277', '5f3d402ad8368.jpg', ',12', 20, '', 'B1', '0', 1, '2020-08-19 21:07:23', NULL),
(12, 'Principles of Management', 'principles-of-management-1', 'Stephen P. Robbins', '#330623', '5f3d4098332fc.jpg', ',8,13', 20, '<p>This is a description</p>', 'A1', '0', 1, '2020-08-19 21:09:12', '2020-08-19 22:14:44'),
(13, 'sdfsdfsd', 'sdfsdfsd', 'Alex Alian', '#976746', '', ',13', 22, '', '', '0', 1, '2020-08-24 01:59:20', NULL),
(14, 'bbbb', 'bbbb', 'Alex Alian', '#875124', '', ',8,13', 22, '', '', '0', 1, '2020-08-24 02:07:37', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tj_borrow`
--

CREATE TABLE `tj_borrow` (
  `id` bigint(20) NOT NULL,
  `borrow_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `book_id` varchar(255) NOT NULL,
  `return_date` datetime NOT NULL,
  `is_accept` tinyint(1) DEFAULT NULL,
  `accept_at` datetime DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_borrow`
--

INSERT INTO `tj_borrow` (`id`, `borrow_id`, `user_id`, `book_id`, `return_date`, `is_accept`, `accept_at`, `create_at`) VALUES
(2, '#939265', '15', '5', '2020-10-17 00:00:00', 1, '2020-08-18 00:00:00', '2020-08-18 19:33:40'),
(3, '#257629', '15', '3', '2020-11-01 00:00:00', 1, '2020-08-18 00:00:00', '2020-08-18 19:33:47'),
(7, '#731110', '15', '6', '2020-10-04 00:00:00', 1, '2020-08-24 00:00:00', '2020-08-24 01:44:49'),
(12, '#979820', '15', '9', '2020-08-31 00:00:00', 1, '2020-08-24 00:00:00', '2020-08-24 17:09:21'),
(16, '#665791', '15', '8', '2020-09-18 00:00:00', 1, '2020-08-25 00:00:00', '2020-08-25 01:08:54'),
(18, '#534576', '15', '2', '2020-09-18 00:00:00', 1, '2020-08-25 00:00:00', '2020-08-25 22:33:38'),
(23, '#813453', '15', '10', '2020-09-25 00:00:00', 1, '2020-08-26 00:00:00', '2020-08-26 00:26:38');

-- --------------------------------------------------------

--
-- Table structure for table `tj_categories`
--

CREATE TABLE `tj_categories` (
  `id` bigint(20) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL,
  `parent_category` varchar(255) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_categories`
--

INSERT INTO `tj_categories` (`id`, `category_name`, `short_description`, `slug`, `parent_category`, `create_at`, `update_at`) VALUES
(1, 'Programming', 'This is a category', 'programming', '6', '2020-08-14 22:53:47', '2020-08-31 22:33:00'),
(2, 'C', '', 'c', '1', '2020-08-14 22:54:02', NULL),
(3, 'c++', '', 'c++', '1', '2020-08-14 22:54:16', NULL),
(5, 'Python', '', 'python', '1', '2020-08-17 17:35:23', NULL),
(6, 'CSE', '', 'cse', NULL, '2020-08-17 17:39:51', NULL),
(7, 'EEE', '', 'eee', NULL, '2020-08-17 17:39:57', NULL),
(8, 'BBA', '', 'bba', NULL, '2020-08-17 17:40:04', NULL),
(9, 'Compiler', '', 'compiler', '6', '2020-08-17 17:41:36', NULL),
(10, 'Java', '', 'java', '1', '2020-08-17 18:27:56', NULL),
(11, 'Journalism', '', 'journalism', NULL, '2020-08-19 21:03:46', NULL),
(12, 'Law', '', 'law', NULL, '2020-08-19 21:05:01', NULL),
(13, 'Management', 'ASasas', 'management', '8', '2020-08-19 21:08:07', '2020-08-22 14:34:56');

-- --------------------------------------------------------

--
-- Table structure for table `tj_faculty`
--

CREATE TABLE `tj_faculty` (
  `id` int(11) NOT NULL,
  `faculty_name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_faculty`
--

INSERT INTO `tj_faculty` (`id`, `faculty_name`, `slug`, `short_description`, `create_at`, `update_at`) VALUES
(1, 'BBA', 'bba-1', 'This is bba faculty.', '2020-08-14 21:06:05', '2020-08-15 23:28:42'),
(2, 'CSE', 'cse', 'This is test for CSE', '2020-08-14 21:06:21', NULL),
(3, 'EEE', 'eee', '', '2020-08-14 21:06:29', NULL),
(4, 'English', 'english-1', 'adsdasdasdj', '2020-08-14 21:06:44', '2020-08-18 15:51:29'),
(7, 'sdfsdf', 'sdfsdf', '', '2020-08-17 14:53:58', NULL),
(8, 'dfgter', 'dfgter', '', '2020-08-17 14:54:02', NULL),
(9, 'sdsdfsdf', 'sdsdfsdf', '', '2020-08-20 19:49:53', NULL),
(10, 'czsrrgxc', 'czsrrgxc', '', '2020-08-20 19:50:00', NULL),
(11, 'ndr', 'ndr', '', '2020-08-20 19:50:09', NULL),
(12, 'mcvbdf', 'mcvbdf', '', '2020-08-20 19:50:18', NULL),
(15, 'asdasd', 'asdasd', '', '2020-08-20 20:04:40', NULL),
(18, 'sdfsdfsdf', 'sdfsdfsdf', 'jkljk', '2020-08-20 20:16:54', '2020-08-20 21:30:53'),
(20, 'asdasdas', 'asdasdas', '', '2020-08-22 14:31:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tj_notifications`
--

CREATE TABLE `tj_notifications` (
  `id` bigint(20) NOT NULL,
  `student_from` varchar(255) DEFAULT NULL,
  `student_to` varchar(255) DEFAULT NULL,
  `user_from` varchar(255) DEFAULT NULL,
  `user_to` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `comment` text,
  `page_permission` tinyint(10) NOT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `expire_date` datetime DEFAULT NULL,
  `notify_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_notifications`
--

INSERT INTO `tj_notifications` (`id`, `student_from`, `student_to`, `user_from`, `user_to`, `subject`, `comment`, `page_permission`, `is_read`, `expire_date`, `notify_at`) VALUES
(2, '15', '', '', '', 'Requested for approve new account', '<p>A student registered an account. Verify the account for approve</p>\n					  <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"btn btn-sm btn-primary\">Verify Now</a>', 0, 1, '2020-08-22 00:00:00', '2020-08-14 22:21:05'),
(4, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=1\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-25 00:00:00', '2020-08-17 16:40:59'),
(5, '', '15', '', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Jumping into c++</strong> book has been rejected. </p>', 0, 1, '2020-08-25 00:00:00', '2020-08-17 17:05:05'),
(7, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Jumping into c++</strong> book has been accepted. </p>', 0, 1, '2020-08-25 00:00:00', '2020-08-17 17:15:36'),
(9, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#754933</strong> </p>\n												<p> Book name: <strong>Jumping into c++</strong> </p>\n													', 0, 1, '2020-08-25 00:00:00', '2020-08-17 17:30:24'),
(10, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=2\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=2\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-25 00:00:00', '2020-08-17 17:30:48'),
(11, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#754933</strong> </p>\n												<p> Book name: <strong>Jumping into c++</strong> </p>', 0, 1, '2020-08-25 00:00:00', '2020-08-17 17:31:01'),
(12, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=1\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-26 00:00:00', '2020-08-18 16:41:27'),
(13, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=2\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-26 00:00:00', '2020-08-18 19:33:40'),
(14, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=3\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-26 00:00:00', '2020-08-18 19:33:47'),
(15, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Compilers</strong> book has been accepted. </p>', 0, 0, '2020-08-26 00:00:00', '2020-08-18 19:38:26'),
(16, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Computer Science</strong> book has been accepted. </p>', 0, 0, '2020-08-26 00:00:00', '2020-08-18 19:38:28'),
(17, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Python Pogramming</strong> book has been accepted. </p>', 0, 0, '2020-08-26 00:00:00', '2020-08-18 19:38:30'),
(18, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=3\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=3\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-26 00:00:00', '2020-08-18 19:40:03'),
(19, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#257629</strong> </p>\n												<p> Book name: <strong>Compilers</strong> </p>', 0, 1, '2020-08-26 00:00:00', '2020-08-18 19:41:23'),
(20, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=2\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=4\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-26 00:00:00', '2020-08-18 20:17:09'),
(21, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#939265</strong> </p>\n												<p> Book name: <strong>Computer Science</strong> </p>', 0, 0, '2020-08-26 00:00:00', '2020-08-18 20:17:24'),
(22, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-27 00:00:00', '2020-08-19 22:06:35'),
(23, '', '15', '1', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Law &amp; Economics</strong> book has been rejected. </p>', 0, 0, '2020-08-27 00:00:00', '2020-08-19 22:06:44'),
(24, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-30 00:00:00', '2020-08-22 14:54:42'),
(25, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Principles of Management</strong> book has been accepted. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 14:57:06'),
(26, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=5\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 14:57:30'),
(27, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Law &amp; Economics</strong> book has been accepted. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:06:51'),
(28, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=6\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:09:36'),
(29, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Tell Me No Lies</strong> book has been accepted. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:09:44'),
(30, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=7\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:09:52'),
(31, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Probability &amp; Statistics for Economists</strong> book has been accepted. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:10:12'),
(32, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=8\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:23:15'),
(33, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=9\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:35:09'),
(34, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=10\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:35:17'),
(35, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=11\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:35:21'),
(36, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=12\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:35:25'),
(37, '', '15', '1', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Encyclopedia of Journalism</strong> book has been rejected. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:35:44'),
(38, '', '15', '1', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Business Mathematics</strong> book has been rejected. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:41:09'),
(39, '', '15', '1', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Java Programming</strong> book has been rejected. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:41:22'),
(40, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Jumping into c++</strong> book has been accepted. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:41:38'),
(41, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Artificial Intelligence</strong> book has been accepted. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 15:41:45'),
(42, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=13\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 18:06:38'),
(43, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Encyclopedia of Journalism</strong> book has been accepted. </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 18:09:03'),
(44, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=5\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-30 00:00:00', '2020-08-22 18:26:18'),
(45, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 18:30:07'),
(46, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=3\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=6\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 18:31:13'),
(47, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#257629</strong> </p>\n												<p> Book name: <strong>Compilers</strong> </p>\n													', 0, 0, '2020-08-30 00:00:00', '2020-08-22 18:34:28'),
(48, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=7\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 18:42:08'),
(49, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=8\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:21:36'),
(50, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:21:46'),
(51, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=3\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=9\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:32:46'),
(52, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#257629</strong> </p>\n												<p> Book name: <strong>Compilers</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:32:57'),
(53, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=2\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=10\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:34:01'),
(54, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#939265</strong> </p>\n												<p> Book name: <strong>Computer Science</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:34:23'),
(55, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=11\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:36:01'),
(56, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:36:27'),
(57, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=12\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:37:33'),
(58, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:37:46'),
(60, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:41:27'),
(62, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:42:51'),
(63, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=15\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:44:18'),
(64, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-30 00:00:00', '2020-08-22 22:50:57'),
(65, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=16\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 14:49:58'),
(66, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 14:50:16'),
(67, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=17\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 14:51:08'),
(68, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 14:51:21'),
(69, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=18\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:02:44'),
(70, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>\n													', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:03:20'),
(71, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=19\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:11:10'),
(72, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:11:21'),
(73, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=20\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-31 00:00:00', '2020-08-23 15:11:43'),
(74, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>\n													', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:12:02'),
(75, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=21\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-31 00:00:00', '2020-08-23 15:12:19'),
(76, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>\n													', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:12:34'),
(77, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>\n													', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:12:56'),
(78, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=4\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=22\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-31 00:00:00', '2020-08-23 15:16:57'),
(79, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#634727</strong> </p>\n												<p> Book name: <strong>Principles of Management</strong> </p>\n													', 0, 0, '2020-08-31 00:00:00', '2020-08-23 15:17:08'),
(80, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n							  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=5\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-08-31 00:00:00', '2020-08-23 17:12:06'),
(81, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Principles of Management</strong> book has been accepted. </p>', 0, 0, '2020-08-31 00:00:00', '2020-08-23 17:12:30'),
(82, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=6\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 01:41:53'),
(83, '', '15', '1', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Compilers</strong> book has been rejected. </p>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 01:43:20'),
(84, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=7\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 01:44:49'),
(85, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Java Programming</strong> book has been accepted. </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 01:44:56'),
(86, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong></strong> book has been accepted. </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 15:33:04'),
(87, '', '15', '1', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Jumping into c++</strong> book has been rejected. </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 15:34:48'),
(88, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Principles of Management</strong> book has been accepted. </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 15:36:04'),
(89, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Jumping into c++</strong> book has been accepted. </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 15:42:14'),
(90, '', '15', '1', '', 'Rejected your request to borrow book', '<p>Your requested for borrow <strong>Principles of Management</strong> book has been rejected. </p>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 16:12:51'),
(91, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=2\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=15\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-09-01 00:00:00', '2020-01-24 16:19:23'),
(92, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#939265</strong> </p>\n												<p> Book name: <strong>Computer Science</strong> </p>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 16:19:45'),
(93, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=10\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=16\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 16:45:52'),
(94, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=7\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=17\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 16:53:25'),
(95, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#731110</strong> </p>\n												<p> Book name: <strong>Java Programming</strong> </p>\n													', 0, 0, '2020-09-01 00:00:00', '2020-08-24 16:58:48'),
(96, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#266436</strong> </p>\n												<p> Book name: <strong>Jumping into c++</strong> </p>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 16:58:51'),
(97, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=10\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=18\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 17:04:43'),
(98, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=3\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=19\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 17:04:49'),
(99, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=3\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=20\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 17:04:56'),
(100, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#266436</strong> </p>\n												<p> Book name: <strong>Jumping into c++</strong> </p>', 0, 0, '2020-09-01 00:00:00', '2020-08-24 17:05:06'),
(101, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#257629</strong> </p>\n												<p> Book name: <strong>Compilers</strong> </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 17:05:09'),
(102, '', '15', '', '', 'Rejected your request of renew book', '<p> your requested for renew book has been rejected. </p>\n												<p> Borrow no: <strong>#257629</strong> </p>\n												<p> Book name: <strong>Compilers</strong> </p>\n													', 0, 1, '2020-09-01 00:00:00', '2020-08-24 17:05:26'),
(103, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=2\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=21\" class=\"btn btn-sm btn-primary\">View Details</a>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 17:05:47'),
(104, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=7\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=22\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-01 00:00:00', '2020-08-24 17:05:53'),
(105, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#731110</strong> </p>\n												<p> Book name: <strong>Java Programming</strong> </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 17:06:09'),
(106, ' ', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#939265</strong> </p>\n												<p> Book name: <strong>Computer Science</strong> </p>', 0, 1, '2020-09-01 00:00:00', '2020-08-24 17:06:12'),
(107, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=7\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=23\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-01 00:00:00', '2020-08-24 17:07:48'),
(108, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=10\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=24\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-01 00:00:00', '2020-08-24 17:07:54'),
(109, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=2\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=25\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-01 00:00:00', '2020-08-24 17:08:00'),
(113, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=12\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-01 00:00:00', '2020-08-24 17:09:21'),
(115, '26', '', '', '', 'Requested for approve new account', '<p>A student registered an account. Verify the account for approve</p>\r\n					  <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=tanjin-tisha\" class=\"btn btn-sm btn-primary\">Verify Now</a>', 2, 1, '2020-09-01 00:00:00', '2020-08-24 21:00:15'),
(116, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=14\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 01:05:08'),
(117, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=15\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 01:07:18'),
(118, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=16\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 01:08:54'),
(119, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=17\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 01:09:00'),
(121, '', '15', '', '', 'Accepted your request to borrow book', '<p>Your requested for borrow <strong>Probability &amp; Statistics for Economists</strong> book has been accepted. </p>', 0, 1, '2020-09-02 00:00:00', '2020-08-25 01:09:19'),
(122, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=17\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 22:32:14'),
(124, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=18\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 22:33:38'),
(126, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=19\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 22:36:07'),
(127, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=20\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 22:44:14'),
(128, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=18\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=1\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 0, '2020-09-02 00:00:00', '2020-08-25 22:55:58'),
(130, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=16\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=2\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-02 00:00:00', '2020-08-25 22:57:51'),
(131, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=21\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 0, '2020-09-02 00:00:00', '2020-08-25 23:01:57'),
(132, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=22\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 0, '2020-09-03 00:00:00', '2020-08-26 00:26:31'),
(133, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=23\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-03 00:00:00', '2020-08-26 00:26:38'),
(134, '15', '', '', '', 'Requested for borrow book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested a book for borrow</p>\r\n								  <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=24\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-03 00:00:00', '2020-08-26 00:26:50'),
(137, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=16\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=3\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-03 00:00:00', '2020-08-26 00:47:17'),
(138, '15', '', '', '', 'Requested for renew book', '<p> <a href=\"http://localhost/ciu/tjadmin/view/student/show.php?student_show=azizur-rahman-jishat\" class=\"text-bold\"> Azizur Rahman Jishat</a> requested to renew a book which <a href=\"http://localhost/ciu/tjadmin/view/borrow/show.php?borrow_show=16\" class=\"text-bold\"> borrowed</a></p>\n						<a href=\"http://localhost/ciu/tjadmin/view/renew/show.php?renew_show=4\" class=\"btn btn-sm btn-primary\">View Details</a>', 3, 1, '2020-09-05 00:00:00', '2020-08-28 03:20:29'),
(139, '', '15', '', '', 'Accept your request of renew book', '<p> your requested for renew book has been accepted </p>\n												<p> Borrow no: <strong>#665791</strong> </p>\n												<p> Book name: <strong>Probability &amp; Statistics for Economists</strong> </p>', 0, 1, '2020-09-05 00:00:00', '2020-08-28 03:20:48');

-- --------------------------------------------------------

--
-- Table structure for table `tj_renew`
--

CREATE TABLE `tj_renew` (
  `id` bigint(20) NOT NULL,
  `borrow_id` varchar(255) NOT NULL,
  `date_request` datetime NOT NULL,
  `is_accept` tinyint(1) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_renew`
--

INSERT INTO `tj_renew` (`id`, `borrow_id`, `date_request`, `is_accept`, `create_at`) VALUES
(1, '18', '2020-09-18 00:00:00', 1, '2020-08-25 22:55:58'),
(2, '16', '2020-08-29 00:00:00', 0, '2020-08-25 22:57:51'),
(3, '16', '2020-08-29 00:00:00', 1, '2020-08-26 00:47:17'),
(4, '16', '2020-09-18 00:00:00', 1, '2020-08-28 03:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `tj_settings`
--

CREATE TABLE `tj_settings` (
  `id` int(11) NOT NULL,
  `option_name` varchar(255) DEFAULT NULL,
  `option_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tj_students`
--

CREATE TABLE `tj_students` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `faculty` varchar(255) NOT NULL,
  `batch` varchar(255) NOT NULL,
  `gender` tinyint(3) NOT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(60) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `admin_verified` tinyint(1) NOT NULL,
  `email_verified` tinyint(1) NOT NULL,
  `e_verify_code` varchar(16) DEFAULT NULL,
  `e_verify_code_exp` datetime DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_students`
--

INSERT INTO `tj_students` (`id`, `name`, `slug`, `student_id`, `picture`, `faculty`, `batch`, `gender`, `mobile`, `address`, `email`, `password`, `status`, `admin_verified`, `email_verified`, `e_verify_code`, `e_verify_code_exp`, `create_at`, `update_at`) VALUES
(15, 'Azizur Rahman Jishat', 'azizur-rahman-jishat', '111-59-10(e)', '5f481e0b41b0a1598561803.jpg', '1', '45', 1, '01837709650', 'baraiapara, ctg.', 'arjishat@gmail.com', '$2y$10$3MDVP1RsUZ0HQzTL7dDi9ujprocC2YkQ/Uw1WwmReHBQUpAdWInpm', 1, 1, 1, NULL, NULL, '2020-08-14 22:21:02', '2020-08-30 18:01:09'),
(16, 'sdfsdfs', 'sdfsdfs', '83638', '', '8', '45', 2, '', '', 'rsdfzdfs@m.com', '$2y$10$H2S5gbEOVX4UdmJESwmJkOJsnHDz0S3CeOB6JzH5BhG3FNdL92jm2', 1, 1, 1, NULL, NULL, '2020-08-19 22:57:54', NULL),
(17, 'ertgvdf', 'ertgvdf', '99803', '', '8', '45', 1, '', '', 'rsdfdfgdfzdfs@m.com', '$2y$10$7/CBZD7sghNaMDsofnnVUuypSdHn8OWEOX1MRMv0oMaPnmVWEOBK6', 1, 1, 1, NULL, NULL, '2020-08-19 22:58:15', NULL),
(18, 'sdfsdfssdfs', 'sdfsdfssdfs', '983039', '', '4', '45', 2, '', '', 'rsdfzsdsdfs@m.com', '$2y$10$Y.u/ndSMG5s93aMaYm5zROb3/xaDE.8m0kiUo08bWYZpn3Xt0y4oK', 1, 1, 1, NULL, NULL, '2020-08-19 22:58:31', NULL),
(19, 'Anayed Hoque', 'anayed-hoque', '111-48-08(e)', '5f42b87263f601598208114.jpg', '2', '45', 1, '', '', 'rsdfsdszdfs@m.com', '$2y$10$4XLOg006iiQkpe11aPNBV.g7B2lw2KL0Dk9stpVdWBFIueoGQU/uC', 1, 1, 1, NULL, NULL, '2020-08-19 22:58:43', '2020-08-24 00:41:54'),
(20, 'Najmul Rahman', 'najmul-rahman', '111-50-29(e)', '5f42b829012b21598208041.jpg', '3', '45', 1, '', '', 'rsdfzzzdfs@m.com', '$2y$10$1kLLs8A5I1k/40dwZfyi9ecbxOZ.3Kk1oGg8AF77R/o/HSkFd0s0a', 1, 1, 1, NULL, NULL, '2020-08-19 22:59:51', '2020-08-24 00:40:41'),
(21, 'Kaiser Uddin', 'kaiser-uddin', '111-39-12', '5f42b7fdf01411598207997.jpg', '7', '45', 1, '', '', 'rsddfgfzdfs@m.com', '$2y$10$AYSkugswMyZoLp4oFIiItO9SrIEx6PiWR45fjKQGyEVt1Hd9trfHq', 1, 1, 1, NULL, NULL, '2020-08-19 23:02:16', '2020-08-24 00:39:58'),
(22, 'Kashem Ahmed', 'kashem-ahmed', '111-59-9(e)', '5f42b7d73a3571598207959.jpg', '1', '59', 1, '', 'baraiapara, ctg', 'kashem@gmail.com', '$2y$10$myVArPyCnI3/W3WkYAdX8ePwPvfr4vueNLO4gfrLBBV8/0hedDm.y', 1, 1, 1, NULL, NULL, '2020-08-19 23:02:41', '2020-08-31 18:23:41'),
(26, 'Tanjin Tisha', 'tanjin-tisha', '111-39-07', '', '2', '39', 2, '', '', 'creativescheme.bd@gmail.com', '$2y$10$w6e3EwVCFwd0wtYhAJeX4eWlSi9aGABahIOASfrNLF1NcMeTfS4fS', 1, 1, 1, NULL, NULL, '2020-08-24 21:00:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tj_users`
--

CREATE TABLE `tj_users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `username` varchar(60) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `user_role` varchar(20) DEFAULT NULL,
  `gender` tinyint(3) DEFAULT NULL,
  `mobile` varchar(16) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_users`
--

INSERT INTO `tj_users` (`id`, `name`, `username`, `slug`, `picture`, `email`, `password`, `user_role`, `gender`, `mobile`, `address`, `status`, `create_at`, `update_at`) VALUES
(1, 'Araf Yeasin', 'araf', 'araf-yeasin', '5f36a502cf8e31597416706.jpg', 'araf@gmail.com', '$2y$10$ODofN5QwkXAjC5bvPyG0f.sSJ49pCpGNHmNEsqoQn8JDUXyE.fXTW', '1', 1, '01932534823', '', 1, '2019-08-14 01:02:10', '2020-08-15 21:38:38'),
(4, 'Kashem Ahmed', 'kashem', 'kashem-ahmed', '5f3bf93984f731597765945.jpg', 'kashem@gmail.com', '$2y$10$e.jryePICLKB1mBqjOz3.erp2jsn9of4PtiUegmMnItObElywLl9q', '2', 1, '+8801837709650', '18 Street, New York, USA', 1, '2020-08-18 21:52:26', '2020-08-25 21:42:06'),
(5, 'Emon Islam', 'emon', 'emon-islam', '5f3bfa0daa1ce1597766157.jpg', 'emon@gmail.com', '$2y$10$CAZ/vjJfRIoQbKsdYMqqQONUTAc3bEgTzOFFN3Qf2XtaqGp/HboYW', '3', 1, '', 'asdasd', 1, '2020-08-18 21:55:58', '2020-08-25 04:20:48'),
(7, 'kader', 'kader', 'kader', '', 'kader@gmail.com', '$2y$10$P2oZUJS3.mX/1C8LtKMMwub0WcQaV5IxSO2kwSXgQaMzpmfvE2RCK', '6', 1, '', '', 1, '2020-08-18 21:56:43', '2020-08-25 21:37:48'),
(8, 'Rahman', 'rahman', 'rahman', '', 'rahman@gmail.com', '$2y$10$bZ1DKFkr9Qee06tHYcU.7uaJWyk5TehdrKKPQiDpEoG2YCp0E24mS', '10', 1, '+8801837709000', '123 Street, New York, USA', 1, '2020-08-18 21:57:03', '2020-08-25 21:40:37'),
(9, 'Farhan', 'farhan', 'farhan', '', 'farhan@gmail.com', '$2y$10$rAxE/ABvguuBWnupyFfTfuhNfsJfLHoOK8elHxcOhpwJTAurwPrSu', '2', 1, '', '', 1, '2020-08-18 21:57:36', '2020-08-25 04:20:01'),
(10, 'Merry', 'merry', 'merry', '', 'merry@gmail.com', '$2y$10$S7PNRKgCKKy6S7YWBMW8J.E5ZW2FyRD52ThHhX0eav/Yv9fWGUHvS', '10', 2, '', '', 1, '2020-08-18 21:58:15', '2020-08-25 16:44:09'),
(11, 'Jonathon Smith', 'jonathon', 'jonathon-smith', '', 'jonathon@gmail.com', '$2y$10$JLAFhtYsHk6gj/TPB7/2te4uff43qgLbY17QDAUIdYgzz1vtsqEre', '2', 1, '', '', 1, '2020-08-18 21:58:48', '2020-08-25 04:19:33'),
(16, 'Abdur', 'abdur', 'abdur', '', 'abdur@gmail.com', '$2y$10$RCsaNvMH9XbdBghMTzrL1uoOcpSXolUjwcMmzwrJuBZcrV9tQDPi2', '8', 1, '', '123 Street, New York, USA', 1, '2020-08-18 22:27:38', '2020-08-25 04:19:16'),
(27, 'Abdur', 'abdur1', 'abdur-1', '', 'smitsdasdh@gmail.com', '$2y$10$e7wk8EOsWDFPVTbAPmDBOeALuZmm8VinFj3VQDGJKKyw/OtwJQf0q', '8', 2, '', '', 1, '2020-08-20 19:32:12', '2020-08-25 16:47:50'),
(29, 'just test', 'just', 'just-test', '5f4434a9887a91598305449.jpg', 'asdfsdfdsraf@gmail.com', '$2y$10$oIF/l5a/wcqof8eQkylYUuULE.epam6bJlJVKvXWYCImEEStxx8lK', '9', 1, '+8801837709650', '', 1, '2020-08-25 03:44:10', '2020-08-25 21:44:11');

-- --------------------------------------------------------

--
-- Table structure for table `tj_user_roles`
--

CREATE TABLE `tj_user_roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `admin_pages_id` varchar(255) DEFAULT NULL,
  `update_at` datetime DEFAULT NULL,
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tj_user_roles`
--

INSERT INTO `tj_user_roles` (`id`, `name`, `slug`, `short_description`, `admin_pages_id`, `update_at`, `create_at`) VALUES
(1, 'Super Admin', 'super-admin', 'sdfsd', ',1,2,3,4', NULL, '2020-08-14 22:49:17'),
(2, 'Editor', 'editor', 'sdfsdfsdfsdfsd', ',1,4', '2020-08-24 23:20:11', '2020-08-14 22:49:17'),
(3, 'Moderator', 'moderator', '', ',2,3', '2020-08-24 21:41:23', '2020-08-15 21:45:26'),
(5, 'Manager', 'manager', '', ',1,2,3,4', '2020-08-24 20:38:35', '2020-08-18 22:07:27'),
(6, 'Supporter', 'supporter', '', ',2', NULL, '2020-08-18 22:07:43'),
(7, 'Accounts', 'accounts', '', ',3', NULL, '2020-08-18 22:07:53'),
(8, 'Deliver', 'deliver', '', ',3', NULL, '2020-08-18 22:08:09'),
(9, 'teacher', 'teacher', '', ',2', NULL, '2020-08-18 22:08:18'),
(10, 'librariyan', 'librariyan', 'cvxzxc', ',3,4', '2020-08-18 23:48:46', '2020-08-18 22:08:35');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brand`
--
ALTER TABLE `brand`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_link`
--
ALTER TABLE `social_link`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_admin_pages`
--
ALTER TABLE `tj_admin_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_books`
--
ALTER TABLE `tj_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_borrow`
--
ALTER TABLE `tj_borrow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_categories`
--
ALTER TABLE `tj_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_faculty`
--
ALTER TABLE `tj_faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_notifications`
--
ALTER TABLE `tj_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_renew`
--
ALTER TABLE `tj_renew`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_settings`
--
ALTER TABLE `tj_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_students`
--
ALTER TABLE `tj_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_users`
--
ALTER TABLE `tj_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tj_user_roles`
--
ALTER TABLE `tj_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brand`
--
ALTER TABLE `brand`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `notice`
--
ALTER TABLE `notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `social_link`
--
ALTER TABLE `social_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tj_admin_pages`
--
ALTER TABLE `tj_admin_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tj_books`
--
ALTER TABLE `tj_books`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tj_borrow`
--
ALTER TABLE `tj_borrow`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tj_categories`
--
ALTER TABLE `tj_categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tj_faculty`
--
ALTER TABLE `tj_faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tj_notifications`
--
ALTER TABLE `tj_notifications`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=140;

--
-- AUTO_INCREMENT for table `tj_renew`
--
ALTER TABLE `tj_renew`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tj_settings`
--
ALTER TABLE `tj_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tj_students`
--
ALTER TABLE `tj_students`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tj_users`
--
ALTER TABLE `tj_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `tj_user_roles`
--
ALTER TABLE `tj_user_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
