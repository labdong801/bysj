-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2013 年 06 月 03 日 12:20
-- 服务器版本: 5.5.31
-- PHP 版本: 5.3.10-1ubuntu3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `bysj`
--

-- --------------------------------------------------------

--
-- 表的结构 `art_instrument_student_select`
--

CREATE TABLE IF NOT EXISTS `art_instrument_student_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(16) CHARACTER SET gb2312 NOT NULL,
  `first` tinyint(4) NOT NULL,
  `second` tinyint(4) NOT NULL,
  `third` tinyint(4) NOT NULL,
  `finally` tinyint(4) NOT NULL,
  `teacher` varchar(25) NOT NULL,
  `year` varchar(4) NOT NULL,
  `lock` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `art_major`
--

CREATE TABLE IF NOT EXISTS `art_major` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) CHARACTER SET gb2312 NOT NULL,
  `icon` varchar(100) NOT NULL,
  `detail` varchar(400) CHARACTER SET gb2312 NOT NULL,
  `grade` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- 转存表中的数据 `art_major`
--

INSERT INTO `art_major` (`id`, `name`, `icon`, `detail`, `grade`) VALUES
(1, '声乐', '\\images\\instrument\\shengyue.png', 'sadsafsafffffffffffffffffffasdasdasdasfasfasfasfasfasd', 3),
(2, '钢琴', '\\images\\instrument\\gangqin.png', 'gangqingangqingangqin', 3),
(3, '舞蹈', '\\images\\instrument\\wudao.png', 'wudaodasafasfasfasdasdasgfasda', 3),
(4, '合唱指挥', '\\images\\instrument\\zhihui.png', 'zhihui', 3),
(5, '二胡', '\\images\\instrument\\erhu.png', 'erhuerhuasdkakslcajkshjadlsad', 3),
(6, '小提琴', '\\images\\instrument\\xiaotiqin.png', 'iasjdasjfklasjklajskldjasdads', 3),
(7, '萨克斯/黑管', '\\images\\instrument\\shakesi.png', 'sadasfasfasfasfasfasdasdasd', 3),
(8, '中国音乐理论', '\\images\\instrument\\zhongguo.png', '1241241252131231231241241241241241', 3),
(9, '作曲技术理论', '\\images\\instrument\\zuoqu.png', 'sadasdasfasfasfasdas', 3),
(10, '外国音乐理论', '\\images\\instrument\\waiguo.png', 'sajkasdhasjdkasdjlaksjdlasjdklasjdkasjdklasjkdajskdjalsdjas', 3),
(11, '声乐', '', '', 2),
(12, '钢琴', '', '', 2),
(13, '小提琴', '\\images\\instrument\\xiaotiqin.png', '小提琴小提琴小提琴小提琴小提琴小提琴小提琴', 1),
(14, '古筝', '\\images\\instrument\\guzheng.png', '古筝古筝古筝古筝古筝', 1),
(15, '长笛', '\\images\\instrument\\changdi.png', '长笛长笛长笛长笛长笛', 1),
(16, '萨克斯/黑管', '\\images\\instrument\\shakesi.png', '萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管萨克斯/黑管', 1),
(17, '二胡', '\\images\\instrument\\erhu.png', '二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡二胡', 1),
(18, '毕业设计', '', '', 4);

-- --------------------------------------------------------

--
-- 表的结构 `art_major_student_select`
--

CREATE TABLE IF NOT EXISTS `art_major_student_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(16) CHARACTER SET gb2312 NOT NULL,
  `first` tinyint(4) NOT NULL,
  `second` tinyint(4) NOT NULL,
  `third` tinyint(4) NOT NULL,
  `finally` tinyint(4) NOT NULL,
  `teacher` varchar(25) NOT NULL,
  `year` varchar(4) NOT NULL,
  `lock` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `art_set_date`
--

