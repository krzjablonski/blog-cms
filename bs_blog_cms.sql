-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2018 at 01:55 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bs_blog_cms`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `author_id` int(11) NOT NULL,
  `author_name` text COLLATE utf8_polish_ci NOT NULL,
  `author_position` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`author_id`, `author_name`, `author_position`) VALUES
(1, 'Krzysztof Jabłoński', 'Lead Web Developer');

-- --------------------------------------------------------

--
-- Table structure for table `blog_info`
--

CREATE TABLE `blog_info` (
  `blog_title` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `blog_dsc` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'news'),
(2, 'Web Design'),
(3, 'Branding'),
(4, 'Web development');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` text COLLATE utf8_polish_ci NOT NULL,
  `phone` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `phone`, `email`) VALUES
(1, 'Krzysztof Jabłoński', '+48 000 000 000', 'krz.jablonski@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `file_name` text COLLATE utf8_polish_ci NOT NULL,
  `alt_tag` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `content` text COLLATE utf8_polish_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `publish_date` date NOT NULL,
  `image_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `text` text COLLATE utf8_polish_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `publish_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `image_id`, `title`, `text`, `author_id`, `publish_date`) VALUES
(20, 15, 'After change after categories change', 'Text of the post\r\nnext change\r\nOld:\r\nNews\r\nWeb Design\r\n\r\nNew:\r\nAll', 1, '2018-06-09'),
(22, 2, 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis at neque ut ornare. Curabitur nisl justo, vestibulum ut varius a, ultrices sed sem. Nullam eu ullamcorper tortor, eu varius purus. Donec vitae tortor vitae nulla molestie suscipit. Aliquam erat volutpat. Suspendisse aliquet, massa quis aliquam varius, velit purus mattis sapien, eu tristique sem mauris non est. Etiam vitae gravida elit. Quisque efficitur, erat et fermentum congue, tellus massa bibendum lorem, et bibendum enim ligula et lorem. Nullam cursus lacus vitae diam vulputate, at consequat est blandit. Donec sed purus dictum, iaculis nulla nec, blandit sem. Fusce a tortor at lorem placerat hendrerit. Aenean pulvinar pretium justo, quis porttitor velit dictum facilisis.\r\n\r\nVestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed bibendum sapien eu mauris laoreet, sit amet eleifend sem interdum. Praesent mi est, dignissim at orci sed, mattis hendrerit ligula. Praesent dictum porttitor velit id molestie. Etiam non sapien et nunc pellentesque facilisis. Proin id ex a ligula eleifend posuere a ut tellus. Proin dui neque, sollicitudin id turpis et, accumsan lacinia sem. Maecenas quis tincidunt tortor. Phasellus pharetra iaculis nunc quis dignissim. Suspendisse dignissim sit amet massa eget feugiat. Sed ultrices lectus non eros pulvinar maximus. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In auctor sed turpis non porttitor. Ut tellus elit, fringilla id nibh eu, fermentum tincidunt neque. Quisque tempor libero id nibh fermentum feugiat.\r\n\r\nIn eu dolor lacus. Fusce feugiat augue nec ipsum congue, a tempor eros tempor. In euismod lectus nec sem facilisis, ac varius purus luctus. Nam mattis erat sed justo condimentum, vehicula cursus leo condimentum. Vestibulum varius feugiat libero hendrerit viverra. Integer varius, tortor id laoreet scelerisque, leo nisl pulvinar leo, ut condimentum orci metus sit amet urna. Vestibulum et velit non purus elementum luctus nec a velit. Nunc in sapien mauris. Donec sit amet ipsum a justo mattis egestas in vitae odio. Sed nec lacus rhoncus, aliquam libero eu, pellentesque sem. Ut lobortis est quis malesuada sagittis. Aenean ante tortor, mollis ac tempor non, sollicitudin a lacus. Aliquam at tellus rutrum, dapibus dui in, hendrerit mauris. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus sed ornare risus, sit amet commodo enim.\r\n\r\nPellentesque ante nunc, sagittis vitae tristique at, vehicula a lectus. Sed et velit nec metus vulputate bibendum in nec turpis. Suspendisse in malesuada sapien. Suspendisse urna magna, elementum in lobortis sit amet, vehicula vitae quam. Suspendisse potenti. Duis ut metus leo. Maecenas porta ac risus ut mollis. Donec blandit a mauris at luctus. Phasellus vehicula auctor vestibulum. Donec non tellus in nulla sodales euismod ac ac mauris. Etiam molestie, ipsum eu convallis pulvinar, est orci finibus ex, eu pulvinar lectus turpis lobortis augue.', 1, '2018-06-14'),
(23, 2, 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis at neque ut ornare. Curabitur nisl justo, vestibulum ut varius a, ultrices sed sem. Nullam eu ullamcorper tortor, eu varius purus. Donec vitae tortor vitae nulla molestie suscipit. Aliquam erat volutpat. Suspendisse aliquet, massa quis aliquam varius, velit purus mattis sapien, eu tristique sem mauris non est. Etiam vitae gravida elit. Quisque efficitur, erat et fermentum congue, tellus massa bibendum lorem, et bibendum enim ligula et lorem. Nullam cursus lacus vitae diam vulputate, at consequat est blandit. Donec sed purus dictum, iaculis nulla nec, blandit sem. Fusce a tortor at lorem placerat hendrerit. Aenean pulvinar pretium justo, quis porttitor velit dictum facilisis.\r\n\r\nVestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed bibendum sapien eu mauris laoreet, sit amet eleifend sem interdum. Praesent mi est, dignissim at orci sed, mattis hendrerit ligula. Praesent dictum porttitor velit id molestie. Etiam non sapien et nunc pellentesque facilisis. Proin id ex a ligula eleifend posuere a ut tellus. Proin dui neque, sollicitudin id turpis et, accumsan lacinia sem. Maecenas quis tincidunt tortor. Phasellus pharetra iaculis nunc quis dignissim. Suspendisse dignissim sit amet massa eget feugiat. Sed ultrices lectus non eros pulvinar maximus. In hac habitasse platea dictumst. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In auctor sed turpis non porttitor. Ut tellus elit, fringilla id nibh eu, fermentum tincidunt neque. Quisque tempor libero id nibh fermentum feugiat.\r\n\r\nIn eu dolor lacus. Fusce feugiat augue nec ipsum congue, a tempor eros tempor. In euismod lectus nec sem facilisis, ac varius purus luctus. Nam mattis erat sed justo condimentum, vehicula cursus leo condimentum. Vestibulum varius feugiat libero hendrerit viverra. Integer varius, tortor id laoreet scelerisque, leo nisl pulvinar leo, ut condimentum orci metus sit amet urna. Vestibulum et velit non purus elementum luctus nec a velit. Nunc in sapien mauris. Donec sit amet ipsum a justo mattis egestas in vitae odio. Sed nec lacus rhoncus, aliquam libero eu, pellentesque sem. Ut lobortis est quis malesuada sagittis. Aenean ante tortor, mollis ac tempor non, sollicitudin a lacus. Aliquam at tellus rutrum, dapibus dui in, hendrerit mauris. Interdum et malesuada fames ac ante ipsum primis in faucibus. Phasellus sed ornare risus, sit amet commodo enim.\r\n\r\nPellentesque ante nunc, sagittis vitae tristique at, vehicula a lectus. Sed et velit nec metus vulputate bibendum in nec turpis. Suspendisse in malesuada sapien. Suspendisse urna magna, elementum in lobortis sit amet, vehicula vitae quam. Suspendisse potenti. Duis ut metus leo. Maecenas porta ac risus ut mollis. Donec blandit a mauris at luctus. Phasellus vehicula auctor vestibulum. Donec non tellus in nulla sodales euismod ac ac mauris. Etiam molestie, ipsum eu convallis pulvinar, est orci finibus ex, eu pulvinar lectus turpis lobortis augue.', 1, '2018-06-13'),
(24, 2, 'TItle alfter changes', 'text', 1, '2018-06-06'),
(25, 16, 'Post po zmianie na loop', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc venenatis rhoncus mi, et posuere neque pellentesque non. Etiam vitae auctor leo. Curabitur consectetur eros id diam facilisis, a ultrices sem finibus. Integer diam magna, ultrices vel condimentum et, placerat non dui. Etiam dapibus, nulla sit amet fermentum vestibulum, diam ante semper nisl, rhoncus maximus arcu quam ut arcu. Nullam luctus congue dui, eget varius lectus blandit sit amet. Etiam eget justo a erat blandit varius. Phasellus porttitor rutrum nisi ac faucibus. Etiam tortor dui, hendrerit vel dapibus vel, sodales id urna. Aenean a risus ac dui lobortis ullamcorper non eget sem. Suspendisse eget lacus magna.\r\n\r\ncośtam dalej cośtam cośtam\r\n\r\nProin non ligula vel purus scelerisque sollicitudin vel eget nisl. Sed et rhoncus ligula. Praesent finibus suscipit venenatis. Quisque et semper nibh. Nullam et posuere orci. Integer bibendum diam quis maximus euismod. Pellentesque malesuada eu lacus eu eleifend.\r\n\r\nSuspendisse et blandit lorem, sit amet convallis magna. Vestibulum facilisis ornare vulputate. Nam non elit justo. Etiam rhoncus velit vehicula, accumsan ligula non, sollicitudin ipsum. Cras sodales, sem id mattis molestie, nisl augue semper est, vel pharetra nibh magna et elit. Aenean quis rhoncus quam. Mauris pretium turpis eget turpis lacinia, quis placerat neque eleifend. Maecenas bibendum massa a augue condimentum tincidunt.\r\n\r\nVestibulum eleifend elit dolor, eu faucibus quam egestas in. Donec odio massa, ornare sed elementum sed, fermentum a ex. Fusce in placerat est. Morbi pharetra quis arcu rutrum tempor. Nulla vel sem tortor. Nam at vehicula odio. Integer vestibulum congue dolor id consequat. Vestibulum vestibulum lectus vitae ligula ultrices pharetra. Integer laoreet accumsan condimentum.\r\n\r\nUt convallis dui sed libero iaculis mollis. Proin eget elit diam. Vivamus vitae pretium tortor. Morbi molestie porttitor turpis id auctor. Fusce et lectus porta, consequat massa eget, tincidunt eros. Nam placerat efficitur risus, aliquet scelerisque massa interdum aliquam. Vestibulum et convallis dolor. Fusce velit tellus, ultricies at faucibus in, efficitur et lacus. Maecenas nec rhoncus odio, at tempor magna. Phasellus lobortis, ligula in vehicula efficitur, sem ligula iaculis dolor, nec blandit dolor leo et ante. Donec cursus vitae leo sit amet tincidunt. Integer tempor, nisl ultrices tincidunt porta, purus lectus sollicitudin ante, et rhoncus nisi arcu vel purus. Sed non justo quis enim tempor cursus. Nunc et lorem nisi. Morbi mattis gravida velit, et malesuada massa rutrum ac. Sed congue erat nec velit tempor, at mollis sapien tincidunt.', 1, '2018-06-06');

-- --------------------------------------------------------

--
-- Table structure for table `posts_categories`
--

CREATE TABLE `posts_categories` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `posts_categories`
--

INSERT INTO `posts_categories` (`id`, `post_id`, `category_id`) VALUES
(22, 22, 1),
(23, 22, 2),
(24, 23, 3),
(25, 23, 4),
(26, 24, 3),
(27, 24, 4),
(71, 20, 2),
(72, 20, 3),
(73, 20, 4),
(78, 25, 1),
(79, 25, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(25) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `authorization` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `authorization`) VALUES
(4, 'Admin', '$2y$10$oaZuRJsnCAAMLRMGQvqEbuCygAShLLtXs51y.FwsHwFRpX4CxgK9S', 'krz.jablonski@bigsite.pl', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`author_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts_categories`
--
ALTER TABLE `posts_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `posts_categories`
--
ALTER TABLE `posts_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
