-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- サーバのバージョン： 10.1.29-MariaDB
-- PHP Version: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pf`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `haiku`
--

CREATE TABLE `haiku` (
  `id` int(11) NOT NULL,
  `kamigo` varchar(10) DEFAULT NULL,
  `nakashichi` varchar(10) DEFAULT NULL,
  `shimogo` varchar(10) DEFAULT NULL,
  `kami_random` varchar(1) DEFAULT NULL,
  `naka_random` varchar(1) DEFAULT NULL,
  `shimo_random` varchar(1) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `haiku`
--

INSERT INTO `haiku` (`id`, `kamigo`, `nakashichi`, `shimogo`, `kami_random`, `naka_random`, `shimo_random`, `member_id`, `created`, `modified`) VALUES
(2, 'ててててて', 'すすすすすすす', 'つつつつつ', NULL, NULL, NULL, NULL, '2022-04-14 22:22:48', '2022-04-14 13:22:48'),
(7, 'きいらぎら', 'ぎいらぎらぎら', 'ぎいらぎら', 'ぎ', 'い', 'ら', 3, '2022-04-18 20:26:22', '2022-05-08 10:48:58'),
(13, 'むりにでも', 'ぺやんぐたべろよ', 'くるしうない', 'む', 'ぺ', 'く', 3, '2022-04-26 01:11:10', '2022-05-08 10:49:09'),
(19, 'ちょーだいな', 'こっぷいっぱい', 'ばりうむを', 'ょ', 'こ', 'ば', 3, '2022-05-02 20:02:15', '2022-05-08 10:49:16'),
(20, 'たたたたた', 'ぞあああああ', 'ぢあああああ', 'た', 'ぞ', 'ぢ', 3, '2022-05-02 20:20:09', '2022-05-08 10:49:28'),
(50, 'りああああ', 'ぎああああああ', 'まああああ', 'り', 'ぎ', 'ま', 3, '2022-05-08 19:48:26', '2022-05-08 10:48:26'),
(51, 'いああああ', 'ゆああああああ', 'ぜああああ', 'い', 'ゆ', 'ぜ', 8, '2022-05-08 20:29:46', '2022-05-08 11:29:46'),
(52, 'やるきでない', 'そんなときでも', 'はたらけよ', 'な', 'そ', 'は', 51, '2022-05-08 20:44:55', '2022-05-08 11:44:55'),
(53, 'とああああ', 'どああああああ', 'ぉああああ', 'と', 'ど', 'ぉ', 51, '2022-05-08 21:09:14', '2022-05-08 12:09:14');

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_image` varchar(255) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `experience` int(11) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `user_name`, `password`, `user_image`, `level`, `experience`, `created`, `modified`) VALUES
(1, 'test', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '20220329140459', 0, 0, '2022-03-29 21:05:03', '2022-03-29 12:05:03'),
(2, 'test2', '109f4b3c50d7b0df729d299bc6f8e9ef9066971f', '20220329142814youngman_26.jpg', 0, 0, '2022-03-29 21:28:18', '2022-03-29 12:28:18'),
(3, 'tanaka', 'c82b6b6f2059dcdb3b2076b2af2ca81901aed3a4', '20220406115845', 0, 0, '2022-04-06 18:58:47', '2022-04-06 09:58:47'),
(4, 'testuser1', 'bc51a83eea09846dc02407dd0979968912a207a9', '20220425105959youngman_26.jpg', 0, 0, '2022-04-25 18:00:49', '2022-04-25 09:00:49'),
(5, 'tanakas', '96f137d3a394f5e18c614202ac13901c1d8ceeb7', '20220429175236', 0, 0, '2022-04-30 00:52:39', '2022-04-29 15:52:39'),
(6, 'OGA', '7c4a8d09ca3762af61e59520943dc26494f8941b', '20220503071734', 0, 0, '2022-05-03 14:18:12', '2022-05-03 05:18:12'),
(7, 'ユーザー名　<script>alert(\'攻撃されているぞ！\');</script>', 'a642a77abd7d4f51bf9226ceaf891fcbb5b299b8', '20220507222109', 0, 0, '2022-05-08 05:21:33', '2022-05-07 20:21:33'),
(8, 'satosato', 'b9010081c4fc1e328cb21711fd3b02419d190a09', '20220508101108', 0, 0, '2022-05-08 17:11:10', '2022-05-08 08:11:10');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `reply_post_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `message`, `member_id`, `reply_post_id`, `created`, `modified`) VALUES
(5, 'test2でぃす！', 2, 0, '2022-03-29 21:37:48', '2022-03-29 12:37:48'),
(6, 'testです', 1, 0, '2022-03-29 21:38:13', '2022-03-29 12:38:13'),
(8, '<input type=\"hidden\">も無害化（サニタイズ・htmlspecialchars）する必要はあるか？ \r\n⇒結論：あるっぽい。ので、サニタイズしよう。\r\n参考サイト：hiddenなinput要素のXSSでJavaScript実行（2016年） \r\n　https://blog.tokumaru.org/2016/04/hiddeninputxssjavascript.html \r\n', 3, 0, '2022-04-29 18:02:34', '2022-04-29 09:02:34'),
(9, 'テストです', 8, 0, '2022-05-08 20:54:14', '2022-05-08 11:54:14'),
(12, '今日は曇り', 8, 0, '2022-05-08 20:57:53', '2022-05-08 11:57:53'),
(13, 'GW最終日。', 8, 0, '2022-05-08 20:58:00', '2022-05-08 11:58:00'),
(14, '明日は月曜日', 8, 0, '2022-05-08 20:58:20', '2022-05-08 11:58:20');

-- --------------------------------------------------------

--
-- テーブルの構造 `quiz_book`
--

CREATE TABLE `quiz_book` (
  `id` int(11) NOT NULL,
  `question` varchar(1000) DEFAULT NULL,
  `choice_a` varchar(500) DEFAULT NULL,
  `choice_b` varchar(500) DEFAULT NULL,
  `choice_c` varchar(500) DEFAULT NULL,
  `answer` varchar(500) DEFAULT NULL,
  `commentary` text,
  `genre` varchar(40) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `quiz_book`
--

INSERT INTO `quiz_book` (`id`, `question`, `choice_a`, `choice_b`, `choice_c`, `answer`, `commentary`, `genre`, `member_id`, `created`, `modified`) VALUES
(1, '1+1は？', '1', '2', '3', '2', '特になし', '足し算', NULL, NULL, '2022-04-10 13:20:30'),
(2, '2+2は？', '1', '2', '4', '4', 'ないよ', '足し算', NULL, NULL, '2022-04-10 13:20:57'),
(3, 'サッカーワールドカップ第一回は1930年に開催された。優勝国はどこ？', 'ブラジル', 'イタリア', 'ウルグアイ', 'ウルグアイ', '第一回優勝国はウルグアイ。ちなみに開催地もウルグアイだった。', 'スポーツ', NULL, '2022-04-09 20:42:59', '2022-04-20 09:18:49'),
(4, '9-4は？', '4', '5', '6', '5', '特になし', '引き算', NULL, '2022-04-09 21:31:04', '2022-04-10 13:22:01'),
(5, '17-9は？', '8', '7', '10', '8', '特になし', '引き算', NULL, '2022-04-09 21:31:04', '2022-04-10 13:23:25'),
(6, '2022年サッカーワールドカップの開催地はどこ？', 'フランス', 'カタール', 'ダカール', 'カタール', 'カタールです。', 'スポーツ', NULL, '2022-04-09 22:08:01', '2022-04-19 07:30:33'),
(7, 'サッカーワールドカップ第二回は1934年に開催された。優勝国はどこ？', 'ウルグアイ', 'イタリア', 'ブラジル', 'イタリア', '第二回優勝国はイタリア。ちなみに、開催地もイタリア。', 'スポーツ', NULL, '2022-04-10 20:17:36', '2022-04-20 09:19:15'),
(8, '本は英語で？', 'book', 'boot', 'textbook', 'book', 'いやいやいや。', '英語', NULL, '2022-04-13 22:13:42', '2022-04-20 09:20:16'),
(9, '11 x  11 は？', '120', '121', '1111', '121', 'なし', 'かけ算', NULL, '2022-04-25 20:09:16', '2022-04-25 11:09:16'),
(10, '9 足す　12　は？', '20', '22', '21', '21', '正解は21です', '足し算', NULL, '2022-04-30 10:21:38', '2022-04-30 01:21:38'),
(11, '日本の都道府県で2番目に人口が多いのは？（2022年時点）', '埼玉県', '大阪府', '神奈川県', '神奈川県', '2位は神奈川県です。大阪府は3位です。2位と3位は殆ど差がありませんケドね。', '地理', NULL, '2022-04-30 21:47:37', '2022-04-30 12:48:29'),
(12, '大型犬といえば？\r\n', 'ブルドッグ', 'プードル', 'ピットブル', 'ピットブル', '', 'アニマル', NULL, '2022-05-03 15:08:51', '2022-05-03 06:08:51'),
(13, 'a', 'a', 'a', 'a', 'a', 'a', 'a', NULL, '2022-05-07 00:00:03', '2022-05-06 15:00:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `haiku`
--
ALTER TABLE `haiku`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quiz_book`
--
ALTER TABLE `quiz_book`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `haiku`
--
ALTER TABLE `haiku`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `quiz_book`
--
ALTER TABLE `quiz_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