CREATE TABLE IF NOT EXISTS `art_set_date` (
  `id` tinyint(2) NOT NULL AUTO_INCREMENT,
  `grade` tinyint(4) NOT NULL COMMENT '所属年级',
  `topic_start` int(11) NOT NULL COMMENT '教师提交时间',
  `topic_end` int(11) NOT NULL COMMENT '教师截止时间',
  `student_start` int(11) NOT NULL COMMENT '学生选题时间',
  `student_end` int(11) NOT NULL COMMENT '学生截止时间',
  `teacher_start` int(11) NOT NULL COMMENT '选学生开始时间',
  `teacher_end` int(11) NOT NULL COMMENT '选学生结束时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `art_set_date`
--

INSERT INTO `art_set_date` (`id`, `grade`, `topic_start`, `topic_end`, `student_start`, `student_end`, `teacher_start`, `teacher_end`) VALUES
(10, 1, 0, 0, 1369180800, 1369958399, 1370044800, 1371081599),
(11, 2, 0, 0, 1367798400, 1368748799, 1367539200, 1371081599),
(12, 3, 0, 0, 1369094400, 1369958399, 1370131200, 1370476799),
(13, 4, 1368576000, 1369958399, 1369267200, 1370476799, 1367452800, 1373241599);

-- --------------------------------------------------------

--
-- 表的结构 `art_student_task`
--

CREATE TABLE IF NOT EXISTS `art_student_task` (
  `sd_id` int(11) NOT NULL AUTO_INCREMENT,
  `major_id` int(4) NOT NULL,
  `classes` varchar(50) COLLATE gb2312_bin NOT NULL,
  `task_id` varchar(2) COLLATE gb2312_bin NOT NULL,
  `file_name` varchar(50) COLLATE gb2312_bin NOT NULL,
  `status` int(1) NOT NULL,
  `year` varchar(20) CHARACTER SET latin1 NOT NULL,
  `teacher_id` varchar(50) CHARACTER SET latin1 NOT NULL,
  `sd_grade` int(2) NOT NULL,
  `student_num` varchar(16) CHARACTER SET gb2312 NOT NULL,
  PRIMARY KEY (`sd_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gb2312 COLLATE=gb2312_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `art_teacher_student`
--

CREATE TABLE IF NOT EXISTS `art_teacher_student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `major_id` int(11) NOT NULL,
  `teacher_id` varchar(25) CHARACTER SET gb2312 NOT NULL,
  `class` tinyint(4) NOT NULL,
  `year` varchar(4) NOT NULL,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `art_teacher_task`
--

CREATE TABLE IF NOT EXISTS `art_teacher_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `content` varchar(1000) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `start_time` varchar(100) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `end_time` varchar(100) CHARACTER SET gb2312 COLLATE gb2312_bin NOT NULL,
  `teacher_task` varchar(100) NOT NULL,
  `class` int(2) NOT NULL,
  `year_task` varchar(20) NOT NULL,
  `major_id` int(4) NOT NULL,
  `grade` int(2) NOT NULL,
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `art_title_sort`
--

CREATE TABLE IF NOT EXISTS `art_title_sort` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT COMMENT '选题类别id',
  `name` varchar(30) NOT NULL COMMENT '选题类别名称',
  `open` tinyint(1) NOT NULL COMMENT '开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=gb2312 AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `art_title_sort`
--

INSERT INTO `art_title_sort` (`id`, `name`, `open`) VALUES
(4, '课程教学', 1),
(5, '科学研究', 1),
(6, '测试', 1);

-- --------------------------------------------------------

--
-- 表的结构 `art_vocalmusic`
--

CREATE TABLE IF NOT EXISTS `art_vocalmusic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_id` varchar(25) NOT NULL,
  `vocalmusic` tinyint(4) NOT NULL,
  `piano` tinyint(4) NOT NULL,
  `year` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- 转存表中的数据 `art_vocalmusic`
--

INSERT INTO `art_vocalmusic` (`id`, `teacher_id`, `vocalmusic`, `piano`, `year`) VALUES
(1, 'ty911', 0, 1, '2013'),
(2, 'fj902', 0, 1, '2013'),
(3, 'cxy910', 0, 1, '2013'),
(4, 'dj901', 1, 0, '2013'),
(5, 'cgl903', 1, 0, '2013'),
(6, 'yxx905', 1, 0, '2013'),
(7, 'lcm913', 1, 0, '2013');

-- --------------------------------------------------------

--
-- 表的结构 `art_vocalmusic_student_select`
--

CREATE TABLE IF NOT EXISTS `art_vocalmusic_student_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_number` varchar(25) CHARACTER SET gb2312 NOT NULL,
  `vocalmusic_first` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_second` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_third` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_finally` varchar(25) NOT NULL DEFAULT '0',
  `vocalmusic_lock` tinyint(4) NOT NULL,
  `piano_first` varchar(25) NOT NULL DEFAULT '0',
  `piano_second` varchar(25) NOT NULL DEFAULT '0',
  `piano_third` varchar(25) NOT NULL DEFAULT '0',
  `piano_finally` varchar(25) NOT NULL DEFAULT '0',
  `piano_lock` tinyint(1) NOT NULL,
  `year` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
